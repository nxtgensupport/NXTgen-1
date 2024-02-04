<?php

/**
 * Plugin Name: Greenshift Woocommerce Addon
 * Description: Extend Woocommerce with Gutenberg blocks
 * Author: Wpsoul
 * Author URI: https://greenshiftwp.com
 * Text Domain: greenshiftwoo
 * Version: 1.9.2
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define Dir URL
define('GREENSHIFTWOO_DIR_URL', plugin_dir_url(__FILE__));
define('GREENSHIFTWOO_DIR_PATH', plugin_dir_path(__FILE__));
define('GREENSHIFTWOO_PLUGIN_VER', '1.9.2');

function gspb_woo_is_parent_active()
{
    $active_plugins = get_option('active_plugins', array());

    if (is_multisite()) {
        $network_active_plugins = get_site_option('active_sitewide_plugins', array());
        $active_plugins         = array_merge($active_plugins, array_keys($network_active_plugins));
    }

    foreach ($active_plugins as $basename) {
        if (
            0 === strpos($basename, 'greenshift-animation-and-page-builder-blocks/')
        ) {
            return true;
        }
    }

    return false;
}

if (gspb_woo_is_parent_active()) {
    if (!defined('EDD_CONSTANTS')) {
        require_once GREENSHIFT_DIR_PATH . 'edd/edd_constants.php';
    }

    add_filter('plugins_api', 'greenshiftwoo_plugin_info', 20, 3);
    add_filter('site_transient_update_plugins', 'greenshiftwoo_push_update');
    add_action('upgrader_process_complete', 'greenshiftwoo_after_update', 10, 2);
    add_action('after_plugin_row_' . plugin_basename(__FILE__), 'greenshiftwoo_after_plugin_row', 10, 3);

    // Hook: Editor assets.
    add_action('enqueue_block_editor_assets', 'greenShiftWoo_editor_assets');
} else {
    add_action('admin_notices', 'greenshiftwoo_admin_notice_warning');
}

//////////////////////////////////////////////////////////////////
// Plugin updater
//////////////////////////////////////////////////////////////////

function greenshiftwoo_after_plugin_row($plugin_file, $plugin_data, $status)
{
    $licenses = greenshift_edd_check_all_licenses();
    $is_active = (((!empty($licenses['all_in_one']) && $licenses['all_in_one'] == 'valid') || (!empty($licenses['all_in_one_woo']) && $licenses['all_in_one_woo'] == 'valid') || (!empty($licenses['woocommerce_addon']) && $licenses['woocommerce_addon'] == 'valid'))) ? true : false;
    if (!$is_active) {
        echo sprintf('<tr class="active"><td colspan="4">%s <a href="%s">%s</a></td></tr>', 'Please enter a license to receive automatic updates', esc_url(admin_url('admin.php?page=' . EDD_GSPB_PLUGIN_LICENSE_PAGE)), 'Enter License.');
    }
}

function greenshiftwoo_plugin_info($res, $action, $args)
{

    // do nothing if this is not about getting plugin information
    if ($action !== 'plugin_information') {
        return false;
    }

    // do nothing if it is not our plugin
    if (plugin_basename(__DIR__) !== $args->slug) {
        return $res;
    }

    // trying to get from cache first, to disable cache comment 23,33,34,35,36
    if (false == $remote = get_transient('greenshiftwoo_upgrade_pluginslug')) {

        // info.json is the file with the actual information about plug-in on your server
        $remote = wp_remote_get(
            EDD_GSPB_STORE_URL_UPDATE . '/get-info.php?slug=' . plugin_basename(__DIR__) . '&action=info',
            array(
                'timeout' => 15,
                'headers' => array(
                    'Accept' => 'application/json'
                )
            )
        );

        if (!is_wp_error($remote) && isset($remote['response']['code']) && $remote['response']['code'] == 200 && !empty($remote['body'])) {
            set_transient('greenshiftwoo_upgrade_pluginslug', $remote, 60000);
        }else{
            set_transient('greenshiftwoo_upgrade_pluginslug', 'error', 60000);
        }
    }

    if (!is_wp_error($remote) && $remote && $remote != 'error') {

        $remote = json_decode(wp_remote_retrieve_body($remote));

        $res = new stdClass();
        $res->name = $remote->name;
        $res->slug = $remote->slug;
        $res->version = $remote->version;
        $res->tested = $remote->tested;
        $res->requires = $remote->requires;
        $res->author = $remote->author;
        $res->author_profile = $remote->author_homepage;
        $res->download_link = $remote->download_link;
        $res->trunk = $remote->download_link;
        $res->last_updated = $remote->last_updated;

        if (isset($remote->sections)) {
            $res->sections = array(
                'description' => $remote->sections->description, // description tab
                'installation' => $remote->sections->installation, // installation tab
                'changelog' => isset($remote->sections->changelog) ? $remote->sections->changelog : '',
            );
        }
        if (isset($remote->banners)) {
            $res->banners = array(
                'low' => $remote->banners->low,
                'high' => $remote->banners->high,
            );
        }

        return $res;
    }

    return false;
}

function greenshiftwoo_push_update($transient)
{

    if (empty($transient->checked)) {
        return $transient;
    }

    // trying to get from cache first, to disable cache comment 11,20,21,22,23
    if (false == $remote = get_transient('greenshiftwoo_upgrade_pluginslug')) {
        // info.json is the file with the actual plugin information on your server
        $remote = wp_remote_get(
            EDD_GSPB_STORE_URL_UPDATE . '/get-info.php?slug=' . plugin_basename(__DIR__) . '&action=info',
            array(
                'timeout' => 10,
                'headers' => array(
                    'Accept' => 'application/json'
                )
            )
        );

        if (!is_wp_error($remote) && isset($remote['response']['code']) && $remote['response']['code'] == 200 && !empty($remote['body'])) {
            set_transient('greenshiftwoo_upgrade_pluginslug', $remote, 60000);
        }else{
            set_transient('greenshiftwoo_upgrade_pluginslug', 'error', 60000);
        }
    }

    if (!is_wp_error($remote) && $remote && $remote != 'error') {

        $remote = json_decode($remote['body']);

        // your installed plugin version should be on the line below! You can obtain it dynamically of course
        if ($remote && version_compare(GREENSHIFTWOO_PLUGIN_VER, $remote->version, '<') && version_compare($remote->requires, get_bloginfo('version'), '<')) {
            $res = new stdClass();
            $res->slug = plugin_basename(__DIR__);
            $res->plugin = plugin_basename(__FILE__); // it could be just pluginslug.php if your plugin doesn't have its own directory
            $res->new_version = $remote->version;
            $res->tested = $remote->tested;
            $licenses = greenshift_edd_check_all_licenses();
            $is_active = (((!empty($licenses['all_in_one']) && $licenses['all_in_one'] == 'valid') || (!empty($licenses['all_in_one_woo']) && $licenses['all_in_one_woo'] == 'valid') || (!empty($licenses['woocommerce_addon']) && $licenses['woocommerce_addon'] == 'valid'))) ? true : false;
            if ($is_active) {
                $res->package = $remote->download_link;
            }
            $transient->response[$res->plugin] = $res;
            //$transient->checked[$res->plugin] = $remote->version;
        }
    }
    return $transient;
}

function greenshiftwoo_after_update($upgrader_object, $options)
{
    if ($options['action'] == 'update' && $options['type'] === 'plugin') {
        // just clean the cache when new plugin version is installed
        delete_transient('greenshiftwoo_upgrade_pluginslug');
    }
}

function greenshiftwoo_admin_notice_warning()
{
?>
    <div class="notice notice-warning">
        <p><?php printf(__('Please, activate %s plugin to use Woocommerce Addon'), '<a href="https://wordpress.org/plugins/greenshift-animation-and-page-builder-blocks" target="_blank">Greenshift</a>'); ?></p>
    </div>
<?php
}

function greenshiftwoo_change_action_links($links)
{

    $links = array_merge(array(
        '<a href="https://greenshiftwp.com/changelog" style="color:#93003c" target="_blank">' . __('What\'s New', 'greenshiftwoo') . '</a>'
    ), $links);

    return $links;
}
add_action('plugin_action_links_' . plugin_basename(__FILE__), 'greenshiftwoo_change_action_links');


/**
 * GreenShift Blocks Category
 */
