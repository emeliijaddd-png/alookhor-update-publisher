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
        # One annotation per log keeps the real final exception within GitHub's
        # per-step annotation cap (many separate lines hide the last error).
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
export WP_SMOKE_CANDIDATE_ZIP="$(pwd)/public/releases/alookhor-control-center-3.10.412.zip"
export WP_SMOKE_CANDIDATE_MANIFEST="$(pwd)/public/manifest.json"
test -f "$WP_SMOKE_CANDIDATE_ZIP"
stage='download and verify complete 405 installation source'
# The pinned GitHub blob is 5 MB; gh api with read-only GITHUB_TOKEN works
# for binary content whereas the JSON contents API omits files above 1 MB.
gh api -H 'Accept: application/vnd.github.raw+json' \
  'repos/emeliijaddd-png/alookhor-update-publisher/contents/packages/cc-release/alookhor-control-center.zip?ref=9ce51fdc897182811db4f808df8c7046de1221f5' > "$baseline"
printf '09fd472b032b3602acc8f2779ab2d1906040c5fa426d8f82f291557161b3f602  %s\n' "$baseline" | sha256sum -c -
stage='checkout pinned WordPress 6.8'
git clone -q --depth 1 --branch 6.8 https://github.com/WordPress/WordPress.git "$root"
test "$(git -C "$root" rev-parse HEAD)" = '6ba3d560fc2b033654f6dbfc6093fefb5c50f148'
stage='download pinned WP-CLI and WooCommerce'
curl -fsSL --retry 3 https://github.com/wp-cli/wp-cli/releases/download/v2.12.0/wp-cli-2.12.0.phar -o "$cli"
printf 'ce34ddd838f7351d6759068d09793f26755463b4a4610a5a5c0a97b68220d85c  %s\n' "$cli" | sha256sum -c -
curl -fsSL --retry 3 https://github.com/woocommerce/woocommerce/releases/download/10.2.0/woocommerce.zip -o "$woo"
printf '8e9ab54e04280f1d49e0d8199761217d5d577482eb5fe47420f7dd42533ef1cb  %s\n' "$woo" | sha256sum -c -
mkdir -p "$root/wp-content/plugins"
unzip -q "$woo" -d "$root/wp-content/plugins"
unzip -q "$baseline" -d "$root/wp-content/plugins"
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
stage='real Plugin_Upgrader rejects corruption and installs 405 to 412'
wp eval-file scripts/cart-tests/wordpress_upgrader_install.php
# A fresh request must load the updated files, not just PHP's already-loaded
# 405 functions from the request that performed the upgrade.
wp eval 'if (ALOOKHOR_CC_VERSION !== "3.10.412" || !is_plugin_active("alookhor-control-center/alookhor-control-center.php")) { throw new RuntimeException("Updated plugin was not active on a fresh WordPress load"); } echo "Active plugin after upgrade: ", ALOOKHOR_CC_VERSION, PHP_EOL;'
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
