<?php
$buttons = array ( 
    'Buttons' => array (
        'button_common'         => array (
            'label'             => __( 'Button General', 'exponent' ),
            'selector'          => '.tatsu-button, input[type = "submit"], button[type="submit"], .cart_totals a.checkout-button',
            'img'               => '',
            'responsive'        => true,
            'options'           => array (
                'font-family'       => 'schemes:primary',
                'font-variant'      => '600',
            )    
        ),
        'button_small'     => array (
            'label'         => __( 'Small Button', 'exponent' ),
            'selector'      => '.smallbtn, .exp-success-message__content a',
            'img'           => '',
            'responsive'    => true,
            'options'       => array (
                'font-size'         => '12px',
                'line-height'       => '12px',
                'letter-spacing'    => '1px',
                'text-transform'    => 'uppercase',
            )
        ),
        'button_medium'     => array (
            'label'         => __( 'Medium Button', 'exponent' ),
            'selector'      => '.mediumbtn, input[type = "submit"], div.wpforms-container-full .wpforms-form .wpforms-submit-container button[type=submit], .woocommerce-mini-cart__buttons a, .woocommerce-address-fields button[name = "save_address"], .woocommerce-EditAccountForm button[name = "save_account_details"], .exp-quick-view, .single_add_to_cart_button, .coupon button, button[name = "calc_shipping"], .woocommerce-form-coupon button[name = "apply_coupon"], .woocommerce-form-login button[name="login"], .woocommerce-form-register button[name="register"]',
            'img'           => '',
            'responsive'    => true,
            'options'       => array (
                'font-size'         => '12px',
                'line-height'       => '12px',
                'letter-spacing'    => '1px',
                'text-transform'    => 'uppercase',
            )
        ),
        'button_large'     => array (
            'label'         => __( 'Large Button', 'exponent' ),
            'selector'      => '.largebtn, .cart_totals .checkout-button, button[name = "woocommerce_checkout_place_order"]',
            'img'           => '',
            'responsive'    => true,
            'options'       => array (
                'font-size'         => '13px',
                'line-height'       => '13px',
                'letter-spacing'    => '1px',
                'text-transform'    => 'uppercase',
            )
        ),
        'button_xlarge'     => array (
            'label'         => __( 'XL Button', 'exponent' ),
            'selector'      => '.x-largebtn',
            'img'           => '',
            'responsive'    => true,
            'options'       => array (
                'font-size'         => '14px',
                'line-height'       => '14px',
                'letter-spacing'    => '1px',
                'text-transform'    => 'uppercase',
            )
        ),
        'button_block'     => array (
            'label'         => __( 'Block Button (Full Width)', 'exponent' ),
            'selector'      => '.tatsu-button-wrap.blockbtn .tatsu-button, .tatsu-button.blockbtn',
            'img'           => '',
            'responsive'    => true,
            'options'       => array (
                'font-size'         => '14px',
                'line-height'       => '14px',
                'letter-spacing'    => '1px',
                'text-transform'    => 'uppercase',
            )
        ),
        'animated_link'         => array (
            'label'         => __( 'Animated Links', 'exponent' ),
            'selector'      => '.tatsu-animated-link-inner',
            'img'           => '',
            'responsive'    => true,
            'options'       => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '12px',
                'line-height'       => '12px',
                'color'             => '#343638',
                'letter-spacing'    => '1px',
                'font-variant'      => '600',
                'text-transform'    => 'uppercase',
            ),
        ),
        
    ),
);

return $buttons;