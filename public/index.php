<?php
/**
 * Custom index.php file to set up additional configuration and load WordPress.
 *
 * @copyright 2019 Google LLC
 * @license   GNU General Public License, version 2
 * @link      https://github.com/GoogleChromeLabs/wordpressdev
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
