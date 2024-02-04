<?php

$woocommerce = array(
    'Shop'  => array (
        'wc_loop_title'      => array (
            'label'        => __( 'Shop Page - Product Title', 'exponent' ),
            'selector'     => sprintf( '.products .%s, .grouped_form a, .woocommerce-cart-form__contents .product-name a, .wishlist_table .product-name a, .woocommerce-checkout-review-order td.product-name, .woocommerce-table--order-details td.product-name, .exp-wc-cart-product-title', be_themes_get_class( 'product-title' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/wc_loop_title.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '18px',
                'font-variant'      => '600',
                'line-height'       => '30px',
                'text-transform'    => 'none',
                'color'             => '#343638',    
                'letter-spacing'    => '-0.005em',
            )
        ),
        'wc_loop_price'      => array (
            'label'        => __( 'Shop Page - Price', 'exponent' ),
            'selector'     => sprintf( '.products .%s,.woocommerce-mini-cart__total .woocommerce-Price-amount, .grouped_form .woocommerce-Price-amount, .woocommerce-table--order-details td.woocommerce-table__product-total, .woocommerce-cart-form__contents .product-subtotal, .woocommerce-checkout-review-order td.product-total', be_themes_get_class( 'wc-loop-price' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/wc_loop_price.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '16px',
                'font-variant'      => '500',
                'line-height'       => '18px',
                'text-transform'    => 'none',
                'color'             => '#343638',    
                'letter-spacing'    => '0px',
            )
        ),
        'wc_loop_discounted_normal_price'      => array (
            'label'        => __( 'Shop Page - On Sale - Striked Price', 'exponent' ),
            'selector'     => sprintf( '.products .%s del, .grouped_form del .woocommerce-Price-amount', be_themes_get_class( 'wc-loop-price' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/wc_loop_discounted_normal_price.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-size'         => '16px',
                'font-variant'      => '400',
                'line-height'       => '16px',
                'text-transform'    => 'none',
                'color'             => 'rgba(0,0,0,0.45)',    
                'letter-spacing'    => '0px',
            )
        ),
        'wc_loop_meta_categories'      => array (
            'label'        => __( 'Shop Page - Category Meta', 'exponent' ),
            'selector'     => sprintf( '.products .%s', be_themes_get_class( 'product-categories' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/wc_loop_meta_categories.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '11px',
                'font-variant'      => '600',
                'line-height'       => '15px',
                'text-transform'    => 'uppercase',
                'color'             => 'rgba(0,0,0,0.45)',    
                'letter-spacing'    => '1px',
            )
        ),
        'wc_loop_cart_button'      => array (
            'label'        => __( 'Shop Page -  Add to Cart Text', 'exponent' ),
            'selector'     => sprintf( '.products .%s .%s', be_themes_get_class( 'wc-price-cart-wrap' ), be_themes_get_class( 'add-to-cart' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/wc_loop_cart_button.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '12px',
                'line-height'       => '12px',
                'letter-spacing'    => '0px',
            )
        ),
        'wc_loop_sale'      => array (
            'label'        => __( 'Shop Page - Sale Indicator', 'exponent' ),
            'selector'     => '.products .onsale',
            'img'          => get_template_directory_uri().'/img/typehub/wc_loop_sale.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '11px',
                'font-variant'      => '500',
                'text-transform'    => 'uppercase',
                'letter-spacing'    => '1px',
            )
        ),
        'wc_single_product_title'   => array (
            'label'        => __( 'Individual Product - Title', 'exponent' ),
            'selector'     => '.product_title',
            'img'          => get_template_directory_uri().'/img/typehub/wc_single_product_title.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '35px',
                'font-variant'      => '600',
                'line-height'       => '48px',
                'text-transform'    => 'none',
                'color'             => '#343638',    
                'letter-spacing'    => '0px',
            )
        ), 
        'wc_single_product_price'   => array (
            'label'        => __( 'Individual Product - Price', 'exponent' ),
            'selector'     => '.exp-wc-single-price, .woocommerce-variation-price',
            'img'          => get_template_directory_uri().'/img/typehub/wc_single_product_price.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '26px',
                'font-variant'      => '500',
                'line-height'       => '35px',
                'text-transform'    => 'none',
                'color'             => '#343638',    
                'letter-spacing'    => '0px',
            )
        ), 
        'wc_single_product_discounted_normal_price'   => array (
            'label'        => __( 'Individual Product - On Sale - Striked Price', 'exponent' ),
            'selector'     => '.exp-wc-single-price del',
            'img'          => get_template_directory_uri().'/img/typehub/wc_single_product_discounted_normal_price.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '22px',
                'font-variant'      => '500',
                'line-height'       => '35px',
                'text-transform'    => 'none',
                'color'             => 'rgba(0,0,0,0.45)',    
                'letter-spacing'    => '0px',
            )
        ), 
        'wc_single_product_metas'   => array (
            'label'        => __( 'Individual Product - Meta', 'exponent' ),
            'selector'     => '.exp-wc-meta-value',
            'img'          => get_template_directory_uri().'/img/typehub/wc_single_product_metas.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:secondary',
                'font-size'         => '17px',
                'font-variant'      => '400',
                'line-height'       => '30px',
                'text-transform'    => 'none',
                'color'             => '#848991',    
                'letter-spacing'    => '0px',
            )
        ), 
    )
);
return $woocommerce;