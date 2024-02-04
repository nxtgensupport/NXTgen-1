<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
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
<div class="woocommerce-error <?php echo be_themes_get_class( 'error-message' ); ?>">
    <div class="<?php echo be_themes_get_class( 'error-message__icon' ); ?>">
        <svg width="24" height="21" viewBox="0 0 24 21" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6 2.3L23 16.5C23.2772 16.8696 23.3836 17.4099 23.4771 17.8843C23.4848 17.9234 23.4924 17.962 23.5 18C23.5 18.8 23.2 19.5 22.6 20.1C22.1 20.7 21.3 21 20.5 21H3.49999C2.99999 21 2.49999 20.9 2.09999 20.6C0.699993 19.8 0.199993 17.9 0.999993 16.5L9.39999 2.2C9.59999 1.8 9.99999 1.4 10.4 1.2C11.1 0.800003 11.9 0.700003 12.7 0.900003C13.5 1.1 14.2 1.6 14.6 2.3ZM20.5 19C20.7 19 21 18.9 21.2 18.7C21.2217 18.6566 21.2481 18.6132 21.2751 18.5688C21.3727 18.4085 21.4783 18.2349 21.4 18C21.4 17.8 21.4 17.6 21.3 17.5L12.8 3.4C12.5 3 11.9 2.8 11.4 3.1C11.3333 3.1 11.2667 3.18889 11.2 3.27778C11.1667 3.32223 11.1333 3.36667 11.1 3.4L2.59999 17.5C2.39999 18 2.49999 18.6 2.99999 18.9C3.19999 19 3.29999 19 3.49999 19H20.5Z" />
            <path d="M12 7C11.4 7 11 7.4 11 8V12C11 12.6 11.4 13 12 13C12.6 13 13 12.6 13 12V8C13 7.4 12.6 7 12 7Z" />
            <path d="M11.3 15.3C11.1 15.5 11 15.7 11 16C11 16.3 11.1 16.5 11.3 16.7C11.5 16.9 11.7 17 12 17C12.3 17 12.5 16.9 12.7 16.7C12.9 16.5 13 16.2 13 16C13 15.8 12.9 15.5 12.7 15.3C12.3 14.9 11.7 14.9 11.3 15.3V15.3Z" />
        </svg>
    </div>
    <div class="h7 <?php echo be_themes_get_class( 'error-message__content' ); ?>">
        <ul role="alert">
            <?php foreach ( $notices as $notice ) : ?>
                <li <?php echo wc_get_notice_data_attr( $notice ); ?>>
                    <?php echo wc_kses_notice( $notice['notice'] ); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>