<?php
/*
	The template for displaying a Portfolio Item.
*/
get_header(); 
$entry_header = apply_filters( 'be_single_entry_header', true );
while( have_posts() ): 
	the_post();
	if( $entry_header ) : ?>
		<?php 
			set_query_var( 'be_entry_header_wrap', true );
			$posts_with_entry_headers = get_theme_mod( 'posts_with_entry_header',array() );
			$entry_header_of_this_post = get_post_meta(get_the_ID(), 'be_themes_entry_header',true );
			if( empty( $entry_header_of_this_post ) || $entry_header_of_this_post === 'inherit' ){
				if( in_array( 'portfolio' ,$posts_with_entry_headers ) ){
					get_template_part( 'template-parts/partials/entry', 'header' ); 
				}
			} elseif ( $entry_header_of_this_post === 'show' ){
				get_template_part( 'template-parts/partials/entry', 'header' );
			}
		?>
	<?php endif; ?>
	<div id="be-content">
		<?php
		do_action( 'tatsu_head' );
		$portfolio_style = get_post_meta( get_the_ID(), 'be_themes_portfolio_single_page_style', true );
		$fixed_page_styles = array(
			'fixed-left', 
			'fixed-right',
			'floting-right',
			'floting-left',
			'fixed-overflow-left',
			'fixed-overflow-right');

		$slider_page_styles = array( 
			'style1',
			'style2',
			'style3',
			'style4',
			'be-ribbon-carousel',
			'be-center-carousel' );
		
		if( in_array( $portfolio_style, $fixed_page_styles ) ){
			get_template_part( 'template-parts/portfolio/single', 'fixed' );
		} elseif ( in_array( $portfolio_style, $slider_page_styles ) ) {
			get_template_part('template-parts/portfolio/single', 'slider');
		}else {
			the_content();
			$posts_with_nav = be_themes_get_option( 'posts_with_nav' );
			if( in_array( 'portfolio', $posts_with_nav ) ){
				$portfolio_home_page =  get_theme_mod( 'portfolio_home_url','' ); 
				if(!empty($portfolio_home_page)) {
					$url = $portfolio_home_page;
					set_query_var( 'home_url', $url );
				}
				$nav_within_cats = get_theme_mod( 'portfolio_navigation_cats', false );
				set_query_var( 'taxonomy', 'portfolio_categories' );
				if( !empty( $nav_within_cats ) ) {
					set_query_var( 'nav_within_cats', true );
				}
				set_query_var( 'be_portfolio_nav', true );
				get_template_part( 'template-parts/partials/posts', 'nav' );
			}
		}
		?>
	</div>
<?php 
endwhile;
get_footer(); 
?>