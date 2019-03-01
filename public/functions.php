<?php
/**
 * Custom functions to load before WordPress is loaded.
 *
 * @copyright 2019 Google LLC
 * @license   GNU General Public License, version 2
 * @link      https://github.com/GoogleChromeLabs/wordpressdev
 */

/**
 * Detects the relative WordPress core path to use.
 *
 * If the 'WP_CORE_PATH_RELATIVE' constant is already defined, the function simply returns its value.
 * Otherwise it reads the core path from the 'WP_CORE_DIR' environment variable or the 'wp-cli.yml'
 * file in the directory located one level above.
 *
 * If all else fails, the function falls back to using the 'core-dev/build' path.
 *
 * @access private
 *
 * @return string WordPress core path, relative to the 'public' directory.
 */
function _wordpressdev_detect_core_path_relative() {
	if ( defined( 'WP_CORE_PATH_RELATIVE' ) ) {
		return WP_CORE_PATH_RELATIVE;
	}

	// Try reading core path from 'WP_CORE_DIR' environment variable.
	if ( false !== getenv( 'WP_CORE_DIR' ) ) {
		$core_dir = getenv( 'WP_CORE_DIR' );
		if ( 0 === strpos( $core_dir, dirname( __FILE__ ) ) ) {
			return trim( str_replace( dirname( __FILE__ ), '', $core_dir ), '/' );
		}
	}

	// Try reading core path from 'wp-cli.yml'.
	if ( function_exists( 'yaml_parse_file' ) && file_exists( dirname( dirname( __FILE__ ) ) . '/wp-cli.yml' ) ) {
		$yaml = yaml_parse_file( dirname( dirname( __FILE__ ) ) . '/wp-cli.yml' );
		if ( is_array( $yaml ) && ! empty( $yaml['path'] ) ) {
			return str_replace( 'public/', '', trim( $yaml['path'], '/' ) );
		}
	}

	// Fall back to a hard-coded 'core-dev/build' as last resort.
	return 'core-dev/build';
}

/**
 * Detects the home URL to use.
 *
 * If the 'WP_HOME' constant is already defined, the function simply returns its value. Otherwise it
 * relies on the $current_blog global if in multisite, or the 'HTTP_HOST' server variable, or the
 * domain defined by the Lando environment.
 *
 * If all else fails, the function falls back to using the 'https://wordpressdev.lndo.site' URL.
 *
 * @access private
 *
 * @return string WordPress home URL.
 */
function _wordpressdev_detect_home_url() {
	if ( defined( 'WP_HOME' ) ) {
		return WP_HOME;
	}

	// In multisite, rely on the $current_blog global if yet available.
	if ( defined( 'MULTISITE' ) && MULTISITE && ! empty( $GLOBALS['current_blog'] ) ) {
		$domain = $GLOBALS['current_blog']->domain;
		$path   = ! empty( $GLOBALS['current_blog']->path ) && '/' !== $GLOBALS['current_blog']->path ? $GLOBALS['current_blog']->path : '';

		return 'https://' . $domain . $path;
	}

	// Rely on the 'HTTP_HOST' server variable if available.
	if ( isset( $_SERVER['HTTP_HOST'] ) ) {
		return 'https://' . strtolower( stripslashes( $_SERVER['HTTP_HOST'] ) );
	}

	// Use the domain defined by the Lando environment.
	if ( false !== getenv( 'LANDO_APP_NAME' ) && false !== getenv( 'LANDO_DOMAIN' ) ) {
		return 'https://' . getenv( 'LANDO_APP_NAME' ) . '.' . getenv( 'LANDO_DOMAIN' );
	}

	// Fall back to a hard-coded 'https://wordpressdev.lndo.site' as last resort.
	return 'https://wordpressdev.lndo.site';
}

/**
 * Detects and sets the location of the WordPress core and content directories to use.
 *
 * The function sets the 'ABSPATH' constant based on the first function parameter or the
 * {@see _wordpressdev_detect_core_path_relative()} function.
 *
 * The function also sets the 'WP_CONTENT_DIR' constant based on the second function parameter.
 *
 * @access private
 *
 * @param string $core_path_relative    Optional. WordPress core path, relative to the 'public' directory. Default
 *                                      is determined by {@see _wordpressdev_detect_core_path_relative()}.
 * @param string $content_path_relative Optional. WordPress content path, relative to the 'public' directory. Default
 *                                      is 'content'.
 */
function _wordpressdev_set_directory_constants( $core_path_relative = '', $content_path_relative = '' ) {
	if ( empty( $core_path_relative ) ) {
		$core_path_relative = _wordpressdev_detect_core_path_relative();
	}
	if ( empty( $content_path_relative ) ) {
		$content_path_relative = 'content';
	}

	// Define custom 'WP_CORE_PATH_RELATIVE' constant, for WordPress core directory relative to 'public'.
	if ( ! defined( 'WP_CORE_PATH_RELATIVE' ) ) {
		define( 'WP_CORE_PATH_RELATIVE', $core_path_relative );
	}

	// Define custom 'WP_CONTENT_PATH_RELATIVE' constant, for WordPress content directory relative to 'public'.
	if ( ! defined( 'WP_CONTENT_PATH_RELATIVE' ) ) {
		define( 'WP_CONTENT_PATH_RELATIVE', $content_path_relative );
	}

	// Define 'ABSPATH'.
	if ( ! defined( 'ABSPATH' ) ) {
		define( 'ABSPATH', dirname( __FILE__ ) . '/' . WP_CORE_PATH_RELATIVE . '/' );
	}

	// Define 'WP_CONTENT_DIR'.
	if ( ! defined( 'WP_CONTENT_DIR' ) ) {
		define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/' . WP_CONTENT_PATH_RELATIVE );
	}
}

/**
 * Defines additional URL constants for WordPress core and content directories to use.
 *
 * The function sets the 'WP_SITEURL' and 'WP_CONTENT_URL' constants based on the first function parameter
 * or the {@see _wordpressdev_detect_home_url()} function.
 *
 * @access private
 *
 * @param string $home_url Optional. WordPress home URL. Default is determined by {@see _wordpressdev_detect_home_url()}.
 */
function _wordpressdev_set_url_constants( $home_url = '' ) {
	if ( empty( $home_url ) ) {
		$home_url = _wordpressdev_detect_home_url();
	}

	// Define 'WP_HOME'.
	if ( ! defined( 'WP_HOME' ) ) {
		define( 'WP_HOME', $home_url );
	}

	// Define 'WP_SITEURL'.
	if ( ! defined( 'WP_SITEURL' ) ) {
		define( 'WP_SITEURL', rtrim( $home_url, '/' ) . '/' . WP_CORE_PATH_RELATIVE );
	}

	// Define 'WP_CONTENT_URL'.
	if ( ! defined( 'WP_CONTENT_URL' ) ) {
		define( 'WP_CONTENT_URL', rtrim( $home_url, '/' ) . '/' . WP_CONTENT_PATH_RELATIVE );
	}
}
