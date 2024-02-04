<?php extract( be_get_color_hub() ); ?>

/****************************************************
Header Styles
*****************************************************/

.exponent-menu li a:hover,
.exponent-menu li.current-menu-item > a,
.exponent-mobile-menu li a:hover,
.exponent-mobile-menu li.current-menu-item > a,
.exponent-menu > ul > li:hover > a,
.exponent-menu .exponent-sub-menu > li:hover > a{
  color:  <?php echo esc_attr($color_scheme); ?>;
}
.exponent-menu > ul > li:hover > .exponent-sub-menu-indicator svg polyline,
.exponent-menu .exponent-sub-menu > li:hover svg polyline {
  stroke : <?php echo esc_attr($color_scheme); ?>;
}
/**
 * Common Styles
 */
blockquote {
  border-left: 4px solid <?php echo esc_attr($color_scheme); ?>;
}
a {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.flickity-page-dots .dot.is-selected {
  background : <?php echo esc_attr($color_scheme); ?>;
}

/**
 * Form Styles
 */ 

.exp-form-border {
  background-color : <?php echo esc_attr($color_scheme); ?>;
}
.exp-form-border-with-underline .exp-form-field-active .exp-form-field-label {
   color : <?php echo esc_attr($color_scheme); ?>; 
}

.exp-form-rounded input:not([type = "submit"]):focus,
.exp-form-rounded textarea:focus,
.exp-form-rounded select:focus {
   border-color : <?php echo esc_attr($color_scheme); ?>;
}
.exp-form-pill input:not([type = "submit"]):focus,
.exp-form-pill textarea:focus,
.exp-form-pill select:focus {
  border-color : <?php echo esc_attr($color_scheme); ?>;
}


.exp-form-pill input:not([type = "submit"]),
.exp-form-pill textarea,
.exp-form-pill select,
.exp-form-rounded input,
.exp-form-rounded textarea,
.exp-form-rounded select {
    background-color : <?php echo esc_attr($secondary_color_scheme); ?>;
}

input[ type = "submit" ] {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}

/**
 * Posts Styles
 */

<?php 
  $featured_posts = be_themes_get_option( 'featured_posts' );
  $featured_post_type = be_themes_get_option( 'featured_posts_type' );
  if( !empty( $featured_posts ) && 'slider' === $featured_post_type ) :
    $featured_post_slide_width = be_themes_get_option( 'featured_posts_slide_width' );
?>
   .exp-featured-posts .be-slide {
      width : <?php echo ( esc_attr( $featured_post_slide_width ) . '%' ); ?>
   }
<?php endif; ?>

.exp-post-categories-normal a:hover,
.exp-post-title a:hover,
.exp-post-author .exp-post-author-name:hover {
    color : <?php echo esc_attr($color_scheme); ?>;
}

.pages_list a {
  background: <?php echo esc_attr($secondary_bg_color); ?>;
  color: <?php echo esc_attr($alt_bg_text_color); ?>;
}

.pages_list a:hover {
  background: <?php echo esc_attr($color_scheme); ?>;
  color: <?php echo esc_attr($alt_bg_text_color); ?>;
}

.exp-categories-post-count {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.exp-archive-post-count {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.widget_calendar tbody a {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.exp-read-more.exp-read-more-underlined::after {
  background : <?php echo esc_attr($color_scheme); ?>;
}

<?php $posts_nav_padding = be_themes_get_option( 'posts_nav_pad' ); ?>
.exp-posts-nav {
   padding-top : <?php echo esc_attr($posts_nav_padding); ?>px;
   padding-bottom : <?php echo esc_attr($posts_nav_padding); ?>px;
}

.exp-home-grid-icon {
  color : <?php echo esc_attr($secondary_bg_color); ?>;
}

.exp-read-more-underlined {
  color : <?php echo esc_attr($secondary_bg_color); ?>;
}
.exp-read-more-underlined::before {
  color : <?php echo esc_attr($secondary_bg_color); ?>;
}
.exp-read-more-underlined:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}
.exp-read-more-underlined:hover::after {
  color : <?php echo esc_attr($color_scheme); ?>;
}

/**
 * anchor styles
 */

  .menu-item.current-menu-item > a {
    color : <?php echo esc_attr($color_scheme); ?>;
  }

 .exp-breadcrumbs a:hover,
 .widget a:hover {
   color : <?php echo esc_attr($color_scheme); ?>;
 }
 .widget .tag-cloud-link:hover {
   background : <?php echo esc_attr($color_scheme); ?>;
 }

.exp-post-single-footer-author {
   background : <?php echo esc_attr($alt_bg_text_color); ?>;
}

.exp-pagination .page-numbers:not(.current):hover {
  background : <?php echo esc_attr($secondary_color_scheme); ?>;
}

.exp-post-single-footer-tags .exp-term:hover,
.exp-pagination .current {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}
.exp-pagination .current {
  border-color:  <?php echo esc_attr($color_scheme); ?>;
  box-shadow : 0 7px 14px -6px <?php echo esc_attr($color_scheme); ?>;
}
.exp-pagination a:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

/**
 * Comments
 */
#cancel-comment-reply-link:hover,
.exp-comment-reply:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

/**
 * Widgets
 */
.exp-archive-post-count,
.exp-categories-post-count {
  background : <?php echo esc_attr($secondary_color_scheme); ?>;
}
.exp-archive-widget-link:hover a {
  color : <?php echo esc_attr($color_scheme); ?>
}
.exp-archive-widget-link:hover .exp-archive-post-count {
  background : <?php echo esc_attr($color_scheme); ?>;
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
}
.exp-categories-widget-link:hover > a {
  color : <?php echo esc_attr($color_scheme); ?>;
}
.exp-categories-widget-link:hover > .exp-categories-post-count {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}
.widget_calendar tbody a {
  background : <?php echo esc_attr($secondary_color_scheme); ?>;
}
#wp-calendar caption {
  color: <?php echo esc_attr($secondary_bg_color); ?>;
}
.widget_calendar tbody a:hover {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}
.tagcloud .tag-cloud-link {
  background : <?php echo esc_attr($secondary_color_scheme); ?>;
}
.tagcloud .tag-cloud-link:hover {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}

/**
 * Accordion Module
 */
.accordion-head:hover {
    color: <?php echo esc_attr($color_scheme); ?>;
}

/** Loader color */
.exp-subscribe-loader-inner {
  border-color : <?php echo esc_attr($secondary_color_scheme); ?>;
  border-left-color : <?php echo esc_attr($color_scheme); ?>;
}

#be-themes-page-loader .style-spin{
    border: 7px solid <?php echo esc_attr(be_modify_color_opacity($color_scheme, '0.3')); ?>;
    border-top-color: <?php echo esc_attr($color_scheme); ?>;
}

#be-themes-page-loader .style-ring div{
	border: 6px solid <?php echo esc_attr(be_modify_color_opacity($color_scheme, '0.6')); ?>;
	border-color:<?php echo esc_attr(be_modify_color_opacity($color_scheme, '0.6')); ?> transparent transparent transparent;
}

