( function( $ ) {
	$( document ).on( 'click', '.merotheme-widget-image-select', function( event ) {
		event.preventDefault();

		var button = $( this );
		var widget = button.closest( '.widget' );
		var input = widget.find( '.merotheme-widget-image-url' );
		var preview = widget.find( '.merotheme-widget-image-preview' );
		var removeButton = widget.find( '.merotheme-widget-image-remove' );
		var frame = wp.media( {
			title: 'Select hero image',
			button: {
				text: 'Use this image',
			},
			multiple: false,
		} );

		frame.on( 'select', function() {
			var attachment = frame.state().get( 'selection' ).first().toJSON();

			input.val( attachment.url ).trigger( 'change' );
			preview.html( '<img src="' + attachment.url + '" alt="" style="max-width:100%;height:auto;">' );
			removeButton.show();
		} );

		frame.open();
	} );

	$( document ).on( 'click', '.merotheme-widget-image-remove', function( event ) {
		event.preventDefault();

		var button = $( this );
		var widget = button.closest( '.widget' );

		widget.find( '.merotheme-widget-image-url' ).val( '' ).trigger( 'change' );
		widget.find( '.merotheme-widget-image-preview' ).empty();
		button.hide();
	} );
}( jQuery ) );
