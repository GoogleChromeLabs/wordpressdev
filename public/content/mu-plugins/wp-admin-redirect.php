<?php
/*
Plugin Name: WP-Admin Redirect
Plugin URI:  https://github.com/felixarntz/wordpressdev
Description: Redirects the plain /wp-admin/ URL to its actual location in the WordPress core subdirectory.
Version:     1.0.0
Author:      WordPressDev contributors
Author URI:  https://github.com/felixarntz/wordpressdev
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
