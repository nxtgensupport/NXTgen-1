<?php
/**
 * Add Custom Meta to Category Taxonomy
 */
if( !function_exists( 'exponent_add_custom_field_to_category' ) ) {
    function exponent_add_custom_field_to_category( $taxonomy ) {
        extract( be_get_color_hub() ); //Color schemes from color hub
        $meta_prefix = be_themes_get_meta_prefix();
        $cat_color_meta = $meta_prefix . 'cat_color';
        $cat_bg_color_meta = $meta_prefix . 'cat_bg_color';
        $cat_custom_header = $meta_prefix . 'cat_custom_header';
        $cat_header_height = $meta_prefix.  'cat_header_height';
        $cat_header_bg_color = $meta_prefix . 'cat_header_bg_color';
        $cat_header_bg_image = $meta_prefix . 'cat_header_bg_image';
    ?>
        <div class="form-field term-colorpicker-wrap">
            <label for="<?php echo esc_attr( $cat_color_meta ); ?>">Category Color</label>
            <input name="<?php echo esc_attr( $cat_color_meta ); ?>" value="<?php echo esc_attr( $alt_bg_text_color ); ?>" class="colorpicker" id="<?php echo esc_attr( $cat_color_meta ); ?>" />
            <p>Color Applied to Category on Masonry and Metro Style Blog post.</p>
        </div>

        <div class="form-field term-colorpicker-wrap">
            <label for="<?php echo esc_attr( $cat_bg_color_meta ); ?>">Category Background Color</label>
            <input name="<?php echo esc_attr( $cat_bg_color_meta ); ?>" value="<?php echo esc_attr( $color_scheme ); ?>" class="colorpicker" id="<?php echo esc_attr( $cat_bg_color_meta ); ?>" />
            <p>Color Applied as Background to Category on Masonry and Metro Style Blog post.</p>
        </div>

        <div class="form-field term-switch-wrap">
            <label for="<?php echo esc_attr( $cat_custom_header ); ?>">Enable Custom Header</label>
            <input name="<?php echo esc_attr( $cat_custom_header ); ?>" type = "checkbox" class="switch" id="<?php echo esc_attr( $cat_custom_header ); ?>" />
            <p>Overrides the title area in category archive pages.</p>
        </div>

        <div class="form-field term-number-wrap">
            <label for="<?php echo esc_attr( $cat_header_height ); ?>">Custom Header Height</label>
            <input type = "number" name="<?php echo esc_attr( $cat_header_height ); ?>" value="60" class="number" id="<?php echo esc_attr( $cat_header_height ); ?>" />
            <p>Values entered are in vh units.</p>
        </div>

        <div class="form-field term-colorpicker-wrap">
            <label for="<?php echo esc_attr( $cat_header_bg_color ); ?>">Custom Header Background Color</label>
            <input name="<?php echo esc_attr( $cat_header_bg_color ); ?>" value="<?php echo esc_attr( $color_scheme ); ?>" class="colorpicker" id="<?php echo esc_attr( $cat_header_bg_color ); ?>" />
        </div>

        <div class="form-field term-imagepicker-wrap">
            <label for="<?php echo esc_attr( $cat_header_bg_image ); ?>">Custom Header Background Image</label>
            <input type = "hidden" name="<?php echo esc_attr( $cat_header_bg_image ); ?>" value="" class="imagepicker" id="<?php echo esc_attr( $cat_header_bg_image ); ?>" />
            <div class="imagepicker-preview">
                <div class="imagepicker-preview-overlay">
                    <span class="media-close-button dashicons dashicons-no-alt">
                    </span>
                </div>
            </div>
            <a class="imagepicker-button button">+ Add Media</a>
        </div>

    <?php

    }
    add_action( 'category_add_form_fields', 'exponent_add_custom_field_to_category' );  // Variable Hook Name
}

/**
 * Add Custom Meta to Edit Category Page
 */
