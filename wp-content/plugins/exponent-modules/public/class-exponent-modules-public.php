<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Exponent_Modules
 * @subpackage Exponent_Modules/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Exponent_Modules
 * @subpackage Exponent_Modules/public
 * @author     Brand Exponents <help@brandexponents.com>
 */
class Exponent_Modules_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$assets_base_url = plugin_dir_url( __FILE__ );
		$cdn_address = apply_filters( 'exponent_modules_cdn_address', false );
		if( !empty( $cdn_address ) ) {
			$site_url = get_site_url();
			if( false !== strpos( $assets_base_url, $site_url ) ) {
				$assets_base_url = str_replace( $site_url, $cdn_address, $assets_base_url );
			}
		}
		if( empty( $suffix ) ) {
			$vendor_style_name = $this->plugin_name . '-vendor-css';
			wp_enqueue_style( $vendor_style_name, $assets_base_url . 'css/vendor.css', array(), $this->version, 'all'  );
			wp_enqueue_style( $this->plugin_name, $assets_base_url . 'css/exponent-modules.css', array( 'tatsu-main', 'tatsu-shortcodes', $vendor_style_name ), $this->version, 'all' );
		}else {
			wp_enqueue_style( $this->plugin_name, $assets_base_url . 'css/exponent-modules.min.css', array( 'tatsu-main' ), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$needed_scripts = array();
		$language = get_bloginfo( 'language' );
		$language = explode( '-', $language );
		if( is_array( $language ) && !empty($language[0]) && file_exists( EXPONENT_MODULES_PLUGIN_DIR . 'public/js/vendor/countdown/jquery.countdown-'.$language[0].'.js' ) ) {
			$countdown_lang_file = EXPONENT_MODULES_PLUGIN_URL . '/public/js/vendor/countdown/jquery.countdown-'.$language[0].'.js';
		} else {
			$countdown_lang_file = false;
		}
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$assets_base_url = plugin_dir_url( __FILE__ );
		$cdn_address = apply_filters( 'exponent_modules_cdn_address', false );
		$version = defined( 'EXPONENT_MODULES_VERSION' ) ? EXPONENT_MODULES_VERSION : '1.0';
		$vendor_scripts_url 	= $assets_base_url . 'js/vendor/';
		if( !empty( $cdn_address ) ) {
			$site_url = get_site_url();
			if( false !== strpos( $assets_base_url, $site_url ) ) {
				$assets_base_url = str_replace( $site_url, $cdn_address, $assets_base_url );
				$vendor_scripts_url 	= $assets_base_url . 'js/vendor/';
			}
		}

		wp_enqueue_script( 'be-script-helpers', $assets_base_url . 'js/helpers' . $suffix . '.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'debouncedresize', $assets_base_url . 'js/vendor/debouncedresize' . $suffix . '.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'asyncloader', $assets_base_url . 'js/vendor/asyncloader' . $suffix . '.js', array(), '1.0', false );
		wp_enqueue_script( $this->plugin_name, $assets_base_url . 'js/exp-modules'.$suffix.'.js', array( 'jquery', 'asyncloader', 'be-script-helpers', 'debouncedresize' ), $this->version, true );
		
		foreach( glob( EXPONENT_MODULES_PLUGIN_DIR . 'public/js/vendor/*'. $suffix .'.js') as $dependency ) {
			if( '.min' === $suffix || false === strpos( $dependency, '.min.js' ) ) { 
				$current_index = basename( $dependency, $suffix . '.js' );
				$cur_dep = add_query_arg( 'ver',  $version, $vendor_scripts_url . basename( $dependency ) );
				$needed_scripts[ $current_index ] = esc_url( $cur_dep );
			}
		}
		if( $countdown_lang_file ) {
			$needed_scripts['countdownLangFile'] = esc_url( $countdown_lang_file );
		}
		wp_localize_script(
			$this->plugin_name, 
			'exponentModulesConfig', 
			array(
				'pluginUrl' => plugins_url().'/'.$this->plugin_name.'/',
				'vendorScriptsUrl' => $vendor_scripts_url,
				'dependencies'     => $needed_scripts,
				'version'		   => $version
			) 
		);

	}

}
