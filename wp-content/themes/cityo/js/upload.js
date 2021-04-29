(function ($) {
    "use strict";

	var cityo_upload;
	var cityo_selector;

	function cityo_add_file(event, selector) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		cityo_selector = selector;

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( cityo_upload ) {
			cityo_upload.open();
		} else {
			// Create the media frame.
			cityo_upload = wp.media.frames.cityo_upload =  wp.media({
				// Set the title of the modal.
				title: "Select Image",

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: "Selected",
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			cityo_upload.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = cityo_upload.state().get('selection').first();
				cityo_upload.close();
				cityo_selector.find('.upload_image').val(attachment.attributes.id).change();
				if ( attachment.attributes.type == 'image' ) {
					cityo_selector.find('.screenshot-user').empty().hide().prepend('<img src="' + attachment.attributes.url + '">').slideDown('fast');
				}
			});

		}
		// Finally, open the modal.
		cityo_upload.open();
	}

	function cityo_remove_file(selector) {
		selector.find('.screenshot-user').slideUp('fast').next().val('').trigger('change');
	}
	
	$('.upload_image_action .user-remove-image').on( 'click', function(event) {
		cityo_remove_file( $(this).parent().parent() );
	});

	$('.upload_image_action .user-add-image').on('click', function(event) {

		cityo_add_file(event, $(this).parent().parent());
	});





    // Uploading files

    var cityo_upload_image;
	var cityo_selector_image;

	function cityo_add_image_meta() {
		var $el = $(this);
		// If the media frame already exists, reopen it.
		if ( cityo_upload_image ) {
			cityo_upload_image.open();
		} else {
			// Create the media frame.
			cityo_upload_image = wp.media.frames.cityo_upload_image =  wp.media({
				// Set the title of the modal.
				title: "Select Image",

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: "Selected",
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				},
				multiple: false
			});

			// When an image is selected, run a callback.
			cityo_upload_image.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = cityo_upload_image.state().get('selection').first();
				cityo_upload_image.close();

				var id = attachment.attributes.id;
            	var url = attachment.attributes.url;
            	
				if ( attachment.attributes.type == 'image' ) {
					var html = '<div class="image-wrapper">' +
                            '<img src="'+ url +'">' +
                            '<input type="hidden" name="_job_logo" value="'+ id +'">' +
                            '<span class="remove-image"><i class="fa fa-close"></i></span>' +
                        '</div>';
                    $('#upload-image-logo-images').html(html);
				}
			});

		}
		// Finally, open the modal.
		cityo_upload_image.open();
	}

    jQuery('#upload-image-logo').on('click', function(event) {
    	event.preventDefault();
        cityo_add_image_meta();
    });


    var media_uploader = null;
	function cityo_add_multiple_images()
	{
		if( media_uploader ) {
            media_uploader.open();
            return;
        }
	    media_uploader = wp.media.frames.media_uploader =  wp.media({
	        title: "Select Image",
			button: {
				text: "Selected",
				close: false
			},
			multiple: true
	    });

	    media_uploader.on( 'select', function(){

	    	var attachments = media_uploader.state().get('selection').map(
                function( attachment ) {
                    attachment.toJSON();
                    return attachment;

            });
	    	media_uploader.close();

	        var html = '', i;
	        for (i = 0; i < attachments.length; ++i) {
	            var id = attachments[i].attributes.id;
	            var url = attachments[i].attributes.url;

	            html += '<div class="image-wrapper">' +
                            '<img src="'+ url +'">' +
                            '<input type="hidden" name="_job_gallery_images[]" value="'+ id +'">' +
                            '<span class="remove-image"><i class="fa fa-close"></i></span>' +
                        '</div>';
                    
	        }
	        $('#upload-image-gallery-images').html(html);
	    });

	    media_uploader.open();
	}

	jQuery('#upload-image-gallery').on('click', function(event) {
    	event.preventDefault();
        cityo_add_multiple_images();
    });

    $(document).on('click', '.image-wrapper .remove-image', function(){
    	$(this).parent().remove();
    });
})(jQuery);