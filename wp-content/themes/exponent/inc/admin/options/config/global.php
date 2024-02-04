<?php 

Be_Options::add_section( 'global_theme_options', array(
    'title' => __( 'Global Site Settings', 'exponent' )
) );

Be_Options::add_field( array(
	'type'        => 'background',
	'settings'    => 'body_bg',
	'label'       => __( 'Body Background', 'exponent' ),
	'section'     => 'global_theme_options',
    'default'     => array(
		'background-color'      => 'rgba(255, 255, 255, 1)',
    ),
) );

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Header and Footer', 'exponent' ),
    'section'   => 'global_theme_options'
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'enable_header',
    'label'       => __( 'Show Header', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => '1',
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'enable_footer',
    'label'       => __( 'Show Footer', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => '1',
) );

Be_Options::add_field( array (
    'type'        => 'textarea',
    'settings'    => 'footer_content',
    'label'       => __( 'Footer Content', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => 'Copyright 2019 Brand Exponents. All Rights Reserved',
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'enable_footer_widgets',
    'label'       => __( 'Show Footer Widgets', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => '1',
) );

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Page Title', 'exponent' ),
    'section'   => 'global_theme_options'
) );

Be_Options::add_field( array (
    'type'          => 'multicheck',
    'settings'      => 'posts_with_entry_header',
    'label'         => __( 'Show Page Title in', 'exponent' ),
    'section'       => 'global_theme_options',
    'default'       => array('page', 'post'),
    'choices'       => array (
        'page'      => 'Page',
        'post'      => 'Post Archive',
        'portfolio' => 'Portfolio',
        'portfolio_archive' => 'Portfolio Archive'
    )
) );

Be_Options::add_field( array (
    'type'        => 'number',
    'settings'    => 'entry_header_pad',
    'label'       => __( 'Title Top & Bottom Padding', 'exponent' ),
    'section'     => 'global_theme_options',
    'description' => __( 'Values entered are in pixels (px)', 'exponent' ),
    'default'     => '80',
) );

Be_Options::add_field( array (
        'type'          => 'background',
        'settings'      => 'entry_header_bg',
        'label'         => __( 'Page Title - Background', 'exponent' ),
        'section'       => 'global_theme_options',
        'default'       => array (
            'background-color'     => '#F5F6FA',
        )
    )
);

Be_Options::add_field( array (
        'type'          => 'color',
        'settings'      => 'entry_header_color',
        'label'         => __( 'Title Color', 'exponent' ),
        'section'       => 'global_theme_options',
        'default'       => '#313233',
        'choices'     => array(
            'alpha' => true,
        )
    )
);

Be_Options::add_field( array (
        'type'          => 'color',
        'settings'      => 'entry_header_nav_color',
        'label'         => __( 'Breadcrumb Color', 'exponent' ),
        'section'       => 'global_theme_options',
        'default'       => '',
        'choices'     => array(
            'alpha' => true,
        )
    )
);

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Navigation bar', 'exponent' ),
    'section'   => 'global_theme_options'
) );

Be_Options::add_field( array (
    'type'          => 'multicheck',
    'settings'      => 'posts_with_nav',
    'label'         => __( 'Show Navigation Bar in', 'exponent' ),
    'section'       => 'global_theme_options',
    'default'       => array( 'post', 'portfolio' ),
    'choices'       => array (
        'post'      => 'Post',
        'portfolio' => 'Portfolio',
    )
) );

Be_Options::add_field( array (
    'type'        => 'number',
    'settings'    => 'posts_nav_pad',
    'label'       => __( 'Navigation Bar Padding', 'exponent' ),
    'section'     => 'global_theme_options',
    'description' => __( 'Top & Bottom in pixels (px)', 'exponent' ),
    'default'     => '20',
) );

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Forms and Buttons', 'exponent' ),
    'section'   => 'global_theme_options'
) );

Be_Options::add_field( array (
    'type'        => 'select',
    'settings'    => 'form_style',
    'label'       => esc_attr__( 'Form Style', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => 'rounded',
    'choices'   => array (
        'rounded'                    => esc_attr__( 'Solid', 'exponent' ),
        'border-with-underline'   => esc_attr__( 'Line', 'exponent' ),
        'rounded-with-underline'   => esc_attr__( 'Rounded - Inner Shadow', 'exponent' ),
        'pill'                 => esc_attr__( 'Pill', 'exponent' ),
    )
) );

Be_Options::add_field( array (
    'type'        => 'select',
    'settings'    => 'button_style',
    'label'       => esc_attr__( 'Button Style', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => 'rounded',
    'choices'   => array (
        'rounded'     => esc_attr__( 'Rounded', 'exponent' ),
        'pill'  => esc_attr__( 'Pill', 'exponent' ),
        'rounded-block' => esc_attr__( 'Rounded Full Width', 'exponent' ),
        'pill-block'    => esc_attr__( 'Pill - Full Width', 'exponent' ),
    )
) );

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Performance', 'exponent' ),
    'section'   => 'global_theme_options'
) );

