<?php 
    $post_header_style = be_themes_get_option_with_override( 'single_title_style', 'single_post_override' );
    $header_alignment = be_themes_get_option( 'single_title_alignment' );
    
    if( 'wide' === $post_header_style ) {
        $post_thumb_size = 'full';
    }else {
        $preserve_aspect_ratio = be_themes_get_option( 'blog_single_auto_height_thumb' );
        if( !empty( $preserve_aspect_ratio ) ) {
            $post_thumb_size = 'exponent-blog-image-with-aspect-ratio';
        }else {
            $post_thumb_size = 'exponent-blog-image';
        }
    }
    $post_thumb_size = apply_filters( 'be_themes_single_post_header_thumb_size', $post_thumb_size );

    $primary_meta = be_themes_get_option( 'blog_single_primary_meta' );
    $secondary_meta = be_themes_get_option( 'blog_single_secondary_meta' );
    $author_meta_image = be_themes_get_option( 'blog_single_meta_author_image' );
    $date_icon = be_themes_get_option( 'blog_single_meta_date_icon' );
    $labeled_cat = be_themes_get_option( 'blog_single_labeled_cat' );
    $animated_cat = empty( $labeled_cat ) && 'wide' === $post_header_style;
    $post_format = get_post_format();
    $animated_author = 'wide' === $post_header_style;
    set_query_var( 'be_primary_meta', $primary_meta );
    set_query_var( 'be_secondary_meta', $secondary_meta );
    set_query_var( 'be_meta_author_image', $author_meta_image );
    set_query_var( 'be_meta_date_icon', $date_icon );
    set_query_var( 'be_meta_labeled_cat', $labeled_cat );
    set_query_var( 'be_animated_cat', $animated_cat );
    set_query_var( 'be_animated_author', $animated_author );

    if( 'wide' === $post_header_style ) {
        $header_style = '';
        $thumb_height = be_themes_get_option_with_override( 'thumb_height', 'single_post_override' );
        $header_lazy_load = be_themes_get_option( 'blog_single_blur_thumb' ) && function_exists( 'be_get_image_datauri' ); // be_get_image_datauri contains file_get_contents and base64_encode so cant be included in theme.Gets it from exp modules.
        if( !is_numeric( $thumb_height ) || 100 < $thumb_height ) {
            $thumb_height = 60;
        }
        $height = "min-height : ${thumb_height}vh;";

        $bg_class = array( 'exp-post-single-header-bg' ) ;
        $bg_attrs = array();
        if( !empty( $header_lazy_load ) ) {
            $bg_class[] = 'be-themes-bg-lazyload';
        }
        if( has_post_thumbnail() ) {
            $image_details = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $post_thumb_size );
            if( !empty( $image_details ) && !empty( $image_details[ 0 ] ) ) {
                $src = $image_details[ 0 ];
                if( !empty( $header_lazy_load ) ) {
                    $bg_attrs[] = 'data-src = "' . $src . '"';
                }
                $bg_attrs[] = 'style = "background : url(' . $src . ') no-repeat center / cover;"';
            }
        }

        if( !empty( $height ) ) {
            $header_style = sprintf( 'style = "%s"', $height );
        }
    ?>
        <div class="<?php echo be_themes_get_class( 'post-single-header-wrap' ); ?>">
        <div class="<?php echo be_themes_get_class( 'post-single-header', 'post-single-header-' . $post_header_style, 'post-single-header-align-' . $header_alignment ); ?>" <?php echo !empty( $header_style ) ? $header_style : ''; ?>>
            <div class="exp-post-single-header-bg-wrap">
            <?php if( !empty( $header_lazy_load ) ) : ?>
            <?php 
                $image_data_uri = esc_attr( be_get_image_datauri( get_post_thumbnail_id( get_the_ID() ), apply_filters( 'be_themes_bg_lazyload_blur_size', 'exponent-carousel-thumb' ) ) );
                $bg_blur_style = 'style = "background : url(' . $image_data_uri . ') no-repeat center / cover;"';
            ?>
            <div class="be-themes-bg-blur" <?php echo !empty( $bg_blur_style ) ? $bg_blur_style : ''; ?>>
            </div>
            <?php endif; ?>
            <div class="<?php echo implode( ' ', $bg_class ); ?>" <?php echo implode( ' ', $bg_attrs ); ?>>
            </div>
            </div>
            <?php get_template_part( 'template-parts/posts/partials/archive', 'title' ); ?>
        </div>
        <?php if( false !== $post_format && exponent_has_blog_thumb( get_the_ID(), $post_format ) ) { ?>
            <?php 
                if ( 'image' === $post_format ) {
                    set_query_var('be_themes_post_thumb_size', 'exponent-blog-image-with-aspect-ratio');
                }
            ?>
            <div class="clearfix <?php echo be_themes_get_class( 'wrap' ); ?>">
                <?php get_template_part( 'template-parts/posts/partials/format', $post_format ); ?>
            </div>
        <?php } ?>
        </div>
<?php
    }else {
        $post_format = get_post_format();
    ?>
        <div class="<?php echo be_themes_get_class( 'post-single-header-wrap' ); ?>">
        <div class="<?php echo be_themes_get_class( 'post-single-header', 'post-single-header-' . $post_header_style, 'post-single-header-align-' . $header_alignment ); ?>">
            <div class="<?php echo be_themes_get_class( 'wrap' ); ?>">
                <?php get_template_part( 'template-parts/posts/partials/archive', 'title' ); ?>
            </div>
            <?php if( false === $post_format && has_post_thumbnail() ) { ?>
                <div class="<?php echo be_themes_get_class( 'wrap' ); ?>">
                    <?php the_post_thumbnail( 'full' ); ?>
                </div>
            <?php }else if( false !== $post_format && exponent_has_blog_thumb( get_the_ID(), $post_format ) ) { ?>
                <?php 
                    if ( 'image' === $post_format ) {
                        set_query_var('be_themes_post_thumb_size', 'full');
                    }
                ?>
                <div class="clearfix  <?php echo be_themes_get_class( 'wrap' ); ?>">
                <?php get_template_part( 'template-parts/posts/partials/format', $post_format ); ?>
                </div>
            <?php } ?>
        </div>
        </div>
<?php  
    }


    