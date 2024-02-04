<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
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
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$svg_icon_path = trailingslashit( get_template_directory() ) . 'woocommerce/dashboard_icons/';
$nav_icons = array (
    'customer-logout'           => '<svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 2H2V16H10V18H2C0.899902 18 0 17.1001 0 16V2C0 0.899902 0.899902 0 2 0H10V2ZM12 4L18 9L12 14V11H5V7H12V4Z" />
    </svg>',
    'dashboard'                 => '<svg width="14" height="12" viewBox="0 0 14 12" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.6001 2H13.3999C13.9519 2 14 1.55298 14 1C14 0.447021 13.9519 0 13.3999 0H5.6001C5.0481 0 5 0.447021 5 1C5 1.55298 5.0481 2 5.6001 2ZM5.6001 5H11.3999C11.9519 5 12 5.44702 12 6C12 6.55298 11.9519 7 11.3999 7H5.6001C5.0481 7 5 6.55298 5 6C5 5.44702 5.0481 5 5.6001 5ZM5.6001 10H13.3999C13.9519 10 14 10.447 14 11C14 11.553 13.9519 12 13.3999 12H5.6001C5.0481 12 5 11.553 5 11C5 10.447 5.0481 10 5.6001 10ZM0.600098 5H2.3999C2.9519 5 3 5.44702 3 6C3 6.55298 2.9519 7 2.3999 7H0.600098C0.0480957 7 0 6.55298 0 6C0 5.44702 0.0480957 5 0.600098 5ZM2.3999 10H0.600098C0.0480957 10 0 10.447 0 11C0 11.553 0.0480957 12 0.600098 12H2.3999C2.9519 12 3 11.553 3 11C3 10.447 2.9519 10 2.3999 10ZM0.600098 0H2.3999C2.9519 0 3 0.447021 3 1C3 1.55298 2.9519 2 2.3999 2H0.600098C0.0480957 2 0 1.55298 0 1C0 0.447021 0.0480957 0 0.600098 0Z"/>
    </svg>',
    'downloads'                 => '<svg width="16" height="14" viewBox="0 0 16 14" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M9 8H11L8 11L5 8H7V0H9V8ZM0 13C0 12.447 0.0480957 12 0.600098 12H15.3999C15.9519 12 16 12.447 16 13C16 13.553 15.9519 14 15.3999 14H0.600098C0.0480957 14 0 13.553 0 13Z"/>
    </svg>',
    'edit-account'              => '<svg width="14" height="15" viewBox="0 0 14 15" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 7C9.433 7 11 5.433 11 3.5C11 1.567 9.433 0 7.5 0C5.567 0 4 1.567 4 3.5C4 5.433 5.567 7 7.5 7Z"/>
    <path fill-rule="evenodd" clip-rule="evenodd" d="M14 15C14 15 13.0561 8 7 8C0.943901 8 0 15 0 15H14Z"/>
    </svg>',
    'edit-address'              => '<svg width="20" height="17" viewBox="0 0 20 17" xmlns="http://www.w3.org/2000/svg">
    <path d="M18.6721 9.99996H17.0001V16C17.0001 16.445 16.8061 17 16.0001 17H12.0001V11H8.00011V17H4.00011C3.19411 17 3.00011 16.445 3.00011 16V9.99996H1.32811C0.730106 9.99996 0.858106 9.67596 1.26811 9.25196L9.29211 1.21996C9.48711 1.01796 9.74311 0.917959 10.0001 0.907959C10.2571 0.917959 10.5131 1.01696 10.7081 1.21996L18.7311 9.25096C19.1421 9.67596 19.2701 9.99996 18.6721 9.99996Z"/>
    </svg>',
    'orders'                    => '<svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.615 8.01001L6.54712 11.1721C5.57788 11.449 5.60205 12 6.75195 12H18V13.5491C18 13.7671 17.8201 13.949 17.6001 13.949H4.3999C4.26782 13.949 4.15039 13.8838 4.07739 13.7842C4.02881 13.718 4 13.6367 4 13.5491V11.8999L3.90991 10.957L2 2H0V0.399902C0 0.179932 0.179932 0 0.398926 0H3.60107C3.81909 0 4 0.179932 4 0.399902V2H18V7.5C18 7.72095 17.8259 7.94897 17.615 8.01001ZM3 16C3 17.104 3.89502 18 5 18C6.10303 18 7 17.104 7 16C7 14.894 6.10303 14 5 14C3.89502 14 3 14.894 3 16ZM13 16C13 17.104 13.894 18 15 18C16.104 18 17 17.104 17 16C17 14.894 16.104 14 15 14C13.894 14 13 14.894 13 16Z"/>
    </svg>'
);
do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation">
	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <li class="h6 <?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                <?php 
                    if( array_key_exists( $endpoint, $nav_icons ) ) {
                        ?>
                        <div class="<?php echo be_themes_get_class( 'wc-account-navigation-icon' ); ?>">
                            <?php echo !empty( $nav_icons[ $endpoint ] ) ? $nav_icons[ $endpoint ] : ''; ?>
                        </div>
                        <?php
                    }
                ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
