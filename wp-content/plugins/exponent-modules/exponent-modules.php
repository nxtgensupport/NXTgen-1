<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Exponent Modules
 * Plugin URI:        http://exponentwptheme.com
 * Description:       Add Ons for Tatsu Page Builder and Exponent theme
 * Version:           2.1.7
 * Author:            Brand Exponents
 * Author URI:        http://brandexponents.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       exponent-modules
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( !defined( 'EXPONENT_MODULES_PLUGIN_URL' ) ) {
	define( 'EXPONENT_MODULES_PLUGIN_URL', plugins_url( '', __FILE__ ) );
}
if( !defined( 'EXPONENT_MODULES_PLUGIN_DIR' ) ) {
	define( 'EXPONENT_MODULES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EXPONENT_MODULES_VERSION', '2.1.7' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-exponent-modules-activator.php
 */
function activate_exponent_modules() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-exponent-modules-activator.php';
	Exponent_Modules_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-exponent-modules-deactivator.php
 */
function deactivate_exponent_modules() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-exponent-modules-deactivator.php';
	Exponent_Modules_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_exponent_modules' );
register_deactivation_hook( __FILE__, 'deactivate_exponent_modules' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-exponent-modules.php';

require EXPONENT_MODULES_PLUGIN_DIR. 'plugin-update-checker/plugin-update-checker.php';
$exponent_modules_update_checker = new PluginUpdateChecker_3_1 (
    'https://brandexponents.com/wp/wp-content/uploads/exponent-modules.json',
    __FILE__,
    'exponent-modules'
);

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_exponent_modules() {

	$plugin = new Exponent_Modules();
	$plugin->run();

}
run_exponent_modules();
