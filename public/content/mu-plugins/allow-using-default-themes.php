<?php
/**
 * Must-use utility plugin.
 *
 * @copyright 2019 Google LLC
 * @license   GNU General Public License, version 2
 * @link      https://github.com/GoogleChromeLabs/wordpressdev
 *
 * @wordpress-plugin
 * Plugin Name: Allow Using Default Themes
 * Plugin URI:  https://github.com/GoogleChromeLabs/wordpressdev
 * Description: Registers the default wp-content/themes directory as additional theme directory.
 * Version:     1.0.0
 * Author:      Google and WordPressDev contributors
 * Author URI:  https://github.com/GoogleChromeLabs/wordpressdev
 */

// Ensure bundled core themes can be used.
if ( ! defined( 'WP_DEFAULT_THEME' ) ) {
	register_theme_directory( ABSPATH . 'wp-content/themes' );
}
