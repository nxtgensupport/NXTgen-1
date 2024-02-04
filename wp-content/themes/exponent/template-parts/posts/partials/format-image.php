<?php
    $blog_style = exponent_get_post_loop_prop( 'style' );
    $lazy_load = be_themes_get_option( 'lazy_load' ) && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) && !( defined( 'REST_REQUEST' ) && REST_REQUEST );
    $arrangement = exponent_get_post_loop_prop( 'arrangement' );
    $loop_type = exponent_get_post_loop_prop( 'type' );

    $metro_styles = array( 'style2', 'style3', 'style7' );
    $list_styles = array ( 'style1', 'style4' );
    $content_height_styles = array( 'style5', 'style6' );
    $post_thumb_size = get_query_var( 'be_themes_post_thumb_size', 'exponent-blog-image' );

    $placeholder_html = '';

    //default thumb classes
    $image_attr = array(
        'class' => be_themes_get_class( 'posts-loop-thumb', 'img-object-fit' )
    );
    $img_details = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $post_thumb_size );

    //lazy load
    if( !empty( $lazy_load ) ) {
        $data_src = '';
        $alt_text = get_post_meta( get_post_thumbnail_id( get_the_ID() ), '_wp_attachment_image_alt', true );
        $alt_text = sprintf( 'alt = "%s"', !empty( $alt_text ) ? $alt_text : '' );
        if( !empty( $img_details ) && !empty( $img_details[ 0 ] ) ) {
            if( 'slider' === $arrangement ) {
                $image_attr[ 'class' ] .= ' be-slide-lazy-load';
                $data_src = sprintf( 'data-flickity-lazyload = "%s"', esc_url( $img_details[ 0 ] ) );
            }else {
                $image_attr[ 'class' ] .= ' be-lazy-load';
                $data_src = sprintf( 'data-src = "%s"', esc_url( $img_details[ 0 ] ) );
            }
        }
    }

    //grid placeholder calc
    if( !in_array( $blog_style, $content_height_styles ) ) {
        if( 'featured' === $loop_type && 'slider' == $arrangement ) {
            $featured_post_height = exponent_get_post_loop_prop( 'featured_posts_height' );
            $featured_post_height = !empty( $featured_post_height ) && is_numeric( $featured_post_height ) ? $featured_post_height : 500;
            $placeholder_style = sprintf( 'style = "padding-bottom : %spx;"', $featured_post_height );
        }else {
            $padding = 100;
            if( in_array( $blog_style, $metro_styles ) ) {
                $blog_aspect_ratio = exponent_get_post_loop_prop( 'grid_aspect_ratio' );
                if( is_numeric( $blog_aspect_ratio ) ) {
                    $padding = round( (1/$blog_aspect_ratio ), 5);
                    $padding = $padding * 100;
                }
            }else {
                $padding = be_themes_get_placeholder_padding( get_post_thumbnail_id( get_the_ID() ), $post_thumb_size );
            }
            $placeholder_style = sprintf( 'style = "padding-bottom : %s%%;"', $padding ); 
        }
        $placeholder_html = sprintf( '<div class="be-grid-placeholder" %s></div>', $placeholder_style );
    }

    //lightbox
    $lightbox = be_themes_get_option( 'blog_lightbox' );
    if( !empty( $lightbox ) ) {
        $link = get_the_post_thumbnail_url( get_the_ID(), 'full' );
    }else {
        $link = get_the_permalink();
    }
?>
    <?php echo wp_kses_post( $placeholder_html ); ?>
    <a href="<?php echo esc_url( $link ); ?>" class="<?php echo be_themes_get_class( 'post-thumb-inner', !empty( $lightbox ) ? 'mfp-image' : '' ); ?>">
        <?php if( $lazy_load && !empty( $img_details ) ) : ?>
            <img class="<?php echo esc_attr( $image_attr[ 'class' ] ); ?>" <?php echo !empty( $data_src ) ? $data_src : ''; ?> <?php echo esc_attr( $alt_text ); ?>/>
        <?php else: ?>
            <?php the_post_thumbnail( $post_thumb_size, $image_attr ); ?>
        <?php endif;?>
    </a>
