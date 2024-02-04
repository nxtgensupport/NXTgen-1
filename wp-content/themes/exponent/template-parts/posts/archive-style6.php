<?php
    $arrangement = exponent_get_post_loop_prop( 'arrangement' );
    $custom_padding = exponent_get_post_loop_prop( 'custom_post_details_padding' );
    $post_details_padding = exponent_get_post_loop_prop( 'post_details_padding' );
    $border_radius = exponent_get_post_loop_prop( 'border_radius' );
    $background_color = exponent_get_post_loop_prop( 'post_details_color' );
    $post_class = array();
    $post_inner_class = array();
    $post_inner_class[] = be_themes_get_class( 'post-inner' );
    if( 'slider' === $arrangement ) {
        $post_class[] = 'be-slide';
        $post_inner_class[] = 'be-slide-inner';
    }else if( 'grid' === $arrangement ) {
        $post_class[] = 'be-col';
    }


    $post_style = '';
    if( !empty( $background_color ) ) {
        $background_color = "background : $background_color;";
    }else {
        $background_color = '';
    }
    if( !empty( $border_radius ) ) {
        $border_radius = "border-radius : {$border_radius}px;";
    }else {
        $border_radius = '';
    }
    if( !empty( $background_color ) || !empty( $border_radius ) ) {
        $post_style = sprintf( 'style = "%s%s"', $background_color, $border_radius );
    }

    $post_details_style = '';
    if( !empty( $custom_padding ) && !empty( $post_details_padding ) ) {
        $post_details_padding = is_array( $post_details_padding ) ? implode( ' ', $post_details_padding ) : $post_details_padding;
        $post_details_style = sprintf( 'style = "padding : %s;"', $post_details_padding );
    }


?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?> <?php exponent_print_post_slide_or_cell_styles(); ?>>
    <div class="<?php echo implode( ' ', $post_inner_class ); ?>" <?php echo !empty( $post_style ) ? $post_style : ''; ?>>
        <?php get_template_part( 'template-parts/posts/partials/archive', 'thumb' ); ?>
        <div class="<?php echo be_themes_get_class( 'post-details' ); ?>" <?php echo !empty( $post_details_style ) ? $post_details_style : ''; ?>>
            <div class="<?php echo be_themes_get_class( 'post-details-inner' ); ?>">
                <?php get_template_part( 'template-parts/posts/loop', 'title' ); ?>
                <?php get_template_part( 'template-parts/posts/partials/archive-tertiary', 'meta' ); ?>
            </div>
        </div>
    </div>
</article>