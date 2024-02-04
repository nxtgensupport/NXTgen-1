<?php
/**
 * Greenshift Woocommerce Meta Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

//////////////////////////////////////////////////////////////////
// 360 gallery
//////////////////////////////////////////////////////////////////

function greenshift_woo_add_meta_boxes() {
    add_meta_box('greenshift_woo_custom_meta', esc_html__("360 gallery, Video, 3D", "greenshiftwoo"), 'greenshiftwoo_render_meta_box', 'product', 'side', 'low');
}
add_action('add_meta_boxes', 'greenshift_woo_add_meta_boxes');
function greenshiftwoo_render_meta_box($post) {
    wp_nonce_field( 'greenshiftwoo_meta_save', 'greenshiftwoo_meta_nonce' );
    ?>
		<div id="greenshiftwoo-panelmeta">
			<div class="inside">
				<div class="greenshiftwoo-container">
					<ul class="greenshiftwoo-panel-images">
						<?php
							if ( metadata_exists( 'post', $post->ID, 'greenshiftwoo360_image_gallery' ) ) {
								$post_image_gallery = get_post_meta( $post->ID, 'greenshiftwoo360_image_gallery', true );
							} else {
								// Backwards compat
								$attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_value=0' );
								$attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
								$post_image_gallery = implode( ',', $attachment_ids );
							}
		
							$attachments = array_filter( explode( ',', $post_image_gallery ) );
							$update_meta = false;
							$updated_gallery_ids = array();
		
							if ( ! empty( $attachments ) ) {
								foreach ( $attachments as $attachment_id ) {
									$attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );
		
									// if attachment is empty skip
									if ( empty( $attachment ) ) {
										$update_meta = true;
										continue;
									}
		
									echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
										' . $attachment . '
										<ul class="actions">
											<li><a href="#" class="gswoo-delete-images tips" data-tip="' . esc_attr__( "Delete image", "greenshiftwoo" ) . '">' . esc_html__( "Delete", "greenshiftwoo" ) . '</a></li>
										</ul>
									</li>';
		
									// rebuild ids to be saved
									$updated_gallery_ids[] = $attachment_id;
								}
		
								// need to update post meta to set new gallery ids
								if ( $update_meta ) {
									update_post_meta( $post->ID, 'greenshiftwoo360_image_gallery', implode( ',', $updated_gallery_ids ) );
								}
							}
						?>
					</ul>
					<input type="hidden" class="greenshiftwoo_image_gallery" name="greenshiftwoo360_image_gallery" value="<?php echo esc_attr( $post_image_gallery ); ?>" />
                    <p class="greenshiftwoo_add_post_images hide-if-no-js">
					<a href="#" data-choose="<?php esc_attr_e( "Add Images to 360 Gallery", "greenshiftwoo" ); ?>" data-update="<?php esc_attr_e( "Add to 360 gallery", "greenshiftwoo" ); ?>" data-delete="<?php esc_attr_e( "Delete image", "greenshiftwoo" ); ?>" data-text="<?php esc_attr_e( "Delete", "greenshiftwoo" ); ?>"><?php esc_html_e( "Add 360 gallery images", "greenshiftwoo" ); ?></a>
				</p>
				</div>
                <div id="greenshiftwoo-repeatable-fields">
                    <?php $extended_gallery = get_post_meta($post->ID, 'greenshiftwoo_extended_gallery', true); ?>
                    <?php if ($extended_gallery) : 
                        foreach ($extended_gallery as $field) { ?>
                        <div class="greenshiftwoo_extended-field-group">
                            <div>
                                <label for="image"><?php esc_attr_e( "Image", "greenshiftwoo" ); ?></label>
                                <?php if(!empty($field['image']) && is_numeric($field['image'])):?>
                                    <?php $attachment = wp_get_attachment_image( $field['image'], 'thumbnail' );?>
                                    <?php echo '<div class="previmagewoo">'.$attachment.'</div>';?>
                                <?php endif;?>
                                <input type="hidden" name="greenshiftwoo_extended_gallery[image][]" class="meta-image" value="<?php echo esc_attr($field['image']); ?>" />
                                <input type="button" class="button button-secondary button-small greenshiftwoo-upload-image" value="<?php esc_attr_e( "Upload Image", "greenshiftwoo" ); ?>" />
                            </div>
                            <div>
                                <label for="text"><?php esc_attr_e( "Video or 3d link", "greenshiftwoo" ); ?><?php echo wc_help_tip("Supported formats: .mp4, youtube links, vimeo links, .glb, .splinecode", false);?></label>
                                <input type="text" name="greenshiftwoo_extended_gallery[file][]" class="meta-url" value="<?php echo esc_url($field['file']); ?>" />
                                <div class="greenshiftwoo-remove-group-btn"><input type="button" class="button button-secondary button-small greenshiftwoo-upload-text" value="<?php esc_attr_e( "Upload File", "greenshiftwoo" ); ?>" /><input type="button" class="button button-small is-destructive greenshiftwoo-remove-field" value="<?php esc_attr_e( "Remove", "greenshiftwoo" ); ?>" /></div>
                            </div>
                        </div>
                        <?php }
                    else : ?>
                        <div class="greenshiftwoo_extended-field-group">
                            <div>
                                <label for="image"><?php esc_attr_e( "Image", "greenshiftwoo" ); ?></label>
                                <div class="previmagewoo"></div>
                                <input type="hidden" name="greenshiftwoo_extended_gallery[image][]" class="meta-image" value="" />
                                <input type="button" class="button button-secondary button-small greenshiftwoo-upload-image" value="<?php esc_attr_e( "Upload Image", "greenshiftwoo" ); ?>" />
                            </div>
                            <div>
                                <label for="text"><?php esc_attr_e( "Video or 3d link", "greenshiftwoo" ); ?><?php echo wc_help_tip("Supported formats: .mp4, youtube links, vimeo links, .glb, .splinecode", false);?></label>
                                <input type="text" name="greenshiftwoo_extended_gallery[file][]" class="meta-url" value="" />
                                <div class="greenshiftwoo-remove-group-btn"><input type="button" class="button button-secondary button-small greenshiftwoo-upload-text" value="<?php esc_attr_e( "Upload File", "greenshiftwoo" ); ?>" /><input type="button" class="button button-small is-destructive greenshiftwoo-remove-field" value="<?php esc_attr_e( "Remove", "greenshiftwoo" ); ?>" /></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="greenshiftwoo-add-media-group-div"><input type="button" class="button button-primary greenshiftwoo-add-group-media" value="<?php esc_attr_e( "Add File group", "greenshiftwoo" ); ?>" /></div>
                <script>
                    jQuery(document).ready(function($){
                        // Add Field
                        $('.greenshiftwoo-add-group-media').click(function(){
                            var field = '<div class="greenshiftwoo_extended-field-group"> \
                                <div> \
                                    <label for="image">Image</label> \
                                    <div class="previmagewoo"></div> \
                                    <input type="hidden" name="greenshiftwoo_extended_gallery[image][]" class="meta-image" value="" /> \
                                    <input type="button" class="button button-secondary button-small greenshiftwoo-upload-image" value="Upload Image" /> \
                                </div> \
                                <div> \
                                    <label for="text">Video or 3d link</label> \
                                    <input type="text" name="greenshiftwoo_extended_gallery[file][]" class="meta-url" value="" /> \
                                    <div class="greenshiftwoo-remove-group-btn"><input type="button" class="button button-secondary button-small greenshiftwoo-upload-text" value="Upload File" /><input type="button" class="button button-small is-destructive greenshiftwoo-remove-field" value="Remove" /></div> \
                                </div> \
                            </div>';
                            $('#greenshiftwoo-repeatable-fields').append(field);
                        });

                        // Remove Field
                        $(document).on('click', '.greenshiftwoo-remove-field', function(){
                            $(this).closest('.greenshiftwoo_extended-field-group').remove();
                        });

                        // Media Upload for Image
                        $(document).on('click', '.greenshiftwoo-upload-image', function(e){
                            e.preventDefault();
                            let imageInput = $(this).closest('.greenshiftwoo_extended-field-group').find('.meta-image');
                            let thisbutton = $(this);
                            wp.media.editor.send.attachment = function(props, attachment) {
                                imageInput.val(attachment.id);
                                let attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                                thisbutton.closest('.greenshiftwoo_extended-field-group').find('.previmagewoo').html( '<img src="' + attachment_image + '" />' );
                            };
                            wp.media.editor.open(imageInput);
                        });

                        // Media Upload for Text
                        $(document).on('click', '.greenshiftwoo-upload-text', function(e){
                            e.preventDefault();
                            let textInput = $(this).closest('.greenshiftwoo_extended-field-group').find('.meta-url');
                            wp.media.editor.send.attachment = function(props, attachment) {
                                textInput.val(attachment.url);
                            };
                            wp.media.editor.open(textInput);
                        });
                    });
                </script>
			</div>
		</div>
	<?php
}

add_action( 'save_post', 'greenshiftwoo_save_meta_boxes', 10, 2);
function greenshiftwoo_save_meta_boxes( $post_id, $post ) {
    // $post_id is required
    if ( empty( $post_id ) || empty( $post ) ) {
        return;
    }

    // Dont' save meta boxes for revisions or autosaves
    if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || is_int(wp_is_post_revision($post_id))  ) {
        return $post_id;
    }

    // Check the post being saved == the $post_id to prevent triggering this call for other save_post events
    if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
        return $post_id;
    }

    // Check the nonce
    if ( empty( $_POST['greenshiftwoo_meta_nonce'] ) || !wp_verify_nonce( $_POST['greenshiftwoo_meta_nonce'], 'greenshiftwoo_meta_save' ) ) {
        return $post_id;
    }

    // Check user has permission to edit
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    //Saving gallery
    if( !empty($_POST['greenshiftwoo360_image_gallery']) && !is_array($_POST['greenshiftwoo360_image_gallery'])){
        $attachment_ids = sanitize_text_field( $_POST['greenshiftwoo360_image_gallery']);
        $attachment_ids = explode(",", $attachment_ids);
        $attachment_ids = array_filter($attachment_ids);
        $attachment_ids = implode(',', $attachment_ids);
        update_post_meta( $post_id, 'greenshiftwoo360_image_gallery', $attachment_ids );
    }elseif(isset($_POST['greenshiftwoo360_image_gallery'])){
        delete_post_meta( $post_id, 'greenshiftwoo360_image_gallery' );
    }

    if (isset($_POST['greenshiftwoo_extended_gallery'])) {
        $meta_data = array();
        foreach ($_POST['greenshiftwoo_extended_gallery']['image'] as $key => $value) {
            if(!empty($_POST['greenshiftwoo_extended_gallery']['image'][$key]) && !empty($_POST['greenshiftwoo_extended_gallery']['file'][$key])){
                $meta_data[] = array(
                    'image' => sanitize_text_field($_POST['greenshiftwoo_extended_gallery']['image'][$key]),
                    'file'  => sanitize_text_field($_POST['greenshiftwoo_extended_gallery']['file'][$key])
                );
            }
        }
        if(!empty($meta_data)){
            update_post_meta($post_id, 'greenshiftwoo_extended_gallery', $meta_data);
        }
    }
}

add_action( 'admin_enqueue_scripts', 'greenshiftwoo_admin_script' );

function greenshiftwoo_admin_script( $hook_suffix ) {

    $allowed_suffixes = array(
        'edit.php',
        'post.php',
        'post-new.php',
    );

    if ( ! in_array( $hook_suffix, $allowed_suffixes, true ) ) {
        return;
    }

    // CSS
    wp_enqueue_style(
        'greenshiftwoo-metabox-css',
        GREENSHIFTWOO_DIR_URL . '/assets/css/admin-metabox.css',
        false,
        '1.8'
    );

    wp_enqueue_script(
        'greenshiftwoo-metabox-js',
        GREENSHIFTWOO_DIR_URL . '/assets/js/admin-metabox.js',
        array('jquery'),
        '1.4',
        true
    );
}


// Add additional gallery images field to variation data
function greenshiftwoo_add_variation_gallery_field($loop, $variation_data, $variation) {
    
    // Get existing variation gallery data
    $variation_id   = absint( $variation->ID );
    $variationimage_data = get_post_meta($variation_id, 'greenshiftwoo_variation_gallery', true);
    $gallery_images = isset($variationimage_data['images']) ? $variationimage_data['images'] : array();
    ?>
        <div class="variable_pricing">
            <div class="inside">
                <div class="greenshiftwoo-container">
                    <ul class="greenshiftwoo-panel-images">
                        <?php
                            if (!empty($gallery_images)) {
                                foreach ($gallery_images as $attachment_id) {
                                    $attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );
                                    echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
                                    ' . $attachment . '
                                    <ul class="actions">
                                        <li><a href="#" class="gswoo-delete-images tips" data-tip="' . esc_attr__( "Delete image", "greenshiftwoo" ) . '">' . esc_html__( "Delete", "greenshiftwoo" ) . '</a></li>
                                    </ul>
                                </li>';
                                }
                            }
                        ?>
                    </ul>
                    <input type="hidden" class="greenshiftwoo_image_gallery" name="greenshiftwoo_variation_gallery[<?php echo (int)$variation_id;?>][images]" value="<?php echo esc_attr( implode(',', $gallery_images)); ?>" />
                    <p class="greenshiftwoo_add_post_images hide-if-no-js">
                    <a href="#" data-choose="<?php esc_attr_e( "Add Images to Variation Gallery", "greenshiftwoo" ); ?>" data-update="<?php esc_attr_e( "Add to Variation gallery", "greenshiftwoo" ); ?>" data-delete="<?php esc_attr_e( "Delete image", "greenshiftwoo" ); ?>" data-text="<?php esc_attr_e( "Delete", "greenshiftwoo" ); ?>"><?php esc_html_e( "Add Variation gallery images", "greenshiftwoo" ); ?></a>
                </p>
                </div>
            </div>
        </div>
    <?php   
}
add_action('woocommerce_variation_options', 'greenshiftwoo_add_variation_gallery_field', 10, 3);

// Save variation gallery images
function greenshiftwoo_save_variation_gallery_field($variation_id, $loop) {
    $product_id = get_post( $variation_id )->post_parent;
    $variation_gallery = isset($_POST['greenshiftwoo_variation_gallery'][$variation_id]) ? $_POST['greenshiftwoo_variation_gallery'][$variation_id] : '';
    
    if (!empty($variation_gallery['images'])) {
        $varimages = sanitize_text_field($variation_gallery['images']);
        $gallery_images = explode(',', $varimages);
        
        // Get all variation galleries
        $all_variation_galleries = get_post_meta($product_id, 'greenshiftwoo_all_variation_galleries', true);
        if (empty($all_variation_galleries)) {
            $all_variation_galleries = array();
        }
        $all_variation_galleries[$variation_id]['images'] = $gallery_images;
        update_post_meta($product_id, 'greenshiftwoo_all_variation_galleries', $all_variation_galleries);

        // Get current variation gallery
        $current_variation_galleries = get_post_meta($variation_id, 'greenshiftwoo_variation_gallery', true);
        if (empty($current_variation_galleries)) {
            $current_variation_galleries = array();
        }
        $current_variation_galleries['images'] = $gallery_images;
        update_post_meta($variation_id, 'greenshiftwoo_variation_gallery', $current_variation_galleries);

    }else{

        $current_variation_galleries = get_post_meta($variation_id, 'greenshiftwoo_variation_gallery', true);
        if(!empty($current_variation_galleries['images'])){
            unset($current_variation_galleries['images']);
            update_post_meta($variation_id, 'greenshiftwoo_variation_gallery', $current_variation_galleries);
        }

        $all_variation_galleries = get_post_meta($product_id, 'greenshiftwoo_all_variation_galleries', true);
        if(!empty($all_variation_galleries[$variation_id]['images'])){
            unset($all_variation_galleries[$variation_id]);
            update_post_meta($product_id, 'greenshiftwoo_all_variation_galleries', $all_variation_galleries);
        }
    }
}
add_action('woocommerce_save_product_variation', 'greenshiftwoo_save_variation_gallery_field', 10, 2);