#be-themes-page-loader .style-ellipsis div {
	background:<?php echo esc_attr($color_scheme); ?>;
}

#be-themes-page-loader .style-ripple div {
	border: 4px solid <?php echo esc_attr($color_scheme); ?>;
}

/**
 * Back to Top
 */
#be-themes-back-to-top {
   background : <?php echo esc_attr($color_scheme); ?>;
   color : <?php echo esc_attr($alt_bg_text_color); ?>;
}

/**
 * Backgrounds
 */

<?php 
  $body_bg = be_themes_get_option( 'body_bg' );
  if( !empty( $body_bg ) ) : 
?>
  body {
      background : <?php echo be_themes_get_background( $body_bg ); ?>
  }
<?php endif; ?>

/**
 * Entry Header
 */
<?php 
  $entry_header_bg = be_themes_get_background( be_themes_get_option( 'entry_header_bg' ) );
  $entry_header_color = be_themes_get_option( 'entry_header_color' );
  $entry_header_vertical_pad = be_themes_get_option( 'entry_header_pad' );
  $entry_header_nav_color = be_themes_get_option( 'entry_header_nav_color' );
?>
  .exp-entry-header {
    background : <?php echo esc_attr($entry_header_bg); ?>;
    color : <?php echo esc_attr($entry_header_color); ?>;
    padding-top : <?php echo esc_attr($entry_header_vertical_pad); ?>px;
    padding-bottom : <?php echo esc_attr($entry_header_vertical_pad); ?>px;
  }
  .exp-entry-header .exp-post-entry-title {
    color : <?php echo esc_attr($entry_header_color); ?>;
  }

  .exp-breadcrumbs {
    color : <?php echo esc_attr($entry_header_nav_color); ?>;
  }


/**
 * Search Form
 */
.search:focus ~ .exp-searchform-icon,
.exp-form-field-active .exp-searchform-icon {
    color : <?php echo esc_attr($color_scheme); ?>;
}

/**
 * Woocommerce
 */

.woocommerce-orders-table a:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-table--order-downloads td a:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.exp-quick-view {
  background : <?php echo esc_attr($color_scheme); ?>;
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
}

.exp-wc-price-cart-wrap .exp-add-to-cart {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.exp-wc-meta-value a:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.single_add_to_cart_button {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}
.single_add_to_cart_button:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
  background : <?php echo esc_attr($alt_bg_text_color); ?>;
  border : 1px solid <?php echo esc_attr($color_scheme); ?>;
}

