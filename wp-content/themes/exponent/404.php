<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 */

get_header(); 
do_action( 'be_themes_before_single_page' );
get_template_part( 'template-parts/partials/content-pad', 'start' );
?>
<div id="be-content">
	<div class="<?php echo be_themes_get_class( 'wrap' ); ?>">
		<header class="<?php echo be_themes_get_class( 'not-found-header' ); ?>">
			<h3 class="<?php echo be_themes_get_class( 'not-found-header-title' ); ?>">
				<?php echo esc_html__( '404 PAGE NOT FOUND', 'exponent' ); ?>
			</h3>
			<p>
				<?php echo esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'exponent' ); ?>
			</p>
		</header>
		<div class="<?php echo be_themes_get_class( 'not-found-search' ); ?>">
			<?php get_search_form(); ?>
		</div>
	</div>
</div>
<?php
get_template_part( 'template-parts/partials/content-pad', 'end' );
do_action( 'be_themes_after_single_page' );
get_footer(); 