<?php
/**
 * Must-use utility plugin.
 *
 * @copyright 2019 Google LLC
 * @license   GNU General Public License, version 2
 * @link      https://github.com/GoogleChromeLabs/wordpressdev
 *
 * @wordpress-plugin
 * Plugin Name: WP-Admin Redirect
 * Plugin URI:  https://github.com/GoogleChromeLabs/wordpressdev
 * Description: Redirects the plain /wp-admin/ URL to its actual location in the WordPress core subdirectory.
 * Version:     1.0.0
 * Author:      Google and WordPressDev contributors
 * Author URI:  https://github.com/GoogleChromeLabs/wordpressdev
 */

add_action(
	'template_redirect',
	function() {
		if ( ! is_404() ) {
			return;
		}

		if ( empty( $_SERVER['REQUEST_URI'] ) || 0 !== strpos( $_SERVER['REQUEST_URI'], '/wp-admin' ) || admin_url() === home_url( 'wp-admin/' ) ) {
			return;
		}

		wp_safe_redirect( site_url( $_SERVER['REQUEST_URI'] ), 301 );
		exit;
	}
);
