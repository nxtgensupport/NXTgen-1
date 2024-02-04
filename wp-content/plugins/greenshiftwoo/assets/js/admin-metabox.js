jQuery(document).ready(function($) {
    $('.greenshiftwoo-container').each(function() {
		let $container = $(this);
		let $image_gallery_ids = $container.find('.greenshiftwoo_image_gallery');
		let $post_images = $container.find('ul.greenshiftwoo-panel-images');
		
		
		$(document).on('click', '.greenshiftwoo_add_post_images a', function(event) {
			let $el = $(this);

			event.preventDefault();

			var post_gallery_frame = wp.media.frames.post_gallery = wp.media({
				title: $el.data('choose'),
				button: {
					text: $el.data('update')
				},
				states: [
					new wp.media.controller.Library({
						title: $el.data('choose'),
						filterable: 'all',
						multiple: true
					})
				]
			});

			post_gallery_frame.on('select', function() {
				var selection = post_gallery_frame.state().get('selection');

				$post_images = $el.closest('.greenshiftwoo-container').find('.greenshiftwoo-panel-images');
				$image_gallery_ids = $el.closest('.greenshiftwoo-container').find('.greenshiftwoo_image_gallery');

				var attachment_ids = $image_gallery_ids.val();

				selection.map(function(attachment) {
					attachment = attachment.toJSON();

					if (attachment.id) {
						attachment_ids = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
						var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

						$post_images.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="gswoo-delete-images" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>');
					}
				});

				$image_gallery_ids.val(attachment_ids);
			});

			post_gallery_frame.open();
			variationChanged($el);
		});

		$(document).on('click', 'a.gswoo-delete-images', function(e) {
			e.preventDefault();
			e.stopPropagation();
			let attachment_ids = '';
			let $el = $(this);
			let $post_images = $el.closest('.greenshiftwoo-container').find('.greenshiftwoo-panel-images');
			let $image_gallery_ids = $el.closest('.greenshiftwoo-container').find('.greenshiftwoo_image_gallery');

			$(this).closest('.image').remove();

			$post_images.find('.image').each(function() {
				let attachment_id = $(this).attr('data-attachment_id');
				attachment_ids = attachment_ids ? attachment_ids + ',' + attachment_id : attachment_id;
			});

			$image_gallery_ids.val(attachment_ids);

			$( '#tiptip_holder' ).removeAttr( 'style' );
			$( '#tiptip_arrow' ).removeAttr( 'style' );

			variationChanged($post_images);

		});

		$post_images.sortable({
			items: 'li.image',
			cursor: 'move',
			scrollSensitivity: 40,
			forcePlaceholderSize: true,
			forceHelperSize: false,
			helper: 'clone',
			opacity: 0.65,
			placeholder: 'greenshiftwoo-metabox-sortable-placeholder',
			start: function(event, ui) {
				ui.item.css('background-color', '#f6f6f6');
			},
			stop: function(event, ui) {
				ui.item.removeAttr('style');
			},
			update: function() {
				var attachment_ids = '';

				$container.find('ul li.image').css('cursor', 'default').each(function() {
					var attachment_id = $(this).attr('data-attachment_id');
					attachment_ids = attachment_ids + attachment_id + ',';
				});

				$image_gallery_ids.val(attachment_ids);
			}
		});

	});
	function variationChanged(element) {
		if(element.closest('.woocommerce_variation').length > 0){
			element.closest('.woocommerce_variation').addClass('variation-needs-update');
			$('button.cancel-variation-changes, button.save-variation-changes').removeAttr('disabled');
			$('#variable_product_options').trigger('woocommerce_variations_input_changed');
		}
	  }
});