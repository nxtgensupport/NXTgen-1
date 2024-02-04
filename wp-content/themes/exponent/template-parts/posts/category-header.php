<?php
    $meta_prefix = be_themes_get_meta_prefix();
    $cur_cat = get_queried_object();
    $header_height = esc_attr( get_term_meta( $cur_cat->term_id, $meta_prefix.  'cat_header_height', true ) );
    $header_bg_color = esc_attr( get_term_meta( $cur_cat->term_id, $meta_prefix.  'cat_header_bg_color', true ) );
    $header_bg_image = get_term_meta( $cur_cat->term_id, $meta_prefix . 'cat_header_bg_image', true );
    $cat_desc = category_description();

    $header_style = '';
    if( !empty( $header_height ) ) {
        $header_height = "height : {$header_height}vh;";
    }else {
        $header_height = '';
    }
    if( !empty( $header_bg_color ) ) {
        $header_bg_color = "background-color : {$header_bg_color};";
    }else {
        $header_bg_color = '';
    }
    if( !empty( $header_bg_image ) ) {
        $image_details = wp_get_attachment_image_src( $header_bg_image, 'full' );
        if( !empty( $image_details ) ) {
            $image_url = esc_url( $image_details[0] );
            $header_bg_image = "background-image : url({$image_url});";
        }else {
            $header_bg_image = '';
        }
    }else {
        $header_bg_image = '';
    }
    if( !empty( $header_height ) || !empty( $header_bg_color ) || !empty( $header_bg_image ) ) {
        $header_style = sprintf( 'style = "%s%s%s"', $header_height, $header_bg_color, $header_bg_image );
    }
?>
    <div class="<?php echo be_themes_get_class( 'category-header' ); ?>" <?php echo !empty( $header_style ) ? $header_style : ''; ?>>
        <div class="<?php echo be_themes_get_class( 'category-header-inner' ) ;?>">
            <div class="<?php echo be_themes_get_class( 'category-header-title' ); ?>">
                <?php echo esc_html( $cur_cat->name ); ?>
            </div>
            <?php if( !empty( $cat_desc ) ) : ?>
                <div class="<?php echo be_themes_get_class( 'category-header-description' ); ?>">
                    <?php echo esc_html( $cat_desc ); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>