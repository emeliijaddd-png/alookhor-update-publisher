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
server_log="$RUNNER_TEMP/alookhor-wp-server.log"
export WP_SMOKE_ROOT="$root" WP_SMOKE_IDS="/tmp/alookhor-wp-smoke-products-$$.json"
server_pid=''
cleanup() {
  code=$?
  if [[ -n "$server_pid" ]]; then kill "$server_pid" 2>/dev/null || true; fi
  if (( code != 0 )); then
    echo "::error title=Isolated WordPress/WooCommerce test::Smoke test failed (exit $code); see setup and server log below."
    if [[ -f "$server_log" ]]; then tail -n 60 "$server_log"; fi
  fi
  rm -f "$WP_SMOKE_IDS"
}
trap cleanup EXIT

git clone -q --depth 1 --branch 6.8 https://github.com/WordPress/WordPress.git "$root"
test "$(git -C "$root" rev-parse HEAD)" = '6ba3d560fc2b033654f6dbfc6093fefb5c50f148'
curl -fsSL --retry 3 https://github.com/wp-cli/wp-cli/releases/download/v2.12.0/wp-cli-2.12.0.phar -o "$cli"
printf 'ce34ddd838f7351d6759068d09793f26755463b4a4610a5a5c0a97b68220d85c  %s\n' "$cli" | sha256sum -c -
curl -fsSL --retry 3 https://github.com/woocommerce/woocommerce/releases/download/10.2.0/woocommerce.zip -o "$woo"
printf '8e9ab54e04280f1d49e0d8199761217d5d577482eb5fe47420f7dd42533ef1cb  %s\n' "$woo" | sha256sum -c -
mkdir -p "$root/wp-content/plugins"
unzip -q "$woo" -d "$root/wp-content/plugins"
cp -a plugin/alookhor-control-center "$root/wp-content/plugins/"
wp() { php -d memory_limit=512M "$cli" --path="$root" "$@"; }
wp core config --dbname=wp_smoke --dbuser=wp_smoke --dbpass=local-smoke-only --dbhost=127.0.0.1:3306 --skip-check
wp core install --url=http://127.0.0.1:8099 --title='Local cart CI' --admin_user=ciadmin --admin_password=local-smoke-only --admin_email=smoke@example.test --skip-email
wp plugin activate woocommerce
wp plugin activate alookhor-control-center
wp rewrite structure '/%postname%/'
wp rewrite flush
wp eval-file scripts/cart-tests/wordpress_smoke_seed.php
php -d memory_limit=512M -S 127.0.0.1:8099 -t "$root" "$(pwd)/scripts/cart-tests/wordpress_router.php" >"$server_log" 2>&1 &
server_pid=$!
python3 scripts/cart-tests/wordpress_smoke.py
