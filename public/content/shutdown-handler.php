<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName

/*
 * Plugin Name: Non-Handling Shutdown Handler
 * Description: Disable WSOD protection so that plugins will not auto-suspend during development while errors often occur.
 * Plugin URI: https://gist.github.com/westonruter/583a42392a0b8684dc268b40d44eb7f1
 * Plugin Author: Weston Ruter
 */

/**
 * Class Non_Handling_Shutdown_Handler
 */
class Non_Handling_Shutdown_Handler extends WP_Shutdown_Handler {

	/**
	 * Override the shutdown handler to no-op.
	 */
	public function handle() {
		// No-op.
	}
}

return new Non_Handling_Shutdown_Handler();
