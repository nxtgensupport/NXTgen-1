<?php
/*
 *
 * Template Name: Blank Page Template
 *
 */

    get_header();
    do_action( 'be_themes_before_single_page' );
    while( have_posts() ): 
        the_post();
?>
    <div id="be-content">
        <?php 
			do_action( 'be_themes_before_single_page_content' );
			the_content();
			do_action( 'be_themes_after_single_page_content' ); 
        ?>
    </div>
<?php 
    endwhile; 
    do_action( 'be_themes_after_single_page' );
    get_footer();    
?>