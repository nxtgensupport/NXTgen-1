<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://brandexponents.com
 * @since      1.0.0
 *
 * @package    Exponent_Modules
 * @subpackage Exponent_Modules/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Exponent_Modules
 * @subpackage Exponent_Modules/includes
 * @author     Brand Exponents <help@brandexponents.com>
 */
class Exponent_Modules {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Exponent_Modules_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'EXPONENT_MODULES_VERSION' ) ) {
			$this->version = EXPONENT_MODULES_VERSION;
		} else {
			$this->version = '2.0';
		}
		$this->plugin_name = 'exponent-modules';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Exponent_Modules_Loader. Orchestrates the hooks of the plugin.
	 * - Exponent_Modules_i18n. Defines internationalization functionality.
	 * - Exponent_Modules_Admin. Defines all hooks for the admin area.
	 * - Exponent_Modules_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once EXPONENT_MODULES_PLUGIN_DIR . 'includes/class-exponent-modules-loader.php';

		require_once EXPONENT_MODULES_PLUGIN_DIR . 'includes/functions/helpers.php';



		require_once EXPONENT_MODULES_PLUGIN_DIR . 'includes/icons/icons.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once EXPONENT_MODULES_PLUGIN_DIR . 'includes/class-exponent-modules-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once EXPONENT_MODULES_PLUGIN_DIR . 'admin/class-exponent-modules-admin.php';

		require_once EXPONENT_MODULES_PLUGIN_DIR . 'includes/widgets/recent_post_widget.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once EXPONENT_MODULES_PLUGIN_DIR . 'public/class-exponent-modules-public.php';

		include_once EXPONENT_MODULES_PLUGIN_DIR . 'includes/integrations/contact_form7.php';

		include_once EXPONENT_MODULES_PLUGIN_DIR . 'includes/integrations/tatsu-gallery.php';

        include_once EXPONENT_MODULES_PLUGIN_DIR . 'includes/integrations/typehub.php';
        
        include_once EXPONENT_MODULES_PLUGIN_DIR . 'includes/templates/index.php';

		$this->loader = new Exponent_Modules_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Exponent_Modules_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Exponent_Modules_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Exponent_Modules_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'tatsu_builder_footer', $plugin_admin, 'enqueue_module_components',11 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Exponent_Modules_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_loaded', $this, 'load_be_helper' );
		$this->loader->add_action( 'init', $this, 'theme_support_mod' );
		$this->loader->add_action( 'wp_loaded', $this, 'load_exponent_modules' );
		
	}

	public function load_be_helper() {
		// Load after Tatsu Loads
		require_once EXPONENT_MODULES_PLUGIN_DIR . 'includes/functions/be-helpers.php';
		remove_theme_support( 'custom-header' );
		remove_theme_support( 'custom-background' );
	}

	public function theme_support_mod() {
		remove_theme_support( 'custom-header' );
		remove_theme_support( 'custom-background' );
	}

	public function load_exponent_modules() {
		foreach ( glob( EXPONENT_MODULES_PLUGIN_DIR . 'includes/modules/*.php' )  as $module ) {
			require_once $module;
		}
		add_shortcode('icon_card', 'tatsu_icon_card');
		add_shortcode('oshine_animated_link', 'tatsu_animated_link');
	}

	// /**
	//  * Register all plugin integrations.
	//  */
	// private function integrations() {
		
	// 	if ( class_exists( 'WPCF7' ) ) {
	// 		include_once EXPONENT_MODULES_PLUGIN_DIR . 'includes/integrations/contact_form7.php';
	// 		$this->loader->add_filter( 'wpcf7_editor_panels', 'be_wcf7_presets_tab' );
	// 	}
	
	// }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Exponent_Modules_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
