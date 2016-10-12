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

		// Output Editing
		self::add_filter( 'body_class', 'add_visibility_class', 999, 1 );
		self::add_action( 'admin_bar_menu', 'add_toggle_button', 999, 1 );
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
		wp_enqueue_style( 'editthis', plugins_url( 'css/public.css', EDITTHIS_PLUGIN_FILE ), '1.0.0', 'screen' );

		// Admin javascript
		wp_enqueue_script( 'editthis-js', plugins_url( 'js/public.js', EDITTHIS_PLUGIN_FILE ), array(), '1.0.0' );

		// Localize the javascript
		wp_localize_script( 'editthis-js', 'editthisL10n', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		) );
	}

	// =========================
	// ! Output Editing
	// =========================

	/**
	 * Add the editthis-visible/hidden class to the body.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes The classes for the body.
	 *
	 * @return array The updated classes list.
	 */
	public static function add_visibility_class( $classes ) {
		$classes[] = 'editthis-' . get_default_visibility();

		return $classes;
	}

	/**
	 * Add the toggle button to the admin bar.
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_Admin_Bar $admin_bar The admin bar to edit.
	 */
	public static function add_toggle_button( \WP_Admin_Bar $admin_bar ) {
		$visible = get_default_visibility() == 'visible';

		$admin_bar->add_node( array(
			'id'    => 'editthis-toggle',
			'title' => $visible ? __( 'Hide Edit Buttons', 'editthis' ) : __( 'Show Edit Buttons', 'editthis' ),
			'href'  => '#',
		) );
	}
}