.wc-tabs .active {
  color : <?php echo esc_attr($color_scheme); ?>;
  border-bottom : 2px solid <?php echo esc_attr($color_scheme); ?>;
}

.exp-product-categories a:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.products .exp-product-title a:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.exp-add-to-wishlist-icon:hover,
.exp-already-in-wishlist {
  color : <?php echo esc_attr($color_scheme); ?>;
}
.products .exp-already-in-wishlist-icon {
  color : <?php echo esc_attr($color_scheme); ?>;
}
.exp-wc-product-info-inner .exp-add-to-wishlist:hover { 
  color : <?php echo esc_attr($color_scheme); ?>;
}

.exp-wc-add-to-cart-icon:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.exp-wc-quickview .product_title:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-mini-cart__buttons a {
   color : <?php echo esc_attr($alt_bg_text_color); ?>;
   background : <?php echo esc_attr($color_scheme); ?>;
}
.woocommerce-mini-cart__buttons a:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
  background  : <?php echo esc_attr($alt_bg_text_color); ?>;
  border-color : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-mini-cart__buttons .checkout {
  color : <?php echo esc_attr($color_scheme); ?>;
  background  : <?php echo esc_attr($alt_bg_text_color); ?>;
}
.woocommerce-mini-cart__buttons .checkout:hover {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}

.exp-wc-cart-product-title:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.grouped_form a:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.product-categories .cat-item a:hover {
    color: <?php echo esc_attr($color_scheme); ?>;
}
.product-categories .cat-item a:hover + .count > .exp-categories-post-count {
    background: <?php echo esc_attr($color_scheme); ?>;
    color : <?php echo esc_attr($alt_bg_text_color); ?>;
}

.widget .price_slider {
  background : <?php echo esc_attr($secondary_color_scheme); ?>;
}

.ui-slider-handle,
.ui-slider-range {
  border-color : <?php echo esc_attr($color_scheme); ?>;
}

.price_slider_amount button {
  background : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-widget-layered-nav-list__item .count {
  color : <?php echo esc_attr($color_scheme); ?>;
}
.woocommerce-widget-layered-nav-list__item .count {
  background : <?php echo esc_attr($secondary_color_scheme); ?>;
}
.woocommerce-widget-layered-nav-list__item > a:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}
.woocommerce-widget-layered-nav-list__item > a:hover + .count {
  background : <?php echo esc_attr($color_scheme); ?>;
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
}

.widget_layered_nav_filters .chosen {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background  : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-cart-form__contents .product-name a:hover,
.wishlist_table .product-name a:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.coupon button {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}

button[name = "calc_shipping"] {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}

.cart_totals .checkout-button {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-form-coupon button[name = "apply_coupon"] {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-shipping-fields input:focus,
.woocommerce-billing-fields input:focus,
.woocommerce-form-login input:focus,
.woocommerce-form-register input:focus,
.woocommerce-form-coupon input:focus,
.woocommerce-address-fields input:focus, 
.woocommerce-EditAccountForm input:focus {
  border-color : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-additional-fields textarea:focus {
  border-color : <?php echo esc_attr($color_scheme); ?>; 
}

button[name = "woocommerce_checkout_place_order"] {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-table--order-details .product-name a:hover {
    color : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-MyAccount-navigation-link:hover {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-orders-table .woocommerce-orders-table__cell-order-number a {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-account .woocommerce-Address-title a {
  color : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-review__verified.verified {
    background : <?php echo esc_attr($secondary_color_scheme); ?>;
}

.woocommerce-form-login button[name="login"],
.woocommerce-form-register button[name="register"] {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-address-fields button[name = "save_address"],
.woocommerce-EditAccountForm button[name = "save_account_details"] {
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
  background : <?php echo esc_attr($color_scheme); ?>;
}

.woocommerce-form-coupon-toggle .showcoupon,
.woocommerce-form-login-toggle .showlogin,
.lost_password a,
.exp-wc-product-share-icons .custom-share-button,
.yith-wcwl-share a {
  color : <?php echo esc_attr($secondary_bg_color); ?>;
}

.exponent-cart-count {
  background : <?php echo esc_attr($color_scheme); ?>;
  color : <?php echo esc_attr($alt_bg_text_color); ?>;
}

/**
 * Portfolio details btn
 */
.be-portfolio-details .mediumbtn {
  background: <?php echo esc_attr($color_scheme); ?>;
  color:<?php echo esc_attr($alt_bg_text_color); ?>;
}

.home-grid-icon:hover span {
  background : <?php echo esc_attr( $color_scheme ); ?>;
}