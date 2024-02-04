<?php

if (!defined('WPINC')) {
    die;
}

class GREENSHIFT_WOO_BUNDLE_WC_Custom_Combos
{

    public function __construct()
    {
        //require GREENSHIFTWOO_DIR_PATH .'/public/custom_combos_tab_content.php';
        $this->init();
    }

    /**
     * Init settings.
     */
    public function init()
    {

        // Admin interface
        add_action('woocommerce_product_options_related', [$this, 'add_custom_combo_panel_data']);

        // Action to search the product on admin interface
        add_action('wp_ajax_product_search', [$this, 'product_search_callback']);
        add_action('wp_ajax_nopriv_product_search', [$this, 'product_search_callback']);

        // Action to add the product to combo on admin interface
        add_action('wp_ajax_nopriv_save_combo_data', [$this, 'save_combo_data_callback']);
        add_action('wp_ajax_save_combo_data', [$this, 'save_combo_data_callback']);

        // Add combo tab to the single product page
        add_filter('woocommerce_product_tabs', [$this, 'wpb_custom_combos_tab_data']);

        //Combos Ajax Add to Cart
        add_action('wp_ajax_nopriv_add_to_cart', [$this, 'add_to_cart']);
        add_action('wp_ajax_add_to_cart', [$this, 'add_to_cart']);

        // Add custom price for combo products
        add_action('woocommerce_before_calculate_totals', [$this, 'apply_custom_price_to_combo_product']);

        // Disable the quantity input for combo product
        add_filter('woocommerce_cart_item_quantity', [$this, 'disable_quantity_input_for_combo_sub_products'], 10, 3);

        //Action to disable remove option for combo item
        add_filter('woocommerce_cart_item_remove_link', [$this, 'disable_remove_link_for_combo_sub_products'], 10, 2);

        //Action to remove sub combo product on removal of main product
        add_action('woocommerce_remove_cart_item', [$this, 'remove_bundle_product_on_combo_main_product_removal'], 10, 2);

        // Add custom notice to combo products
        add_filter('woocommerce_cart_item_name', [$this, 'add_custom_message_for_combo_to_cart_item_name'], 10, 3);

        //Action to enqueue javascript and css
        add_action('init', [$this, 'init_scripts']);
        add_action('admin_init', [$this, 'enqueue_scripts_admin']);
    }

    /*  */
    public function init_scripts()
    {
        wp_register_style('greenshift_woocommerce_combos', GREENSHIFTWOO_DIR_URL . 'libs/combos/woo-custom-combos.css', [], GREENSHIFTWOO_PLUGIN_VER, 'all');

        wp_register_script('gs_woocommerce_combos', GREENSHIFTWOO_DIR_URL . 'libs/combos/woo-custom-combos.js', ['jquery'], GREENSHIFTWOO_PLUGIN_VER, false);
    }

    /*  */
    public function enqueue_scripts_admin()
    {
        wp_enqueue_style('greenshift_woocommerce_combos_backend', GREENSHIFTWOO_DIR_URL . 'assets/css/woo-custom-combo-backend.css', [], GREENSHIFTWOO_PLUGIN_VER, 'all');
        wp_enqueue_script('greenshift_woocommerce_combos_backend', GREENSHIFTWOO_DIR_URL . 'assets/js/custom-combo-backend.js', ['jquery'], GREENSHIFTWOO_PLUGIN_VER, false);
    }

    /*  */
    public function product_search_callback()
    {
        $search_term = sanitize_text_field($_POST['search_term']);
        $post_id     = $_POST['post_id'];

        // Perform the product search using WooCommerce functions
        $args = [
            'post_type'    => 'product',
            's'            => $search_term,
            'product_type' => 'simple',
            'post__not_in' => [$post_id]
        ];
        $products = new WP_Query($args);

        // Generate the dropdown options
        $options = '';
        while ($products->have_posts()) {
            $products->the_post();
            $options .= '<option value="' . esc_attr(get_the_ID()) . '">' . esc_html(get_the_title()) . '</option>';
        }
        wp_reset_postdata();

        echo ''.$options;
        wp_die();
    }

