<?php
    $post_shadow = exponent_get_post_loop_prop( 'post_shadow' );
    $arrangement = exponent_get_post_loop_prop( 'arrangement' );
    $border_radius = exponent_get_post_loop_prop( 'border_radius' );
    $post_class = array();
    $post_inner_class = array();
    $post_inner_class[] = be_themes_get_class( 'post-inner' );

    $post_style = '';
    if( !empty( $border_radius ) ) {
        $post_style = 'style = "border-radius : ' . $border_radius . 'px"';
    }
    if( !empty( $post_shadow ) ) {
        $post_inner_class[] = be_themes_get_class( 'post-shadow-' . $post_shadow );
    }

    if( 'grid' === $arrangement ) {
        $post_class[] = 'be-col';
        $double_width = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'blog_double_width', true );
        $double_height = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'blog_double_height', true );    
        if( !empty( $double_height ) && !empty( $double_width ) ) {
            $post_class[] = 'be-double-width-height-cell';
        }else if( !empty( $double_width ) ) {
            $post_class[] = 'be-double-width-cell';
        }else if( !empty( $double_height ) ) {
            $post_class[] = 'be-double-height-cell';
        }
    }else if( 'slider' === $arrangement ) {
        $post_class[] = 'be-slide';
        $post_inner_class[] = 'be-slide-inner';
    }

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?> <?php exponent_print_post_slide_or_cell_styles(); ?>>
    <div class="<?php echo implode( ' ', $post_inner_class ); ?>" <?php echo !empty( $post_style ) ? $post_style : ''; ?>>
        <?php get_template_part( 'template-parts/posts/partials/archive', 'thumb' ); ?>
        <div class="<?php echo be_themes_get_class( 'post-details' ); ?>">
            <div class="<?php echo be_themes_get_class( 'post-details-inner' ); ?>">
                <?php get_template_part( 'template-parts/posts/loop', 'title' ); ?>
                <?php get_template_part( 'template-parts/posts/partials/archive-tertiary', 'meta' ); ?>
            </div>
        </div>
    </div>
</article>
