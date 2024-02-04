<?php
    $post_details_style = '';
    $post_shadow = exponent_get_post_loop_prop( 'post_shadow' );
    $arrangement = exponent_get_post_loop_prop( 'arrangement' );
    $custom_padding = exponent_get_post_loop_prop( 'custom_post_details_padding' );
    $post_details_padding = exponent_get_post_loop_prop( 'post_details_padding' );
    $post_details_color = exponent_get_post_loop_prop( 'post_details_color' );
    $post_class = array();
    $post_inner_class = array();
    $post_inner_class[] = be_themes_get_class( 'post-inner' );
    if( 'slider' === $arrangement ) {
        $post_class[] = 'be-slide';
        $post_inner_class[] = 'be-slide-inner';
    }else if( 'grid' === $arrangement ) {
        $post_class[] = 'be-col';
    }
    
    if( !empty( $custom_padding ) && !empty( $post_details_padding ) ) {
        $post_details_padding = is_array( $post_details_padding ) ? implode( ' ', $post_details_padding ) : $post_details_padding;
        $post_details_padding = "padding : {$post_details_padding};"; 
    }else {
        $post_details_padding = '';
    }
    if( !empty( $post_details_color ) ) {
        $post_details_color = "background : $post_details_color;";
    }else {
        $post_details_color = '';
    }
    
    if( !empty( $post_details_color ) || !empty( $post_details_padding ) ) {
        $post_details_style = 'style = "' . $post_details_color . $post_details_padding . '"';
    }

    if( !empty( $post_shadow ) ) {
        $post_inner_class[] = be_themes_get_class( 'post-shadow-' . $post_shadow );
    }
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?> <?php exponent_print_post_slide_or_cell_styles(); ?>>
    <div class="<?php echo implode( ' ', $post_inner_class ); ?>">
        <?php get_template_part( 'template-parts/posts/partials/archive', 'thumb' ); ?>
        <div class="<?php echo be_themes_get_class( 'post-details' ); ?>" <?php echo !empty($post_details_style) ? $post_details_style : ''; ?>>
            <div class="<?php echo be_themes_get_class( 'post-details-inner' ); ?>">
                <?php get_template_part( 'template-parts/posts/loop', 'title' ); ?>
                <?php get_template_part( 'template-parts/posts/partials/archive', 'content' ); ?>
                <?php get_template_part( 'template-parts/posts/partials/archive-tertiary', 'meta' ); ?>
            </div>
        </div>
    </div>
</article>