if (!function_exists('gspb_greenShiftWoo_category')) {
    function gspb_greenShiftWoo_category($categories, $post)
    {
        return array_merge(
            array(
                array(
                    'slug'  => 'greenShiftWoo',
                    'title' => __('GreenShift Woocommerce'),
                ),
            ),
            $categories
        );
    }
}
add_filter('block_categories_all', 'gspb_greenShiftWoo_category', 1, 2);

//////////////////////////////////////////////////////////////////
// Register server side
//////////////////////////////////////////////////////////////////
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-price/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-categories/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-tags/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-sku/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-availability/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-button/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-discount/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-rating/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-quick-view/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-comparison/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-title/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-featured-image/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/woo-cart-button/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-gallery/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-tabs/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-hooks/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-breadcrumbs/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-notice/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-catalog-ordering/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-result-count/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-widgets/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-short-description/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-stock-notice/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-shipping-bar/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-bundles/block.php';
require_once GREENSHIFTWOO_DIR_PATH . 'blockrender/product-combo/block.php';

/*include product comparison functions*/
require_once GREENSHIFTWOO_DIR_PATH . 'includes/comparison.php';

/*  */
require_once GREENSHIFTWOO_DIR_PATH . 'includes/query.php';

/* Include woocommerce functions and features. */
add_action('init', 'init_woo_features');
function init_woo_features()
{
    $theme = wp_get_theme();
    if ('Rehub theme' != $theme->name && 'Rehub theme' != $theme->parent_theme && class_exists('WooCommerce')) {
        include_once GREENSHIFTWOO_DIR_PATH . 'includes/helper-aftertheme.php';
        include_once GREENSHIFTWOO_DIR_PATH . 'includes/woo_group_attributes_class.php';

        $group_attributes_post_type = new GSPBWOO_WC_Group_Attributes(GREENSHIFTWOO_PLUGIN_VER);
        $group_attributes_post_type->init();
    }
    include_once GREENSHIFTWOO_DIR_PATH . 'includes/helper-functions.php';
}

