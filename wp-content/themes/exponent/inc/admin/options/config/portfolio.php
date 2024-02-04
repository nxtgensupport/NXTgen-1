<?php

Be_Options::add_section( 'portfolio_archive_options', array(
    'title' => __( 'Portfolio Settings', 'exponent' ),
) );

Be_Options::add_field( array(
    'type'        => 'text',
    'settings'    => 'portfolio_slug',
    'label'       => __( 'Portfolio Slug', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'default'     => '',
) );

Be_Options::add_field( array(
    'type'        => 'text',
    'settings'    => 'portfolio_home_url',
    'label'       => __( 'Portfolio Home URL', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'default'     => '',
) );

Be_Options::add_field( array(
        'type'        => 'slider',
        'settings'    => 'portfolio_aspect_ratio',
        'label'       => __( 'Portfolio Aspect Ratio', 'exponent' ),
        'section'     => 'portfolio_archive_options',
        'default'     => 1.6, 
        'choices'     => array(
            'min'  => 0.1,
            'max'  => 3,
            'step' => 0.1,
        ),
    )
);

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Portfolio Archive Settings', 'exponent' ),
    'section'   => 'portfolio_archive_options'
) );

Be_Options::add_field( array (
    'type'        => 'radio-buttonset',
    'settings'    => 'portfolio_column_count',
    'label'       => __( 'No. of Columns (Items Per Row )', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'default'     => '3',
    'choices'     => array (
        '1'        => __( 'One', 'exponent' ),
        '2'      => __( 'Two', 'exponent' ),
        '3'       => __( 'Three', 'exponent' ),
        '4'       => __( 'Four', 'exponent' ),
        '5'       => __( 'Five', 'exponent' ),
    )
) );

Be_Options::add_field( array (
    'type'        => 'select',
    'settings'    => 'portfolio_gutter_style',
    'label'       => __( 'Spacing on Either Sides', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'default'     => 'style1',
    'choices'     => array (
        'style1'        => __( 'With Spacing', 'exponent' ),
        'style2'        => __( 'Without Spacing', 'exponent' ),
    )
) );

Be_Options::add_field( array (
    'type'        => 'number',
    'settings'    => 'portfolio_gutter_width',
    'label'       => __( 'Gutter Width', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'description' => __( 'Values entered are in pixels', 'exponent' ),
    'default'     => '40',
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'portfolio_masonry',
    'label'       => __( 'Masonry Layout', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'default'     => '0',
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'portfolio_lazy_load',
    'label'       => __( 'Lazy Load Images', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'default'     => '0',
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'portfolio_delay_load',
    'label'       => __( 'Reveal Items only On Scroll', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'default'     => '1',
) );

Be_Options::add_field( array (
    'type'          => 'color',
    'settings'      => 'portfolio_grid_placeholder_color',
    'label'         => __( 'Image Placehoder Background', 'exponent' ),
    'description'   => __( 'during lazy load', 'exponent' ),
    'section'       => 'portfolio_archive_options',
    'default'       => '',
    'choices'     => array(
        'alpha' => true,
    )
) );

Be_Options::add_field( array (
    'type'        => 'number',
    'settings'    => 'portfolio_item_count',
    'label'       => __( 'Number of Items', 'exponent' ),
    'description'   => __( 'Enter -1 to load all items', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'default'     => '-1',
) );

Be_Options::add_field( array (
    'type'        => 'select',
    'settings'    => 'portfolio_load_animation',
    'label'       => __( 'Image Load Animation', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'default'     => 'fadeIn',
    'choices'     => array (
        'init-slide-left' => __( 'Slide Left', 'exponent' ),
        'init-slide-right' => __( 'Slide Right', 'exponent' ),
        'init-slide-top' => __( 'Slide Top', 'exponent' ),
        'init-slide-bottom' => __( 'Slide Bottom', 'exponent' ),
        'init-scale' => __( 'Scale', 'exponent' ),
        'fadeIn' => __( 'Fade In', 'exponent' ),
        'none' => __( 'None', 'exponent' ),
    )
) );

Be_Options::add_field( array (
    'type'        => 'select',
    'settings'    => 'portfolio_hover_style',
    'label'       => __( 'Hover Style', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'default'     => 'style1',
    'choices'     => array (
        'style1'        => __( 'Style 1', 'exponent' ),
        'style2'        => __( 'Style 2', 'exponent' ),
        'style3'        => __( 'Style 3', 'exponent' ),
        'style4'        => __( 'Style 4', 'exponent' ),
    )
) );

Be_Options::add_field( array (
    'type'          => 'color',
    'settings'      => 'portfolio_thumb_overlay_color',
    'label'         => __( 'Thumb Overlay Color', 'exponent' ),
    'section'       => 'portfolio_archive_options',
    'default'       => 'rgba(0,0,0,0.4)',
    'choices'     => array(
        'alpha' => true,
    )
) );

Be_Options::add_field( array (
    'type'          => 'color',
    'settings'      => 'portfolio_title_color',
    'label'         => __( 'Title Color', 'exponent' ),
    'section'       => 'portfolio_archive_options',
    'default'       => 'rgba(255,255,255,1)',
    'choices'     => array(
        'alpha' => true,
    )
) );

Be_Options::add_field( array (
    'type'          => 'color',
    'settings'      => 'portfolio_cat_color',
    'label'         => __( 'Category Color', 'exponent' ),
    'section'       => 'portfolio_archive_options',
    'default'       => 'rgba(255,255,255,1)',
    'choices'     => array(
        'alpha' => true,
    )
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'portfolio_hide_cat',
    'label'       => __( 'Hide Categories ?', 'exponent' ),
    'section'     => 'portfolio_archive_options',
    'default'     => '0',
) );