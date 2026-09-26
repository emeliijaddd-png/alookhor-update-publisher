#!/usr/bin/env bash
# Isolated real WordPress + WooCommerce guest-cart contract. GitHub runner only.
# No production URLs, secrets, orders, installs, or POSTs are used.
set -euo pipefail
if [[ "${GITHUB_ACTIONS:-}" != 'true' || -z "${RUNNER_TEMP:-}" ]]; then
  echo 'This script only runs on an isolated GitHub Actions runner.' >&2
  exit 1
fi
root="$RUNNER_TEMP/alookhor-wordpress-smoke"
cli="$RUNNER_TEMP/alookhor-wp-cli.phar"
woo="$RUNNER_TEMP/alookhor-woocommerce.zip"
baseline="$RUNNER_TEMP/alookhor-405-source.zip"
other_412="$RUNNER_TEMP/alookhor-other-channel-412-source.zip"
server_log="$RUNNER_TEMP/alookhor-wp-server.log"
setup_log="$RUNNER_TEMP/alookhor-wp-setup.log"
export WP_SMOKE_ROOT="$root" WP_SMOKE_IDS="/tmp/alookhor-wp-smoke-products-$$.json"
server_pid=''
stage='checkout'
# GitHub's log download API may not be available in every sandbox. Also emit
# safe failure diagnostics as check-run annotations, without production secrets.
exec 3>&1 4>&2
exec >"$setup_log" 2>&1
cleanup() {
  code=$?
  if [[ -n "$server_pid" ]]; then kill "$server_pid" 2>/dev/null || true; fi
  if (( code != 0 )); then
    printf '::error file=scripts/cart-tests/wordpress_smoke.sh,title=Isolated cart smoke::Stage %s failed (exit %s)\n' "$stage" "$code" >&4
    for log in "$setup_log" "$server_log"; do
      if [[ -f "$log" ]]; then
        echo "Recent local log lines ($log):" >&4
        tail -n 22 "$log" >&4
        # WP-CLI's traceback can push the actual error outside the log tail.
        # Annotate the first root-cause line as well as the traceback tail.
        cause=$(grep -m1 -E 'PHP Fatal error:|Uncaught RuntimeException:|^Error:' "$log" | cut -c 1-1600 || true)
        if [[ -n "$cause" ]]; then
          cause=${cause//'%'/'%25'}
          printf '::error title=Isolated cart root cause::%s\n' "$cause" >&4
        fi
        detail=$(tail -n 16 "$log" | tr '\n' '|' | cut -c 1-2400)
        detail=${detail//'%'/'%25'}
        printf '::error title=Isolated cart diagnostic::%s\n' "$detail" >&4
      fi
    done
  else
    cat "$setup_log" >&3
  fi
  rm -f "$WP_SMOKE_IDS"
}
trap cleanup EXIT

stage='build and verify unpublished candidate ZIP'
python3 scripts/build_release.py
python3 scripts/verify_release_safety.py
export WP_SMOKE_CANDIDATE_ZIP="$(pwd)/public/releases/alookhor-control-center-3.10.413.zip"
export WP_SMOKE_CANDIDATE_MANIFEST="$(pwd)/public/manifest.json"
test -f "$WP_SMOKE_CANDIDATE_ZIP"
stage='download and verify complete 405 installation source'
# Read the immutable Git blob from this same repository, not a mutable branch,
# and verify its published SHA before installing it in the isolated runner.
git fetch -q --no-tags --depth=1 --filter=blob:none origin 9ce51fdc897182811db4f808df8c7046de1221f5
test "$(git rev-parse FETCH_HEAD)" = '9ce51fdc897182811db4f808df8c7046de1221f5'
git show 9ce51fdc897182811db4f808df8c7046de1221f5:packages/cc-release/alookhor-control-center.zip > "$baseline"
printf '09fd472b032b3602acc8f2779ab2d1906040c5fa426d8f82f291557161b3f602  %s\n' "$baseline" | sha256sum -c -
stage='checkout pinned WordPress 6.8'
git clone -q --depth 1 --branch 6.8 https://github.com/WordPress/WordPress.git "$root"
test "$(git -C "$root" rev-parse HEAD)" = '6ba3d560fc2b033654f6dbfc6093fefb5c50f148'
stage='download pinned WP-CLI and WooCommerce'
curl -fsSL --retry 3 https://github.com/wp-cli/wp-cli/releases/download/v2.12.0/wp-cli-2.12.0.phar -o "$cli"
printf 'ce34ddd838f7351d6759068d09793f26755463b4a4610a5a5c0a97b68220d85c  %s\n' "$cli" | sha256sum -c -
curl -fsSL --retry 3 https://github.com/woocommerce/woocommerce/releases/download/10.2.0/woocommerce.zip -o "$woo"
printf '8e9ab54e04280f1d49e0d8199761217d5d577482eb5fe47420f7dd42533ef1cb  %s\n' "$woo" | sha256sum -c -
mkdir -p "$root/wp-content/plugins" "$root/wp-content/mu-plugins"
unzip -q "$woo" -d "$root/wp-content/plugins"
unzip -q "$baseline" -d "$root/wp-content/plugins"
cp scripts/cart-tests/wordpress_header_fixture.php "$root/wp-content/mu-plugins/alookhor-ci-header.php"
wp() { php -d memory_limit=512M "$cli" --path="$root" "$@"; }
stage='install isolated WordPress'
wp core config --dbname=wp_smoke --dbuser=wp_smoke --dbpass=local-smoke-only --dbhost=127.0.0.1:3306 --skip-check
wp core install --url=http://127.0.0.1:8099 --title='Local cart CI' --admin_user=ciadmin --admin_password=local-smoke-only --admin_email=smoke@example.test --skip-email
# WP-CLI can infer its temporary directory name as a subdirectory URL. The
# built-in router serves from /, so force both base options to that exact origin.
wp option update home http://127.0.0.1:8099
wp option update siteurl http://127.0.0.1:8099
printf 'WP base: home=%s siteurl=%s\n' "$(wp option get home)" "$(wp option get siteurl)"
stage='activate WooCommerce and verified 405 baseline'
wp plugin activate woocommerce
wp plugin activate alookhor-control-center
verify_installed_zip() {
  # Inspect installed on-disk bytes after WordPress replaced the old plugin.
  # Matching the ZIP is stronger than checking the new Version header alone.
  python3 - <<'PY'
import os
from pathlib import Path
from zipfile import ZipFile
root = Path(os.environ['WP_SMOKE_ROOT']) / 'wp-content/plugins/alookhor-control-center'
with ZipFile(os.environ['WP_SMOKE_CANDIDATE_ZIP']) as archive:
    prefix = 'alookhor-control-center/'
    expected = {name[len(prefix):]: archive.read(name) for name in archive.namelist()
                if name.startswith(prefix) and not name.endswith('/')}
actual = {str(path.relative_to(root)): path.read_bytes() for path in root.rglob('*') if path.is_file()}
assert actual == expected, ('Installed plugin bytes differ from candidate ZIP', sorted(set(actual) ^ set(expected)))
print('Real WordPress installed all', len(actual), 'candidate files byte-for-byte')
PY
}
stage='WordPress manual ZIP replacement from active 405'
WP_SMOKE_SOURCE_VERSION=3.10.405 wp eval-file scripts/cart-tests/wordpress_manual_upload.php
verify_installed_zip
stage='restore pinned 405 fixture for independent native-update test'
test "$root" = "$RUNNER_TEMP/alookhor-wordpress-smoke"
rm -rf -- "$root/wp-content/plugins/alookhor-control-center"
unzip -q "$baseline" -d "$root/wp-content/plugins"
wp eval 'if (ALOOKHOR_CC_VERSION !== "3.10.405" || !is_plugin_active("alookhor-control-center/alookhor-control-center.php")) { throw new RuntimeException("405 was not restored in the isolated fixture"); } echo "Restored isolated 405 baseline for native update.\n";'
stage='real Plugin_Upgrader rejects corruption and installs 405 to 413'
wp eval-file scripts/cart-tests/wordpress_upgrader_install.php
verify_installed_zip
# A fresh request must load the updated files, not just PHP's already-loaded
# 405 functions from the request that performed the upgrade.
wp eval 'if (ALOOKHOR_CC_VERSION !== "3.10.413" || !is_plugin_active("alookhor-control-center/alookhor-control-center.php")) { throw new RuntimeException("Updated plugin was not active on a fresh WordPress load"); } echo "Active plugin after upgrade: ", ALOOKHOR_CC_VERSION, PHP_EOL;'
wp rewrite structure '/%postname%/'
wp rewrite flush
stage='seed real WooCommerce products'
wp eval-file scripts/cart-tests/wordpress_smoke_seed.php
printf 'Active REST root: '; wp eval "echo rest_url('alookhor-cart/v4/'), PHP_EOL;"
stage='real WordPress updater rejects a mocked corrupt ZIP'
wp eval-file scripts/cart-tests/wordpress_updater_negative.php
stage='HTTP guest cart and variation assertions'
php -d memory_limit=512M -S 127.0.0.1:8099 -t "$root" "$(pwd)/scripts/cart-tests/wordpress_router.php" >"$server_log" 2>&1 &
server_pid=$!
python3 scripts/cart-tests/wordpress_smoke.py
stage='real Chromium guest cart browser assertions'
npm ci --prefix scripts/cart-tests --ignore-scripts --no-audit --no-fund
node scripts/cart-tests/wordpress_browser.cjs
# Public read-only checks have since reported 412 and exposed the old broken JS.
# Test the *different* ZIP advertised by the pinned older updater, not our old
# repaired 412 draft. This is still strictly an isolated CI WordPress install:
# never call its public cart-probe endpoint or touch production.
stage='fetch immutable other-channel 412 fixture for a separate manual replacement'
git fetch -q --no-tags --depth=1 --filter=blob:none origin 74414472235602e04465e7084765c7d22d19e86e
test "$(git rev-parse FETCH_HEAD)" = '74414472235602e04465e7084765c7d22d19e86e'
git show 74414472235602e04465e7084765c7d22d19e86e:packages/cc-release/alookhor-control-center.zip > "$other_412"
printf '47456a5646a2f870bfdee4dd1dd460c9196dc5f47bd1a0071e6b46cf87ea941d  %s\n' "$other_412" | sha256sum -c -
python3 - "$other_412" <<'PYTEST'
import sys
from zipfile import ZipFile
with ZipFile(sys.argv[1]) as archive:
    names = archive.namelist()
    assert sum(not name.endswith('/') for name in names) == 132 and archive.testzip() is None
    assert 'alookhor-control-center/includes/cart-probe.php' in names
    assert b'empty_cart(true)' in archive.read('alookhor-control-center/includes/cart-probe.php')
    assert b'API+bust' in archive.read('alookhor-control-center/assets/js/frontend-cart.js')
print('Other channel 412 fixture verified; never call its destructive endpoint.')
PYTEST
stage='replace isolated other-channel 412 by explicit manual ZIP upload'
if [[ -n "$server_pid" ]]; then kill "$server_pid" 2>/dev/null || true; wait "$server_pid" 2>/dev/null || true; server_pid=''; fi
test "$root" = "$RUNNER_TEMP/alookhor-wordpress-smoke"
rm -rf -- "$root/wp-content/plugins/alookhor-control-center"
unzip -q "$other_412" -d "$root/wp-content/plugins"
wp eval 'if (ALOOKHOR_CC_VERSION !== "3.10.412" || !is_plugin_active("alookhor-control-center/alookhor-control-center.php")) { throw new RuntimeException("Other-channel 412 was not restored in the isolated fixture"); } echo "Restored isolated other-channel 412 fixture.\n";'
WP_SMOKE_SOURCE_VERSION=3.10.412 wp eval-file scripts/cart-tests/wordpress_manual_upload.php
verify_installed_zip
wp eval 'if (ALOOKHOR_CC_VERSION !== "3.10.413" || !is_plugin_active("alookhor-control-center/alookhor-control-center.php") || is_file(WP_PLUGIN_DIR . "/alookhor-control-center/includes/cart-probe.php")) { throw new RuntimeException("413 did not fully replace the other-channel 412 fixture"); } echo "413 active on fresh WordPress load after 412 manual replacement.\n";'
stage='real HTTP and Chromium cart after isolated 412-to-413 replacement'
php -d memory_limit=512M -S 127.0.0.1:8099 -t "$root" "$(pwd)/scripts/cart-tests/wordpress_router.php" >"$server_log" 2>&1 &
server_pid=$!
python3 scripts/cart-tests/wordpress_smoke.py
node scripts/cart-tests/wordpress_browser.cjs
