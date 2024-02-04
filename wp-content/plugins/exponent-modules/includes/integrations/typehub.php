<?php
if( !function_exists( 'exponent_modules_typehub_add_options' ) ) {
    function exponent_modules_typehub_add_options() {
        $modules = array (
            'countdown_number'   =>   array (
                'label'        => __( 'Countdown', 'exponent-modules' ),
                'selector'     => '.exp-countdown-wrap .countdown-amount',
                'img'          => '',
                'options'      => array (
                    'font-family'       => 'schemes:primary',
                    'font-size'         => '50px',
                    'line-height'       => '2',
                    'letter-spacing'    => '0px',
                    'font-variant'      => '400',
                )
            ),
            'countdown_caption'  =>   array (
                'label'        => __( 'Countdown Caption', 'exponent-modules' ),
                'selector'     =>  '.exp-countdown-wrap .countdown-period',
                'img'          => '',
                'options'      => array (
                    'font-family'       => 'schemes:primary',
                    'font-size'         => '15px',
                    'line-height'       => '1.7em',
                    'letter-spacing'    => '0px',
                    'font-variant'      => '400',
                    'text-transform'    => 'none',    
                )
            )
        );
        typehub_register_options( $modules, 'Exponent Modules' );
    }
    add_action( 'typehub_register_options', 'exponent_modules_typehub_add_options', 11 );
}
