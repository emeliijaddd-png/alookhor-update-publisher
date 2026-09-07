# ALOOKHOR Update Publisher

Private release publisher for `updates.alookhor.ir`.

## Safety model

- Pushes to `main` run a build-only dry run plus non-mutating FTPS/WordPress access audit.
- Production deployment requires both a matching SemVer tag and `release.json` state `ready`; Draft tags fail closed.
- Explicit FTPS uses port 21, certificate/hostname verification, and the certificate-valid host `cp174.mihancheck.com`.
- Publication order is ZIP → remote ZIP/SHA/archive/version verification → metadata → atomic Manifest-last rename.
- `manifest.json` cannot advance when any package or metadata stage fails.
- FTP and WordPress Application Password credentials exist only in GitHub Actions Secrets.
- The FTP account is restricted to the update subdomain Document Root.

## Required repository secrets

- `FTP_SERVER`
- `FTP_PORT`
- `FTP_USERNAME`
- `FTP_PASSWORD`

Never commit credentials to this repository.

## One-time WordPress CI and activation-state bridge

The code in `ops/wordpress-ci-bootstrap.php` created the restricted `ALOOKHOR
Publisher` role and authenticated bridge for 3.8.5 → 3.8.6. Keep its updated
activation-state callbacks enabled through the first 3.8.6 → 3.8.7 transition.
They restore only this plugin when it was active before Core Upgrader and do not
grant `activate_plugins` or any other new capability.

Create a dedicated WordPress user with that role, create an Application Password,
and store these values only as GitHub Actions Secrets:

- `WP_BASE_URL`
- `WP_USERNAME`
- `WP_APP_PASSWORD`

After 3.8.7 is installed, active, and `/wp-json/alookhor-cc/v1/status` reports a
successful activation restore, the bootstrap snippet can be disabled and removed.

## Offline repository gate

Before any documentation or release work is committed, run:

```bash
python3 scripts/verify_repository_integrity.py
```

It is deterministic, requires no network and no credentials, and checks version
consistency across `release.json`, the plugin bootstrap, `readme.txt` and
`config/site.json`; that every declared and required source file exists; that
`docs/MASTER_CODE_REGISTRY.md` is fresh; and that no secret-shaped literal is
tracked. The scan reports file names and rule identifiers only, never values.

## Machine-readable diagnostics

Every tag deployment writes a sanitized report to the `publisher-status` branch.
No FTP or WordPress secret is included. The report lets the publisher agent inspect
build, FTPS, atomic manifest, and WordPress verification failures without screenshots.
