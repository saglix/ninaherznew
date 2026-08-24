<?php
/**
 * Production wp-config.php template.
 *
 * Replace the DB_* values with your production MySQL database details.
 */

define( 'DB_NAME', 'DATABASE_NAME' );
define( 'DB_USER', 'DATABASE_USER' );
define( 'DB_PASSWORD', 'DATABASE_PASSWORD' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

define( 'AUTH_KEY',         'replace-this-with-a-new-random-key' );
define( 'SECURE_AUTH_KEY',  'replace-this-with-a-new-random-key' );
define( 'LOGGED_IN_KEY',    'replace-this-with-a-new-random-key' );
define( 'NONCE_KEY',        'replace-this-with-a-new-random-key' );
define( 'AUTH_SALT',        'replace-this-with-a-new-random-key' );
define( 'SECURE_AUTH_SALT', 'replace-this-with-a-new-random-key' );
define( 'LOGGED_IN_SALT',   'replace-this-with-a-new-random-key' );
define( 'NONCE_SALT',       'replace-this-with-a-new-random-key' );

$table_prefix = 'wp_';

define( 'WP_DEBUG', false );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
