"""Prove the production probe is read-only and does not disclose secrets."""

import sys
import unittest
from io import BytesIO
from pathlib import Path
from unittest.mock import patch
from urllib.error import HTTPError

sys.path.insert(0, str(Path(__file__).resolve().parents[1]))
import diagnose_production as diagnosis


class DiagnosticTests(unittest.TestCase):
    def test_auth_cannot_be_redirected_to_other_host(self):
        request = object()
        self.assertIsNone(diagnosis.NoRedirects().redirect_request(
            request, None, 302, 'Moved', {}, 'https://example.com/steal'
        ))

    def test_bad_wordpress_base_cannot_get_basic_auth(self):
        for url in ('http://alookhor.ir', 'https://other.example',
                    'https://alookhor.ir@evil.example', 'https://alookhor.ir:8443',
                    'https://alookhor.ir/wp-json/'):
            with self.subTest(url=url), self.assertRaises(ValueError):
                diagnosis.safe_base_url(url)
        with self.assertRaises(ValueError):
            diagnosis.fetch_json(diagnosis.MIRROR, ('user', 'password'))

    def test_private_error_exposes_only_codes(self):
        result = {'http': 200, 'data': {
            'version': '3.10.390', 'active': True, 'manifest_url': 'https://raw.githubusercontent.com/path?token=PRIVATE',
            'settings': {'private': 'SECRET'},
            'manifest': {'ok': False, 'error': 'http_request_failed',
                         'message': 'cURL error 28: private SECRET timeout'},
        }}
        summary = diagnosis.private_summary(result)
        self.assertEqual(summary['version'], '3.10.390')
        self.assertEqual(summary['manifest_host'], 'raw.githubusercontent.com')
        self.assertEqual(summary['manifest']['curl_code'], 28)
        self.assertNotIn('SECRET', str(summary))
        self.assertNotIn('PRIVATE', str(summary))

    def test_auth_error_exposes_only_safe_wp_code(self):
        class Opener:
            def open(self, *args, **kwargs):
                body = b'{"code":"application_passwords_invalid_password","message":"SECRET value"}'
                raise HTTPError(diagnosis.PRIVATE_IDENTITY, 401, 'Unauthorized', {}, BytesIO(body))

        with patch.object(diagnosis, 'build_opener', return_value=Opener()):
            result = diagnosis.fetch_json(diagnosis.PRIVATE_IDENTITY, ('publisher', 'secret'))
        self.assertEqual(result['wp_error_code'], 'application_passwords_invalid_password')
        self.assertNotIn('SECRET', str(result))
        self.assertNotIn('publisher', str(result))

    def test_no_password_skips_private_probe(self):
        with patch.object(diagnosis, 'fetch_json', return_value={'http': 404, 'error': 'http_error'}) as fetch:
            report = diagnosis.run_probe({'WP_BASE_URL': diagnosis.SITE})
            self.assertEqual(fetch.call_count, 3)
            self.assertEqual(report['wordpress']['state'], 'not_authenticated')
            self.assertEqual(report['wordpress']['required_secret_names'], ['WP_USERNAME', 'WP_APP_PASSWORD'])
            self.assertEqual(report['update_channel']['http'], 404)

    def test_password_triggers_only_authorized_status_get(self):
        def fake_fetch(url, auth=None):
            if auth is not None:
                self.assertEqual(auth, ('publisher', 'secret'))
                if url == diagnosis.PRIVATE_IDENTITY:
                    return {'http': 200, 'data': {'email': 'private@example.com', 'capabilities': {'update_plugins': True}}}
                self.assertEqual(url, diagnosis.PRIVATE_STATUS)
                return {'http': 200, 'data': {'version': '3.10.390', 'active': True, 'manifest': {'ok': False, 'error': 'http_request_failed'}}}
            return {'http': 200, 'data': {'version': '3.10.390'}}

        with patch.object(diagnosis, 'fetch_json', side_effect=fake_fetch):
            report = diagnosis.run_probe({'WP_BASE_URL': diagnosis.SITE, 'WP_USERNAME': 'publisher', 'WP_APP_PASSWORD': 'secret'})
        self.assertEqual(report['wordpress']['version'], '3.10.390')
        self.assertEqual(report['wordpress_auth'], {'http': 200, 'update_plugins': True})
        self.assertNotIn('private@example.com', str(report))
        self.assertNotIn('secret', str(report))
        self.assertNotIn('publisher', str(report))
        self.assertNotIn('secret', diagnosis.render_summary(report))
        self.assertNotIn('secret', diagnosis.annotation_summary(report))
        self.assertNotIn('publisher', diagnosis.annotation_summary(report))


if __name__ == '__main__':
    unittest.main()
