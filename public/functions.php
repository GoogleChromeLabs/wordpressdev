<?php
/**
 * Custom functions to load before WordPress is loaded.
 *
 * @package WordPress
 */

/**
 * Detects the relative WordPress core path to use.
 *
 * The function reads the core path from 'wp-cli.yml' in the directory located one level above. If the file
 * is not found or cannot be read, the function falls back to using the 'trunk-git/build' path.
 *
 * @access private
 *
 * @return string WordPress core path, relative to the 'public' directory.
 */
function _wordpressdev_detect_core_path_relative() {
	// Try reading core path from 'wp-cli.yml'.
	if ( function_exists( 'yaml_parse_file' ) && file_exists( dirname( dirname( __FILE__ ) ) . '/wp-cli.yml' ) ) {
		$yaml = yaml_parse_file( dirname( dirname( __FILE__ ) ) . '/wp-cli.yml' );
		if ( is_array( $yaml ) && ! empty( $yaml['path'] ) ) {
			return str_replace( 'public/', '', trim( $yaml['path'], '/' ) );
		}
	}

	return 'trunk-git/build';
}

/**
 * Detects and sets the location of the WordPress core and content directories to use.
 *
 * The function sets the 'ABSPATH' constant based on the function parameter or the
 * {@see _wordpressdev_detect_core_path_relative()} function.
 *
 * The function also sets the 'WP_CONTENT_DIR' constant, based on a hard-coded content path
 * 'content'.
 *
 * @access private
 *
 * @param string $core_path_relative    Optional. WordPress core path, relative to the 'public' directory. Default
 *                                      is determined by {@see _wordpressdev_detect_core_path_relative()}.
 * @param string $content_path_relative Optional. WordPress content path, relative to the 'public' directory. Default
 *                                      is 'content'.
 */
function _wordpressdev_set_directory_constants( $core_path_relative = '', $content_path_relative = 'content' ) {
	if ( empty( $core_path_relative ) ) {
		$core_path_relative = _wordpressdev_detect_core_path_relative();
	}

	// Define custom 'WP_CORE_PATH_RELATIVE' constant, for WordPress core directory relative to 'public'.
	define( 'WP_CORE_PATH_RELATIVE', $core_path_relative );

	// Define custom 'WP_CONTENT_PATH_RELATIVE' constant, for WordPress content directory relative to 'public'.
	define( 'WP_CONTENT_PATH_RELATIVE', $content_path_relative );

	// Define 'ABSPATH'.
	define( 'ABSPATH', dirname( __FILE__ ) . '/' . WP_CORE_PATH_RELATIVE . '/' );

	// Define 'WP_CONTENT_DIR'.
	define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/' . WP_CONTENT_PATH_RELATIVE );
}

/**
 * Defines additional URL constants for WordPress core and content directories to use.
 *
 * The function defines these constants based on the 'WP_HOME' constant. It should be called whenever that
 * constant has been set, which typically is in either 'wp-config.php' or, in multisite, from the 'sunrise.php'
 * drop-in or via the 'ms_loaded' action.
 *
 * The function will try to set 'WP_HOME' initially if it is not available yet. This may fail when accessing
 * via WP-CLI without the --url argument.
 *
 * @access private
 */
function _wordpressdev_set_url_constants() {
	// Define 'WP_HOME' if possible.
	if ( ! defined( 'WP_HOME' ) ) {
		if ( defined( 'MULTISITE' ) && MULTISITE && ! empty( $GLOBALS['current_blog'] ) ) {
			// In multisite, rely on the $current_blog global if yet available.
			$domain = $GLOBALS['current_blog']->domain;
			$path   = ! empty( $GLOBALS['current_blog']->path ) && '/' !== $GLOBALS['current_blog']->path ? $GLOBALS['current_blog']->path : '';
			define( 'WP_HOME', 'https://' . $domain . $path );
		} else {
			// Otherwise, rely on the 'HTTP_HOST' server variable.
			if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
				return;
			}

			define( 'WP_HOME', 'https://' . strtolower( stripslashes( $_SERVER['HTTP_HOST'] ) ) );
		}
	}

	// Define 'WP_SITEURL'.
	if ( ! defined( 'WP_SITEURL' ) ) {
		define( 'WP_SITEURL', rtrim( WP_HOME, '/' ) . '/' . WP_CORE_PATH_RELATIVE );
	}

	// Define 'WP_CONTENT_URL'.
	if ( ! defined( 'WP_CONTENT_URL' ) ) {
		define( 'WP_CONTENT_URL', rtrim( WP_HOME, '/' ) . '/' . WP_CONTENT_PATH_RELATIVE );
	}
}
