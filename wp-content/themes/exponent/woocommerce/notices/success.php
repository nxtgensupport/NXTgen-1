<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
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
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $notices ) {
	return;
}

?>

<?php foreach ( $notices as $notice ) : ?>
	<div class="woocommerce-message <?php echo wc_get_notice_data_attr( $notice ); echo be_themes_get_class( 'success-message' ); ?>" role="alert">
        <div class="<?php echo be_themes_get_class( 'success-message__icon' ); ?>">
            <svg width="22" height="22" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 9.1C20.4 9.1 20 9.5 20 10.1V11C20 16 16 20 11 20V20C6 20 2 16 2 11C2 6 6 2 11 2V2C12.3 2 13.5 2.3 14.7 2.8C15.2 3 15.8 2.8 16 2.3C16.2 1.8 16 1.2 15.5 1C14.1 0.4 12.6 0 11 0V0C4.9 0 0 4.9 0 11C0 17.1 4.9 22 11 22V22C17.1 22 22 17.1 22 11V10.1C22 9.5 21.6 9.1 21 9.1Z"/>
                <path d="M8.7 9.3C8.3 8.9 7.7 8.9 7.3 9.3C6.9 9.7 6.9 10.3 7.3 10.7L10.3 13.7C10.5 13.9 10.7 14 11 14C11.3 14 11.5 13.9 11.7 13.7L21.7 3.7C22.1 3.3 22.1 2.7 21.7 2.3C21.3 1.9 20.7 1.9 20.3 2.3L11 11.6L8.7 9.3V9.3Z"/>
            </svg>
        </div>
        <div class="h7 <?php echo be_themes_get_class( 'success-message__content' ); ?>">
            <?php echo wp_kses_post( $notice['notice'] ); ?>
        </div>
    </div>
<?php endforeach; ?>
