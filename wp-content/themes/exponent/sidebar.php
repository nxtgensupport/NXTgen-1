<?php
/**
 * The Sidebar containing the main (right) widget area.
 *
 * @package WordPress
 * 
 * 
 */  
	$sidebar_sticky = get_query_var( 'sidebar_sticky' );
?>
<div class="<?php echo be_themes_get_class( 'sidebar' ); ?>">
	<div class="<?php echo !empty( $sidebar_sticky ) ? 'be-sidebar-sticky' : ''; ?> <?php echo be_themes_get_class( 'sidebar-inner'); ?>">
		<?php
			global $wp_registered_sidebars; 
			$sidebar_array = array();
			foreach ( $wp_registered_sidebars as $key => $value ) {
				$sidebar_array[] = $key;
			}
			if( is_page() ) {
				$sidebar = get_post_meta(get_the_ID(), be_themes_get_meta_prefix() . 'page_sidebar', true);
			}
			if( is_home() || is_singular( 'post' ) ) {
				$sidebar = be_themes_get_option( 'blog_loop_sidebar_name' );
			}
			if( be_themes_is_woocommerce_activated() && function_exists('is_shop') && function_exists('is_product') && function_exists('is_product_category') && function_exists('is_product_tag') && (is_shop() || is_product_category() || is_product_tag() || is_product()) ) {
				$sidebar = be_themes_get_option( 'wc_loop_sidebar_name' );
			}
			if( empty( $sidebar ) || !in_array( $sidebar, $sidebar_array ) ) {
				$sidebar = 'default-sidebar';
			}
			if (is_active_sidebar( $sidebar ) ) {
				dynamic_sidebar( $sidebar );
			}
		?>
	</div>
</div>