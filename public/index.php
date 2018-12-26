<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

// Load custom functions.
require_once dirname( __FILE__ ) . '/functions.php';

// Detect and set WordPress core and content locations.
_wordpressdev_set_directory_constants();

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

// Load WordPress.
require ABSPATH . 'wp-blog-header.php';
