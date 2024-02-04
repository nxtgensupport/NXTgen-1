<?php
$sidebar = array ( 
    'Sidebar' => array (
        'sidebar_title'             => array (
            'label'                 => __( 'Sidebar Heading', 'exponent' ),
            'selector'              => sprintf( '.%s h6', be_themes_get_class( 'sidebar' ) ),
            'img'                   => get_template_directory_uri().'/img/typehub/sidebar_title.jpg',
            'responsive'            => true,
            'options'               => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '16px',
                'font-variant'      => '600',
                'line-height'       => '1',
                'text-transform'    => 'none',
                'color'             => '#343638',    
                'letter-spacing'    => '25px',
            ),
        ),
        'sidebar_content'             => array (
            'label'                 => __( 'Sidebar Content', 'exponent' ),
            'selector'              => sprintf( '.%s', be_themes_get_class( 'sidebar' ) ),
            'img'                   => get_template_directory_uri().'/img/typehub/sidebar_content.jpg',
            'responsive'            => true,
            'options'               => array (
                'font-family'       => 'schemes:secondary',
                'font-size'         => '16px',
                'font-variant'      => '400',
                'line-height'       => '28px',
                'text-transform'    => 'none',
                'color'             => '#848991',    
                'letter-spacing'    => '0px',
            ),
        )        
    )
);
return $sidebar;