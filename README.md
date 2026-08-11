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
