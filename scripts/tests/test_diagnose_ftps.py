"""Read-only FTPS audit: no credentials or server paths leave the process."""

import json
import ssl
import sys
import unittest
from pathlib import Path
from ftplib import error_perm

sys.path.insert(0, str(Path(__file__).resolve().parents[1]))
import diagnose_ftps


class FakeFTPS:
    def __init__(self, context, timeout):
        assert context.verify_mode == ssl.CERT_REQUIRED and context.check_hostname
        assert timeout <= 30
        self.calls = []

    def connect(self, host, port):
        self.calls.append('connect')

    def login(self, username, password):
        self.calls.append('login')

    def prot_p(self):
        self.calls.append('protect_data')

    def nlst(self, path=None):
        self.calls.append('list')
        if path == 'releases':
            return ['releases/alookhor-control-center-3.10.385.zip',
                    'releases/alookhor-control-center-3.10.387.zip',
                    'releases/private.txt']
        return ['manifest.json', 'releases', 'index.html']

    def retrbinary(self, name, receive):
        self.calls.append('read_manifest')
        assert name == 'RETR manifest.json'
        receive(json.dumps({'version': '3.10.387',
                            'download_url': 'https://updates.alookhor.ir/releases/plugin.zip',
                            'sha256': 'a' * 64}).encode())

    def quit(self):
        self.calls.append('quit')


class FTPSDiagnosticTests(unittest.TestCase):
    def test_never_dumps_credentials_or_paths(self):
        fake = FakeFTPS(ssl.create_default_context(), 25)
        result = diagnose_ftps.run_probe({
            'FTP_SERVER': 'ftp.test.example', 'FTP_PORT': '21',
            'FTP_USERNAME': 'private-user', 'FTP_PASSWORD': 'private-password',
        }, ftp_class=lambda **kwargs: fake)
        self.assertEqual(fake.calls, ['connect', 'login', 'protect_data', 'list', 'read_manifest', 'list', 'quit'])
        self.assertEqual(result['manifest']['version'], '3.10.387')
        self.assertEqual(result['release_versions'], ['3.10.385', '3.10.387'])
        for secret in ('private-user', 'private-password', 'ftp.test.example'):
            self.assertNotIn(secret, str(result))

    def test_missing_secret_names_only(self):
        self.assertEqual(diagnose_ftps.run_probe({})['missing_secret_names'], list(diagnose_ftps.REQUIRED))

    def test_absent_manifest_is_reported_not_downloaded_elsewhere(self):
        class NoManifest(FakeFTPS):
            def retrbinary(self, name, receive):
                self.calls.append('read_manifest')
                raise error_perm('550 File unavailable')

        fake = NoManifest(ssl.create_default_context(), 25)
        result = diagnose_ftps.run_probe({
            'FTP_SERVER': 'ftp.test.example', 'FTP_PORT': '21',
            'FTP_USERNAME': 'private-user', 'FTP_PASSWORD': 'private-password',
        }, ftp_class=lambda **kwargs: fake)
        self.assertEqual(result['manifest'], {'present': False, 'ftp_code': 550})
        self.assertNotIn('private-password', str(result))


if __name__ == '__main__':
    unittest.main()
