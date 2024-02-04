<?php
    $gallery_images = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'gallery_images' );
    $lazy_load = be_themes_get_option( 'lazy_load' );
    $post_thumb_size = apply_filters( 'be_theme_blog_archive_thumb_size', 'exponent-blog-image' );
    if( !empty( $gallery_images ) && is_array( $gallery_images ) ) {
        $data_attrs = array();
        $data_attrs[] = 'data-cols = "1"';
        $data_attrs[] = 'data-dots = "1"';
        if(!empty($lazy_load)) {
            $data_attrs[] = 'data-lazy-load = "1"';
        }
?>
        <div class="be-slider <?php echo be_themes_get_class( 'post-thumb-slider' ); ?>" <?php echo implode( ' ', $data_attrs ); ?>>
            <?php 
                foreach( $gallery_images as $image_id ) { 
                    $img_details = wp_get_attachment_image_src( $image_id, $post_thumb_size );
                    $image_attrs = array();
                    $image_class = array();   
                    $image_class[] = be_themes_get_class( 'post-thumb-slide-img' );
                    $image_class[] = be_themes_get_class( 'img-object-fit' );         
                    $image_src = !empty( $img_details ) && !empty( $img_details[0] ) ? $img_details[0] : 'img/placeholder.png';
                    $padding = be_themes_get_placeholder_padding( $image_id, $post_thumb_size );
                    $padding_style = sprintf( 'style = "padding-bottom : %s%%;"', $padding ); 
                    if( !empty($lazy_load) ) {
                        $image_class[] = 'be-slide-lazy-load';
                        $image_attrs[] = 'data-flickity-lazyload = "' . esc_url($image_src) . '"';
                    }else {
                        $image_attrs[] = 'src = "' . esc_url($image_src) . '"';
                    }
            ?>
                <div class="be-slide <?php echo be_themes_get_class( 'post-thumb-slide' ); ?>">
                    <div class="be-slide-inner">
                        <div class="<?php echo be_themes_get_class( 'post-thumb-slide-placeholder' ); ?>" <?php echo !empty( $padding_style ) ? $padding_style : ''; ?>>
                        </div>
                        <?php echo sprintf( '<img class="%s" %s/>', implode( ' ', $image_class ), implode( ' ', $image_attrs ) ); ?>
                    </div>
                </div>
            <?php 
                } 
            ?>
        </div>
<?php
    }