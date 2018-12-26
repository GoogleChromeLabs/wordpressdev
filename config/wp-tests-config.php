<?php

// If testing core, run from 'build' directory. Otherwise, run from 'src' directory.
if ( defined( 'WP_RUN_CORE_TESTS' ) && WP_RUN_CORE_TESTS ) {
	define( 'WP_TESTS_CORE_PATH_RELATIVE', basename( dirname( __FILE__ ) ) . '/build' );
} else {
	define( 'WP_TESTS_CORE_PATH_RELATIVE', basename( dirname( __FILE__ ) ) . '/src' );
}

// 'wp-tests-config.php' is managed in a central location.
require_once dirname( dirname( __FILE__ ) ) . '/wp-tests-config.php';
