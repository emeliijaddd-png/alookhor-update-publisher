# ALOOKHOR Update Publisher

GitHub source and release checks for ALOOKHOR Control Center.

- **Live site (public REST check, 2026-09-26):** 3.10.405. This does not prove the bytes installed on the server.
- **This branch:** 3.10.413 **draft cart-repair candidate**, restored from the complete GitHub 3.10.405 ZIP and modified with focused fixes. It is **not published on the native updater**; owner-controlled manual ZIP replacement is being verified for a limited trial.
- **Other `main` branch / public legacy server:** 3.10.411 is currently advertised at `updates.alookhor.ir`; the ZIP reproduced locally from `main` has **71 files rather than the verified 405 ZIP's 132**, and its SHA matches that public manifest (the hosted ZIP was not read back). Do **not** install 411. The updater inside the verified 405 ZIP defaults to a different GitHub-raw manifest that **now advertises a different, unsafe 3.10.412 ZIP (SHA `47456a56…`, 132 files, destructive cart probe)**. Never click Update for 412; live PHP/config overrides have not been verified.
- **Build:** `python3 scripts/build_release.py && python3 scripts/verify_release_safety.py` (restore tracked `public/` after local verification; draft artifacts are not committed).
- **Tests:** 19 Python, 23 PHP contract assertions and 11 JS DOM checks. [GitHub Actions passed build plus real isolated WordPress 6.8/WooCommerce 10.2.0 and Chromium](https://github.com/emeliijaddd-png/alookhor-update-publisher/actions/runs/36230380998): active 405 → complete 412 through WordPress's manual ZIP replacement **and** native Upgrader with mocked HTTP, corrupt-ZIP rejection, byte-for-byte installed-file comparison, and guest cart/add/variation/quantity/removal. Neither the live theme/cache nor the actual configured download channel was exercised.
- **Current 413 manual trial ZIP SHA-256:** `2c3de582cdd0592076864a216b449dd46939cb15e5479c3c60892bb5a35825ea` (131 files; not published to either live channel).
- **Owner-only manual trial:** [upload/replace guide](docs/MANUAL_INSTALL_3_10_413.md). Never use the competing automatic 412 offer.
- **Review:** [Cart diagnosis, fixes, and remaining release gates](docs/CART_405_AUDIT.md). Previous release-channel history is archived in [RECOVERY_390.md](docs/RECOVERY_390.md).

A branch push runs **build/tests only**. Production deployment is disabled for branch pushes; a version tag and gated checks are required. Nothing in this branch installs a plugin on the live site.
