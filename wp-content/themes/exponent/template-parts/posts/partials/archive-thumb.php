<?php  
    $blog_style = exponent_get_post_loop_prop( 'style' );
    $arrangement = exponent_get_post_loop_prop( 'arrangement' );
    $archives_with_thumb_styles = array ( 'style1', 'style2', 'style4' );
    $list_styles = array ( 'style1', 'style4' );
    $metro_styles = array ( 'style3', 'style7' );
    $loop_type = exponent_get_post_loop_prop( 'type' );

    if( 'slider' === $arrangement ) {
        $loops_with_post_format_support = array ();
    }else {
        $loops_with_post_format_support = array ( 'style1', 'style2', 'style4' );
    }
    $loops_with_post_format_support = apply_filters( 'exp_post_loop_styles_with_post_format_support', $loops_with_post_format_support );
    $styles_with_mandatory_thumb = array( 'style6', 'style3', 'style7' );
    $post_thumb_style = '';
    $post_thumb_shadow = '';
    $post_format = 'image'; //post format image and standard has same styling handled by format-image tempate part
    $post_thumb_size = '';

    if( in_array( $blog_style, $loops_with_post_format_support ) ) {
        $cur_post_format = get_post_format();
        if( !empty( $cur_post_format ) ) {
            $post_format = $cur_post_format;
        }
    }

    if( 'image' === $post_format ) {
        if( in_array( $blog_style, $list_styles ) ) {
            $preserve_aspect_ratio = be_themes_get_option( 'blog_archive_auto_height_thumb' );
            if( !empty( $preserve_aspect_ratio ) ) {
                $post_thumb_size = 'exponent-blog-image-with-aspect-ratio';
            }else {
                $post_thumb_size = 'exponent-blog-image';
            }
        }else if( 'featured' === $loop_type ) {
            $post_thumb_size = 'full';
        }else if( in_array( $blog_style, $metro_styles ) ) {
            $double_width = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'blog_double_width', true );
            $double_height = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'blog_double_height', true );
            if( !empty( $double_width ) && !empty( $double_height ) ) {
                $post_thumb_size = 'full';
            }else if( !empty( $double_width ) || !empty( $double_height ) ) {
                $post_thumb_size = 'exponent-blog-image-with-aspect-ratio';
            }else {
                $post_thumb_size = 'exponent-blog-image-with-aspect-ratio';
            }
        }else {
            $post_thumb_size = 'medium_large';
        }
        $post_thumb_size = apply_filters( 'be_theme_blog_archive_thumb_size', $post_thumb_size );
        set_query_var( 'be_themes_post_thumb_size', $post_thumb_size );
    }

    //thumb styles
    if( in_array( $blog_style, $archives_with_thumb_styles ) ) {
        $border_radius = exponent_get_post_loop_prop( 'border_radius' );
        if( !empty( $border_radius ) ) {
            $post_thumb_style = sprintf( 'style = "border-radius : %spx;"', esc_attr( $border_radius ) );
        }

        $post_thumb_shadow = exponent_get_post_loop_prop( 'thumb_shadow' );
        if( !empty( $post_thumb_shadow ) && 'none' !== $post_thumb_shadow ) {
            $post_thumb_shadow = 'post-shadow-' . $post_thumb_shadow;
        }else {
            $post_thumb_shadow = '';
        }
    }
?>
<?php if( in_array( $blog_style, $styles_with_mandatory_thumb ) || exponent_has_blog_thumb( get_the_ID(), $post_format ) ) : ?>
    <?php if( 'style4' === $blog_style ) : ?>
        <div class="<?php echo be_themes_get_class( 'post-thumb-wrap' ); ?>">
    <?php endif; ?>
        <div class="<?php echo be_themes_get_class( 'post-thumb', $post_thumb_shadow ); ?>" <?php echo !empty( $post_thumb_style ) ? $post_thumb_style : ''; ?>>
            <?php get_template_part( 'template-parts/posts/partials/format', $post_format ); ?>
        </div>
    <?php if( 'style4' === $blog_style ) : ?>
        </div>
    <?php endif; ?>
<?php endif; ?>