/* Include Custom Tabs the Product Page (see WC -> Settings -> Greenshift Tools tab). */
function gspbwoo_tools_init()
{
    if (class_exists('WooCommerce')) {
        require GREENSHIFTWOO_DIR_PATH . 'includes/class_gspbwoo_tools.php';
        new GSPBWOO_Tools();
    }
}
add_action('plugins_loaded', 'gspbwoo_tools_init');

//////////////////////////////////////////////////////////////////
// Functions to render conditional scripts
//////////////////////////////////////////////////////////////////

// Hook: Frontend assets.
add_action('wp_enqueue_scripts', 'greenShiftWoo_register_init');

if (!function_exists('greenShiftWoo_register_init')) {
    function greenShiftWoo_register_init()
    {
        $theme = wp_get_theme();
        //register scripts


        wp_register_script(
            'gspbquickviewscript',
            GREENSHIFTWOO_DIR_URL . 'libs/quick-view/index.min.js',
            array(),
            '1.1',
            true
        );

        wp_register_script(
            'gspbreviewlink',
            GREENSHIFTWOO_DIR_URL . 'libs/reviewlink/index.min.js',
            array(),
            '1.0',
            true
        );

        // wp_register_script(
        //     'gsshippingbar',
        //     GREENSHIFTWOO_DIR_URL . 'libs/cartbar/index.min.js',
        //     array('wc-cart-fragments'),
        //     '1.4',
        //     true
        // );

        /*compare script*/
        wp_register_script(
            'gspbproductcomparison',
            GREENSHIFTWOO_DIR_URL . 'libs/compare/comparison.min.js',
            array(),
            '1.1',
            true
        );
        $compareNonce = wp_create_nonce('comparenonce');
        wp_localize_script(
            'gspbproductcomparison',
            'gscomparevars',
            array(
                'ajax_url' => admin_url('admin-ajax.php', 'relative'),
                'comparenonce' => $compareNonce,
            )
        );

        wp_register_script(
            'gspbproductcomparison-table',
            GREENSHIFTWOO_DIR_URL . 'libs/compare/tablechart.min.js',
            array(),
            '1.0',
            true
        );
        wp_localize_script(
            'gspbproductcomparison-table',
            'gscomparevars',
            array(
                'ajax_url' => admin_url('admin-ajax.php', 'relative'),
                'comparenonce' => $compareNonce,
            )
        );

        wp_register_script(
            'gspbcompare',
            GREENSHIFTWOO_DIR_URL . 'libs/compare/comparechart.min.js',
            array('jquery', 'gspbproductcomparison-table'),
            '1.0',
            true
        );
        $trans_array = array(
            'item_error_add' => esc_html__('Please, add items to this compare group or choose not empty group', 'greenshiftwoo'),
            'item_error_comp' => esc_html__('Please, add more items to compare', 'greenshiftwoo'),
            'comparenonce' => $compareNonce,
        );
        wp_localize_script('gspbcompare', 'comparechart', $trans_array);
        wp_localize_script(
            'gspbcompare',
            'gscomparevars',
            array(
                'ajax_url' => admin_url('admin-ajax.php', 'relative')
            )
        );

        wp_register_style(
            'gspbcomparesearch',
            GREENSHIFTWOO_DIR_URL . 'assets/css/comparesearch.css',
            array(),
            '1.2',
        );

        wp_register_style(
            'gspbajaxsearch',
            GREENSHIFTWOO_DIR_URL . 'assets/css/ajaxsearch.css',
            array(),
            '1.0',
        );

        $scriptvars = array(
            'filternonce' => wp_create_nonce('filterpanel'),
            'ajax_url' => admin_url('admin-ajax.php', 'relative'),
        );


        wp_register_script(
            'gspbwoocartbutton',
            GREENSHIFTWOO_DIR_URL . 'libs/woo-cart-button/ajaxcart.min.js',
            array(),
            '1.2',
            true
        );
        wp_localize_script('gspbwoocartbutton', 'gspbscriptvars', $scriptvars);

        if ('Rehub theme' != $theme->name && 'Rehub theme' != $theme->parent_theme) {
            wp_register_script(
                'gsswatches',
                GREENSHIFTWOO_DIR_URL . 'libs/swatch/wooswatch.min.js',
                array('jquery'),
                '1.4.2',
                true
            );

            // Styles.
            wp_enqueue_style(
                'gsswatches', // Handle.
                GREENSHIFTWOO_DIR_URL . 'assets/css/swatches.css',
                array(),
                '1.7'
            );
        }

        wp_register_script(
            'gsvariationajax',
            GREENSHIFTWOO_DIR_URL . 'libs/variation/variationajax.min.js',
            array('jquery'),
            '1.1',
            true
        );

        wp_register_script(
            'gspbwoo_product_gallery',
            GREENSHIFTWOO_DIR_URL . 'libs/product-gallery/index.min.js',
            array(),
            '1.9',
            true
        );

        wp_register_script(
            'gspbwoo_product_tabs',
            GREENSHIFTWOO_DIR_URL . 'libs/product-tabs/tabs.min.js',
            array(),
            '1.1',
            true
        );
        wp_register_script(
            'gspbwoo_product_toggles',
            GREENSHIFTWOO_DIR_URL . 'libs/product-tabs/toggle.min.js',
            array(),
            '1.1',
            true
        );
        
    }
}

