<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     7.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}

$form_style = $hidden ? 'style="display:none;"' : '';

?>
<form class="woocommerce-form woocommerce-form-login login" method="post" <?php echo !empty( $form_style ) ? $form_style : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

    <?php echo ( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>

    <div class="woocommerce-form-login-inner">
        <div class="be-row exp-checkout-loginform-layout">
            <div class="form-row be-col">
                <input type="text" class="input-text" name="username" id="username" placeholder = "<?php esc_html_e( 'Username or email*', 'exponent' ); ?>" autocomplete="username" />
            </div>
            <div class="form-row be-col">
                <input class="input-text" placeholder = "<?php esc_html_e( 'Password*', 'exponent' ); ?>" type="password" name="password" id="password" autocomplete="current-password" />
            </div>
            <?php do_action( 'woocommerce_login_form' ); ?>
            <div class="form-row be-col">
                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                <button type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'exponent' ); ?>"><?php esc_html_e( 'Login', 'exponent' ); ?></button>
                <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
            </div>
        </div>
        <div class = "lost-pass-remember-me-wrap be-row">
            <div class = "be-col remember-me">
                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> 
                <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
            </div>
            <div class="be-col lost_password">
                <a class="exp-lively-link-style1" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'exponent' ); ?></a>
            </div>
        </div>
        <div class="exp-wc-login-info">
            <span class="exp-wc-login-info-note">
                *Note
            </span>
            <?php echo esc_html__( 'If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing &amp; Shipping section.', 'exponent' ); ?>
        </div>
    </div>
</form>
