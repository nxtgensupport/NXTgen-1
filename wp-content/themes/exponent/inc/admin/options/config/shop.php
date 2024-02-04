<?php

    /**
     * Shop archive settings
     */

    Be_Options::add_field( array (
        'type'      => 'be_title',
        'settings'  => be_themes_get_options_decorator_setting(),
        'label'     => __( 'Shop Page', 'exponent' ),
        'section'   => 'woocommerce_product_catalog'
    ) );

    Be_Options::add_field( array (
        'type'        => 'toggle',
        'settings'    => 'wc_archive_full_width',
        'label'       => esc_attr__( 'Full Width', 'exponent' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => 3,
        'choices'     => array(
            'min'  => '1',
            'max'  => '6',
            'step' => '1',
        ),
    ) );

    Be_Options::add_field( array (
        'type'        => 'toggle',
        'settings'    => 'wc_loop_sidebar',
        'label'       => __( 'Show Sidebar', 'exponent' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => '0',
    ) );
    
    Be_Options::add_field( array (
        'type'      => 'radio-buttonset',
        'settings'  => 'wc_loop_sidebar_position',
        'label'     => __( 'Sidebar Position', 'exponent' ),
        'section'   => 'woocommerce_product_catalog',
        'default'   => 'right',
        'choices'   => array (
            'left'     => __( 'Left', 'exponent' ),
            'right'      => __( 'Right', 'exponent' )
        ),
        'required'    => array (
            array (
                'setting'   => 'wc_loop_sidebar',
                'operator'  => '==',
                'value'     => '1',
            ),
        )  
    ) );

    global $wp_registered_sidebars;
    $sidebars = array();
    foreach ( $wp_registered_sidebars as $sidebar ) {
        $sidebars[ $sidebar['id'] ] = $sidebar['name'];
    }
    Be_Options::add_field( array (
        'type'        => 'select',
        'settings'    => 'wc_loop_sidebar_name',
        'label'       => __( 'Sidebar', 'exponent' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => '',
        'choices'     => $sidebars,
        'required'    => array (
            array (
                'setting'   => 'wc_loop_sidebar',
                'operator'  => '==',
                'value'     => '1',
            ),
        )  
    ) );

    Be_Options::add_field( array (
        'type'        => 'radio-buttonset',
        'settings'    => 'wc_loop_pagination_alignment',
        'label'       => __( 'Pagination Alignment', 'exponent' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => 'left',
        'choices'     => array (
            'left'        => __( 'Left', 'exponent' ),
            'center'      => __( 'Center', 'exponent' ),
            'right'       => __( 'Right', 'exponent' ),
        )
    ) );

    Be_Options::add_field( array (
        'type'        => 'slider',
        'settings'    => 'woocommerce_catalog_6_cols',
        'label'       => esc_attr__( 'Products per Row', 'exponent' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => 3,
        'choices'     => array(
            'min'  => '2',
            'max'  => '6',
            'step' => '1',
        ),
        'required'      => array (
            array (
                'setting'       => 'wc_loop_sidebar',
                'operator'      => '==',
                'value'         => '0'
            ),
            array (
                'setting'       => 'wc_archive_full_width',
                'operator'      => '==',
                'value'         => '1'
            )
        ),
    ) );

    Be_Options::add_field( array (
        'type'        => 'slider',
        'settings'    => 'woocommerce_catalog_4_cols',
        'label'       => esc_attr__( 'Products per Row', 'exponent' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => 3,
        'choices'     => array(
            'min'  => '2',
            'max'  => '4',
            'step' => '1',
        ),
        'required'      => array (
            array (
                'setting'       => 'wc_loop_sidebar',
                'operator'      => '==',
                'value'         => '1'
            ),
            array (
                'setting'       => 'wc_archive_full_width',
                'operator'      => '==',
                'value'         => '1'
            )
        ),
    ) );

    Be_Options::add_field( array (
        'type'        => 'slider',
        'settings'    => 'woocommerce_catalog_4_cols_alt',
        'label'       => esc_attr__( 'Products per Row', 'exponent' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => 3,
        'choices'     => array(
            'min'  => '2',
            'max'  => '4',
            'step' => '1',
        ),
        'required'      => array (
            array (
                'setting'       => 'wc_loop_sidebar',
                'operator'      => '==',
                'value'         => '1'
            ),
            array (
                'setting'       => 'wc_archive_full_width',
                'operator'      => '==',
                'value'         => '0'
            )
        ),
    ) );

    Be_Options::add_field( array (
        'type'        => 'slider',
        'settings'    => 'woocommerce_catalog_3_cols',
        'label'       => esc_attr__( 'Products per Row', 'exponent' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => 3,
        'choices'     => array(
            'min'  => '2',
            'max'  => '3',
            'step' => '1',
        ),
        'required'      => array (
            array (
                'setting'       => 'wc_loop_sidebar',
                'operator'      => '==',
                'value'         => '0'
            ),
            array (
                'setting'       => 'wc_archive_full_width',
                'operator'      => '==',
                'value'         => '0'
            )
        ),
    ) );

    Be_Options::add_field( array (
        'type'        => 'toggle',
        'settings'    => 'wc_loop_mobile_two_cols',
        'label'       => __( 'Enable 2 column layout in mobile', 'exponent' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => '0',
    ) );

    
    Be_Options::add_field( array (
        'type'        => 'select',
        'settings'    => 'wc_grid_gutter',
        'label'       => esc_attr__( 'Spacing Between Products', 'exponent' ),
        'section'     => 'woocommerce_product_catalog',
        'default'     => 'medium',
        'choices'   => array (
            'tiny'          => esc_attr__( 'Tiny', 'exponent' ),
            'small'          => esc_attr__( 'Small', 'exponent' ),
            'medium'  => esc_attr__( 'Medium', 'exponent' ),
            'large' => esc_attr__( 'Large', 'exponent' ),
        )
    ) );

    Be_Options::add_field( array (
        'type'      => 'be_title',
        'settings'  => be_themes_get_options_decorator_setting(),
        'label'     => __( 'Shop Title', 'exponent' ),
        'section'   => 'woocommerce_product_catalog'
    ) );

    Be_Options::add_field( array (
        'type'      => 'toggle',
        'settings'   => 'wc_enable_breadcrumb',
        'label'     => __( 'Show Breadcrumbs', 'exponent' ),
        'section'   => 'woocommerce_product_catalog',
        'default'   => '1'  
    ) );

    Be_Options::add_field( array (
        'type'      => 'toggle',
        'settings'   => 'wc_enable_archive_title',
        'label'     => __( 'Show Title', 'exponent' ),
        'section'   => 'woocommerce_product_catalog',
        'default'   => '0'  
    ) );

    Be_Options::add_field( array (
        'type'      => 'toggle',
        'settings'   => 'wc_enable_orderby_filter',
        'label'     => __( 'Show Filters', 'exponent' ),
        'section'   => 'woocommerce_product_catalog',
        'default'   => '1'  
    ) );

    Be_Options::add_field( array (
        'type'      => 'be_title',
        'settings'  => be_themes_get_options_decorator_setting(),
        'label'     => __( 'Meta Settings', 'exponent' ),
        'section'   => 'woocommerce_product_catalog'
    ) );

    Be_Options::add_field( array(
        'type'       => 'toggle',
        'settings'   => 'wc_alt_image_on_hover',
        'label'      => __( 'Show secondary image on Hover', 'exponent' ),
        'section'    => 'woocommerce_product_catalog',
        'default'    => '1',
    ) ); 

    Be_Options::add_field( array (
        'type'      => 'toggle',
        'settings'  => 'wc_enable_quick_view',
        'label'     => __( 'Quick View', 'exponent' ),
        'section'   => 'woocommerce_product_catalog',
        'default'   => '1'
    ) );

    Be_Options::add_field( array (
        'type'      => 'toggle',
        'settings'  => 'wc_enable_archive_category',
        'label'     => __( 'Show Category Meta', 'exponent' ),
        'section'   => 'woocommerce_product_catalog',
        'default'   => '1'
    ) );

    Be_Options::add_field( array (
        'type'          => 'toggle',
        'settings'      => 'wc_enable_archive_rating',
        'label'         => __( 'Show Rating', 'exponent' ),
        'section'       => 'woocommerce_product_catalog',
        'default'       => '1'
    ) );

    Be_Options::add_field( array (
        'type'          => 'toggle',
        'settings'      => 'wc_enable_archive_price',
        'label'         => __( 'Show Price', 'exponent' ),
        'section'       => 'woocommerce_product_catalog',
        'default'       => '1'
    ) );

    if( class_exists( 'YITH_WCWL' ) ) {
        Be_Options::add_field( array (
            'type'      => 'toggle',
            'settings'  => 'wc_enable_add_to_wishlist',
            'label'     => __( 'Enable Add to Wishlist', 'exponent' ),
            'section'   => 'woocommerce_product_catalog',
            'default'   => '0'
        ) );
    }

    Be_Options::add_field( array(
        'type'      => 'be_title',
        'settings'  => be_themes_get_options_decorator_setting(),
        'label'     => __( 'Add to cart', 'exponent' ),
        'section'   => 'woocommerce_product_catalog'
    ) );

    Be_Options::add_field( array (
        'type'      => 'toggle',
        'settings'   => 'wc_enable_add_to_cart',
        'label'     => __( 'Enable Add to cart', 'exponent' ),
        'section'   => 'woocommerce_product_catalog',
        'default'   => '1'
    ) );

    Be_Options::add_field( array (
        'type'      => 'radio-buttonset',
        'settings'  => 'wc_add_to_cart_style',
        'label'     => __( 'Add to Cart Style', 'exponent' ),
        'section'   => 'woocommerce_product_catalog',
        'default'   => 'button',
        'choices'   => array (
            'button'    => esc_attr__( 'Button', 'exponent' ),
            'icon'      => esc_attr__( 'Icon', 'exponent' )
        )
    ) );

    Be_Options::add_field( array (
        'type'          => 'toggle',
        'settings'      => 'wc_archive_show_cart_on_hover',
        'label'         => __( 'Show Add to Cart only on Hover', 'exponent' ),
        'section'       => 'woocommerce_product_catalog',
        'default'       => '0'
    ) );

    /**
     * Single Product Settings
     */
    Be_Options::add_section( 'woocommerce_single_product', array(
        'title' => __( 'Product Page', 'exponent' ),
        'panel' => 'woocommerce',
    ) );

    Be_Options::add_field( array (
        'type'      => 'toggle',
        'settings'  => 'wc_single_product_breadcrumbs',
        'label'     => __( 'Show Breadcrumbs', 'exponent' ),
        'section'   => 'woocommerce_single_product',
        'default'   => '1'
    ) );

    Be_Options::add_field( array (
        'type'      => 'toggle',
        'settings'  => 'wc_single_product_meta',
        'label'     => __( 'Show SKU and Meta data (category & tags )', 'exponent' ),
        'section'   => 'woocommerce_single_product',
        'default'   => '1'
    ) );

    Be_Options::add_field( array (
        'type'      => 'toggle',
        'settings'  => 'wc_single_product_gallery_zoom',
        'label'     => __( 'Zoom Product image on hover', 'exponent' ),
        'description'   => __( 'Works only with default single product template', 'exponent' ),
        'section'   => 'woocommerce_single_product',
        'default'   => '0'
    ) );


    Be_Options::add_field( array (
        'type'        => 'slider',
        'settings'    => 'woocommerce_related_products_count',
        'label'       => __( 'No of Related Products per Page', 'exponent' ),
        'section'     => 'woocommerce_single_product',
        'default'     => 4,
        'choices'     => array(
            'min'  => '4',
            'max'  => '12',
            'step' => '1',
        ),
    ) );