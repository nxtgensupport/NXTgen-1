<?php
if (!defined('WPINC')) {
    die;
}

class GREENSHIFT_WOO_BUNDLE_WC_Custom_Bundles
{

    public function __construct()
    {
        $this->init();
    }

    /**
     * Init settings.
     */
    public function init()
    {

        // Admin interface
        add_action('woocommerce_product_options_related', [$this, 'add_custom_bundle_panel_data']);
        add_action('woocommerce_process_product_meta_simple', [$this, 'save_custom_bundle_panel_data']);
        add_action('woocommerce_process_product_meta_variable', [$this, 'save_custom_bundle_panel_data']);
        add_action('woocommerce_process_product_meta_grouped', [$this, 'save_custom_bundle_panel_data']);
        add_action('woocommerce_process_product_meta_external', [$this, 'save_custom_bundle_panel_data']);

        // bundles Ajax Total Price Update
        add_action('wp_ajax_nopriv_bundle_checked_custom_price', [$this, 'bundle_checked_custom_price']);
        add_action('wp_ajax_bundle_checked_custom_price', [$this, 'bundle_checked_custom_price']);

        // bundles Ajax Add to Cart for Variable Products
        add_action('wp_ajax_nopriv_custom_bundles_add_to_cart', [$this, 'custom_bundles_add_to_cart']);
        add_action('wp_ajax_custom_bundles_add_to_cart', [$this, 'custom_bundles_add_to_cart']);

        //Action to add bundle tab
        add_filter('woocommerce_product_tabs', [$this, 'wpb_custom_bundles_tab_data']);

        //Action to add custom price
        add_action('woocommerce_before_calculate_totals', [$this, 'custom_price']);

        //Action to remove sub product on removal of main product
        add_action('woocommerce_remove_cart_item', [$this, 'remove_bundle_product_on_main_product_removal'], 10, 2);

        //Action to add custom data to cart item
        add_filter('woocommerce_add_cart_item_data', [$this, 'add_custom_data_to_cart_item'], 10, 4);

        //Action to disable quantity for bundel item
        add_filter('woocommerce_cart_item_quantity', [$this, 'disable_quantity_input_for_sub_products'], 10, 3);

        //Action to disable remove option for bundel item
        add_filter('woocommerce_cart_item_remove_link', [$this, 'disable_remove_link_for_specific_products'], 10, 2);

        // Action to edit name on cart page for bundle
        add_filter('woocommerce_cart_item_name', [$this, 'add_custom_message_to_cart_item_name'], 10, 3);

        //Init scripts
        add_action('init', [$this, 'init_scripts']);
    }

    public function init_scripts()
    {
        wp_register_style(
            'greenshift_woocommerce_bundle',
            GREENSHIFTWOO_DIR_URL . 'libs/bundles/woo-custom-bundles.css',
            [],
            GREENSHIFTWOO_PLUGIN_VER,
            'all'
        );
        wp_register_script(
            'gs_woocommerce_bundle_js',
            GREENSHIFTWOO_DIR_URL . 'libs/bundles/woo-custom-bundles.js',
            ['jquery'],
            GREENSHIFTWOO_PLUGIN_VER,
            true
        );
    }

