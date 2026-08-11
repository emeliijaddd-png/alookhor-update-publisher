# ALOOKHOR Update Publisher

Private release publisher for `updates.alookhor.ir`.

## Safety model

- Pushes to `main` run a build-only dry run.
- Production deployment runs only for a SemVer tag such as `v3.8.6`.
- The plugin package uploads before the manifest.
- `manifest.json` is uploaded as `manifest.json.next` and renamed atomically.
- FTP credentials exist only in GitHub Actions Secrets.
- The FTP account must be restricted to the update subdomain Document Root.

## Required repository secrets

- `FTP_SERVER`
- `FTP_PORT`
- `FTP_USERNAME`
- `FTP_PASSWORD`

Never commit credentials to this repository.

## One-time WordPress CI bootstrap for 3.8.5 → 3.8.6

Until 3.8.6 installs its native authenticated REST endpoints, activate the code in
`ops/wordpress-ci-bootstrap.php` through Code Snippets. It creates the restricted
`ALOOKHOR Publisher` role and authenticated status/install endpoints.

Create a dedicated WordPress user with that role, create an Application Password,
and store these values only as GitHub Actions Secrets:

- `WP_BASE_URL`
- `WP_USERNAME`
- `WP_APP_PASSWORD`

After 3.8.6 is installed and `/wp-json/alookhor-cc/v1/status` is verified, the
bootstrap snippet can be disabled and removed.

## Machine-readable diagnostics

Every tag deployment writes a sanitized report to the `publisher-status` branch.
No FTP or WordPress secret is included. The report lets the publisher agent inspect
build, FTPS, atomic manifest, and WordPress verification failures without screenshots.
