<?php
exponent_setup_post_loop();
$blog_style = exponent_get_post_loop_prop( 'style' );
$full_width = exponent_get_post_loop_prop( 'grid_with_margin' );
$pagination_alignment = be_themes_get_option( 'blog_archive_pagination_alignment' );
$pagination_args = array();
$grid_styles = array( 'style2', 'style3', 'style5', 'style6', 'style7' );
if( !empty( $full_width ) && in_array( $blog_style, $grid_styles ) ) {
    $gutter = exponent_get_post_loop_prop( 'posts_gutter' );
    $pagination_args[ 'padding' ] = $gutter;
}
if( !empty( $pagination_alignment ) ) {
    $pagination_args[ 'class' ] = 'exp-pagination-' . $pagination_alignment;
}
get_template_part( 'template-parts/posts/before', 'loop' );
if( have_posts() ) {
    while ( have_posts() ) : 
        the_post();
        get_template_part( 'template-parts/posts/archive', $blog_style );
    endwhile;
}else {
    echo '<p class="element element-empty-message inner-content">'. esc_html__( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'exponent' ).'</p>';
}
get_template_part( 'template-parts/posts/after', 'loop' );
echo be_get_pagination( $pagination_args );

