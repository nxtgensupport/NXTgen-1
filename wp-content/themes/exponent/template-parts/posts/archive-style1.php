<?php
    $custom_padding = exponent_get_post_loop_prop( 'custom_post_details_padding' );
    $post_details_padding = exponent_get_post_loop_prop( 'post_details_padding' );
    $post_shadow = exponent_get_post_loop_prop( 'post_shadow' );
    $post_details_color = exponent_get_post_loop_prop( 'post_details_color' );
    $post_details_style = '';

    if( !empty( $post_details_color ) ) {
        $post_details_color = "background : $post_details_color;";
    }else{
        $post_details_color = '';
    }
    if( !empty( $custom_padding ) && !empty( $post_details_padding ) ) {
        $post_details_padding = is_array( $post_details_padding ) ? implode( ' ', $post_details_padding ) : $post_details_padding;
        $post_details_padding = "padding : {$post_details_padding};";
    }else {
        $post_details_padding = '';
    }
    if( !empty( $post_details_color ) || !empty( $post_details_padding ) ) {
        $post_details_style = sprintf( 'style = "%s%s"', esc_attr( $post_details_color ), esc_attr( $post_details_padding ) );
    }

    if( !empty( $post_shadow ) && 'none' !== $post_shadow ) {
        $post_shadow = 'post-shadow-' . $post_shadow;
    }else {
        $post_shadow = '';
    }
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="<?php echo be_themes_get_class( 'post-inner', $post_shadow ); ?>" >
            <?php get_template_part( 'template-parts/posts/partials/archive', 'thumb' ); ?>
            <div class="<?php echo be_themes_get_class( 'post-details' ); ?>" <?php echo !empty( $post_details_style ) ? $post_details_style : ''; ?>>
                <div class="<?php echo be_themes_get_class( 'post-details-inner' ); ?>">
                    <?php get_template_part( 'template-parts/posts/loop', 'title' ); ?>
                    <?php get_template_part( 'template-parts/posts/partials/archive', 'content' ); ?>
                    <?php get_template_part( 'template-parts/posts/partials/archive-tertiary', 'meta' ); ?>
                </div>
            </div>
        </div>
</article>