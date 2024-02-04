<?php

    $blog_style = exponent_get_post_loop_prop( 'style' );
    $lazy_load  = be_themes_get_option( 'lazy_load' );
    $alignment = exponent_get_post_loop_prop( 'alignment' );
    $arrangement = exponent_get_post_loop_prop( 'arrangement' ); //either grid or slider
    $list_styles = array( 'style1', 'style4' );
    $masonry_styles = array ( 'style2', 'style5', 'style6' );
    $metro_styles = array ( 'style3', 'style7' );
    $loop_type = exponent_get_post_loop_prop( 'type' );

?>
    <?php //clearfix to prevent collapsing margin ?>
    <div class="<?php echo be_themes_get_class( 'posts-loop', 'posts-loop-' . $blog_style, 'posts-loop-align-' . $alignment ) . ( 'slider' === $arrangement ? ' clearfix' : '' ); ?>">
<?php  
    if( 'list' !== $arrangement ) {
        $classes = array();
        $data_attrs = array();
        $style = '';
    
        $gutter = exponent_get_post_loop_prop( 'posts_gutter' );
        $columns = exponent_get_post_loop_prop( 'columns' );
        $columns = is_numeric( $columns ) ? strval( $columns ) : false;
        $grid_margin = exponent_get_post_loop_prop( 'grid_with_margin' );
        $gutter = is_numeric( $gutter ) ? $gutter : 20;
        $classes[] = "be-" . $arrangement;
        if( !empty( $columns ) ) {
            $data_attrs[] = 'data-cols = "' . $columns . '"';
        }

        if( 'grid' === $arrangement ) {
            $classes[] = "be-cols-$columns";
            $blog_aspect_ratio = exponent_get_post_loop_prop( 'grid_aspect_ratio' );
            $data_attrs[] = 'data-gutter = "' . $gutter . '"'; 
            $data_attrs[] = 'data-scroll-reveal = "1"';
            if( in_array( $blog_style, $metro_styles ) ) {
                $data_attrs[] = 'data-layout = "metro"';
            }else {
                $data_attrs[] = 'data-layout = "masonry"';
            }
            $data_attrs[] = 'data-aspect-ratio = "' . $blog_aspect_ratio . '"';
            if( !empty( $grid_margin ) ) {
                $style = sprintf( 'style = "margin : 0px;padding : 0 %spx;"', $gutter/2 );
                $classes[] = 'be-grid-with-margin';
            }else {
                $style = sprintf( 'style = "margin : 0 -%1$spx -%2$spx -%1$spx;"', $gutter/2, $gutter );
            }
        }else {
            $classes[] = "be-slider-cols-$columns";
            $post_shadow = exponent_get_post_loop_prop( 'post_shadow' );
            if( !empty( $post_shadow ) && 'none' !== $post_shadow ) {
                $classes[] = 'be-slider-with-shadow';
            }
            $center_mode = exponent_get_post_loop_prop( 'center_mode' );
            $arrows = exponent_get_post_loop_prop( 'arrows' );
            $data_attrs[] = 'data-dots="1"';
            $data_attrs[] = 'data-arrows = "' . $arrows . '"';
            if( !empty( $grid_margin ) ) {
                $style = sprintf( 'style = "margin : 0px;padding : 0 %spx;"', $gutter/2 );
                $classes[] = 'be-slider-with-margin';
            }else {
                $style = sprintf( 'style = "margin : 0 -%spx;"', $gutter/2 );
            }
            if( !empty( $arrows ) ) {
                $data_attrs[] = 'data-outer-arrows  = "1"';
            }
            $data_attrs[] = 'data-gutter = "' . $gutter . '"';
            if( !empty( $lazy_load ) ) {
                $data_attrs[] = 'data-lazy-load = "1"';
            }
            if( in_array( $blog_style, $masonry_styles ) ) {
                $data_attrs[] = 'data-equal-height = "1"';
            }
            if( 'featured' === $loop_type ) {
                $data_attrs[] = 'data-cell-align = "center"';
                $data_attrs[] = 'data-infinite = "1"';
            }
        }
    ?>
        <div class="<?php echo be_themes_get_class( 'grid' === $arrangement ? 'grid-wrap' : 'slider-wrap' ); ?>">
        <div class="<?php echo implode( ' ', $classes ); ?>" <?php echo implode( ' ', $data_attrs ); ?> <?php echo wp_kses_post( $style ); ?>>
    <?php
        }
    ?>