if( !function_exists( 'exponent_add_custom_field_to_edit_category' ) ) {
    function exponent_add_custom_field_to_edit_category( $term ) {

        extract( be_get_color_hub() ); //Color schemes from color hub
        $meta_prefix = be_themes_get_meta_prefix();
        $cat_color_meta = $meta_prefix . 'cat_color';
        $cat_bg_color_meta = $meta_prefix . 'cat_bg_color';
        $cat_custom_header_meta = $meta_prefix . 'cat_custom_header';
        $cat_header_height_meta = $meta_prefix.  'cat_header_height';
        $cat_header_bg_color_meta = $meta_prefix . 'cat_header_bg_color';
        $cat_header_bg_image_meta = $meta_prefix . 'cat_header_bg_image';

        $bg_color = '';
        if( metadata_exists( 'term', $term->term_id, $cat_bg_color_meta ) ) {
            $bg_color = get_term_meta( $term->term_id, $cat_bg_color_meta, true );
            if( !empty( $bg_color ) && be_themes_check_valid_colorhex( $bg_color ) ) {
                $bg_color = "#{$bg_color}";
            }
        }else {
            $bg_color = $color_scheme;
        }

        $color = '';
        if( metadata_exists( 'term', $term->term_id, $cat_color_meta ) ) {
            $color = get_term_meta( $term->term_id, $cat_color_meta, true );
            if( !empty( $color ) && be_themes_check_valid_colorhex( $color ) ) {
                $color = "#{$color}";
            }
        }else {
            $color = $alt_bg_text_color;
        }

        $custom_header_bg_color = '';
        if( metadata_exists( 'term', $term->term_id, $cat_header_bg_color_meta ) ) {
            $custom_header_bg_color = get_term_meta( $term->term_id, $cat_header_bg_color_meta, true );
            if( !empty( $custom_header_bg_color ) && be_themes_check_valid_colorhex( $custom_header_bg_color ) ) {
                $custom_header_bg_color = "#{$custom_header_bg_color}";
            }
        }else {
            $custom_header_bg_color = $color_scheme;
        }

        $custom_header = get_term_meta( $term->term_id, $cat_custom_header_meta, true );
        $custom_header_height = get_term_meta( $term->term_id, $cat_header_height_meta, true );
        $custom_header_bg_image = get_term_meta( $term->term_id, $cat_header_bg_image_meta, true );

        $img_src_from_id = '';
        if( !empty( $custom_header_bg_image ) ) {
            $image_details = wp_get_attachment_image_src( $custom_header_bg_image, 'thumbnail' );
            if( !empty( $image_details ) && !empty( $image_details[0] ) ) {
                $img_src_from_id = $image_details[ 0 ];
            }
        }



    ?>
        <tr class="form-field term-colorpicker-wrap">
            <th scope="row"><label for="<?php echo esc_attr( $cat_bg_color_meta ); ?>">Category Label BG Color</label>
            </th>
            <td>
                <input name="<?php echo esc_attr( $cat_bg_color_meta ); ?>" value="<?php echo esc_attr( $bg_color ); ?>" class="colorpicker" id="<?php echo esc_attr( $cat_bg_color_meta ); ?>" />
                <p class="description">Color Applied as Background to Category on Masonry and Metro Style Blog post.</p>
            </td>
        </tr>
        <tr class="form-field term-colorpicker-wrap">
            <th scope="row"><label for="<?php echo esc_attr( $cat_color_meta ); ?>">Category Color</label>
            </th>
            <td>
                <input name = "<?php echo esc_attr( $cat_color_meta ); ?>" value="<?php echo esc_attr( $color ); ?>" class="colorpicker" id="<?php echo esc_attr( $cat_color_meta ); ?>" />
                <p class="description">Color Applied to Category on Masonry and Metro Style Blog post.</p>
            </td>
        </tr>
        <tr class="form-field term-switch-wrap">
            <th scope="row"><label for="<?php echo esc_attr( $cat_custom_header_meta ); ?>">Enable Custom Header</label>
            </th>
            <td>
                <input name="<?php echo esc_attr( $cat_custom_header_meta ); ?>" type= "checkbox" <?php echo !empty( $custom_header ) ? 'checked' : ''; ?> class="switch" id="<?php echo esc_attr( $cat_custom_header_meta ); ?>" />
                <p class="description">Overrides the title area in category archive pages.</p>
            </td>
        </tr>
        <tr class="form-field term-number-wrap">
            <th scope="row"><label for="<?php echo esc_attr( $cat_header_height_meta ); ?>">Custom Header Height</label>
            </th>
            <td>
                <input name="<?php echo esc_attr( $cat_header_height_meta ); ?>" value = "<?php echo esc_attr( $custom_header_height ); ?>" type= "number" class="number" id="<?php echo esc_attr( $cat_header_height_meta ); ?>" />
                <p class="description">Values entered are in vh units.</p>
            </td>
        </tr>
        <tr class="form-field term-colorpicker-wrap">
            <th scope="row"><label for="<?php echo esc_attr( $cat_header_bg_color_meta ); ?>">Category Header Bg Color</label>
            </th>
            <td>
                <input name = "<?php echo esc_attr( $cat_header_bg_color_meta ); ?>" value="<?php echo esc_attr( $custom_header_bg_color ); ?>" class="colorpicker" id="<?php echo esc_attr( $cat_header_bg_color_meta ); ?>" />
                <p class="description">Bg Color Applied to Custom Header if it's enabled.</p>
            </td>
        </tr>
        <tr class="form-field term-imagepicker-wrap">
            <th scope="row"><label for="<?php echo esc_attr( $cat_header_bg_image_meta ); ?>">Category Header Bg Image</label>
            </th>
            <td>
                <input type = "hidden" name = "<?php echo esc_attr( $cat_header_bg_image_meta ); ?>" value="<?php echo esc_attr( $custom_header_bg_image ); ?>" class="imagepicker" id="<?php echo esc_attr( $cat_header_bg_image_meta ); ?>" />
                <div class="imagepicker-preview <?php echo !empty( $img_src_from_id ) ? 'active' : ''; ?>">
                    <div class="imagepicker-preview-overlay">
                        <span class="media-close-button dashicons dashicons-no-alt">
                        </span>
                    </div>
                    <?php if( !empty( $img_src_from_id ) ) : ?>
                        <img src = <?php echo esc_url( $img_src_from_id ); ?> />
                    <?php endif; ?>
                </div>
                <a class="imagepicker-button button <?php echo !empty( $img_src_from_id ) ? 'hidden' : ''; ?>">+ Add Media</a>
            </td>
        </tr>
    <?php
    }
    add_action( 'category_edit_form_fields', 'exponent_add_custom_field_to_edit_category' );   // Variable Hook Name
}

