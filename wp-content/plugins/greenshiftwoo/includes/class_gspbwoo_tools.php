<?php

if ( !defined( 'WPINC' ) ) die;

class GSPBWOO_Tools {
	
	function __construct(){
		$this->includes();
		$this->init_hooks();
	}
	
		/* Include required core files */
	public function includes(){
		require GREENSHIFTWOO_DIR_PATH .'includes/class_gspbwoo_settings_tab.php';
		$gspbwoo_settings = new GSPBWOO_Settings_Tab_Tools();
		$gspbwoo_settings->init();

        //Bundle tab
        require GREENSHIFTWOO_DIR_PATH . 'includes/class_gspb_wc_settings_bundle_tab.php';
        $gspb_wc_settings = new GREENSHIFT_WOO_BUNDLE_WC_Settings_Bundle_Tab_Tools();
        $gspb_wc_settings->init();

        //Combo tab
        require GREENSHIFTWOO_DIR_PATH . 'includes/class_gspb_wc_settings_combo_tab.php';
        $gspb_wc_combo_settings = new GREENSHIFT_WOO_BUNDLE_WC_Settings_Combo_Tab_Tools();
        $gspb_wc_combo_settings->init();

        require GREENSHIFTWOO_DIR_PATH . 'includes/class_gspb_wc_combo.php';
        new GREENSHIFT_WOO_BUNDLE_WC_Custom_Combos();

        require GREENSHIFTWOO_DIR_PATH . 'includes/class_gspb_wc_bundle.php';
        new GREENSHIFT_WOO_BUNDLE_WC_Custom_Bundles();

	}
	
	/* Hook into actions and filters.*/
	private function init_hooks(){
        add_action('admin_enqueue_scripts', array($this, 'register_scripts'));
		add_filter('woocommerce_product_tabs', array($this, 'disable_desc_tab'));
		add_filter('woocommerce_product_tabs', array($this, 'product_custom_tabs'));
		add_filter('wp_ajax_gspbwoo_tools_add_tab', array($this, 'gspbwoo_tools_add_tab'));
        add_filter( 'use_block_editor_for_post_type', array($this, 'activate_gutenberg_product'), 10, 2 );
        add_filter( 'woocommerce_taxonomy_args_product_cat', array($this, 'enable_taxonomy_rest'));
        add_filter( 'woocommerce_taxonomy_args_product_tag', array($this, 'enable_taxonomy_rest'));
        add_action( 'wp', array($this, 'remove_woo_scripts'), 99 );
        add_filter( 'woocommerce_register_post_type_product', array($this, 'temp_reset_product_template'), );
	}

	/* Removes Description tab in Tabs array */
	function disable_desc_tab($tabs) {
		if(WC_Admin_Settings::get_option('gspbwoo_hide_desc_tab') === 'yes') {
			unset($tabs['description']);
		}
		return $tabs;
	}

    function temp_reset_product_template( $post_type_args ) {
        if ( array_key_exists( 'template', $post_type_args ) ) {
            unset( $post_type_args['template'] );
        }
    
        return $post_type_args;
    }

    // enable gutenberg for woocommerce
    function activate_gutenberg_product( $can_edit, $post_type ) {
        if ( $post_type == 'product' && WC_Admin_Settings::get_option('gspbwoo_gutenberg_for_woo') === 'yes' ) {
            $can_edit = true;
        }
        return $can_edit;
    }
    function enable_taxonomy_rest( $args ) {
        $args['show_in_rest'] = true;
        return $args;
    }

    //Disable gallery scripts
    function remove_woo_scripts() {
		if(WC_Admin_Settings::get_option('gspbwoo_disable_gallery_scripts') === 'yes') {
			remove_theme_support( 'wc-product-gallery-zoom' );
            remove_theme_support( 'wc-product-gallery-lightbox' );
            remove_theme_support( 'wc-product-gallery-slider' );
		}
        if(WC_Admin_Settings::get_option('gspbwoo_disable_hook_render') === 'yes') {

			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

            //Archive loop
			remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
			remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_after_shop_loop', 10 );
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

            //Loop inside
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

            //Single Product
            remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
            remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
            remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}
	}

	/* Adds Custom Tabs the Product Page (see WC -> Settings -> Greenshift Tools tab) */
	function product_custom_tabs( $tabs ) {

        $tabs_count = WC_Admin_Settings::get_option('gspbwoo_tabs_count', 1);

        for($i = 1; $i <= $tabs_count; $i++) {
            $tab_title = WC_Admin_Settings::get_option('gspbwoo_tab_product_title_' . $i);
            $tab_order = WC_Admin_Settings::get_option('gspbwoo_tab_product_order_' . $i);
            $tab_content = WC_Admin_Settings::get_option('gspbwoo_tab_product_content_' . $i);

            if(empty($tab_title) || empty($tab_order) || empty($tab_content)) continue;

            $tabs['gspbwoo_tab_'.$i] = array(
                'title' => $tab_title,
                'priority' => $tab_order,
                'content' => nl2br( $tab_content ),
                'callback'  => array($this, 'product_custom_tab_content'),
            );
        }

        return $tabs;
	}

	/* Callback function for Content of the Castom Tabs */
	function product_custom_tab_content( $key, $tab ){
		echo do_shortcode($tab['content']);
	}

    /* Register admin scripts */
    function register_scripts(){
        wp_enqueue_script( 'gspbwoo-tools-scripts', GREENSHIFTWOO_DIR_URL .'assets/js/gspbwoo_tools.js', array(), '0.1', true);
        wp_localize_script(
            'gspbwoo-tools-scripts',
            'gspbwoovars',
            array(
                'ajax_url' => admin_url( 'admin-ajax.php', 'relative' )
            )
        );
    }

    function gspbwoo_tools_add_tab() {
        $i = $_POST['i'];
        $settings = [];

        $settings[] = array(
            'title' => __( 'Name for tab #' . $i, 'greenshiftwoo' ),
            'id' => 'gspbwoo_tab_product_title_' . $i,
            'type' => 'text',
            'placeholder' => __( 'Tab #' . $i, 'greenshiftwoo' ),
        );
        $settings[] = array(
            'title' => __( 'Content for tab #' . $i, 'greenshiftwoo' ),
            'id' => 'gspbwoo_tab_product_content_' . $i,
            'type' => 'textarea',
            'placeholder' => 'Tab #' . $i . ' Content',
            'css' => 'min-width:50%; height:65px;',
        );
        $settings[] = array(
            'title' => __( 'Order for tab #' . $i, 'greenshiftwoo' ),
            'id' => 'gspbwoo_tab_product_order_' . $i,
            'type' => 'text',
            'placeholder' => __( '10', 'greenshiftwoo' ),
            'css' => 'margin-bottom: 30px',
        );

        ob_start();
        woocommerce_admin_fields( $settings );
        $html = ob_get_contents();
        ob_get_clean();

        wp_send_json(['html' => $html]);
    }

}