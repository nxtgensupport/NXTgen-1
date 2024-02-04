<?php
/*
 *
 * The default full width template for displaying pages.
 *
 */
	get_header(); 
	do_action( 'tatsu_head' );
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