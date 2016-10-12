<?php
/**
 * EditThis Frontend Functionality
 *
 * @package EditThis
 * @subpackage Handlers
 *
 * @since 1.0.0
 */

namespace EditThis;

/**
 * The Frontend Functionality
 *
 * Hooks into various frontend systems to handle
 * localization setup and asset enqueueing.
 *
 * @internal Used by the System.
 *
 * @since 1.0.0
 */
final class Frontend extends Handler {
	// =========================
	// ! Hook Registration
	// =========================

	/**
	 * Register hooks.
	 *
	 * @since 1.0.0
	 */
	public static function register_hooks() {
		// Don't do anything if in the backend
		if ( is_backend() ) {
			return;
		}

		// Setup stuff
		self::add_action( 'plugins_loaded', 'load_textdomain', 10, 0 );

		// Script/Style Enqueues
		self::add_action( 'enqueue_scripts', 'enqueue_assets' );
	}

	// =========================
	// ! Setup Stuff
	// =========================

	/**
	 * Load the text domain.
	 *
	 * @since 1.0.0
	 */
	public static function load_textdomain() {
		// Load the textdomain
		load_plugin_textdomain( 'editthis', false, dirname( EDITTHIS_PLUGIN_FILE ) . '/languages' );
	}

	// =========================
	// ! Script/Style Enqueues
	// =========================

	/**
	 * Enqueue necessary styles and scripts.
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_assets(){
		// Admin styling
		wp_enqueue_style( 'editthis', plugins_url( 'css/public.css', SLUG_PLUGIN_FILE ), '1.0.0', 'screen' );

		// Admin javascript
		wp_enqueue_script( 'editthis-js', plugins_url( 'js/public.js', SLUG_PLUGIN_FILE ), array(), '1.0.0' );

		// Localize the javascript
		wp_localize_script( 'editthis-js', 'pluginnameL10n', array(
			// to be written
		) );
	}
}