    /*  */
    public function add_custom_bundle_panel_data()
    {
        global $post;
    ?>
            <div class="options_group">
                <p class="form-field">
                    <label for="custom_bundle_ids"><?php esc_html_e('Bundle', 'greenshiftwoo'); ?></label>
                    <select class="wc-product-search" multiple="multiple" style="width: 50%;" id="custom_bundle_ids" name="custom_bundle_ids[]" data-placeholder="<?php esc_attr_e('Search for a product&hellip;', 'greenshiftwoo'); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo intval($post->ID); ?>">
                        <?php
                        $product_ids = array_filter(array_map('absint', (array) get_post_meta($post->ID, '_custom_bundle_ids', true)));

                        foreach ($product_ids as $product_id) {
                            $product = wc_get_product($product_id);
                            if (is_object($product)) {
                                echo '<option value="' . esc_attr($product_id) . '"' . selected(true, true, false) . '>' . htmlspecialchars(wp_kses_post($product->get_formatted_name())) . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <?php echo wc_help_tip(__('Bundle are products which you recommend to be bought along with this product. Only simple products can be added as bundle.', 'greenshiftwoo')); ?>
                </p>
                <p class="form-field">
                    <label for="bundle_discount"><?php esc_html_e('Bundle Discount', 'greenshiftwoo'); ?></label>
                    <input type="text" id="bundle_discount" name="bundle_discount" value="<?php echo esc_attr(get_post_meta($post->ID, '_bundle_discount', true)); ?>" placeholder="<?php esc_attr_e('Enter bundle discount', 'greenshiftwoo'); ?>" /> %
                    <?php echo wc_help_tip(__('Enter the discount amount for this bundle.', 'greenshiftwoo')); ?>
                </p>
            </div>
    <?php
    }

    /*  */
    public static function save_custom_bundle_panel_data($post_id)
    {
        $bundle          = isset($_POST['custom_bundle_ids']) ? array_map('intval', (array) $_POST['custom_bundle_ids']) : [];
        $bundle_discount = isset($_POST['bundle_discount']) ? sanitize_text_field($_POST['bundle_discount']) : '';

        // Add post meta of bundle product and bundle discount
        update_post_meta($post_id, '_custom_bundle_ids', $bundle);
        update_post_meta($post_id, '_bundle_discount', $bundle_discount);
    }

    /*  */
    public function wpb_custom_bundles_tab_data($tabs)
    {
        global $product;
        $priority = WC_Admin_Settings::get_option('GREENSHIFT_WOO_BUNDLE_tab_product_order_bundle');
        $title    = WC_Admin_Settings::get_option('GREENSHIFT_WOO_BUNDLE_bundle_title');
        $enable    = WC_Admin_Settings::get_option('GREENSHIFT_WOO_BUNDLE_show_bundles');
        if ($enable != 'yes') {
            return $tabs;
        }
        if (!$title) {
            $title = esc_html__('Bundles', 'greenshiftwoo');
        }

        $tancontent = get_post_meta($product->get_id(), '_custom_bundle_ids', true);
        if (empty($priority)) {
            $priority = 10;
        }

        if (!empty($tancontent)) {
            $tabs['bundles_tab'] = [
                'title'    => $title,
                'priority' => $priority,
                'callback' => [&$this, 'greenshift_woo_bundle_custom_bundles_tab_content']
            ];
        }

        return $tabs;
    }

    /*  */
    public function greenshift_woo_bundle_custom_bundles_tab_content()
    {
        echo self::gspbwoo_get_bundle_product(false, [], true);
    }

    /*  */
    public function bundle_checked_custom_price()
    {
        global $woocommerce;
        $price = empty($_POST['price']) ? 0 : $_POST['price'];

        if ($price) {
            $price_html = wc_price($price);
            echo wp_kses_post($price_html);
        }

        die();
    }

    /*  */
    public function custom_bundles_add_to_cart()
    {
        global $sub_product_flag;
        $product_id = absint($_POST['product_id']);
        $discount   = isset($_POST['custom_discount']) ? floatval($_POST['custom_discount']) : 0.0;
        $product    = wc_get_product($product_id);
        if ($product) {
            $product_type = $product->get_type(); // This will give you the product type (simple, variable, grouped, etc.)

            // Add children of grouped product to the cart
            if ($product_type && $product_type === 'grouped') {
                //Get data from AJAX
                $is_sub_product = isset($_POST['sub_product']) && $_POST['sub_product'] === 'yes';
                $quantity       = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
                $variation_id   = 0; // Grouped products do not have variations
                $variation      = [];

                foreach ($product->get_children() as $child_product_id) {
                    $child_product    = wc_get_product($child_product_id);
                    $price            = $child_product->get_price();
                    $custom_price     = $this->calculate_discounted_price($price, $discount);
                    $product_status   = get_post_status($child_product_id);
                    $sub_product_flag = $is_sub_product ? 'yes' : 'no';

                    // Add product to the cart
                    if (WC()->cart->add_to_cart($child_product_id, $quantity, $variation_id, $variation, ['custom_price' => $custom_price]) && 'publish' === $product_status) {
                        do_action('woocommerce_ajax_added_to_cart', $product_id);

                        if (get_option('woocommerce_cart_redirect_after_add') == 'yes') {
                            wc_add_to_cart_message($product_id);
                        }
                    } else {
                        // If there was an error adding to the cart, redirect to the product page to show any errors
                        $data = [
                            'error'       => true,
                            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
                        ];

                        wp_send_json($data);
                    }
                }
                // Return fragments
                WC_AJAX::get_refreshed_fragments();
            } else {
                $is_sub_product     = isset($_POST['sub_product']) && $_POST['sub_product'] === 'yes';
                $custom_price       = isset($_POST['custom_price']) ? floatval($_POST['custom_price']) : 0.0;
                $quantity           = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
                $variation_id       = empty($_POST['variation_id']) ? 0 : $_POST['variation_id'];
                $variation          = empty($_POST['variation']) ? 0 : $_POST['variation'];
                $product_status     = get_post_status($product_id);
                $sub_product_flag   = $is_sub_product ? 'yes' : 'no';
                $bundle_product_ids = empty($_POST['bundle_product_ids']) ? [] : $_POST['bundle_product_ids'];

                $main_product_data = [
                    'custom_price'       => $custom_price,
                    'custom_discount'    => $discount,
                    'bundle_product_ids' => $bundle_product_ids
                ];

                if (WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation, $main_product_data) && 'publish' === $product_status) {
                    do_action('woocommerce_ajax_added_to_cart', $product_id);

                    if (get_option('woocommerce_cart_redirect_after_add') == 'yes') {
                        wc_add_to_cart_message($product_id);
                    }

                    // Return fragments
                    WC_AJAX::get_refreshed_fragments();
                } else {
                    // If there was an error adding to the cart, redirect to the product page to show any errors
                    $data = [
                        'error'       => true,
                        'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
                    ];

                    wp_send_json($data);
                }
            }
        }
        die();
    }

    /*  */
    public function calculate_discounted_price($price, $discount)
    {
        $discounted_price = $price - ($price * ($discount / 100));
        return $discounted_price;
    }

    /*  */
    public function custom_price($cart_object)
    {

        foreach ($cart_object->get_cart() as $item) {
            if (array_key_exists('custom_price', $item)) {
                $item['data']->set_price($item['custom_price']);
            }
        }
    }

    /*  */
    // Add custom data to cart item for sub-products
    public function add_custom_data_to_cart_item($cart_item_data, $product_id, $variation_id, $quantity)
    {
        global $sub_product_flag;

        if ($sub_product_flag === 'yes') {
            $cart_item_data['custom_product_type'] = 'sub_product';
        }
        if ($sub_product_flag === 'no') {
            $cart_item_data['custom_product_type'] = 'main_product';
        }
        return $cart_item_data;
    }

    /*  */
    public function disable_quantity_input_for_sub_products($product_quantity, $cart_item_key, $cart_item)
    {
        // Check if the product is a sub-product (bundled product) of the main product
        if (isset($cart_item['custom_product_type']) && ($cart_item['custom_product_type'] === 'sub_product' || $cart_item['custom_product_type'] === 'main_product')) {
            return sprintf('<strong style="margin-left: 20px;">%s</strong>', $cart_item['quantity']);
        }
        return $product_quantity;
    }

    /*  */
    public function remove_bundle_product_on_main_product_removal($cart_item_key, $cart)
    {
        $removed_item = $cart->cart_contents[$cart_item_key];

        if (isset($removed_item['product_id']) && isset($removed_item['custom_product_type'])) {
            if ($removed_item['custom_product_type'] === 'main_product') {
                $main_product_id = $removed_item['product_id'];

                // Get the bundle product ID from the main product's meta
                $bundle_product_ids = get_post_meta($main_product_id, '_custom_bundle_ids', true);

                foreach ($bundle_product_ids as $bundle_product_id) {
                    $grouped_product = wc_get_product($bundle_product_id);
                    if ($grouped_product && $grouped_product->get_type() === 'grouped') {
                        foreach ($grouped_product->get_children() as $child_product_id) {
                            foreach ($cart->cart_contents as $child_key => $child_cart_item) {
                                if ($child_cart_item['product_id'] === $child_product_id && isset($child_cart_item['custom_product_type']) && $child_cart_item['custom_product_type'] === 'sub_product') {
                                    WC()->cart->remove_cart_item($child_key);
                                }
                            }
                        }
                    } else {
                        foreach ($cart->cart_contents as $key => $cart_item) {
                            if ($cart_item['product_id'] === $bundle_product_id && isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'sub_product') {
                                // Remove the bundle product from the cart
                                WC()->cart->remove_cart_item($key);
                            }
                        }
                    }
                }
            }
        }
    }

    /*  */
    public function disable_remove_link_for_specific_products($sprintf, $cart_item_key)
    {
        $cart_item = WC()->cart->cart_contents[$cart_item_key];

        // Check if the current cart item is one you want to disable removal for
        if (isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'sub_product') {
            return ''; // Return an empty string to hide the remove link
        }

        return $sprintf; // Return the original remove link HTML
    }

    /*  */
    public function add_custom_message_to_cart_item_name($product_name, $cart_item, $cart_item_key)
    {
        // Check if the cart item has the custom_product_type set to 'main_product'
        if (isset($cart_item['custom_product_type']) && $cart_item['custom_product_type'] === 'main_product') {
            $bundle_sub_product_ids = $cart_item['bundle_product_ids'];
            $matching_product_names = [];

            // Iterate through the bundle product IDs
            foreach ($bundle_sub_product_ids as $bundle_sub_product_id) {
                // Check if the bundle product ID is not the same as the current product_id
                if ($bundle_sub_product_id !== $cart_item['product_id']) {
                    $bundle_product_name = get_the_title($bundle_sub_product_id);

                    // Add the bundle product name to the matching_product_names array
                    $matching_product_names[] = $bundle_product_name;
                }
            }
            $label    = \WC_Admin_Settings::get_option('GREENSHIFT_WOO_BUNDLE_bundle_cart_label');
            if(!$label){
                $label = esc_html__("With this bundle you are getting %s%% discount", 'greenshiftwoo');
            }else{
                $label = str_replace('{AMOUNT}', '%s%%', $label);
            }
            if(strpos($label, '%s') === false){
                $label .= ' %s%%';
            }
            $product_name .= '<br><small style="font-size: 12px; color: #777777; display:block; margin: 10px 0 10px 85px">'.sprintf($label, $cart_item['custom_discount']).'<br>(';
            $product_name .= implode(' + ', $matching_product_names);
            $product_name .= ')</small>';
        }
        return $product_name;
    }

    /*  */
    public function custom_template_loop_categories()
    {
        global $product;
        $categories = wc_get_product_category_list($product->get_id());
        echo wp_kses_post(sprintf('<span class="gspbwoo-loop-product-categories">%s</span>', $categories));
    }

    /*  */
    public function custom_bundles_price($main_product_id, $id)
    {
        global $product, $post;

        if ($product->is_type('variable') && $product->has_child()) {
            $attributes = $product->get_attributes(); // GET ALL ATRIBUTES

            echo '<div class="wc-bundle-price">';
            remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
            add_filter('woocommerce_is_sold_individually', 'wc_remove_all_quantity_fields', 10, 2);

            if (!function_exists('wc_remove_all_quantity_fields')) {
                function wc_remove_all_quantity_fields($return, $product)
                {
                    return (true);
                }
            }

            woocommerce_variable_add_to_cart();
            echo '</div>';
        } else {
            $child_total_price = 0;
            $is_bundle         = get_post_meta($main_product_id, '_custom_bundle_ids', true);

            if ($is_bundle) {
                if($id == $main_product_id){
                    $bundle_discount_percentage = 0;
                }else{
                    $bundle_discount_percentage = get_post_meta($main_product_id, '_bundle_discount', true);
                }

                if ($bundle_discount_percentage && is_numeric($bundle_discount_percentage)) {
                    //$original_price = $product->get_price();
                    if ($product->get_type() == 'grouped') {
                        $children = $product->get_children(); // Get child product IDs
                        foreach ($children as $child_id) {
                            $child_product       = wc_get_product($child_id);
                            $child_display_price = $child_product->get_price();
                            $child_total_price += $child_display_price; // Add child product price to total price
                            $original_price = $child_total_price;
                        }
                    } else {
                        $original_price = $product->get_price();
                    }
                    $discounted_price   = $original_price - ($original_price * ($bundle_discount_percentage / 100));
                    $formatted_discount = wc_price($discounted_price);
                    $formatted_original = wc_price($original_price);

                    echo '<div class="price-add-to-cart">';
                    echo '<p class="price fontnormal">';
                    echo '<del>' . $formatted_original . '</del> <ins>' . $formatted_discount . '</ins>';
                    echo '</p>';
                    echo '</div>';
                } else {
                    echo '<div class="price-add-to-cart"><p class="price fontnormal">' . wp_kses_post($product->get_price_html()) . '</p></div>';
                }
            } else {
                echo '<div class="price-add-to-cart"><p class="price fontnormal">' . wp_kses_post($product->get_price_html()) . '</p></div>';
            }
        }
    }

    public static function gspbwoo_get_bundle_product( $product_id = false, $settings = [], $isTab = false ) {

        global $post, $product;
    
        if ( ! is_object( $product ) ) {
            if ( $product_id === false ) {
                if ( is_object( $post ) ) {
                    $product_id = $post->ID;
                } else {
                    return;
                }
            }
    
            //get Product
            $wc_product = wc_get_product( $product_id );
            if ( is_object( $wc_product ) ) {
                $product = $wc_product;
            } else {
                return;
            }
        }
    
        $product_id = $product->get_id();
    
        $bundles = get_post_meta( $product_id, '_custom_bundle_ids', true );
        if ( ! $bundles ) {
            return;
        }

        if($isTab){
            wp_enqueue_style('greenshift_woocommerce_bundle');
        }
        wp_enqueue_script('gs_woocommerce_bundle_js');
        wp_localize_script('gs_woocommerce_bundle_js', 'gspbwoo_bundles', [
            'ajax_url'      => admin_url('admin-ajax.php'),
            'loader_icon'   => GREENSHIFTWOO_DIR_URL . 'assets/css/select2-spinner.gif',
            'success'       => sprintf('<div class="woocommerce-message">%s <a class="button wc-forward" href="%s">%s</a></div>', esc_html__('Products was successfully added to your cart.', 'greenshiftwoo'), wc_get_cart_url(), esc_html__('View Cart', 'greenshiftwoo')),
            'empty'         => sprintf('<div class="woocommerce-error">%s</div>', esc_html__('No Products selected.', 'greenshiftwoo')),
            'no_variation'  => sprintf('<div class="woocommerce-error">%s</div>', esc_html__('Product Variation does not selected.', 'greenshiftwoo')),
            'not_available' => sprintf('<div class="woocommerce-error">%s</div>', esc_html__('Sorry, this product is unavailable.', 'greenshiftwoo'))
        ]);
    
        //$meta_query = WC()->query->get_meta_query();
        $bundles    = array_diff( $bundles, [$product_id] );
    
        $args = [
            'post_type'           => 'product',
            'ignore_sticky_posts' => 1,
            'no_found_rows'       => 1,
            'posts_per_page'      => -1,
            'orderby'             => 'post__in',
            'post__in'            => $bundles,
            //'meta_query'          => $meta_query
        ];
    
        //unset( $args['meta_query'] );
    
        $products             = new WP_Query( $args );
    
        ob_start();
        gspbwoo_get_view_file( 'product_bundle', [
            'product' => $product,
            'products' => $products,
            'product_id' => $product_id,
            'isTab' => $isTab,
            'settings' => [
                'title'             => $settings['mainTitle'] ?? false,
                'button_text'       => $settings['buttonText'] ?? false,
                'save_text'         => $settings['saveText'] ?? false,
                'final_price'       => $settings['finalPrice'] ?? false,
                'current_label'     => $settings['currentProductLabel'] ?? false,
                'show_category'     => $settings['showCategory'] ?? true,
                'show_title'        => $settings['showTitle'] ?? true,
                'show_product_list' => $settings['showProductList'] ?? true,
                'title_tag'         => $settings['titleTag'] ?? false
            ]
        ] );
        
        wp_reset_postdata();
        return ob_get_clean();
    }
}
