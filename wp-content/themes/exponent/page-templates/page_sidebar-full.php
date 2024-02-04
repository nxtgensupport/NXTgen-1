<?php
/*
 *
 * Template Name: Page With Sidebar Full Width
 *
 */

    $sidebar_position = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'page_sidebar_layout', true );
    $sidebar_position = empty( $sidebar_position ) ? 'right' : $sidebar_position;
    set_query_var( 'be_sidebar_position', $sidebar_position );

    get_header();
    do_action( 'be_themes_before_single_page' );
    get_template_part( 'template-parts/partials/content-pad', 'start' );
    while( have_posts() ): 
        the_post();
        get_template_part( 'template-parts/posts/sidebar', 'start' );
?>
        <div id="be-content">
            <?php 
                do_action( 'be_themes_before_single_page_content' );
                the_content();
                do_action( 'be_themes_after_single_page_content' );             
            ?>
        </div>
        <?php get_template_part( 'template-parts/posts/sidebar', 'end' ); ?>
    </div>
<?php endwhile; ?>
<?php
    get_template_part( 'template-parts/partials/content-pad', 'end' );
    do_action( 'be_themes_after_single_page' );
    get_footer();
?>