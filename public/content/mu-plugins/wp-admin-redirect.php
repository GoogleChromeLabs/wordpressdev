<?php
/*
Plugin Name: WP-Admin Redirect
Plugin URI:  https://github.com/felixarntz/wordpressdev
Description: Redirects the plain /wp-admin/ URL to its actual location in the WordPress core subdirectory.
Version:     1.0.0
Author:      WordPressDev contributors
Author URI:  https://github.com/felixarntz/wordpressdev
*/

if ( ! empty( $_SERVER['REQUEST_URI'] ) && 0 === strpos( $_SERVER['REQUEST_URI'], '/wp-admin' ) && admin_url() !== home_url( 'wp-admin/' ) ) {
	// `wp_safe_redirect()` and `wp_redirect()` are not available here yet.
	header( 'Location: ' . site_url( $_SERVER['REQUEST_URI'] ), true, 301 );
	exit;
}
