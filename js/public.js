/* globals editthisL10n */
jQuery( function( $ ) {
	var visible = $( 'body' ).hasClass( 'editthis-visible' );
	$( '#wp-admin-bar-editthis-toggle a' ).click( function( e ) {
		e.preventDefault();

		// Toggle visible status
		visible = ! visible;
		// Update text
		$( this ).text( visible ? editthisL10n.hide : editthisL10n.show );
		// Change body class
		$( 'body' ).toggleClass( 'editthis-visible', visible ).toggleClass( 'editthis-hidden', ! visible );

		$.ajax( {
			url: editthisL10n.ajax_url,
			data: {
				action: 'editthis_toggle',
				default: hidden ? 0 : 1,
			}
		} );
	} );
} );
