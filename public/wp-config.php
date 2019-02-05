<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// Load custom functions.
if ( ! function_exists( '_wordpressdev_set_directory_constants' ) ) {
	require_once dirname( __FILE__ ) . '/functions.php';
}

// Detect and set WordPress core and content locations.
if ( ! defined( 'WP_CORE_PATH_RELATIVE' ) ) {
	_wordpressdev_set_directory_constants();
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wordpress' );

/** MySQL hostname */
define( 'DB_HOST', 'database:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

// Allow local environment to override config.
if ( file_exists( dirname( __FILE__ ) . '/wp-config-local.php' ) ) {
	require dirname( __FILE__ ) . '/wp-config-local.php';
} elseif ( file_exists( dirname( dirname( __FILE__ ) ) . '/wp-config-local.php' ) ) {
	require dirname( dirname( __FILE__ ) ) . '/wp-config-local.php';
}

// Define constants that haven't been overridden by wp-tests-config-local.php.
$constants = array(
	'FORCE_SSL_ADMIN'                => true,
	'WP_DEBUG'                       => true,
	'WP_DEBUG_LOG'                   => true,
	'WP_DISABLE_FATAL_ERROR_HANDLER' => true,
	'JETPACK_DEV_DEBUG'              => true,
);
foreach ( $constants as $constant_name => $constant_value ) {
	if ( ! defined( $constant_name ) ) {
		define( $constant_name, $constant_value );
	}
}
unset( $constants, $constant_name, $constant_value );

/* That's all, stop editing! Happy blogging. */

if ( defined( 'MULTISITE' ) && MULTISITE ) {
	// Set 'WP_SITEURL' and 'WP_CONTENT_URL' based on 'WP_HOME' on the 'ms_loaded' action hook.
	$wp_filter = array(
		'ms_loaded' => array(
			1 => array(
				'_wordpressdev_set_url_constants' => array(
					'function'      => '_wordpressdev_set_url_constants',
					'accepted_args' => 0,
				),
			),
		),
	);
} else {
	// Set 'WP_SITEURL' and 'WP_CONTENT_URL' based on 'WP_HOME'.
	_wordpressdev_set_url_constants();
}
