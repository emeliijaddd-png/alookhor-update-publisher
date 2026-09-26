# ALOOKHOR Update Publisher

GitHub source and release checks for ALOOKHOR Control Center.

- **Live site (public REST check, 2026-09-26):** 3.10.405. This does not prove the bytes installed on the server.
- **This branch:** 3.10.412 **draft cart-repair candidate**, restored from the complete GitHub 3.10.405 ZIP and modified with focused fixes. It is **not published or install-ready**.
- **Other `main` branch:** 3.10.411 at the time of this audit; its plugin tree is missing files that are present in the 3.10.405 ZIP. Do not replace the active installation with it or an older package.
- **Build:** `python3 scripts/build_release.py && python3 scripts/verify_release_safety.py` (restore tracked `public/` after local verification; draft artifacts are not committed).
- **Tests:** `python3 -m unittest discover -s scripts/tests -q`, `php scripts/cart-tests/cart_contract.php`, `npm ci --prefix scripts/cart-tests && npm test --prefix scripts/cart-tests`.
- **Review:** [Cart diagnosis, fixes, and remaining release gates](docs/CART_405_AUDIT.md). Previous release-channel history is archived in [RECOVERY_390.md](docs/RECOVERY_390.md).

A branch push runs **build/tests only**. Production deployment is disabled for branch pushes; a version tag and gated checks are required. Nothing in this branch installs a plugin on the live site.
