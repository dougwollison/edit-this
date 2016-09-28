<?php
/**
 * EditThis Template Functions
 *
 * @package EditThis
 * @subpackage Utilities
 *
 * @api
 *
 * @since 1.0.0
 */

/**
 * Create the HTML for the edit button.
 *
 * You can enter an array of options, or separate arguments which will
 * have their intended purpose guessed (use this method at your own risk).
 *
 * Example of argument guesses:
 *      integer or object: the target object.
 *      string with only letter/numbers/hyphens: the class name.
 *      string with no spaces: the target url.
 *		string not matching previous conditions: the text.
 *
 * @since 1.0.0
 *
 * @param array $options... The options for the link.
 *		@option mixed  "target" A value for admin_url() or a post/term object.
 *		@option string "text"   The text of the link, defaults to "Edit This".
 *      @option string "class"  The class(es) to add to the link.
 *      @option string "cap"    The capability to check for.
 *      @option string "attr"   The capability to check for.
 */
function get_edit_button( $options = null ) {
	$target = $text = $class = $cap = $attr = null;

	if ( is_array( $options ) ) {
		extract( $options, EXTR_IF_EXISTS );
	} else {
		$args = func_get_args();
		foreach ( $args as $arg ) {
			if ( is_numeric( $arg ) || is_int( $arg ) || is_object( $arg ) ) {
				$target = $arg;
			} else
			if ( is_string( $arg ) ) {
				if ( preg_match( '/^[\w\-]+$/', $arg ) ) {
					$class = $arg;
				} else
				if ( preg_match( '/^\S+$/', $arg ) ) {
					$target = $arg;
				} else {
					$text = $arg;
				}
			}
		}
	}
}

/**
 * Print the edit button.
 *
 * @see the_edit_button() for details.
 */
function the_edit_button( $options = null ) {
	echo call_user_func_array( 'get_edit_button', func_get_args() );
}
