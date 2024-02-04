<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;


do_action( 'woocommerce_before_cart' ); 
?>
<div class="<?php echo be_themes_get_class( 'wc-cart-form-wrap' ); ?>">
    <?php woocommerce_output_all_notices(); ?>
	<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
		<?php do_action( 'woocommerce_before_cart_table' ); ?>

		<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
			<thead>
				<tr>
					<th class="product-remove">&nbsp;</th>
					<th class="product-thumbnail">&nbsp;</th>
					<th class="product-name"><?php esc_html_e( 'Product', 'exponent' ); ?></th>
					<th class="product-price"><?php esc_html_e( 'Price', 'exponent' ); ?></th>
					<th class="product-quantity"><?php esc_html_e( 'Quantity', 'exponent' ); ?></th>
					<th class="product-subtotal"><?php esc_html_e( 'Total', 'exponent' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-remove">
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'exponent' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
						</td>

						<td class="product-thumbnail">
						<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo wp_kses_post( $thumbnail ); // PHPCS: XSS ok.
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) ); // PHPCS: XSS ok.
						}
						?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'exponent' ); ?>">
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
						} else {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'exponent' ) . '</p>', $product_id ) );
						}
						?>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'exponent' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'exponent' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
						} else {
							$product_quantity = woocommerce_quantity_input(
								array(
									'input_name'   => "cart[{$cart_item_key}][qty]",
									'input_value'  => $cart_item['quantity'],
									'max_value'    => $_product->get_max_purchase_quantity(),
									'min_value'    => '0',
									'product_name' => $_product->get_name(),
								),
								$_product,
								false
							);
						}

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'exponent' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions">

                    <div class="<?php echo be_themes_get_class( 'wc-coupon-update-wrap' ); ?>">
						<?php if ( wc_coupons_enabled() ) { ?>
							<div class="coupon">
								<div class="coupon-icon">	
                                    <svg width="27" height="27" viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg">
                                        <path id="Shape Copy" fill-rule="evenodd" clip-rule="evenodd" d="M22.3899 17.6228L22.3907 15.4625C22.0727 15.3676 21.7732 15.1968 21.5224 14.9459C20.7235 14.147 20.7236 12.8522 21.5218 12.054C21.7733 11.8024 22.0728 11.6301 22.39 11.5372L22.3908 9.37708C22.3901 8.81457 21.9299 8.35449 21.3675 8.35376L5.63202 8.35413C5.07106 8.35352 4.61014 8.81433 4.60869 9.37744L4.61006 11.537C4.92805 11.6321 5.22748 11.8029 5.479 12.0543C6.27719 12.8525 6.27716 14.1475 5.47749 14.947C5.22739 15.1971 4.92796 15.3694 4.60924 15.4637L4.61061 17.6233C4.6106 18.1864 5.07008 18.6459 5.6339 18.6466L21.3665 18.6461C21.9304 18.6454 22.3906 18.1852 22.3899 17.6228ZM8.75905 10.9624L8.75749 16.0389L18.073 16.0387L18.0717 10.9622L8.75905 10.9624ZM7.59785 9.80115L7.59622 17.2001L19.2335 17.1991L19.2337 9.80151L7.59785 9.80115Z"/>
                                    </svg>
                                </div>
				    			<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'exponent' ); ?></label>
                                <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'exponent' ); ?>" />
                                <button class="exp-wc-apply-coupon" type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'exponent' ); ?>">
                                    <?php esc_html_e( 'Apply coupon', 'exponent' ); ?>
                                </button>
								<?php do_action( 'woocommerce_cart_coupon' ); ?>
							</div>
						<?php } ?>
						<div class="<?php echo be_themes_get_class( 'wc-update-cart' ); ?>">
							<div class="<?php echo be_themes_get_class( 'wc-update-cart-icon' ); ?>">
								<svg width="17" height="17" viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M3.84378 3.81299C1.49377 6.18005 1.45377 9.99194 3.71576 12.424L6.02277 10.101L6.03778 15.9351L0.527771 15.634L2.26877 13.882C-0.795227 10.64 -0.757233 5.521 2.39175 2.35095C3.73676 0.995972 5.43378 0.213013 7.18875 0L7.25775 2.07703C6.00775 2.26599 4.80576 2.84399 3.84378 3.81299ZM10.3777 6.29895L10.3628 0.464966L15.8728 0.765015L14.1318 2.51892C17.1958 5.75891 17.1578 10.8779 14.0098 14.0499C12.6638 15.4039 10.9668 16.187 9.21176 16.4L9.14276 14.324C10.3928 14.135 11.5958 13.557 12.5568 12.588C14.9068 10.223 14.9467 6.41101 12.6848 3.97693L10.3777 6.29895Z"/>
								</svg>
							</div>
							<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
							</button>
						</div>
					</div>
					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>
			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>
</div>
<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>