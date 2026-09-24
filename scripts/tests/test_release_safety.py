"""Negative tests for release publication safeguards (no external network)."""

import hashlib
import io
import json
import sys
import tempfile
import unittest
from pathlib import Path
from unittest.mock import patch
from zipfile import ZipFile

sys.path.insert(0, str(Path(__file__).resolve().parents[1]))
import verify_release_safety as safety
import verify_public_release as published


class PackageSafetyTests(unittest.TestCase):
    def make_release(self, root, *, missing_asset=False, stub=False):
        plugin = root / 'plugin/alookhor-control-center'
        (plugin / 'includes').mkdir(parents=True)
        (plugin / 'assets/css').mkdir(parents=True)
        (plugin / 'alookhor-control-center.php').write_text(
            "<?php require_once ALOOKHOR_CC_DIR . 'includes/live.php'; "
            "wp_enqueue_style('x', ALOOKHOR_CC_URL.'assets/css/test.css');"
        )
        (plugin / 'includes/live.php').write_text(
            '<?php /** Compatibility stub: empty */' if stub else '<?php function real_module() {}'
        )
        if not missing_asset:
            (plugin / 'assets/css/test.css').write_text('body { color: #fff }')
        (root / 'release.json').write_text(json.dumps({'version': '3.10.391', 'state': 'ready'}))
        public = root / 'public/releases'
        public.mkdir(parents=True)
        package = public / 'alookhor-control-center-3.10.391.zip'
        with ZipFile(package, 'w') as archive:
            for path in plugin.rglob('*'):
                if path.is_file():
                    archive.write(path, 'alookhor-control-center/' + path.relative_to(plugin).as_posix())
        (root / 'public/manifest.json').write_text(json.dumps({
            'version': '3.10.391',
            'sha256': hashlib.sha256(package.read_bytes()).hexdigest(),
            'download_url': 'https://updates.alookhor.ir/releases/' + package.name,
        }))

    def test_complete_package_passes(self):
        with tempfile.TemporaryDirectory() as directory:
            root = Path(directory)
            self.make_release(root)
            version, errors = safety.check_release(root)
            self.assertEqual(version, '3.10.391')
            self.assertEqual(errors, [])

    def test_missing_asset_and_stub_are_blocked(self):
        with tempfile.TemporaryDirectory() as directory:
            root = Path(directory)
            self.make_release(root, missing_asset=True, stub=True)
            _, errors = safety.check_release(root)
            self.assertTrue(any('Missing enqueued asset: assets/css/test.css' in error for error in errors))
            self.assertTrue(any('Implementation replaced by compatibility stub' in error for error in errors))

    def test_stale_manifest_sha_blocks(self):
        with tempfile.TemporaryDirectory() as directory:
            root = Path(directory)
            self.make_release(root)
            manifest = root / 'public/manifest.json'
            data = json.loads(manifest.read_text())
            data['sha256'] = '0' * 64
            manifest.write_text(json.dumps(data))
            _, errors = safety.check_release(root)
            self.assertTrue(any('SHA-256 differs' in error for error in errors))

    def test_live_version_cannot_be_downgraded_or_reinstalled(self):
        class Response:
            status = 200

            def __enter__(self): return self
            def __exit__(self, *args): return False
            def geturl(self): return 'https://alookhor.ir/wp-json/alookhor-cc/v1/topbar/'
            def read(self, size): return b'{"version":"3.10.391"}'

        def fake_urlopen(request, **kwargs):
            self.assertIn('/wp-json/alookhor-cc/v1/topbar/?release_gate=', request.full_url)
            return Response()

        with patch.object(safety, 'urlopen', side_effect=fake_urlopen):
            for version in ('3.10.387', '3.10.390', '3.10.391'):
                with self.subTest(version=version), self.assertRaisesRegex(ValueError, 'not newer'):
                    safety.check_live_version(version)
            self.assertEqual(safety.check_live_version('3.10.392'), '3.10.391')


class ReadbackTests(unittest.TestCase):
    def test_other_hosts_are_rejected(self):
        for url in ('http://updates.alookhor.ir/manifest.json',
                    'https://updates.alookhor.ir.evil.com/manifest.json',
                    'https://updates.alookhor.ir:444/manifest.json'):
            with self.subTest(url=url), self.assertRaises(ValueError):
                published.verified_get(url)

    def test_verification_rejects_wrong_public_package_and_manifest(self):
        manifest = {'version': '3.10.391', 'sha256': hashlib.sha256(b'expected').hexdigest(),
                    'download_url': 'https://updates.alookhor.ir/releases/alookhor-control-center-3.10.391.zip'}
        with patch.object(published, 'verified_get', return_value=b'different'):
            with self.assertRaisesRegex(ValueError, 'SHA-256'):
                published.verify('package', manifest)
        with patch.object(published, 'verified_get', return_value=json.dumps({**manifest, 'version': '3.10.390'}).encode()):
            with self.assertRaisesRegex(ValueError, 'version'):
                published.verify('manifest', manifest)


if __name__ == '__main__':
    unittest.main()
