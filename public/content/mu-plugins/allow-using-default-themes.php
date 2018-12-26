<?php
/*
Plugin Name: Allow Using Default Themes
Plugin URI:  https://github.com/felixarntz/wordpressdev
Description: Registers the default wp-content/themes directory as additional theme directory.
Version:     1.0.0
Author:      WordPressDev contributors
Author URI:  https://github.com/felixarntz/wordpressdev
*/

// Ensure bundled core themes can be used.
if ( ! defined( 'WP_DEFAULT_THEME' ) ) {
	register_theme_directory( ABSPATH . 'wp-content/themes' );
}
