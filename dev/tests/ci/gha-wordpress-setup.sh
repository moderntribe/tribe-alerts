#!/usr/bin/env bash
# GitHub Actions only: download WordPress core into dev/public, write wp-config.php
# for docker-compose php-tests (mysql hostname, tribe_ prefix), and run wp core install.
# Matches dev/tests/.env-dist and dev/docker test services — not used by Lando.

set -euo pipefail

ROOT="/application/www"
WP_DIR="$ROOT/dev/public"
WP_BIN="$ROOT/vendor/bin/wp"

DB_HOST="${GHA_WP_DB_HOST:-mysql}"
DB_NAME="${GHA_WP_DB_NAME:-tribe_tribe_alerts_acceptance}"
DB_USER="${GHA_WP_DB_USER:-root}"
DB_PASSWORD="${GHA_WP_DB_PASSWORD:-password}"
TABLE_PREFIX="${GHA_WP_TABLE_PREFIX:-tribe_}"

WP_URL="${GHA_WP_URL:-http://tribe-alertstest.tribe}"
WP_TITLE="${GHA_WP_TITLE:-Tribe Alerts CI}"
WP_ADMIN_USER="${GHA_WP_ADMIN_USER:-admin}"
WP_ADMIN_PASSWORD="${GHA_WP_ADMIN_PASSWORD:-password}"
WP_ADMIN_EMAIL="${GHA_WP_ADMIN_EMAIL:-admin@example.org}"

if [[ ! -f "$WP_BIN" ]]; then
	echo "WP-CLI not found at $WP_BIN (run composer install first)." >&2
	exit 1
fi

mkdir -p "$WP_DIR"

if [[ ! -f "$WP_DIR/wp-includes/version.php" ]]; then
	echo "Downloading WordPress core to ${WP_DIR}..."
	"$WP_BIN" core download --path="$WP_DIR"
fi

echo "Writing ${WP_DIR}/wp-config.php for CI..."
cat >"${WP_DIR}/wp-config.php" <<WP_CONFIG_EOF
<?php
/**
 * Auto-generated on GitHub Actions by dev/tests/ci/gha-wordpress-setup.sh.
 * Uses mysql service hostname and credentials from dev/tests/.env-dist (acceptance DB).
 */
define( 'DB_NAME', '${DB_NAME}' );
define( 'DB_USER', '${DB_USER}' );
define( 'DB_PASSWORD', '${DB_PASSWORD}' );
define( 'DB_HOST', '${DB_HOST}' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

\$table_prefix = '${TABLE_PREFIX}';

define( 'AUTH_KEY',         'put your unique phrase here|gha-ci' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here|gha-ci' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here|gha-ci' );
define( 'NONCE_KEY',        'put your unique phrase here|gha-ci' );
define( 'AUTH_SALT',        'put your unique phrase here|gha-ci' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here|gha-ci' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here|gha-ci' );
define( 'NONCE_SALT',       'put your unique phrase here|gha-ci' );

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SCRIPT_DEBUG', true );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
WP_CONFIG_EOF

if "$WP_BIN" core is-installed --path="$WP_DIR" 2>/dev/null; then
	echo "WordPress already installed at ${WP_DIR}; skipping wp core install."
else
	echo "Running wp core install..."
	"$WP_BIN" core install \
		--path="$WP_DIR" \
		--url="${WP_URL}" \
		--title="${WP_TITLE}" \
		--admin_user="${WP_ADMIN_USER}" \
		--admin_password="${WP_ADMIN_PASSWORD}" \
		--admin_email="${WP_ADMIN_EMAIL}" \
		--skip-email
fi

echo "WordPress CI prep finished."
