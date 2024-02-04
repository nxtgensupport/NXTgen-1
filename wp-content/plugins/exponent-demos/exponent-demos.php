<?php
/**
 * Plugin Name: Exponent Demos
 * Description: The plugin handles the demo import functionality of Exponent and makes it easy to get started with the theme. 
 * Plugin URI: http://brandexponents.com
 * Author: Brand Exponents
 * Author URI: http://brandexponents.com
 * Version: 1.3.3
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: exponent-demos
 */
defined( 'ABSPATH' ) or exit;

define( 'EXP_DEMOS_URL', plugins_url('', __FILE__) );
define( 'EXP_DEMOS_PATH', dirname(__FILE__) );

require_once EXP_DEMOS_PATH . '/inc/importer/importer/class-exponent-demos-importer.php'; 
require_once EXP_DEMOS_PATH . '/inc/importer/init.php';
require_once EXP_DEMOS_PATH . '/inc/class-exponent-demos-core.php';

/*
 *
 */
function exp_demos_init() {
    global $ExponentCore;
    $ExponentCore               = new ExponentDemosCore();
    $ExponentCore['path']       = realpath( plugin_dir_path( __FILE__ ) ). DIRECTORY_SEPARATOR;
    $ExponentCore['url']        = plugin_dir_url( __FILE__ );
    $ExponentCore['version']    = '1.3.3';
    $ExponentCore['ExponentDemoImporter'] = new ExponentDemoImporter();
    apply_filters( 'exponent_demos_config', $ExponentCore );
    $ExponentCore->run();
}
add_action( 'init', 'exp_demos_init', 10, 1 );


function exp_demos_stat_display() {
    require_once EXP_DEMOS_PATH . '/inc/system-status.php';
    return exp_demos_system_status_tpl();
}
add_action( 'exp_systatus_tpl', 'exp_demos_stat_display', 10, 1 );

require EXP_DEMOS_PATH. '/plugin-update-checker/plugin-update-checker.php';
$exponent_demos_update_checker = new PluginUpdateChecker_3_1 (
    'https://brandexponents.com/wp/wp-content/uploads/exponent-demos.json',
    __FILE__,
    'exponent-demos'
);