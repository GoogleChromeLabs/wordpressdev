<?php

// Load custom functions.
require_once dirname( __FILE__ ) . '/functions.php';

/* Path to the WordPress codebase you'd like to test. Add a forward slash in the end. */
if ( defined( 'WP_RUN_CORE_TESTS' ) && WP_RUN_CORE_TESTS ) {
	_wordpressdev_set_directory_constants( WP_TESTS_CORE_PATH_RELATIVE, WP_TESTS_CORE_PATH_RELATIVE . '/wp-content' );
} else {
	_wordpressdev_set_directory_constants( WP_TESTS_CORE_PATH_RELATIVE );
}

// ** MySQL settings ** //

// This configuration file will be used by the copy of WordPress being tested.
// wordpress/wp-config.php will be ignored.

// WARNING WARNING WARNING!
// These tests will DROP ALL TABLES in the database with the prefix named below.
// DO NOT use a production database or one that is shared with something else.

define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'wordpress' );
define( 'DB_PASSWORD', 'wordpress' );
define( 'DB_HOST', 'database:3306' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 */
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );

$table_prefix = 'wptests_';   // Only numbers, letters, and underscores please!

define( 'WP_TESTS_DOMAIN', 'example.org' );
define( 'WP_TESTS_EMAIL', 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Test Blog' );
define( 'WP_HOME', 'http://example.org' );

// Allow local environment to override config.
if ( file_exists( dirname( __FILE__ ) . '/wp-tests-config-local.php' ) ) {
	require dirname( __FILE__ ) . '/wp-tests-config-local.php';
} elseif ( file_exists( dirname( dirname( __FILE__ ) ) . '/wp-tests-config-local.php' ) ) {
	require dirname( dirname( __FILE__ ) ) . '/wp-tests-config-local.php';
}

/*
 * Path to the theme to test with.
 *
 * The 'default' theme is symlinked from test/phpunit/data/themedir1/default into
 * the themes directory of the WordPress installation defined above.
 */
if ( ! defined( 'WP_DEFAULT_THEME' ) ) {
	define( 'WP_DEFAULT_THEME', 'default' );
}

// Test with multisite enabled.
// Alternatively, use the tests/phpunit/multisite.xml configuration file.
// define( 'WP_TESTS_MULTISITE', true );

// Force known bugs to be run.
// Tests with an associated Trac ticket that is still open are normally skipped.
// define( 'WP_TESTS_FORCE_KNOWN_BUGS', true );

// Test with WordPress debug mode (default).
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
}

/* That's all, stop editing! Happy blogging. */

// Set 'WP_SITEURL' and 'WP_CONTENT_URL' based on 'WP_HOME'.
_wordpressdev_set_url_constants();

define( 'WP_PHP_BINARY', 'php' );
define( 'WPLANG', '' );
