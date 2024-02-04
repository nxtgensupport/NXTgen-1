<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/notice.php.
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
	exit; // Exit if accessed directly
}

if ( ! $notices ) {
	return;
}

?>

<?php foreach ( $notices as $notice ) : ?>
	<div class="woocommerce-info <?php echo wc_get_notice_data_attr( $notice ); echo be_themes_get_class( 'info-message' ); ?>">
        <div class="<?php echo be_themes_get_class( 'info-message__icon' ); ?>">
            <svg width="22" height="22" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 11C0 17.1 4.9 22 11 22C17.1 22 22 17.1 22 11C22 4.9 17.1 0 11 0C4.9 0 0 4.9 0 11ZM2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20C6 20 2 16 2 11Z" />
                <path d="M11 16C10.4 16 10 15.6 10 15V11C10 10.4 10.4 10 11 10C11.6 10 12 10.4 12 11V15C12 15.6 11.6 16 11 16Z" />
                <path d="M10.3 7.7C10.1 7.5 10 7.3 10 7C10 6.7 10.1 6.5 10.3 6.3C10.5 6.1 10.7 6 11 6C11.3 6 11.5 6.1 11.7 6.3C11.9 6.5 12 6.8 12 7C12 7.2 11.9 7.5 11.7 7.7C11.3 8.1 10.7 8.1 10.3 7.7V7.7Z" />
            </svg>
        </div>
        <div class="h7 <?php echo be_themes_get_class( 'info-message__content' ); ?>">
            <?php echo wp_kses_post( $notice['notice'] ); ?>
        </div>
    </div>
<?php endforeach; ?>
