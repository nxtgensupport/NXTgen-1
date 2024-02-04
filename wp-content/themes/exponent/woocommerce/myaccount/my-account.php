<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="be-themes-content-padding <?php echo be_themes_get_class( 'wrap' ); ?>">
    <div class="<?php echo be_themes_get_class( 'wc-dashboard-header' ); ?>">
        <div class="<?php echo be_themes_get_class( 'wc-dashboard-header-inner' ); ?>">
            <h2 class="<?php echo be_themes_get_class( 'wc-dashboard-header-title' ); ?>"> 
                <?php echo esc_html__( 'My Account', 'exponent' ); ?>
            </h2>
            <div class="<?php echo be_themes_get_class( 'wc-dashboard-description' ); ?>" >
                <?php echo esc_html__( 'Add, edit or save details of your account', 'exponent' ); ?>
            </div>
        </div>
    </div>
<?php
wc_print_notices();

/**
 * My Account navigation.
 * @since 2.6.0
 */
?>
<div class="be-row <?php echo be_themes_get_class( 'wc-dashboard-layout' ); ?>">
    <div class="be-col">
        <?php do_action( 'woocommerce_account_navigation' ); ?>
    </div>
    <div class="be-col">
        <div class="woocommerce-MyAccount-content">
            <?php
                /**
                 * My Account content.
                 * @since 2.6.0
                 */
                do_action( 'woocommerce_account_content' );
            ?>
        </div>
    </div>
</div>
</div>