    /*  */
    public function add_custom_combo_panel_data()
    {
        global $post, $product;
    ?>
        <div class="options_group">
            <!-- Existing combo fields -->
            <div class="custom-combo-repeater">
                <?php
                $is_combo = get_post_meta($post->ID, '_combo_data', true);
                if (!empty($is_combo)) {
                    foreach ($is_combo as $combo_data) {
                        if ($combo_data['productId'] !== "") {
                            $combo          = wc_get_product($combo_data['productId']);
                            $combo_name     = $combo->get_title();
                            $combo_discount = $combo_data['discount'];

                ?>
                            <div class="combo-template">
                                <p class="form-field">
                                    <label><?php esc_html_e('Combo', 'greenshiftwoo'); ?></label>
                                    <input type="text" id="product-search-input" placeholder="<?php esc_attr_e('Search for products', 'greenshiftwoo'); ?>">
                                    <select id="product-dropdown" name="product_dropdown">
                                        <option value="<?php echo (int)$combo_data['productId'] ?>"><?php echo esc_attr($combo_name) ?> </option>
                                    </select>

                                    <?php echo wc_help_tip(esc_html__('combo are products which you recommend to be bought along with this product. Only simple products can be added as combo.', 'greenshiftwoo')); ?>
                                </p>
                                <p class="form-field">
                                    <label><?php esc_html_e('Combo Discount', 'greenshiftwoo'); ?></label>
                                    <input type="number" max="100" id="combo_discount" name="combo_discount" placeholder="<?php esc_attr_e('Enter combo discount', 'greenshiftwoo'); ?>" value="<?php echo esc_attr($combo_discount) ?>" /> %
                                    <?php echo wc_help_tip(__('Enter the discount amount for this combo.', 'greenshiftwoo')); ?>
                                    <a class="remove-combo "><?php esc_attr_e('Remove Combo', 'greenshiftwoo'); ?></a>
                                </p>
                            </div>
                <?php
                        }
                    }
                }
                ?>
            </div>
            <button class="combo-button-custom page-title-action" type="button"><?php esc_attr_e('Add Combo', 'greenshiftwoo'); ?></button>
            <button class="save-custom-combo button-primary" type="button"><?php esc_attr_e('Save Combo', 'greenshiftwoo'); ?></button>
        </div>

        <div id="combo-template" style="display: none;">
            <p class="form-field">
                <label><?php esc_html_e('Combo', 'greenshiftwoo'); ?></label>
                <input type="text" id="product-search-input" placeholder="<?php esc_attr_e('Search for products', 'greenshiftwoo'); ?>">
                <select id="product-dropdown" name="product_dropdown">
                </select>

                <?php echo wc_help_tip(esc_html__('combo are products which you recommend to be bought along with this product. Only simple products can be added as combo.', 'greenshiftwoo')); ?>
            </p>
            <p class="form-field">
                <label><?php esc_html_e('Combo Discount', 'greenshiftwoo'); ?></label>
                <input type="text" id="combo_discount" name="combo_discount" placeholder="<?php esc_attr_e('Enter combo discount', 'greenshiftwoo'); ?>" /> %
                <?php echo wc_help_tip(__('Enter the discount amount for this combo.', 'greenshiftwoo')); ?>
                <a class="remove-combo "> <?php esc_attr_e('Remove Combo', 'greenshiftwoo'); ?></a>
            </p>
        </div>
    <?php
    }

    /*  */
    public function save_combo_data_callback()
    {
        $post_id = $_POST['post_id'];
        if (isset($_POST['combo_data'])) {
            $combo_data = $_POST['combo_data'];
            update_post_meta($post_id, '_combo_data', $combo_data);
        }
    }

    /*  */
    public function wpb_custom_combos_tab_data($tabs)
    {

        global $product, $post;
        $priority = \WC_Admin_Settings::get_option('GREENSHIFT_WOO_BUNDLE_tab_product_order_combo');
        $title    = \WC_Admin_Settings::get_option('GREENSHIFT_WOO_BUNDLE_combo_title');
        $enable    = \WC_Admin_Settings::get_option('GREENSHIFT_WOO_BUNDLE_show_combos');
        if ($enable != 'yes') {
            return $tabs;
        }
        if (!$title) {
            $title = esc_html__('Combos', 'greenshiftwoo');
        }

        $tabcontent = get_post_meta($post->ID, '_combo_data', true);
        if (empty($priority)) {
            $priority = 10;
        }

        if (!empty($tabcontent)) {
            $tabs['combos_tab'] = [
                'title'    => $title,
                'priority' => $priority,
                'callback' => [&$this, 'rhwoo_custom_combos_tab_content']
            ];
        }

        return $tabs;
    }

    /*  */
    public function rhwoo_custom_combos_tab_content()
    {
        $title = \WC_Admin_Settings::get_option('rhwct_combo_title');
        if (!$title) {
            $title = esc_html__('Combos', 'greenshiftwoo');
        }

        ob_start();
        gspbwoo_get_view_file('product_combo', [
            'show_title'  => true,
            'isTab'       => true,
            'title'       => $title,
            'offer_label' => esc_html__( 'Combo price:', 'greenshiftwoo' ),
            'offer_text'  => false,
            'with_text'   => esc_html__( 'Combo with:', 'greenshiftwoo' ),
            'final_price' => false,
            'button_text' => esc_html__('Add to cart', 'greenshiftwoo')
        ]);
        echo ob_get_clean();

    }

