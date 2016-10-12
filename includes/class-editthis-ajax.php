<?php
/**
 * EditThis AJAX Handler
 *
 * @package EditThis
 * @subpackage Handlers
 *
 * @since 1.0.0
 */

namespace EditThis;

/**
 * The AJAX Request Handler
 *
 * Add necessary wp_ajax_* hooks to fullfill any
 * custom AJAX requests.
 *
 * @internal Used by the System.
 *
 * @since 1.0.0
 */
final class AJAX extends Handler {
	// =========================
	// ! Hook Registration
	// =========================

	/**
	 * Register hooks.
	 *
	 * @since 1.0.0
	 */
	public static function register_hooks() {
		// Don't do anything if not doing an AJAX request
		if ( ! defined( 'DOING_AJAX' ) || DOING_AJAX !== true ) {
			return;
		}

		self::add_action( 'wp_ajax_editthis_toggle', 'toggle_default' );
	}

	// =========================
	// ! Option Handling
	// =========================

	/**
	 * Toggle the user's default visibility option for the Edit This buttons.
	 *
	 * @since 1.0.0
	 */
	public static function toggle_default() {
		update_user_meta( get_current_user_id(), 'editthis_default_visibility', $_REQUEST['default'] );
		echo 1;
		exit;
	}
}
