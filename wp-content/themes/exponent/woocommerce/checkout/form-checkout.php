<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="<?php echo be_themes_get_class( 'wc-checkout-header' ); ?>">
    <div class="<?php echo be_themes_get_class( 'wc-checkout-header-inner' ); ?>">
        <h2 class="<?php echo be_themes_get_class( 'wc-checkout-header-title' ); ?>">
            <?php echo esc_html__( 'Your Shopping Cart', 'exponent' ); ?>
        </h2>
        <div class="<?php echo be_themes_get_class( 'wc-checkout-header-description' ); ?>">
            <?php echo esc_html__( 'Missed something ?', 'exponent' ); ?>
            <a class="<?php echo be_themes_get_class( 'lively-link-style1' ); ?>" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
                <?php echo esc_html__( 'Continue Shopping', 'exponent' ); ?>
            </a>
        </div>
    </div>
</div>
<?php get_template_part( 'template-parts/partials/content-pad', 'start' ); ?>
<div class="<?php echo be_themes_get_class( 'wrap' ); ?>">
<?php
do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'exponent' ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <div class="be-row <?php echo be_themes_get_class('checkout-form-layout' ); ?>">
        <div class="be-col">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
        </div>
        <div class="be-col">
        <div class="<?php echo be_themes_get_class( 'checkout-review-order' ); ?>">

	<h3 id="order_review_heading"><?php echo esc_html__( 'Your order', 'exponent' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
    </div>
    </div>
    </div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</div>
<?php get_template_part( 'template-parts/partials/content-pad', 'end' ); ?>
