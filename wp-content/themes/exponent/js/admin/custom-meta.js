(function() {
    "use strict";
    jQuery( function( $ ) {
        $( '.colorpicker' ).wpColorPicker();
        var imagePickers = $( '.imagepicker-button' ),
            closeButton = $( '.media-close-button' ),
            frame = null;
        if( 0 < imagePickers.length ) {
            imagePickers.on( 'click', function() {
                event.preventDefault();
                var curButton = $(this),    
                    imgIdInput = curButton.siblings( '.imagepicker' ),
                    imagePickerPreview = curButton.siblings( '.imagepicker-preview' );
                if ( frame ) {
                    frame.open();
                    return;
                }
                frame  = wp.media({
                    title: 'Select Category Meta',
                    button: {
                        text: 'Add Image'
                    },
                    library : {
                        type : 'image'
                    }                
                });
                frame.on( 'select', function() {
                    var attachment = frame.state().get('selection').first().toJSON(),
                        url = '';
                    if( null != attachment ) {
                        url = 'object' == typeof attachment.sizes && attachment.sizes.hasOwnProperty( 'thumbnail' ) ? attachment.sizes.thumbnail.url : attachment.url;
                        imgIdInput.val( attachment.id );
                        imagePickerPreview.append( '<img src="' + url + '" alt=""/>' );
                        curButton.addClass( 'hidden' );
                        imagePickerPreview.addClass( 'active' );
                    }
                } );
                frame.open();
            } );
        }
        if( 0 < closeButton.length ) {
            closeButton.on( 'click', function() {
                var imagePickerPreview = $(this).closest( '.imagepicker-preview' ),
                    img = imagePickerPreview.find( 'img' ),
                    imgIdInput = imagePickerPreview.siblings( '.imagepicker' ),
                    imagePickerButton = imagePickerPreview.siblings( '.imagepicker-button' );
                img.remove();
                imagePickerPreview.removeClass( 'active' );
                imgIdInput.val('');
                imagePickerButton.removeClass( 'hidden' );
            } );
        }
    } );
})();