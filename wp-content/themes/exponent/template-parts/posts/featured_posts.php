<?php

$featured_meta_key = be_themes_get_meta_prefix() . 'featured_post';
$featured_posts_type = be_themes_get_option( 'featured_posts_type' );
$featured_posts_gutter = be_themes_get_option( 'featured_posts_gutter' );
$primary_meta = be_themes_get_option( 'blog_featured_primary_meta' );
$secondary_meta = be_themes_get_option( 'blog_featured_secondary_meta' );
$tertiary_meta = be_themes_get_option( 'blog_featured_tertiary_meta' );
$meta_date_icon = be_themes_get_option( 'blog_featured_meta_date_icon' );
$meta_author_image = be_themes_get_option( 'blog_featured_meta_author_image' );
$labeled_cats = be_themes_get_option( 'blog_featured_labeled_cat' );
$grid_cols = be_themes_get_option( 'featured_posts_grid_cols' );
$grid_with_margin = be_themes_get_option( 'featured_posts_grid_with_margin' );
$shadow = be_themes_get_option( 'featured_posts_shadow' );

$args = array (
	'post_type'         => 'post',
    'posts_per_page'    => 6,
    'orderby'           => 'date',
    'meta_key'          => $featured_meta_key,
    'meta_value'        => '1'    
);

$args = apply_filters( 'be_themes_featured_posts_query_args', $args );
$the_query = new WP_Query( $args );

$loop_style = apply_filters( 'be_themes_featured_posts_style', 'style3' );
$columns = 'grid' === $featured_posts_type ? $grid_cols : false;

$featured_post_loop_args = array (
    'style'             => $loop_style,
    'columns'           => $columns,
    'arrangement'       => $featured_posts_type,
    'posts_gutter'      => $featured_posts_gutter,
    'grid_with_margin'  => !empty( $grid_with_margin ) ? true : false,
    'type'              => 'featured',
    'primary_meta'      => $primary_meta,
    'post_shadow'       => $shadow,
    'secondary_meta'    => $secondary_meta,
    'tertiary_meta'     => $tertiary_meta,
    'meta_date_icon'    => $meta_date_icon,
    'meta_author_image' => $meta_author_image,
    'labeled_cat'       => $labeled_cats,
    'border_radius'     => 0
);

?>
<section class="<?php echo be_themes_get_class( 'featured-posts' ); ?>">
    <?php
        if( $the_query->have_posts() ) {
            exponent_setup_post_loop( $featured_post_loop_args );
            get_template_part( 'template-parts/posts/before', 'loop' );
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); 
                get_template_part( 'template-parts/posts/archive', $loop_style );
            }
            get_template_part( 'template-parts/posts/after', 'loop' );
        }
        wp_reset_query();
        exponent_reset_post_loop();
    ?>
</section>