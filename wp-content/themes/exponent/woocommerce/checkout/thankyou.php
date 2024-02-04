<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="woocommerce-order">

	<?php if ( $order ) : 
		
		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>
            <div class="<?php echo be_themes_get_class( 'wc-order-header' ); ?>">
                <div class="<?php echo be_themes_get_class( 'wc-order-header-inner' ); ?>">
                    <h2 class="<?php echo be_themes_get_class( 'wc-order-header-title' ); ?>">
                        <?php echo esc_html__( 'Order Failed' ,'exponent' ); ?>
                    </h2>
                    <div class="<?php echo be_themes_get_class( 'wc-order-header-description' ); ?>">
                        <?php echo esc_html__( "Alas, that's unfortunate", 'exponent' ); ?>
                    </div>
				</div>
			</div>
			<div class="exp-wrap">
				<div class="exp-wc-order-overview-wrap">
					<div class="<?php echo be_themes_get_class( 'wc-order-failed-text' ); ?>">
						<?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'exponent' ); ?>
					</div>
					<div class="<?php echo be_themes_get_class( 'wc-order-retry' ); ?>">
						<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'exponent' ) ?>
						</a>
						<?php if ( is_user_logged_in() ) : ?>
							<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'exponent' ); ?></a>
						<?php endif; ?>
					</div>
				</a>
				<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
				<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
			</div>
		<?php else : ?>
            <div class="<?php echo be_themes_get_class( 'wc-order-header' ); ?>">
                <div class="<?php echo be_themes_get_class( 'wc-order-header-inner' ); ?>">
                    <h2 class="<?php echo be_themes_get_class( 'wc-order-header-title' ); ?>">
                        <?php echo esc_html__( 'Order Successful' ,'exponent' ); ?>
                    </h2>
                    <div class="<?php echo be_themes_get_class( 'wc-order-header-description' ); ?>">
                        <?php echo esc_html__( "Yay, that's awesome", 'exponent' ); ?>
                    </div>
                </div>
            </div>
			<div class="<?php echo be_themes_get_class( 'wrap' ); ?>">
				<div class="exp-wc-order-overview-wrap">
					<div class="h4 <?php echo be_themes_get_class( 'exp-wc-order-received-text' ); ?>">
						<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'exponent' ), $order ); ?>
					</div>
					<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details be-row <?php echo be_themes_get_class( 'wc-order-overview' ); ?>">
						<li class="<?php echo be_themes_get_class( 'wc-order-overview-col' ); ?>">
							<div class="<?php echo be_themes_get_class( 'wc-order-overview-col-inner' ); ?>">
								<div class="woocommerce-order-overview__order order">
									<strong class="h6"><?php esc_html_e( 'Order number:', 'exponent' ); ?></strong>
									<?php echo wp_kses_post( $order->get_order_number() ); ?>
								</div>
								<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
									<div class="woocommerce-order-overview__email email">
										<strong class="h6"><?php esc_html_e( 'Email:', 'exponent' ); ?></strong>
										<?php echo wp_kses_post( $order->get_billing_email() ); ?>
									</div>
								<?php endif; ?>
							</div>
						</li>
						<li class="<?php echo be_themes_get_class( 'wc-order-overview-col' ); ?>">
							<div class="<?php echo be_themes_get_class( 'wc-order-overview-col-inner' ); ?>">
								<div class="woocommerce-order-overview__date date">
									<strong class="h6"><?php esc_html_e( 'Date:', 'exponent' ); ?></strong>
									<?php echo wc_format_datetime( $order->get_date_created() ); ?>
								</div>
								<?php if ( $order->get_payment_method_title() ) : ?>
									<div class="woocommerce-order-overview__payment-method method">
										<strong class="h6"><?php esc_html_e( 'Payment method:', 'exponent' ); ?></strong>
										<?php echo wp_kses_post( $order->get_payment_method_title() ); ?>
									</div>
								<?php endif; ?>
							</div>
						</li>
						<li class="<?php echo be_themes_get_class( 'wc-order-overview-col' ); ?>">
							<div class="<?php echo be_themes_get_class( 'wc-order-overview-col-inner' ); ?>">
								<div class="woocommerce-order-overview__total total">
									<strong class="h6"><?php esc_html_e( 'Total:', 'exponent' ); ?></strong>
									<?php echo wp_kses_post( $order->get_formatted_order_total() ); ?>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
				<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
            </div>
		<?php endif; ?>


	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'exponent' ), null ); ?></p>

	<?php endif; ?>

</div>
