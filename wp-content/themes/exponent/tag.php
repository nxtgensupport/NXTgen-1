<?php
	/**
	 * Tag Template.
	 */

	$sidebar = be_themes_get_option( 'blog_loop_sidebar' );
	$sidebar_position = be_themes_get_option( 'blog_loop_sidebar_position' );

	get_header();
	do_action( 'be_themes_before_post_archive' );
?>
	<div class="be-blog-archive">
<?php
	get_template_part( 'template-parts/partials/content-pad', 'start' );
	get_template_part( 'template-parts/partials/wrap', 'start' );
	if( !empty( $sidebar ) ) {
		set_query_var( 'be_sidebar_position', $sidebar_position );
		get_template_part( 'template-parts/posts/sidebar', 'start' );
	}
	get_template_part( 'template-parts/posts/archive' );
	if( !empty( $sidebar ) ) {
		get_template_part( 'template-parts/posts/sidebar', 'end' );
	}
	get_template_part( 'template-parts/partials/wrap', 'end' );
	get_template_part( 'template-parts/partials/content-pad', 'end' );
?>
	</div>
<?php
	do_action( 'be_themes_after_post_archive' );
	get_footer(); 
