<?php
/**
 * The blog archive template file.
 *
 * @package exponent
 */

$featured_posts = !empty( be_themes_get_option( 'featured_posts' ) ) ? true : false;
$sidebar = be_themes_get_option( 'blog_loop_sidebar' );
$sidebar_position = be_themes_get_option( 'blog_loop_sidebar_position' );
$sidebar_sticky = be_themes_get_option( 'blog_loop_sidebar_sticky' );
$blog_style = be_themes_get_option( 'blog_archive_style' );
$list_styles = array( 'style1', 'style4' );
$full_width = !in_array( $blog_style, $list_styles ) && be_themes_get_option( 'blog_grid_full_width' );

get_header();
be_themes_print_home_page_content();
do_action( 'be_themes_before_post_archive' );
if( !empty( $featured_posts ) ) {
    get_template_part( 'template-parts/posts/featured_posts' );
}
?>
    <div class="be-blog-archive">
<?php
    get_template_part( 'template-parts/partials/content-pad', 'start' );
    get_template_part( 'template-parts/partials/wrap', 'start' );
    if( !empty( $sidebar ) ) {
        set_query_var( 'be_sidebar_position', $sidebar_position );
        if( !empty( $full_width ) ) {
            set_query_var( 'be_sidebar_with_margin', true ); 
        }
        get_template_part( 'template-parts/posts/sidebar', 'start' );
    }
    get_template_part( 'template-parts/posts/archive' );
    if( !empty( $sidebar ) ) {
        set_query_var('sidebar_sticky', $sidebar_sticky);
        get_template_part( 'template-parts/posts/sidebar', 'end' );
    }
    get_template_part( 'template-parts/partials/wrap', 'end' );
    get_template_part( 'template-parts/partials/content-pad', 'end' );
?>
    </div>
<?php
do_action( 'be_themes_after_post_archive' );
get_footer(); 
?>