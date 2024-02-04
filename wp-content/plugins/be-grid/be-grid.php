<?php 
/*
Plugin Name: BE Grid
Plugin URI: https://www.exponentwptheme.com
Description: Create beautiful Portfolio Grids
Author: Brand Exponents
Version: 1.2.9
Author URI: https://www.brandexponents.com
Text Domain: be-grid
Domain Path: /languages
*/


//load text domain
function be_grid_load_textdomain(){

	load_plugin_textdomain( 'be-grid', false, plugin_dir_path( __FILE__ ).'languages/' );

}

add_action( 'plugins_loaded', 'be_grid_load_textdomain' );



if( !defined( 'BE_GRID_PLUGIN_DIR' ) ) {
	define( 'BE_GRID_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if( !defined( 'BE_GRID_PLUGIN_URL' ) ){
	define( 'BE_GRID_PLUGIN_URL', plugins_url('', __FILE__ ) );
}
if( !defined( 'BE_GRID_PLUGIN_VERSION' ) ){
	define( 'BE_GRID_PLUGIN_VERSION', '1.2.9' );
}
if( !defined( 'BE_GRID_PLUGIN_NAME' ) ){
	define( 'BE_GRID_PLUGIN_NAME','be-grid-portfolio' );
}


require_once (BE_GRID_PLUGIN_DIR.'includes/helpers.php');
require_once (BE_GRID_PLUGIN_DIR.'custom-post-types/PostType.php');
require_once (BE_GRID_PLUGIN_DIR.'modules/tatsu-module-option.php');
require_once (BE_GRID_PLUGIN_DIR.'modules/portfolio-module.php');
require_once (BE_GRID_PLUGIN_DIR.'modules/portfolio-details.php');
require_once (BE_GRID_PLUGIN_DIR.'portfolio-meta.php');
require_once (BE_GRID_PLUGIN_DIR.'typehub-config.php');

require BE_GRID_PLUGIN_DIR. 'plugin-update-checker/plugin-update-checker.php';
$be_grid_update_checker = new PluginUpdateChecker_3_1 (
    'https://brandexponents.com/wp/wp-content/uploads/be-grid.json',
    __FILE__,
    'be-grid'
);


if( !function_exists('be_grid_load_be_helper') ){
	function be_grid_load_be_helper() {
		// Load after Tatsu Loads
		require_once (BE_GRID_PLUGIN_DIR. 'includes/be-helpers.php');
	}
	add_action( 'wp_loaded', 'be_grid_load_be_helper' );
}

/***********************************************
					PORTFOLIO
***********************************************/	

//Create Post Type
$portfolio = Be_Grid_Create_Custom_Post_Type( 'portfolio' );

//Add Categories Style Taxonomy
$portfolio->Add_Categories_Style_Taxonomy( 'portfolio_categories' );

//Add Tags Style Taxonomy
$portfolio->Add_Tags_Style_Taxonomy( 'portfolio_tags' );

$portfolio->args['supports'] = array( 'title', 'editor','thumbnail','excerpt' );


add_action('after_setup_theme', 'be_grid_crop_portfolio_images');

if ( function_exists( 'add_image_size' ) ) {
	function be_grid_crop_portfolio_images(){
		$aspect_ratio = false;
		$aspect_ratio = apply_filters('portfolio_aspect_ratio', $aspect_ratio);
		
		$portfolio_image_height = $aspect_ratio ? round(650 / floatval($aspect_ratio)) : 385;
		$portfolio_2_col = $aspect_ratio ? round(1000 / floatval($aspect_ratio)) : 592;
		$portfolio_3_col_wide_width_height_image_height = $aspect_ratio ? round(1250 / floatval($aspect_ratio)) : 766;
		$portfolio_3_col_wide_width_image_height = $aspect_ratio ? round(1250 / floatval($aspect_ratio)) : 350;
		$portfolio_3_col_wide_height_image_height = $aspect_ratio ? 2*round(650 / floatval($aspect_ratio)) : 770;
		// PORTFOLIO
		add_image_size( 'portfolio', 650, $portfolio_image_height, true );
		add_image_size( 'portfolio-masonry', 650 );
		add_image_size( '2col-portfolio', 1000, $portfolio_2_col, true );
		add_image_size( '2col-portfolio-masonry', 1000 );
		add_image_size( '3col-portfolio-wide-width-height', 1250, $portfolio_3_col_wide_width_height_image_height, true );
		add_image_size( '3col-portfolio-wide-width', 1250, $portfolio_3_col_wide_width_image_height, true );
		add_image_size( '3col-portfolio-wide-height', 650, $portfolio_3_col_wide_height_image_height, true );
	}
}
add_action( 'wp_enqueue_scripts', 'be_grid_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'be_grid_enqueue_scripts' );
if( !function_exists( 'be_grid_enqueue_scripts' ) ) {
	function be_grid_enqueue_scripts(){
		$needed_scripts = array();
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$version = defined( 'BE_GRID_PLUGIN_VERSION' ) ? BE_GRID_PLUGIN_VERSION : '1.0';
		$assets_base_url = plugin_dir_url( __FILE__ );
		$vendor_scripts_url 	= $assets_base_url . 'js/vendor/';
		$cdn_address = apply_filters( 'be_portfolio_post_cdn_address', false );
		if( !empty( $cdn_address ) ) {
			$site_url = get_site_url();
			if( false !== strpos( $assets_base_url, $site_url ) ) {
				$assets_base_url = str_replace( $site_url, $cdn_address, $assets_base_url );
				$vendor_scripts_url 	= $assets_base_url . 'js/vendor/';
			}
		}

		wp_enqueue_script( 'asyncloader', $vendor_scripts_url . 'asyncloader' . $suffix . '.js', array(), BE_GRID_PLUGIN_VERSION, false );
		wp_enqueue_script( 'be-script-helpers', $assets_base_url . 'js/helpers' . $suffix . '.js', array( 'jquery' ), BE_GRID_PLUGIN_VERSION, true );
		wp_enqueue_script( 'debouncedresize', $vendor_scripts_url . 'debouncedresize' . $suffix . '.js', array( 'jquery' ), BE_GRID_PLUGIN_VERSION, true );
		wp_enqueue_script( BE_GRID_PLUGIN_NAME, $assets_base_url . 'js/portfolio'.$suffix.'.js', array( 'jquery', 'asyncloader', 'be-script-helpers', 'debouncedresize' ), BE_GRID_PLUGIN_VERSION, true );

		foreach( glob( BE_GRID_PLUGIN_DIR . 'js/vendor/*'. $suffix .'.js') as $dependency ) {
			if( '.min' === $suffix || false === strpos( $dependency, '.min.js' ) ) { 
				$current_index = basename( $dependency, $suffix . '.js' );
				$cur_dep = add_query_arg( 'ver',  $version, $vendor_scripts_url . basename( $dependency ) );
				$needed_scripts[ $current_index ] = esc_url( $cur_dep );
			}
		}	

		wp_localize_script(
			BE_GRID_PLUGIN_NAME, 
			'portfolioPluginConfig', 
			array(
				'pluginUrl' 	   => plugins_url().'/'.BE_GRID_PLUGIN_NAME.'/',
				'vendorScriptsUrl' => $vendor_scripts_url,
				'dependencies'     => $needed_scripts,
				'version'		   => $version,
			) 
		);

		if( empty( $suffix ) ) {
			wp_enqueue_style( BE_GRID_PLUGIN_NAME, $assets_base_url . 'css/be-grid.css', array(), BE_GRID_PLUGIN_VERSION, 'all' );
			wp_enqueue_style( 'modulobox', $assets_base_url . 'css/modulobox.css', array(), BE_GRID_PLUGIN_VERSION, 'all' );
		}else{ 
			wp_enqueue_style( BE_GRID_PLUGIN_NAME, $assets_base_url . 'css/be-grid.min.css', array(), BE_GRID_PLUGIN_VERSION, 'all' );
		}
	}
}
?>