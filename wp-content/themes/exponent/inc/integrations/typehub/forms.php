<?php

$form = array(
    'Forms' => array (
        'form_core_typo'   =>   array (
            'label'        => __( 'Form Entries', 'exponent' ),
            'selector'     => sprintf( '.%1$s input:not([type = "submit"]), .%1$s textarea, .%1$s select, input, select, textarea, .select2-container--default .select2-selection--single .select2-selection__rendered, .select2-container--default .select2-selection--single .select2-selection__rendered', be_themes_get_class( 'form' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/form_core_typo.jpg',
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '15px',
                'line-height'       => '1.7em',
                'color'             => '#343638',
                'letter-spacing'    => '0px',
                'font-variant'      => '600',
                'text-transform'    => 'none',
            )
        ),
        'form_label_typo'  =>   array (
            'label'        => __( 'Form Label / Placeholder', 'exponent' ),
            'selector'     =>  sprintf( '.%s %s, .%1$s ::-webkit-input-placeholder, .%s', be_themes_get_class( 'form' ), 'label', be_themes_get_class( 'searchform-icon' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/form_label_typo.jpg',
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '15px',
                'line-height'       => '1.7em',
                'color'             => 'rgba(0,0,0,0.45)',
                'letter-spacing'    => '0px',
                'font-variant'      => '600',
                'text-transform'    => 'none',    
            )
        )
    )
);

return $form;