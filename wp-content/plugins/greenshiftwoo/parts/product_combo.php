<?php

/**
 * View file for Product Combos
 */

global $product, $post;

$combos_data = get_post_meta($post->ID, '_combo_data', true);

if (!$combos_data) {
	return;
}

if ($isTab) {
	wp_enqueue_style('greenshift_woocommerce_combos');
}
wp_enqueue_script('gs_woocommerce_combos');
wp_localize_script('gs_woocommerce_combos', 'gspbwoo_combos', [
	'ajax_url'      => admin_url('admin-ajax.php'),
	'loader_icon'   => GREENSHIFTWOO_DIR_URL . 'assets/css/select2-spinner.gif',
	'success'       => sprintf('<div class="woocommerce-message">%s <a class="button wc-forward" href="%s">%s</a></div>', esc_html__('Products was successfully added to your cart.', 'greenshiftwoo'), wc_get_cart_url(), esc_html__('View Cart', 'greenshiftwoo')),
	'empty'         => sprintf('<div class="woocommerce-error">%s</div>', esc_html__('No Products selected.', 'greenshiftwoo')),
	'no_variation'  => sprintf('<div class="woocommerce-error">%s</div>', esc_html__('Product Variation does not selected.', 'greenshiftwoo')),
	'not_available' => sprintf('<div class="woocommerce-error">%s</div>', esc_html__('Sorry, this product is unavailable.', 'greenshiftwoo'))
]);

$main_product_id = $product->get_id();

$title       = $title ? $title : esc_html__('Combo Offer', 'greenshiftwoo');
$titleTag       = !empty($titleTag) ? $titleTag : 'h2';
$offer_label = $offer_label ? $offer_label : esc_html__('Combo price:', 'greenshiftwoo');

$with_text   = $with_text ? $with_text : esc_html__('Combo with:', 'greenshiftwoo');

$button_text = $button_text ? $button_text : esc_html__('Add to cart', 'greenshiftwoo');

echo '<div class="gspb-combos">';

	if ($show_title) {
		echo '<div class="gspb-woo-section-title"><'.$titleTag.'>' . esc_attr($title) . '</span></'.$titleTag.'></div>';
	}
	?>
	<div class="custom-wc-message">
		<!-- AJAX output var woo_combos -->
	</div>
	<div class="gspbwoo-combo-list-section">
		<?php
		foreach ($combos_data as $combo) {
			if ($combo['productId'] !== "") {
				$main_product        = wc_get_product($main_product_id);
				$combo_product       = wc_get_product($combo['productId']);
				$combo_product_title = $combo_product->get_title();
				$main_product_title  = $main_product->get_title();
				$url                 = get_permalink($combo['productId']);
				$main_url            = get_permalink($main_product_id);
				$thumbnail_id        = get_post_thumbnail_id($main_product_id);
				if ($thumbnail_id) {
					// If a featured image exists, retrieve and display it
					$main_image = wp_get_attachment_image($thumbnail_id, [96, 96]); // Replace 96 with your desired height and width
				} else {
					// If no featured image exists, display the WooCommerce dummy image
					$main_image = '<img src="' . wc_placeholder_img_src('woocommerce_thumbnail') . '" alt="' . esc_attr(get_the_title($main_product_id)) . '" width="96" height="96" />';
				}
				$combo_thumbnail_id = get_post_thumbnail_id($combo['productId']);
				if ($combo_thumbnail_id) {
					// If a featured image exists, retrieve and display it
					$combo_image = wp_get_attachment_image($combo_thumbnail_id, [96, 96]); // Replace 96 with your desired height and width
				} else {
					// If no featured image exists, display the WooCommerce dummy image
					$combo_image = '<img src="' . wc_placeholder_img_src('woocommerce_thumbnail') . '" alt="' . esc_attr(get_the_title($main_product_id)) . '" width="96" height="96" />';
				}
				$combo_product_price     = $combo_product->get_price();
				$main_product_price      = $main_product->get_price();
				$combo_discount          = $combo['discount'];
				$combo_discount_amount   = $combo_product_price * ($combo_discount / 100);
				$combo_discounted_amount = $combo_product_price - $combo_discount_amount;
				$total_amount            = $main_product_price + $combo_discounted_amount;

				$offer_text  = $offer_text ? str_replace('{amount}', wc_price($combo_discount_amount), $offer_text) : esc_html__("Save", "greenshiftwoo") . ' ' . wc_price($combo_discount_amount);
				$final_price = $final_price ? str_replace('{amount}', wc_price($total_amount), $final_price) : "<strong class='price'>" . wc_price($total_amount) . "</strong>";
				?>
				<div class="gspbwoo-combo-list-item">
					<div class="combo-title-box">
						<span class="combo-title-box-text"><?php echo wp_kses_post($offer_label); ?> <span class="combo-title-box-price"><?php echo wp_kses_post($offer_text) ?></span></span>
					</div>

					<div class="cross-sell-list">
						<div class="combo-offer-image-container">
							<div class="combo-offer-images">
								<div class="combo-offer-image">
									<a href="<?php echo esc_url($main_url) ?>" class="product-image-link">
										<?php echo '' . $main_image; ?>
									</a>
								</div>
								<span class="icon-plus-wrapper">+</span>
								<div class="combo-offer-image">
									<a href="<?php echo esc_url($url) ?>" class="product-image-link">
										<?php echo '' . $combo_image; ?>
									</a>
								</div>
							</div>
						</div>
							<div class="gspbwoo-combos_with_label"><?php echo wp_kses_post($with_text); ?> </div>
							<div class="gspbwoo-combos_title">
								<a class="product-link" href="<?php echo esc_url($url) ?>">
									<?php echo wp_kses_post($combo_product_title); ?>
								</a>
							</div>
						<div class="discount-price-text"><?php echo ''.$final_price ?></div>
						<div class="add-both-to-cart-button">
								<button class="wp-element-button  gspbwoo-combo-btn-block combo-btn-add-to-cart" data-main-product-id="<?php echo (int)$main_product_id; ?>" data-combo-product-id="<?php echo (int)$combo['productId']; ?>" data-main-product-price="<?php echo esc_attr($main_product_price); ?>" data-combo-discount="<?php echo esc_attr($combo_discounted_amount); ?>" data-discount="<?php echo esc_attr($combo_discount); ?>">
									<?php echo esc_attr($button_text); ?>
								</button>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>