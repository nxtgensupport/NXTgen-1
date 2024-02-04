<?php

/**
 * View file for Product Combos
 */

if ($products->have_posts()) :
    $add_to_cart_checkbox = '';
    $total_price          = 0;
    $child_total_price    = 0;
?>

    <div class="gspbwoo-bundles">
        <?php
        if (isset($settings['title']) && $settings['title']) {
            $main_title = $settings['title'];
        } else {
            $title = WC_Admin_Settings::get_option('GREENSHIFT_WOO_BUNDLE_bundle_title');
            $main_title = $title;
        }
        if (!$main_title) {
            $main_title = esc_html__('Bundles', 'greenshiftwoo');
        }
        $title_tag = 'h2';
        if (isset($settings['title_tag']) && $settings['title_tag']) {
            $title_tag = $settings['title_tag'];
        }
        if (isset($settings['show_title']) && $settings['show_title']) {
            echo '<div class="gspb-woo-section-title"><' . $title_tag . ' class="gspb-heading-icon">' . esc_attr($main_title) . '</span></' . $title_tag . '></div>';
        }

        ?>
        <div class="custom-wc-message">
            <?php // AJAX output var woo_bundles 
            ?>
        </div>
        <div class="gspbwoo-bundles-row">
            <div class="gspbwoo-bundles-column-left">
                <div class="products gspbwoo-bundles-products">
                    <?php
                    gspbwoo_get_view_file('partial/product_content', [
                        'product' => $product,
                        'products' => $products,
                        'product_id' => $product_id
                    ]);
                    ?>
                    <?php
                    $price_html                 = '';
                    $display_price              = (int) wc_get_price_to_display($product);
                    $bundle_discount_percentage = (int) get_post_meta($product_id, '_bundle_discount', true);
                    $discount_price             = $display_price - ($display_price * ($bundle_discount_percentage / 100));

                    if ($price_html = $product->get_price_html()) {
                        $price_html = '<span class="bundle-price">'.$price_html.'</span>';
                    }

                    $total_price += $display_price;

                    $this_product_label = esc_html__('This product:', 'greenshiftwoo');
                    if (isset($settings['current_label']) && $settings['current_label']) {
                        $this_product_label = esc_attr($settings['current_label']);
                    }

                    $add_to_cart_checkbox = sprintf(
                        '
              <div class="gspbwoo-bundle-checkbox">
                  <label>
                      <input checked disabled
                      type="checkbox"
                      class="product-check"
                      data-discount="%1$s"
                      data-price="%2$s"
                      data-product-id="%3$s"
                      data-product-type="%4$s"
                      />
                      <strong>%5$s</strong>
                      <span class="product-title">%6$s</span> - %7$s
                  </label>
              </div>',
                        $bundle_discount_percentage,
                        $display_price,
                        $product->get_id(),
                        $product->get_type(),
                        $this_product_label,
                        get_the_title(),
                        $price_html
                    );

                    while ($products->have_posts()) : $products->the_post();
                        global $product;

                        gspbwoo_get_view_file('partial/product_content', [
                            'product' => $product,
                            'products' => $products,
                            'product_id' => $product_id
                        ]);

                        $price_html = '';
                        if ($product->get_type() == 'grouped') {
                            $children = $product->get_children(); // Get child product IDs
                            foreach ($children as $child_id) {
                                $child_product       = wc_get_product($child_id);
                                $child_display_price = $child_product->get_price();
                                $child_total_price += $child_display_price; // Add child product price to total price
                                $display_price = $child_total_price;
                            }
                        } else {
                            $display_price = wc_get_price_to_display($product);
                        }
                        $discount_price = $display_price - ($display_price * ($bundle_discount_percentage / 100));

                        if ($price_html = $product->get_price_html()) {
                            $price_html = '<span class="bundle-price"><del>' . wc_price($display_price) . $product->get_price_suffix() . '</del><ins>' . wc_price($discount_price) . $product->get_price_suffix() . '</ins></span>';
                        }

                        $total_price += $display_price;
                        $prefix = '';

                        if ($display_price != 0 || $display_price != '') {
                            $add_to_cart_checkbox .= '<div class="gspbwoo-bundle-checkbox"><label><input checked type="checkbox"
                  class="product-check" data-sub-product="yes" data-discount="' . $bundle_discount_percentage . '" data-price="' . $discount_price . '"
                  data-product-id="' . $product->get_id() . '" data-product-type="' . $product->get_type() . '" /> <span
                  class="product-title">' . $prefix . get_the_title() . '</span> - ' . $price_html . '</label></div>';
                        }
                    ?>
                    <?php endwhile; ?>

                </div>
                <?php
                $show_product_list = true;
                if (isset($settings['show_product_list'])) {
                    $show_product_list = $settings['show_product_list'];
                }
                if ($show_product_list) {
                ?>
                    <div class="gspbwoo-check-products">
                        <?php echo ''.$add_to_cart_checkbox; ?>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="gspbwoo-bundles-column-right">
                <div class="total-price">
                    <?php
                    $total_price_html    = '<span class="total-price-html">' . wc_price($total_price) . $product->get_price_suffix() . '</span>';
                    $total_products_html = '<span class="total-products">' . $products->post_count + 1 . '</span>';
                    // final_price
                    if (isset($settings['final_price']) && $settings['final_price']) {
                        $total_price = str_replace('{amount}', $total_price_html, $settings['final_price']);
                        $total_price = str_replace('{number}', $total_products_html, $total_price);
                    } else {
                        $total_price = sprintf(esc_html__('%s for %s item(s)', 'greenshiftwoo'), $total_price_html, $total_products_html);
                    }
                    echo wp_kses_post($total_price);
                    ?>
                </div>
                <div class="gspbwoo-bundles-add-all-to-cart">
                    <?php
                    if (isset($settings['button_text']) && $settings['button_text']) {
                        $button_text = esc_attr($settings['button_text']);
                    } else {
                        $button_text = __('Add to cart', 'greenshiftwoo');
                    }

                    if (isset($settings['save_text']) && $settings['save_text']) {
                        $save_text = str_replace('{amount}', $bundle_discount_percentage . '%', $settings['save_text']);
                    } else {
                        $save_text = sprintf(__('Save %s%%', 'greenshiftwoo'), $bundle_discount_percentage); 
                    }
                    ?>

                    <button type="button" class="wp-element-button add-all-to-cart"><?php echo esc_html($button_text); ?></button>
                </div>
                <strong><?php echo esc_html($save_text) ?></strong>
            </div>
        </div>
    </div>
<?php endif;