    /*  */
    public function add_to_cart()
    {

        $response = [];

        if (isset($_POST['main_product_id']) && isset($_POST['combo_product_id'])) {
            $main_product_id         = sanitize_text_field($_POST['main_product_id']);
            $combo_product_id        = sanitize_text_field($_POST['combo_product_id']);
            $combo_discounted_amount = isset($_POST['combo_discount']) ? floatval($_POST['combo_discount']) : 0.0;
            $combo_discount          = isset($_POST['discount']) ? floatval($_POST['discount']) : 0.0;

            // Get main and combo products
            $main_product  = wc_get_product($main_product_id);
            $combo_product = wc_get_product($combo_product_id);

            if ($main_product && $combo_product) {
                // Add main product to cart
                $combo_main_item_data = [
                    'custom_product_type'   => 'main_combo_product', // Adding custom_product_type
                    'custom_combo_sub_product_id' => $combo_product_id,
                    'custom_combo_discount' => $combo_discount
                ];
                if (WC()->cart->add_to_cart($main_product_id, 1, 0, [], $combo_main_item_data)) {
                    $combo_item_data = [
                        'custom_combo_price'  => $combo_discounted_amount,
                        'custom_product_type' => 'sub_combo_product', // Adding custom_product_type
                        'custom_combo_main_product_id' => $main_product_id
                    ];
                    if (WC()->cart->add_to_cart($combo_product_id, 1, 0, [], $combo_item_data)) {
                        do_action('woocommerce_ajax_added_to_cart', $combo_product_id);

                        if (get_option('woocommerce_cart_redirect_after_add') == 'yes') {
                            wc_add_to_cart_message($main_product_id);
                        }

                        \WC_AJAX::get_refreshed_fragments();
                    }
                } else {
                    $data = [
                        'error'       => true,
                        'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($main_product_id), $main_product_id)
                    ];

                    wp_send_json($data);
                }
            }
        }

        // Return fragments
        wp_die();
    }

    /*  */
    public function apply_custom_price_to_combo_product($cart_object)
    {

        foreach ($cart_object->get_cart() as $item) {
            if (array_key_exists('custom_combo_price', $item)) {
                $item['data']->set_price($item['custom_combo_price']);
            }
        }
    }

    /*  */
    public function disable_quantity_input_for_combo_sub_products($product_quantity, $cart_item_key, $cart_item)
    {
        // Check if the product is a sub-product (combo product) of the main product
        if (isset($cart_item['custom_product_type']) && ($cart_item['custom_product_type'] === 'sub_combo_product' || $cart_item['custom_product_type'] === 'main_combo_product')) {
            return sprintf('<strong style="margin-left: 20px;">%s</strong>', $cart_item['quantity']);
        }
        return $product_quantity;
    }

    /*  */
    public function disable_remove_link_for_combo_sub_products($sprintf, $cart_item_key)
    {
        $cart_item = WC()->cart->cart_contents[$cart_item_key];

        // Check if the current cart item is one you want to disable removal for
        if (isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'sub_combo_product') {
            return ''; // Return an empty string to hide the remove link
        }
        return $sprintf; // Return the original remove link HTML
    }

    /*  */
    public function remove_bundle_product_on_combo_main_product_removal($cart_item_key, $cart)
    {
        $removed_item = $cart->cart_contents[$cart_item_key];

        if (isset($removed_item['product_id']) && isset($removed_item['custom_product_type'])) {
            if ($removed_item['custom_product_type'] === 'main_combo_product') {
                $main_product_id  = $removed_item['product_id'];
                $combo_product_id = $removed_item['custom_combo_sub_product_id'];

                foreach ($cart->cart_contents as $key => $cart_item) {
                    if ($cart_item['product_id'] == $combo_product_id && isset($cart_item['custom_combo_main_product_id']) && $cart_item['custom_combo_main_product_id'] == $main_product_id && isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'sub_combo_product') {
                        // Remove the bundle product from the cart
                        WC()->cart->remove_cart_item($key);
                    }
                }
            }
        }
    }

    /*  */
    public function add_custom_message_for_combo_to_cart_item_name($product_name, $cart_item, $cart_item_key)
    {
        // Check if the cart item has the custom_product_type set to 'main_product'
        if (isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'main_combo_product') {
            $combo_main_product_id = $cart_item['product_id'];
            $combo_sub_product_id  = $cart_item['custom_combo_sub_product_id'];

            $combo_sub_product_name  = get_the_title($combo_sub_product_id);
            $combo_main_product_name = get_the_title($combo_main_product_id);
            $label    = \WC_Admin_Settings::get_option('GREENSHIFT_WOO_BUNDLE_combo_cart_label');
            if(!$label){
                $label = esc_html__("With this combo you are getting %s%% discount", 'greenshiftwoo');
            }else{
                $label = str_replace('{AMOUNT}', '%s%%', $label);
            }
            if(strpos($label, '%s') === false){
                $label .= ' %s%%';
            }
            $product_name .= '<br><small style="font-size: 12px; color: #777777;display:block; margin: 10px 0 10px 85px">'.sprintf($label, $cart_item['custom_combo_discount']).'<br>(';
            $product_name .= $combo_main_product_name . ' + ' . $combo_sub_product_name;
            $product_name .= ')</small>';
        }
        return $product_name;
    }
}