/**
 * Save Custom Meta
 */
if( !function_exists( 'exponent_save_custom_meta' ) ) {
    function exponent_save_custom_meta( $term_id ) {

        $meta_prefix = be_themes_get_meta_prefix();
        $cat_color_meta = $meta_prefix . 'cat_color';
        $cat_bg_color_meta = $meta_prefix . 'cat_bg_color';
        $cat_custom_header_meta = $meta_prefix . 'cat_custom_header';
        $cat_header_height_meta = $meta_prefix.  'cat_header_height';
        $cat_header_bg_color_meta = $meta_prefix . 'cat_header_bg_color';
        $cat_header_bg_image_meta = $meta_prefix . 'cat_header_bg_image';

        if( isset( $_POST[ $cat_bg_color_meta ] ) ) {
            if( be_themes_check_valid_colorhex( $_POST[ $cat_bg_color_meta ] ) ) {
                $_POST[ $cat_bg_color_meta ] = sanitize_hex_color_no_hash( $_POST[ $cat_bg_color_meta ] );
            }
            update_term_meta( $term_id, $cat_bg_color_meta, $_POST[ $cat_bg_color_meta ] );
        }

        if( isset( $_POST[ $cat_color_meta ] ) ) {
            if( be_themes_check_valid_colorhex( $_POST[ $cat_color_meta ] ) ) {
                $_POST[ $cat_color_meta ] = sanitize_hex_color_no_hash( $_POST[ $cat_color_meta ] );
            }
            update_term_meta( $term_id, $cat_color_meta, $_POST[ $cat_color_meta ] );
        }

        if( isset( $_POST[ $cat_custom_header_meta ] ) ) {
            update_term_meta( $term_id, $cat_custom_header_meta, '1' );
        }else {
            update_term_meta( $term_id, $cat_custom_header_meta, '0' );
        }

        if( isset( $_POST[ $cat_header_height_meta ] ) && is_numeric( $_POST[ $cat_header_height_meta ] ) ) {
            update_term_meta( $term_id, $cat_header_height_meta, $_POST[ $cat_header_height_meta ] );
        }

        if( isset( $_POST[ $cat_header_bg_color_meta ] ) ) {
            if( be_themes_check_valid_colorhex( $_POST[ $cat_header_bg_color_meta ] ) ) {
                $_POST[ $cat_header_bg_color_meta ] = sanitize_hex_color_no_hash( $_POST[ $cat_header_bg_color_meta ] );
            }
            update_term_meta( $term_id, $cat_header_bg_color_meta, $_POST[ $cat_header_bg_color_meta ] );
        }

        if( isset( $_POST[ $cat_header_bg_image_meta ] ) && is_numeric( $_POST[ $cat_header_bg_image_meta ] ) ) {
            update_term_meta( $term_id, $cat_header_bg_image_meta, $_POST[ $cat_header_bg_image_meta ] );
        }

    }
    add_action( 'created_category', 'exponent_save_custom_meta' );  // Variable Hook Name
    add_action( 'edited_category',  'exponent_save_custom_meta' );  // Variable Hook Name
}

/**
 * Enqueue colorpicker styles and scripts.
 */
if( !function_exists( 'exponent_category_colorpicker_enqueue' ) ) {
    function exponent_category_colorpicker_enqueue( $taxonomy ) {

        if( null !== ( $screen = get_current_screen() ) && 'edit-category' !== $screen->id ) {
            return;
        }
        wp_enqueue_media();
        wp_enqueue_style( 'custom-meta-css', trailingslashit( get_template_directory_uri() ) . 'css/admin/custom-meta.css', array ( 'wp-color-picker' ) );
        wp_enqueue_script( 'custom-meta-js', trailingslashit( get_template_directory_uri() ) . 'js/admin/custom-meta.js', array( 'jquery', 'wp-color-picker', 'media-views', 'media-models' ) );
        
    }
    add_action( 'admin_enqueue_scripts', 'exponent_category_colorpicker_enqueue' );
}

?>