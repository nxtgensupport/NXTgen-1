<?php
$related_posts_count = apply_filters( 'be_themes_related_posts_count', 6 );
$related_posts_query_args = be_themes_get_related_posts( get_the_ID(), $related_posts_count );
$full_width_related_posts = be_themes_get_option( 'related_posts_full_width' );
$primary_meta = be_themes_get_option( 'blog_related_primary_meta' );
$secondary_meta = be_themes_get_option( 'blog_related_secondary_meta' );
$tertiary_meta = be_themes_get_option( 'blog_related_tertiary_meta' );
$meta_date_icon = be_themes_get_option( 'blog_related_meta_date_icon' );
$meta_author_image = be_themes_get_option( 'blog_related_meta_author_image' );
$labeled_cats = be_themes_get_option( 'blog_related_labeled_cat' );
$thumb_shadow = be_themes_get_option( 'related_thumb_shadow' );
$posts_shadow = be_themes_get_option( 'related_posts_shadow' );
$grid_aspect_ratio = be_themes_get_option( 'related_posts_aspect_ratio' );
$alignment = be_themes_get_option( 'related_posts_alignment' );
if( !empty( $related_posts_query_args ) ) {
    $the_query = new WP_Query( $related_posts_query_args );
    if( $the_query->have_posts() ) {
        $total_posts = (int)$the_query->found_posts;
        $related_posts_style = apply_filters( 'be_themes_related_posts_style', 'style2' );
        $related_posts_cols = be_themes_get_option( 'related_posts_cols' );
        $related_posts_gutter = be_themes_get_option( 'related_posts_gutter' );
        $related_posts_loop_args = array (
            'style'             => $related_posts_style,
            'columns'           => $related_posts_cols,
            'grid_aspect_ratio' => $grid_aspect_ratio,
            'alignment'         => $alignment,
            'grid_with_margin'  => !empty( $full_width_related_posts ) ? true : false,
            'posts_gutter'      => $related_posts_gutter,
            'hide_content'      => '1',
            'arrangement'       => $total_posts > $related_posts_cols ? 'slider' : 'grid',
            'type'              => 'related_posts',
            'primary_meta'      => $primary_meta,
            'secondary_meta'    => $secondary_meta,
            'tertiary_meta'     => $tertiary_meta,
            'meta_date_icon'    => $meta_date_icon,
            'meta_author_image' => $meta_author_image,
            'blog_post_details_custom_pad' => '0',
            'thumb_shadow'      => 'none',
            'post_shadow'       => 'none',
            'labeled_cat'       => $labeled_cats,
        );
        exponent_setup_post_loop( $related_posts_loop_args );
?>
        <div class="<?php echo be_themes_get_class( 'related-posts', empty( $full_width_related_posts ) ? 'wrap' : '' ); ?>">
    <?php
        get_template_part( 'template-parts/posts/before', 'loop' );
            while ( $the_query->have_posts() ) {
                $the_query->the_post(); 
                set_query_var('be_related_post_loop', 'in_related_post_loop');
                get_template_part( 'template-parts/posts/archive', $related_posts_style );
            }
        get_template_part( 'template-parts/posts/after', 'loop' );
    ?>
        </div>
<?php
        wp_reset_query();
        exponent_reset_post_loop();
    }
}