add_action( 'wp_enqueue_scripts', 'gspb_optimized_media_styles', 99 ); 
function gspb_optimized_media_styles() {
	if(class_exists('WC_Admin_Settings') && WC_Admin_Settings::get_option('gspbwoo_disable_cart_scripts') === 'yes') {
		if ( function_exists( 'is_woocommerce' ) ) {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				# Scripts
				wp_dequeue_script( 'wc-add-to-cart' );
				wp_dequeue_script( 'wc-cart-fragments' );;
				wp_dequeue_script( 'wc-add-to-cart-variation' );
				wp_dequeue_script( 'wc-cart' );
				wp_dequeue_script( 'woocommerce' );
			}
		}
	}
}

//////////////////////////////////////////////////////////////////
// Enqueue Gutenberg block assets for backend editor.
//////////////////////////////////////////////////////////////////

if (!function_exists('greenShiftWoo_editor_assets')) {
    function greenShiftWoo_editor_assets()
    {
        // phpcs:ignor

        $index_asset_file = include(GREENSHIFTWOO_DIR_PATH . 'build/index.asset.php');


        // Blocks Assets Scripts
        wp_enqueue_script(
            'greenShiftWoo-block-js', // Handle.
            GREENSHIFTWOO_DIR_URL . 'build/index.js',
            array('greenShift-editor-js', 'greenShift-library-script', 'wp-block-editor', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-data'),
            rand(1, 9999),
            true
        );

        $licenses = greenshift_edd_check_all_licenses();
        $is_active = (((!empty($licenses['all_in_one']) && $licenses['all_in_one'] == 'valid') || (!empty($licenses['all_in_one_woo']) && $licenses['all_in_one_woo'] == 'valid') || (!empty($licenses['woocommerce_addon']) && $licenses['woocommerce_addon'] == 'valid'))) ? true : false;

        $check = '';
        if ($is_active) {
            $check = 1;
        }
        $lc = array('can_use_premium_code' => $check);
        wp_localize_script('greenShiftWoo-block-js', 'greenshiftWOO', $lc);


        // Styles.
        wp_enqueue_style(
            'greenShiftWoo-block-css', // Handle.
            GREENSHIFTWOO_DIR_URL . 'build/index.css', // Block editor CSS.
            array('greenShift-library-editor', 'wp-edit-blocks'),
            $index_asset_file['version']
        );
    }
}


//////////////////////////////////////////////////////////////////
// REST routes to save and get settings
//////////////////////////////////////////////////////////////////

add_action('rest_api_init', 'gspb_woo_register_route');
function gspb_woo_register_route()
{
    register_rest_route('greenshiftwoo/v1', '/get-product-part/', [
        [
            'methods' => 'GET',
            'callback' => 'gspbwoo_get_product_parts_callback',
            'permission_callback' => function (WP_REST_Request $request) {
                return current_user_can('editor') || current_user_can('administrator');
            },
            'args' => array(
                'product_id' => array(
                    'type' => 'int',
                    'required' => false,
                ),
                'part' => array(
                    'type' => 'string',
                    'required' => true,
                ),
                'image_size' => [
                    'type' => 'string',
                    'required' => false
                ]
            ),
        ]
    ]);

    register_rest_route('greenshiftwoo/v1', '/get-terms-search/', [
        [
            'methods' => 'GET',
            'callback' => 'gspbwoo_get_taxonomy_terms_search',
            'permission_callback' => function (WP_REST_Request $request) {
                return current_user_can('editor') || current_user_can('administrator');
            },
            'args' => array(
                'taxonomy' => array(
                    'type' => 'string',
                    'required' => true,
                ),
                'search' => array(
                    'type' => 'string',
                    'required' => false
                ),
                'search-id' => array(
                    'type' => 'string',
                    'required' => false
                ),
            ),
        ]
    ]);

    register_rest_route(
        'greenshiftwoo/v1',
        '/getcomparisonelement/',
        array(
            'methods'  => WP_REST_Server::CREATABLE,
            'permission_callback' => function (WP_REST_Request $request) {
                return current_user_can('editor') || current_user_can('administrator');
            },
            'callback' => 'gspb_query_comparisonelementapi',
        )
    );

    register_rest_route('greenshiftwoo/v1', '/get-user-roles/', [
        [
            'methods' => 'GET',
            'callback' => 'gspbwoo_get_user_roles',
            'permission_callback' => function (WP_REST_Request $request) {
                return current_user_can('editor') || current_user_can('administrator');
            },
            'args' => array(
                'search' => array(
                    'type' => 'string',
                    'required' => false,
                )
            ),
        ]
    ]);

    register_rest_route('greenshiftwoo/v1', '/get-image-sizes/', [
        [
            'methods' => 'GET',
            'callback' => 'gspbwoo_get_image_sizes',
            'permission_callback' => function (WP_REST_Request $request) {
                return current_user_can('editor') || current_user_can('administrator');
            },
        ]
    ]);
}

function gspbwoo_get_image_sizes()
{
    $res = [];
    foreach (wp_get_registered_image_subsizes() as $key => $val) {
        $res[] = ['label' => $key, 'value' => $key];
    }
    return $res;
}

function gspbwoo_get_user_roles(WP_REST_Request $request)
{
    $search = sanitize_text_field($request->get_param('search'));

    global $wp_roles;

    $res = [];

    foreach ($wp_roles->roles as $key => $role) {
        if (empty($search) || strpos(strtolower($role['name']), strtolower($search)) !== false) {
            $res[] = ['label' => $role['name'], 'id' => $key, 'value' => $key];
        }
    }

    return json_encode($res);
}

function gspb_query_comparisonelementapi(WP_REST_Request $request)
{
    $type = sanitize_text_field($request->get_param('type'));
    $icontype = sanitize_text_field($request->get_param('icontype'));
    $postId = (int)$request->get_param('postId');
    $comparisonadd = sanitize_text_field($request->get_param('comparisonadd'));
    $comparisonadded = sanitize_text_field($request->get_param('comparisonadded'));
    $comparisonpage = sanitize_text_field($request->get_param('comparisonpage'));
    $loginpage = sanitize_text_field($request->get_param('loginpage'));
    $noitemstext = sanitize_text_field($request->get_param('noitemstext'));
    $table_type = sanitize_text_field($request->get_param('table_type'));
    $predefined_by = sanitize_text_field($request->get_param('predefined_by'));
    $is_backend_editor = boolval($request->get_param('is_backend_editor'));
    $productsIds = $request->get_param('productsIds');
    $categoryId = sanitize_text_field($request->get_param('categoryId'));
    $tagId = sanitize_text_field($request->get_param('tagId'));
    $disable_fields = $request->get_param('disable_fields');
    $additional_shortcode = sanitize_text_field($request->get_param('additional_shortcode'));
    $additional_shortcode_label = sanitize_text_field($request->get_param('additional_shortcode_label'));
    $search_button = boolval($request->get_param('search_button'));
    $icon = sanitize_text_field($request->get_param('icon'));

    $value = gspb_query_comparison(array(
        'type' => $type, 'icon' => $icon, 'post_id' => $postId,
        'comparisonadd' => $comparisonadd, 'comparisonadded' => $comparisonadded, 'comparisonpage' => $comparisonpage, 'loginpage' => $loginpage, 'noitemstext' => $noitemstext, 'table_type' => $table_type, 'predefined_by' => $predefined_by, 'is_backend_editor' => $is_backend_editor, 'productsIds' => $productsIds, 'categoryId' => $categoryId, 'tagId' => $tagId, 'disable_fields' => $disable_fields, 'additional_shortcode' => $additional_shortcode, 'additional_shortcode_label' => $additional_shortcode_label, 'searchbtn' => $search_button
    ));
    return json_encode($value);
}

function gspbwoo_get_taxonomy_terms_search(WP_REST_Request $request)
{
    $taxonomy = sanitize_text_field($request->get_param('taxonomy'));
    $search = sanitize_text_field($request->get_param('search'));
    $search_id = sanitize_text_field($request->get_param('search-id'));

    global $wpdb;
    if (empty($search_id)) {
        $query = [
            "select" => "SELECT SQL_CALC_FOUND_ROWS a.term_id AS id, b.name as name, b.slug AS slug
                        FROM {$wpdb->term_taxonomy} AS a
                        INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id",
            "where"  => "WHERE a.taxonomy = '{$taxonomy}'",
            "like"   => "AND (b.slug LIKE '%s' OR b.name LIKE '%s' )",
            "offset" => "LIMIT %d, %d"
        ];

        $search_term = '%' . $wpdb->esc_like($search) . '%';
        $offset = 0;
        $search_limit = 100;

        $final_query = $wpdb->prepare(implode(' ', $query), $search_term, $search_term, $offset, $search_limit);
    } else {
        $search_id = rtrim($search_id, ',');
        $query = [
            "select" => "SELECT SQL_CALC_FOUND_ROWS a.term_id AS id, b.name as name, b.slug AS slug
                        FROM {$wpdb->term_taxonomy} AS a
                        INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id",
            "where"  => "WHERE a.taxonomy = '{$taxonomy}'",
            "like"   => "AND a.term_id IN({$search_id})",
            "offset" => "LIMIT %d, %d"
        ];

        $offset = 0;
        $search_limit = 100;

        $final_query = $wpdb->prepare(implode(' ', $query), $offset, $search_limit);
    }
    // Return saved values

    $results = $wpdb->get_results($final_query);

    $total_results = $wpdb->get_row("SELECT FOUND_ROWS() as total_rows;");
    $response_data = [];

    if ($results) {
        foreach ($results as $result) {
            $response_data[] = [
                'slug'        => esc_html($result->slug),
                'name'      => esc_html($result->name),
                'id'     => (int)$result->id
            ];
        }
    }

    return json_encode($response_data);
}

function gspbwoo_get_product_parts_callback(WP_REST_Request $request)
{
    $postId = intval($request->get_param('product_id'));
    $part = sanitize_text_field($request->get_param('part'));
    $image_size = sanitize_text_field($request->get_param('image_size'));

    $_product = gspbwoo_get_product_object_by_id($postId);

    if (empty($_product)) return __('Product not found.', 'greenshiftwoo');

    $result = '';
    switch ($part) {
        case 'price':
            if($_product->is_type( 'variable' )){
                $result = '<span class="gspb-variable-price">'.$_product->get_price_html().'</span>';
            }else{
                $result = $_product->get_price_html();
            }
            break;
        case 'categories':
            $result = wc_get_product_category_list($_product->get_id());
            $result = !empty($result) ? $result : __('Categories not found', 'greenshiftwoo');
            break;
        case 'tags':
            $result = wc_get_product_tag_list($_product->get_id());
            $result = !empty($result) ? $result : __('Tags not found', 'greenshiftwoo');
            break;
        case 'sku':
            $result = $_product->get_sku();
            $result = !empty($result) ? $result : __('SKU not found', 'greenshiftwoo');
            break;
        case 'availability':
            $result = empty($_product->get_availability()['availability']) ? __('In stock', 'greenshiftwoo') : '<span class="' . $_product->get_availability()['class'] . '">' . $_product->get_availability()['availability'] . '</span>';
            break;
        case 'button':
            $result = \greenshiftwoo\Blocks\ProductButton::get_button($_product);
            break;
        case 'discount':
            $result = \greenshiftwoo\Blocks\ProductDiscount::get_discount_percentage($_product);
            break;
        case 'rating':
            $result = '<div class="star-rating" role="img">' . wc_get_star_rating_html($_product->get_average_rating(), $_product->get_rating_count()) . '</div>';
            break;
        case 'ratingnumber':
            $result = '<svg height="16" viewBox="0 0 512 512" width="16" xmlns="http://www.w3.org/2000/svg"><g><g><g><circle cx="256" cy="256" fill="orange" r="256"/></g></g><g><g><path d="m412.924 205.012c-1.765-5.43-6.458-9.388-12.108-10.209l-90.771-13.19-40.594-82.252c-2.527-5.12-7.742-8.361-13.451-8.361s-10.924 3.241-13.451 8.362l-40.594 82.252-90.771 13.19c-5.65.821-10.345 4.779-12.109 10.209s-.292 11.391 3.796 15.376l65.683 64.024-15.506 90.404c-.965 5.627 1.348 11.315 5.967 14.671 4.62 3.356 10.743 3.799 15.797 1.142l81.188-42.683 81.188 42.683c5.092 2.676 11.212 2.189 15.797-1.142 4.619-3.356 6.933-9.043 5.968-14.671l-15.506-90.404 65.682-64.024c4.088-3.986 5.559-9.947 3.795-15.377z" fill="white"/></g></g></g></svg><span>' . $_product->get_average_rating() . '</span>';
            break;
        case 'taxonomy':
            $result = $_product->get_price_html();
            break;
        case 'title':
            $result = $_product->get_title();
            break;
        case 'featured_image':
            $result = $_product->get_image($image_size);
            break;
        case 'product_images':
            $featured_image = $_product->get_image_id();
            $main_image_size = sanitize_text_field($request->get_param('main_image_size'));
            $thumbnail_image_size = sanitize_text_field($request->get_param('thumbnail_image_size'));
            $result = empty($featured_image) ? [wc_placeholder_img_src('woocommerce_single')] : gspbwoo_get_all_images_url_of_product($_product, $main_image_size, $thumbnail_image_size);
            break;
        default:
            break;
    }

    return json_encode($result);
}

function gspbwoo_get_all_images_url_of_product($_product, $main_image_size = '', $thumbnail_image_size = '')
{
    $featured_image = $_product->get_image_id();
    $image_ids = $_product->get_gallery_image_ids();

    $main_size = !empty($main_image_size) ? $main_image_size : 'woocommerce_single';
    $thumbnail_size = !empty($thumbnail_image_size) ? $thumbnail_image_size : 'woocommerce_gallery_thumbnail';

    $result = [wp_get_attachment_image_url($featured_image, $main_size)];

    foreach ($image_ids as $image_id) {
        $result[] = wp_get_attachment_image_url($image_id, $thumbnail_size);
    }

    return $result;
}

function gspbwoo_get_product_object_by_id($product_id)
{
    if ((int) $product_id > 0 && function_exists('wc_get_product')) {
        $_product = wc_get_product($product_id);
    }
    else {
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 1,
            'post_status' => 'published',
            'no_found_rows' => true,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        $loop = new WP_Query($args);

        if (empty($loop->posts)) return NULL;

        if(function_exists('wc_get_product')){
            $_product = wc_get_product($loop->posts[0]->ID);
        }else{
            return false;
        }

        wp_reset_query();
    }

    return $_product;
}

//////////////////////////////////////////////////////////////////
// Frontend Scripts
//////////////////////////////////////////////////////////////////

add_filter('render_block', 'greenShiftWoo_block_script_assets', 10, 2);
if (!function_exists('greenShiftWoo_block_script_assets')) {
    function greenShiftWoo_block_script_assets($html, $block)
    {
        // phpcs:ignore

        //Main styles for blocks are loaded via Redux in main plugin. Can be found in src/customJS/editor/store/index.js

        if (!is_admin()) {

            $blockname = isset($block['blockName']) ? $block['blockName'] : '';

            if ($blockname == 'greenshift-blocks/product-quick-view') {
                wp_enqueue_script('gspbquickviewscript');

                wp_enqueue_style(
                    'gspbquickviewscript', // Handle.
                    GREENSHIFTWOO_DIR_URL . 'libs/quick-view/index.css', // Block editor CSS.
                    array(),
                    '1.1'
                );
            }
            else if ($blockname == 'greenshift-blocks/product-comparison' && !empty($block['attrs']['type']) && $block['attrs']['type'] == 'table') {
                add_action('wp_footer', 'show_search_form');
            }

            else if ($blockname == 'greenshift-blocks/woo-cart-button') {
                wp_enqueue_script('gspbwoocartbutton');
                if (!empty($block['attrs']['enableAnimation'])) {
                    wp_enqueue_script('greenshift-inview');
                }

            }

            else if ($blockname === 'greenshift-blocks/product-stocknotice') {
                if (!empty($block['attrs']['enableAnimation'])) {
                    wp_enqueue_script('greenshift-inview');
                }
            }

            else if ($blockname == 'greenshift-blocks/product-rating') {
                if(!empty($block['attrs']['innerPage'])){
                    wp_enqueue_script('gspbreviewlink');
                }
            }

            else if ($blockname == 'greenshift-blocks/product-gallery') {
                wp_enqueue_script('gsswiper');
                wp_enqueue_style('gsswiper');
                wp_enqueue_style('gslightbox');
                wp_enqueue_script('gslightbox');
                wp_enqueue_script('gspbwoo_product_gallery');
            }

            else if ($blockname == 'greenshift-blocks/product-tabs') {
                if (!empty($block['attrs']['panelType']) && $block['attrs']['panelType'] == 'toggles') {
                    wp_enqueue_script('gspbwoo_product_toggles');
                } else {
                    wp_enqueue_script('gspbwoo_product_tabs');
                }
            }
        }

        return $html;
    }
}

//////////////////////////////////////////////////////////////////
// Ajax cart
//////////////////////////////////////////////////////////////////
add_filter( 'woocommerce_add_to_cart_fragments', 'greenshiftwoo_add_to_cart_fragment_amount' );
function greenshiftwoo_add_to_cart_fragment_amount( $fragments ) {
    ob_start();
    ?>
        <?php echo '
		    <span class="gspb_woocartmenu-amount" data-cartvalue="'.WC()->cart->get_total('raw').'">' . WC()->cart->get_total() . '</span>';
        ?>
    <?php
    $fragments['.gspb_woocartmenu-amount'] = ob_get_clean();
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'greenshiftwoo_add_to_cart_fragment_count' );
function greenshiftwoo_add_to_cart_fragment_count( $fragments ) {
    ob_start();
    ?>
        <?php echo '
		    <span class="gspb-woocartmenu-count">' . WC()->cart->cart_contents_count . '</span>';
        ?>
    <?php
    $fragments['.gspb-woocartmenu-count'] = ob_get_clean();
    return $fragments;
}

//////////////////////////////////////////////////////////////////
// Meta Panels
//////////////////////////////////////////////////////////////////
require_once GREENSHIFTWOO_DIR_PATH . 'includes/meta.php';


//////////////////////////////////////////////////////////////////
// Patterns
//////////////////////////////////////////////////////////////////
require_once GREENSHIFTWOO_DIR_PATH . 'querypatterns.php';

//////////////////////////////////////////////////////////////////
// Quick Buy
//////////////////////////////////////////////////////////////////
function gspb_redirect_to_checkout_quickbuy() {
    if ( ! isset( $_REQUEST['gspb-quick-buy-now'] ) ) {
        return false;
    }
    $quantity     = isset( $_REQUEST['quantity'] ) ? absint( $_REQUEST['quantity'] ) : 1;
    $product_id   = isset( $_REQUEST['gspb-quick-buy-now'] ) ? absint( $_REQUEST['gspb-quick-buy-now'] ) : '';

    WC()->cart->add_to_cart( $product_id, $quantity );
    $url = WC()->cart->get_checkout_url();
    wp_safe_redirect($url);
    exit;
}
add_action('template_redirect', 'gspb_redirect_to_checkout_quickbuy');


//////////////////////////////////////////////////////////////////
// Localization
//////////////////////////////////////////////////////////////////
function greenshiftwoo_plugin_load_textdomain() {
    load_plugin_textdomain('greenshiftwoo', false, GREENSHIFTWOO_DIR_PATH . 'lang');
}
add_action('plugins_loaded', 'greenshiftwoo_plugin_load_textdomain');