Be_Options::add_field( array (
    'type'        => 'select',
    'settings'    => 'page_loader',
    'label'       => __( 'Show Page Loader', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => 'none',
    'choices'   => array (
        'none' => esc_attr__( 'None', 'exponent' ),
        'spin'     => esc_attr__( 'Spin', 'exponent' ),
        'ring'  => esc_attr__( 'Ring', 'exponent' ),
        'ellipsis' => esc_attr__( 'Ellipsis', 'exponent' ),
        'ripple'    => esc_attr__( 'Ripple', 'exponent' ),
    )
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'lazy_load',
    'label'       => __( 'Lazy Load Images', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => '0',
) );

Be_Options::add_field( array(
        'type'        => 'toggle',
        'settings'    => 'minify_assets',
        'label'       => __( 'Minify CSS and JS', 'exponent' ),
        'section'     => 'global_theme_options',
        'default'     => '0',
) );

Be_Options::add_field( array(
    'type'        => 'toggle',
    'settings'    => 'site_status',
    'label'       => __( 'Cache Dynamic Css ', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => '0',
) );


Be_Options::add_field( array(
    'type'        => 'text',
    'settings'    => 'cdn_address',
    'label'       => __( 'CDN URL', 'exponent' ),
    'section'     => 'global_theme_options',
    'description' => __( 'Enter the CDN URL without trailing slash. ( to load async JS files from a CDN )', 'exponent' ),
    'default'     => '',
)
);

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Maintenance Mode', 'exponent' ),
    'section'   => 'global_theme_options'
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'maintenance_mode_on',
    'label'       => __( 'Maintenance Mode', 'exponent' ),
    'description' => __( 'For users, not logged into the site', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => '0',
) );

Be_Options::add_field( array (
    'type'        => 'select',
    'settings'    => 'maintenance_mode_page',
    'label'       => __( 'Page for Maintenance Mode', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => 'none',
    'choices'     => exponent_get_all_pages()
) );

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Other Settings', 'exponent' ),
    'section'   => 'global_theme_options'
) );

Be_Options::add_field( array(
        'type'        => 'slider',
        'settings'    => 'gallery_aspect_ratio',
        'label'       => __( 'Gallery Aspect Ratio', 'exponent' ),
        'section'     => 'global_theme_options',
        'default'     => 1.6, 
        'choices'     => array(
            'min'  => 0.1,
            'max'  => 3,
            'step' => 0.1,
        ),
    )
);

Be_Options::add_field( array(
    'type'        => 'text',
    'settings'    => 'instagram_token',
    'label'       => __( 'Instagram Access Token', 'exponent' ),
    'section'     => 'global_theme_options',
    'description' => __( 'Enter the Instagram Acces Key', 'exponent' ),
    'default'     => '',
));

Be_Options::add_field( array(
    'type'        => 'toggle',
    'settings'    => 'back_to_top_btn',
    'label'       => __( 'Show Back to top Button', 'exponent' ),
    'section'     => 'global_theme_options',
    'default'     => '1',
    )
);

Be_Options::add_field( array(
	'type'        => 'repeater',
	'label'       => __( 'Custom Sidebars', 'exponent' ),
	'section'     => 'global_theme_options',
	'priority'    => 10,
	'row_label'   => array(
		'type'    => 'field',
        'value'   => __('Custom Sidebar', 'exponent' ),
        'field'   => 'sidebar'
	),
	'button_label' => __('Add New', 'exponent' ),
	'settings'     => 'custom_sidebar',
	'default'      => array(),
	'fields' => array(
		'sidebar' => array(
			'type'        => 'text',
			'label'       => __( 'Sidebar Name', 'exponent' ),
			'default'     => '',
		),
	)
) );

Be_Options::add_field( array(
        'type'        => 'toggle',
        'settings'    => 'comments_on_page',
        'label'       => __( 'Show Comments on Pages', 'exponent' ),
        'section'     => 'global_theme_options',
        'default'     => '1',
    )
);

Be_Options::add_field( array(
        'type'        => 'code',
        'settings'    => 'custom_js',
        'label'       => __( 'Additional JS', 'exponent' ),
        'section'     => 'global_theme_options',
        'default'     => '',
        'choices'     => [
            'language' => 'javascript',
        ],
    )
);