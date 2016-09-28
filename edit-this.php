<?php
/*
Plugin Name: Edit This
Plugin URI: https://github.com/dougwollison/edit-this
Description: WordPress utility for adding "Edit This" buttons to the front end of your site while logged-in.
Version: 1.0.0
Author: Doug Wollison
Author URI: http://dougw.me
Tags: admin, edit, ui, button
License: GPL2
Text Domain: edit-this
Domain Path: /languages
*/

// =========================
// ! Constants
// =========================

/**
 * Reference to the plugin file.
 *
 * @since 1.0.0
 *
 * @var string
 */
define( 'EDITTHIS_PLUGIN_FILE', __FILE__ );

/**
 * Reference to the plugin directory.
 *
 * @since 1.0.0
 *
 * @var string
 */
define( 'EDITTHIS_PLUGIN_DIR', dirname( EDITTHIS_PLUGIN_FILE ) );

// =========================
// ! Includes
// =========================

require( EDITTHIS_PLUGIN_DIR . '/includes/autoloader.php' );
require( EDITTHIS_PLUGIN_DIR . '/includes/functions-editthis.php' );
require( EDITTHIS_PLUGIN_DIR . '/includes/functions-template.php' );

// =========================
// ! Setup
// =========================

EditThis\System::setup();
