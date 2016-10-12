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
 *      @option string "attr"   The attributes fo the link.
 */
function get_edit_button( $options = null ) {
	$target = $text = $class = $cap = $attr = null;
	$default_options = array(
		'target' => null,
		'text'   => __( 'Edit This', 'editthis' ),
		'class'  => '',
		'cap'    => 'manage_options',
		'attr'   => array(),
	);

	if ( is_array( $options ) ) {
		$options = wp_parse_args( $options, $default_options );
	} else {
		$options = $default_options;
		$args = func_get_args();
		foreach ( $args as $arg ) {
			if ( is_numeric( $arg ) || is_int( $arg ) || is_object( $arg ) ) {
				$options['target'] = $arg;
			} else
			if ( is_string( $arg ) ) {
				if ( preg_match( '/^[\w\-]+$/', $arg ) ) {
					$options['class'] = $arg;
				} else
				if ( preg_match( '/^\S+$/', $arg ) ) {
					$options['target'] = $arg;
				} else {
					$options['text'] = $arg;
				}
			}
		}
	}

	// Extract options
	extract( $options, EXTR_IF_EXISTS );

	// If target is null, defaul to current post
	if ( is_null( $target ) ) {
		$target = $GLOBALS['post'];
	}

	// Build the URL based on the target
	if ( is_string( $target ) ) { // Assume a page within the admin
		// Create the URL and get the cap test result
		$url = admin_url( $target );
		$can = current_user_can( $cap );
	} else { // Assume a Object/ID
		// If not an object, assume Post and fetch.
		if ( ! is_object( $target ) ) {
			$target = get_post( $target );
		}

		// Figure out the link based on what kind of object it is
		if ( property_exists( $target, 'post_type' ) ) {
			// A post object
			$url = get_edit_post_link( $target->ID );

			// Override the cap requirement
			$cap = get_post_type_object( $target->post_type )->cap->edit_post;
			$can = current_user_can( $cap, $target->ID );
		} else
		if ( property_exists( $target, 'taxonomy' ) ) {
			// A term object
			$taxonomy = get_taxonomy( $target->taxonomy );
			$url = get_edit_term_link( $target->term_id, $target->taxonomy, $taxonomy->object_type[0] );

			// Override the cap requirement
			$cap = $taxonomy->cap->edit_terms;
			$can = current_user_can( $cap, $target->term_id );
		}
	}

	// Add to attributes list
	$attr['href'] = $url;

	// Convert class to array and append editthis-link class
	$class = (array) $class;
	$class[] = 'editthis-link';

	// Add to attributes list
	$attr['class'] = $class;

	// Return the link HTML if the cap test passes
	if ( $can ) {
		$html = '<a';
		foreach ( $attr as $key => $value ) {
			$value = esc_attr( $value );

			if ( is_numeric( $key ) ) {
				// Added numerically, assume some kind of flag
				$html .= " {$value}";
			} else {
				// Standard attribute/value pair
				if ( is_array( $value ) ) {
					// Implode if an array
					$value = implode( ' ', $value );
				}
				$html .= " {$key}='{$value}'";
			}
		}
		$html .= ">{$text}</a>";

		return $html;
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
