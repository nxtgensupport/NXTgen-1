<?php
/**
 * Single Post template file.
 *
 * @package exponent
 */

$related_posts = be_themes_get_option( 'related_posts' );
$single_title = be_themes_get_option( 'blog_single_title' );
$posts_nav          = be_themes_get_option( 'posts_with_nav' );
$posts_nav_sticky   = be_themes_get_option( 'single_nav_sticky' );
get_header();
do_action( 'be_themes_before_post_single' );
while( have_posts() ) {
    the_post();
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( be_themes_get_class( 'post-single' ) ); ?>>
    <?php 
        if( !empty( $single_title ) ) {
            get_template_part( 'template-parts/posts/single', 'header' );  
        }
        do_action( 'tatsu_head' );
        if( !empty( $related_posts ) ) {
            get_template_part( 'template-parts/posts/single-post-details', 'related' );
        }else {
            get_template_part( 'template-parts/posts/single-post-details' );
        }
        if( in_array( 'post', $posts_nav ) ) {
            if( !empty( $posts_nav_sticky ) ) {
                set_query_var( 'single_nav_sticky', true );
            }
            get_template_part( 'template-parts/partials/posts', 'nav' );
        }
    ?>
</div>
<?php    
}
do_action( 'be_themes_after_post_single' );
get_footer(); 
?>