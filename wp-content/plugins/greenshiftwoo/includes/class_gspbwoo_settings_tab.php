<?php
/**
 * Adds GSPBWOO Tools settings tab
 */
 
if ( !defined( 'WPINC' ) ) die;

class GSPBWOO_Settings_Tab_Tools {

    /**
     * Bootstraps the class and hooks required actions & filters.
     */
    public function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_gspbwoo', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_gspbwoo', __CLASS__ . '::update_settings' );
    }

    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['gspbwoo'] = __( 'Greenshift Tools', 'greenshiftwoo' );
        return $settings_tabs;
    }

    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     */
    public static function settings_tab() {
        echo '<div class="gspbwoo-tools-tab-content">';
        woocommerce_admin_fields( self::get_settings() );

        echo '<div class="gspbwoo-tools-actions-wrap"><button class="button-primary add-new-tab">+</button> <button class="button-primary remove-last-tab" style="background: transparent;border-color: #cc1818;color: #cc1818;">-</button></div>';

        $tabs_count = WC_Admin_Settings::get_option('gspbwoo_tabs_count', 1);
        echo '<input type="hidden" name="gspbwoo_tabs_count" id="gspbwoo_tabs_count" value="'.$tabs_count.'"/>';
        echo '</div>';
    }

    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );

        // update custom fields
        update_option('gspbwoo_tabs_count', $_POST['gspbwoo_tabs_count']);

        for($i = 1; $i <= $_POST['gspbwoo_tabs_count']; $i++) {
            update_option('gspbwoo_tab_product_title_' . $i, $_POST['gspbwoo_tab_product_title_' . $i]);
            update_option('gspbwoo_tab_product_content_' . $i, $_POST['gspbwoo_tab_product_content_' . $i]);
            update_option('gspbwoo_tab_product_order_' . $i, $_POST['gspbwoo_tab_product_order_' . $i]);
        }
    }

    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {

		$settings = array();
		
		//Product Tabs setting
		$settings[] = array(
			'title' => __( 'Greenshift Tools', 'greenshiftwoo' ),
			'type' => 'title',
			'id' => 'gspbwoo_options',
			'class' => 'gspbwoo_options',
		);
		$settings[] = array(
			'title' => __( 'Hide Description tab', 'greenshiftwoo' ),
			'desc' => __( 'The option disables Description tab on Product page', 'greenshiftwoo' ),
			'id' => 'gspbwoo_hide_desc_tab',
			'default' => 'no',
			'type' => 'checkbox',
		);
        $settings[] = array(
			'title' => __( 'Enable Gutenberg for Woocommerce Editor', 'greenshiftwoo' ),
			'desc' => __( 'Experimental, use with caution', 'greenshiftwoo' ),
			'id' => 'gspbwoo_gutenberg_for_woo',
			'default' => 'no',
			'type' => 'checkbox',
		);
        $settings[] = array(
			'title' => __( 'Disable Woo gallery scripts', 'greenshiftwoo' ),
			'desc' => __( 'ONLY FOR FSE THEMES! Use this if you use Product Gallery block on Single product template', 'greenshiftwoo' ),
			'id' => 'gspbwoo_disable_gallery_scripts',
			'default' => 'no',
			'type' => 'checkbox',
		);
        $settings[] = array(
			'title' => __( 'Disable Woo Cart scripts', 'greenshiftwoo' ),
			'desc' => __( 'ONLY FOR AFFILIATE AND CATALOG MODE! This will disable cart scripts on pages', 'greenshiftwoo' ),
			'id' => 'gspbwoo_disable_cart_scripts',
			'default' => 'no',
			'type' => 'checkbox',
		);
        $settings[] = array(
			'title' => __( 'Remove render functions from Hooks', 'greenshiftwoo' ),
			'desc' => __( 'ONLY FOR FSE THEMES! Use this if you build custom FSE templates. This will disable render functions attached to hooks and you can add Hook block in places where you need hooks, which can be required for some plugins', 'greenshiftwoo' ),
			'id' => 'gspbwoo_disable_hook_render',
			'default' => 'no',
			'type' => 'checkbox',
		);


        $tabs_count = WC_Admin_Settings::get_option('gspbwoo_tabs_count', 1);

        for($i = 1; $i <= $tabs_count; $i++) {
            $settings[] = array(
                'title' => __( 'Name for tab #' . $i, 'greenshiftwoo' ),
                'id' => 'gspbwoo_tab_product_title_' . $i,
//                'desc' => __( 'List of the Tabs names separated by semicolons.', 'greenshiftwoo' ),
                'type' => 'text',
                'placeholder' => __( 'Tab #' . $i, 'greenshiftwoo' ),
//                'css' => 'margin-top: 30px',
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
        }

        $settings[] = array(
            'type' => 'sectionend',
            'id' => 'gspbwoo_tools',
        );

        return apply_filters( 'wc_settings_gspbwoo', $settings );
    }
}