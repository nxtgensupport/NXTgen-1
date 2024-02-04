<?php 
//panel
Kirki::add_panel( 'blog_panel', array(
    'priority'    => 10,
    'title'       => __( 'Blog Settings', 'exponent' ),
) );

//sections
Be_Options::add_section( 'blog_loop', array(
    'title'     => __( 'Post Archive', 'exponent' ),
    'panel'     => 'blog_panel'
) );
Be_Options::add_section( 'blog_single', array(
    'title'     => __( 'Individual Post', 'exponent' ),
    'panel'     => 'blog_panel'
) );

//loop section options
Be_Options::add_field( array (
    'type'        => 'select',
    'settings'    => 'blog_archive_style',
    'label'       => __( 'Style', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => 'style1',
    'choices'     => array (
        'style1'        => __( 'Style 1', 'exponent' ),
        'style2'        => __( 'Style 2', 'exponent' ),
        'style3'        => __( 'Style 3', 'exponent' ),
        'style4'        => __( 'Style 4', 'exponent' ),
        'style5'        => __( 'Style 5', 'exponent' ),
        'style6'        => __( 'Style 6', 'exponent' ),
        'style7'        => __( 'Style 7', 'exponent' ),
    )
) );

//loop title tag
Be_Options::add_field( array (
    'type'        => 'select',
    'settings'    => 'blog_title_tag',
    'label'       => __( 'Blog Title Tag', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => 'h1',
    'choices'     => array (
        'h1'        => __( 'h1', 'exponent' ),
        'h2'        => __( 'h2', 'exponent' ),
        'h3'        => __( 'h3', 'exponent' )
    )
) );


Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_archive_auto_height_thumb',
    'label'       => __( 'Preserve Aspect Ratio of Featured Images ?', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => '0',
    'required'    => array (
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style2',
        ),
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style3',
        ),
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style5',
        ),
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style6',
        ),
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style7',
        ),
    )
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_loop_sidebar',
    'label'       => __( 'Show Sidebar ?', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => '1',
) );

Be_Options::add_field( array (
    'type'      => 'radio-buttonset',
    'settings'  => 'blog_loop_sidebar_position',
    'label'     => __( 'Sidebar Position', 'exponent' ),
    'section'   => 'blog_loop',
    'default'   => 'right',
    'choices'   => array (
        'right'     => __( 'Right', 'exponent' ),
        'left'      => __( 'Left', 'exponent' )
    ),
    'required'    => array (
        array (
            'setting'   => 'blog_loop_sidebar',
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
    'settings'    => 'blog_loop_sidebar_name',
    'label'       => __( 'Sidebar', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => '',
    'choices'     => $sidebars,
    'required'    => array (
        array (
            'setting'   => 'blog_loop_sidebar',
            'operator'  => '==',
            'value'     => '1',
        ),
    )
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_loop_sidebar_sticky',
    'label'       => __( 'Sticky Sidebar ?', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => '0',
    'required'    => array (
        array (
            'setting'   => 'blog_loop_sidebar',
            'operator'  => '==',
            'value'     => '1',
        ),
    )
) );

Be_Options::add_field( array (
    'type'        => 'radio-buttonset',
    'settings'    => 'blog_archive_alignment',
    'label'       => __( 'Alignment', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => 'left',
    'choices'     => array (
        'left'        => __( 'Left', 'exponent' ),
        'center'      => __( 'Center', 'exponent' ),
        'right'       => __( 'Right', 'exponent' ),
    )
) );

Be_Options::add_field( array (
    'type'        => 'radio-buttonset',
    'settings'    => 'blog_archive_pagination_alignment',
    'label'       => __( 'Pagination Alignment', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => 'left',
    'choices'     => array (
        'left'        => __( 'Left', 'exponent' ),
        'center'      => __( 'Center', 'exponent' ),
        'right'       => __( 'Right', 'exponent' ),
    )
) );

Be_Options::add_field( array(
	'type'        => 'toggle',
	'settings'    => 'blog_post_details_custom_pad',
	'label'       => __( 'Custom Padding for Content Box ?', 'exponent' ),
	'section'     => 'blog_loop',
) );

Be_Options::add_field( array(
	'type'        => 'dimensions',
	'settings'    => 'blog_post_detials_pad',
	'label'       => __( 'Content Box - Padding', 'exponent' ),
	'section'     => 'blog_loop',
    'description' => __( 'Values in px', 'exponent' ),
    'default'     => array (
        'top-bottom'       => '40px',
        'left-right'       => '40px'
    ),
    'required'    => array (
        array (
            'setting'   => 'blog_post_details_custom_pad',
            'operator'  => '==',
            'value'     => '1',
        )
    )
) );

Be_Options::add_field( array(
    'type'        => 'color',
	'settings'    => 'blog_post_details_color',
	'label'       => __( 'Content Box - Background', 'exponent' ),
	'section'     => 'blog_loop',
    'default'     => '',
) );

Be_Options::add_field( array (
    'type'      => 'radio-buttonset',
    'settings'  => 'blog_archive_thumb_shadow',
    'label'     => __( 'Image - Shadow', 'exponent' ),
    'section'   => 'blog_loop',
    'default'   => 'none',
    'choices'   => array (
        'none'      => __( 'None', 'exponent' ),
        'light'     => __( 'Light', 'exponent' ),
        'medium'    => __( 'Medium', 'exponent' ),
        'dark'      => __( 'Dark', 'exponent' ),
    ),
    'required'    => array (
        array (
            array (
                'setting'   => 'blog_archive_style',
                'operator'  => '==',
                'value'     => 'style1',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'operator'  => '==',
                'value'     => 'style2',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'operator'  => '==',
                'value'     => 'style4',
            ),
        ),
    ),
) );

Be_Options::add_field( array (
    'type'      => 'radio-buttonset',
    'settings'  => 'blog_archive_shadow',
    'label'     => __( 'Content Box - Shadow', 'exponent' ),
    'section'   => 'blog_loop',
    'default'   => 'none',
    'choices'   => array (
        'none'      => __( 'None', 'exponent' ),
        'light'     => __( 'Light', 'exponent' ),
        'medium'    => __( 'Medium', 'exponent' ),
        'dark'      => __( 'Dark', 'exponent' ),
    ),
    'required'    => array (
        array (
            array (
                'setting'   => 'blog_archive_style',
                'operator'  => '==',
                'value'     => 'style1',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'operator'  => '==',
                'value'     => 'style2',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'operator'  => '==',
                'value'     => 'style3',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'operator'  => '==',
                'value'     => 'style7',
            ),
        ),
    ),
) );

Be_Options::add_field( array(
	'type'        => 'number',
	'settings'    => 'blog_archive_border_radius',
	'label'       => __( 'Image - Border Radius', 'exponent' ),
	'section'     => 'blog_loop',
    'default'     => 5,
    'description' => __( 'Values in px', 'exponent' ),  
	'choices'     => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
) );

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Meta Settings', 'exponent' ),
    'section'   => 'blog_loop'
) );

Be_Options::add_field( array(
    'type'       => 'sortable',
    'settings'   => 'blog_loop_primary_meta',
    'label'      => __( 'Primary Meta', 'exponent' ),
    'section'    => 'blog_loop',
    'default'    => array( 'categories' ),
    'choices'    => array(
        'categories'        => __( 'Categories', 'exponent' ),
        'author'            => __( 'Author', 'exponent' ),
        'date'              => __( 'Date', 'exponent' ),
    ),
) );

Be_Options::add_field( array(
    'type'       => 'sortable',
    'settings'   => 'blog_loop_secondary_meta',
    'label'      => __( 'Secondary Meta', 'exponent' ),
    'section'    => 'blog_loop',
    'default'    => array( 'author', 'date' ),
    'choices'    => array(
        'categories'        => __( 'Categories', 'exponent' ),
        'author'            => __( 'Author', 'exponent' ),
        'date'              => __( 'Date', 'exponent' ),
    ),
) );

Be_Options::add_field( array(
    'type'       => 'sortable',
    'settings'   => 'blog_loop_tertiary_meta',
    'label'      => __( 'Tertiary Meta', 'exponent' ),
    'section'    => 'blog_loop',
    'default'    => array(),
    'choices'    => array(
        'categories'        => __( 'Categories', 'exponent' ),
        'author'            => __( 'Author', 'exponent' ),
        'date'              => __( 'Date', 'exponent' ),
    ),
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_loop_meta_author_image',
    'label'       => __( 'Show Author Profile Photo ?', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => '0',
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_loop_meta_date_icon',
    'label'       => __( 'Show Date Icon ?', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => '1',
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_loop_labeled_cat',
    'label'       => __( 'Use Label Style for Category Meta ?', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => '0',
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_hide_content',
    'label'       => __( 'Hide Content ?', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => '0',
) );

Be_Options::add_field( array (
    'type'      => 'radio-buttonset',
    'settings'  => 'blog_read_more_style',
    'label'     => __( 'Read More Style', 'exponent' ),
    'section'   => 'blog_loop',
    'default'   => 'underlined',
    'choices'   => array (
        'underlined'     => __( 'Underlined', 'exponent' ),
        'dots'           => __( 'Dotted', 'exponent' )
    )
) );

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Grid Style Settings', 'exponent' ),
    'section'   => 'blog_loop',
    'required'  => array (
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style1',
        ),
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style4',
        ),
    )
) );

Be_Options::add_field( array(
    'type'        => 'toggle',
	'settings'    => 'blog_grid_full_width',
	'label'       => __( 'Full Width Layout', 'exponent' ),
	'section'     => 'blog_loop',
    'default'     => '0',
    'required'  => array (
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style1',
        ),
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style4',
        ),
    )
) );

Be_Options::add_field( array (
    'type'        => 'slider',
    'settings'    => 'blog_loop_normal_3_cols',
    'label'       => __( 'Posts per Row', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => 3,
    'choices'     => array(
        'min'  => '2',
        'max'  => '3',
        'step' => '1',
    ),
    'required'  => array (
        array (
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style2',
                'operator'  => '==',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style5',
                'operator'  => '==',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style6',
                'operator'  => '==',
            ), 
        ),
        array ( 
            'setting'   => 'blog_grid_full_width',
            'value'     => '0',
            'operator'  => '==',
        ),
        array (
            'setting'   => 'blog_loop_sidebar',
            'value'     => '1',
            'operator'  => '==',
        )
    ),
) );

Be_Options::add_field( array (
    'type'        => 'slider',
    'settings'    => 'blog_loop_normal_4_cols',
    'label'       => __( 'Posts per Row', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => 3,
    'choices'     => array(
        'min'  => '2',
        'max'  => '4',
        'step' => '1',
    ),
    'required'  => array (
        array (
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style2',
                'operator'  => '==',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style5',
                'operator'  => '==',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style6',
                'operator'  => '==',
            ), 
        ),
        array ( 
            'setting'   => 'blog_grid_full_width',
            'value'     => '0',
            'operator'  => '==',
        ),
        array (
            'setting'   => 'blog_loop_sidebar',
            'value'     => '0',
            'operator'  => '==',
        )
    ),
) );

Be_Options::add_field( array (
    'type'        => 'slider',
    'settings'    => 'blog_loop_normal_4_cols_alt',
    'label'       => __( 'Posts per Row', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => 3,
    'choices'     => array(
        'min'  => '2',
        'max'  => '4',
        'step' => '1',
    ),
    'required'  => array (
        array (
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style2',
                'operator'  => '==',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style5',
                'operator'  => '==',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style6',
                'operator'  => '==',
            ), 
        ),
        array ( 
            'setting'   => 'blog_grid_full_width',
            'value'     => '1',
            'operator'  => '==',
        ),
        array (
            'setting'   => 'blog_loop_sidebar',
            'value'     => '1',
            'operator'  => '==',
        )
    ),
) );

Be_Options::add_field( array (
    'type'        => 'slider',
    'settings'    => 'blog_loop_normal_5_cols',
    'label'       => __( 'Posts per Row', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => 3,
    'choices'     => array(
        'min'  => '2',
        'max'  => '5',
        'step' => '1',
    ),
    'required'  => array (
        array (
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style2',
                'operator'  => '==',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style5',
                'operator'  => '==',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style6',
                'operator'  => '==',
            ), 
        ),
        array ( 
            'setting'   => 'blog_grid_full_width',
            'value'     => '1',
            'operator'  => '==',
        ),
        array (
            'setting'   => 'blog_loop_sidebar',
            'value'     => '0',
            'operator'  => '==',
        )
    ),
) );

//metro cols
Be_Options::add_field( array (
    'type'        => 'slider',
    'settings'    => 'blog_loop_metro_4_cols',
    'label'       => __( 'Posts per Row', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => 3,
    'choices'     => array(
        'min'  => '2',
        'max'  => '4',
        'step' => '1',
    ),
    'required'  => array (
        array (
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'styl3',
                'operator'  => '==',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style7',
                'operator'  => '==',
            ),
        ),
        array ( 
            'setting'   => 'blog_grid_full_width',
            'value'     => '1',
            'operator'  => '==',
        ),
        array (
            'setting'   => 'blog_loop_sidebar',
            'value'     => '0',
            'operator'  => '==',
        )
    ),
) );

Be_Options::add_field( array (
    'type'        => 'slider',
    'settings'    => 'blog_loop_metro_3_cols',
    'label'       => __( 'Posts per Row', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => 3,
    'choices'     => array(
        'min'  => '2',
        'max'  => '3',
        'step' => '1',
    ),
    'required'  => array (
        array (
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style3',
                'operator'  => '==',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style7',
                'operator'  => '==',
            ),
        ),
        array ( 
            'setting'   => 'blog_grid_full_width',
            'value'     => '0',
            'operator'  => '==',
        ),
        array (
            'setting'   => 'blog_loop_sidebar',
            'value'     => '0',
            'operator'  => '==',
        )
    ),
) );

Be_Options::add_field( array (
    'type'        => 'slider',
    'settings'    => 'blog_loop_metro_3_cols_alt',
    'label'       => __( 'Posts per Row', 'exponent' ),
    'section'     => 'blog_loop',
    'default'     => 3,
    'choices'     => array(
        'min'  => '2',
        'max'  => '4',
        'step' => '1',
    ),
    'required'  => array (
        array (
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style3',
                'operator'  => '==',
            ),
            array (
                'setting'   => 'blog_archive_style',
                'value'     => 'style7',
                'operator'  => '==',
            ),
        ),
        array ( 
            'setting'   => 'blog_grid_full_width',
            'value'     => '1',
            'operator'  => '==',
        ),
        array (
            'setting'   => 'blog_loop_sidebar',
            'value'     => '1',
            'operator'  => '==',
        )
    ),
) );

Be_Options::add_field( array (
    'type'      => 'radio-buttonset',
    'settings'  => 'blog_gutter',
    'type'      => 'number',    
    'label'     => __( 'Spacing Between Posts', 'exponent' ),
    'section'   => 'blog_loop',
    'default'   => '20',
    'required'  => array (
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style1',
        ),
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style4',
        ),
    )
) );

Be_Options::add_field( array(
	'type'        => 'number',
	'settings'    => 'blog_aspect_ratio',
	'label'       => __( 'Blog Aspect Ratio', 'exponent' ),
	'section'     => 'blog_loop',
    'default'     => 1.25,
    'description' => __( 'Applies for Metro Grid - Style 3 and 7', 'exponent' ),  
	'choices'     => array(
		'min'  => 0,
		'max'  => 3,
		'step' => 0.01,
    ),
    'required'  => array (
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style1',
        ),
        array (
            'setting'   => 'blog_archive_style',
            'operator'  => '!=',
            'value'     => 'style4',
        ),
    )
) );

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Author Page Settings', 'exponent' ),
    'section'   => 'blog_loop'
) );

Be_Options::add_field( array (
    'type'          =>  'toggle',
    'settings'      => 'author_custom_header',
    'label'         => __( 'Show Hero Header ?', 'exponent' ),
    'section'       => 'blog_loop',
    'default'       => '0',
) );

Be_Options::add_field( array (
    'type'          => 'number',
    'settings'      => 'author_hero_height',
    'label'         => __( 'Header Height', 'exponent' ),
    'section'       => 'blog_loop',
    'default'       => '60',
    'description'   => __( 'Value entered are in viewport units.', 'exponent' ),
    'required'      => array (
        array (
            'setting'   => 'author_custom_header',
            'operator'  => '==',
            'value'     => '1',
        ),
    )
) );

Be_Options::add_field( array(
	'type'        => 'background',
	'settings'    => 'author_hero_background',
	'label'       => __( 'Header Background', 'exponent' ),
	'section'     => 'blog_loop',
    'default'     => array(
		'background-color'      => 'rgba(20,20,20,0.8)',
		'background-image'      => '',
		'background-repeat'     => 'no-repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
    ),
    'required'      => array (
        array (
            'setting'   => 'author_custom_header',
            'operator'  => '==',
            'value'     => '1',
        ),
    )
) );

Be_Options::add_field( array (
    'type'          => 'toggle',
    'settings'      => 'author_hero_overlay',
    'label'         => __( 'Enable Overlay', 'exponent' ),
    'section'       => 'blog_loop',
    'default'       => '0',
    'required'      => array (
        array (
            'setting'   => 'author_custom_header',
            'operator'  => '==',
            'value'     => '1',
        ),
    )
) );

Be_Options::add_field( array (
    'type'          => 'color',
    'settings'      => 'author_hero_overlay_color',
    'label'         => __( 'Enable Overlay', 'exponent' ),
    'section'       => 'blog_loop',
    'default'       => 'rgba(0, 0, 0, 0.5)',
    'choices'     => array(
		'alpha' => true,
    ),
    'required'      => array (
        array (
            'setting'   => 'author_custom_header',
            'operator'  => '==',
            'value'     => '1',
        ),
    )
) );

//single post settings
Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_single_title',
    'label'       => __( 'Show Single Blog Title ?', 'exponent' ),
    'section'     => 'blog_single',
    'default'     => '1',
) );

Be_Options::add_field( array (
    'type'          => 'radio-buttonset',
    'settings'      => 'single_title_style',
    'choices'       => array (
        'wide'      => __( 'Hero Header', 'exponent' ),
        'wrap'      => __( 'Normal', 'exponent' )
    ),
    'label'         => __( 'Single Post Title Style', 'exponent' ),
    'section'       => 'blog_single',
    'default'       => 'wrap',
) );

Be_Options::add_field( array (
    'type'          => 'toggle',
    'settings'      => 'blog_single_blur_thumb',
    'label'         => __( 'Lazy Load Hero Image', 'exponent' ),
    'section'       => 'blog_single',
    'default'       => '1',
    'required'      => array (
        array (
            'setting'   => 'single_title_style',
            'operator'  => '==',
            'value'     => 'wide',
        ),
    )
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_single_auto_height_thumb',
    'label'       => __( 'Preserve Aspect Ratio of Featured Images ?', 'exponent' ),
    'section'     => 'blog_single',
    'default'     => '0',
    'required'    => array (
        array (
            'setting'   => 'single_title_style',
            'operator'  => '==',
            'value'     => 'wrap',
        ),
    )
) );

Be_Options::add_field( array (
    'type'          => 'number',
    'settings'      => 'thumb_height',
    'label'         => __( 'Hero Header Height', 'exponent' ),
    'section'       => 'blog_single',
    'default'       => '60',
    'description'   => __( 'Values entered are in vh units', 'exponent' ),
    'required'      => array (
        array (
            'setting'   => 'single_title_style',
            'operator'  => '==',
            'value'     => 'wide',
        )
    ),
) );

Be_Options::add_field( array (
    'type'          => 'radio-buttonset',
    'settings'      => 'single_title_alignment',
    'choices'       => array (
        'left'      => __( 'Left', 'exponent' ),
        'center'    => __( 'Center', 'exponent' ),
        'right'     => __( 'Right', 'exponent' ),   
    ),
    'label'         => __( 'Title Horizontal Alignment', 'exponent' ),
    'section'       => 'blog_single',
    'default'       => 'center',
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_single_sidebar',
    'label'       => __( 'Show Sidebar ?', 'exponent' ),
    'section'     => 'blog_single',
    'default'     => '0',
) );

Be_Options::add_field( array (
    'type'      => 'radio-buttonset',
    'settings'  => 'blog_single_sidebar_position',
    'label'     => __( 'Sidebar Position', 'exponent' ),
    'section'   => 'blog_single',
    'default'   => 'right',
    'choices'   => array (
        'right'     => __( 'Right', 'exponent' ),
        'left'      => __( 'Left', 'exponent' )
    ),
    'required'      => array (
        array (
            'setting'   => 'blog_single_sidebar',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_single_sidebar_sticky',
    'label'       => __( 'Make Sidebar Sticky', 'exponent' ),
    'section'     => 'blog_single',
    'default'     => '0',
    'required'      => array (
        array (
            'setting'   => 'blog_single_sidebar',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array(
    'type'       => 'sortable',
    'settings'   => 'blog_single_primary_meta',
    'label'      => __( 'Primary Meta', 'exponent' ),
    'section'    => 'blog_single',
    'default'    => array( 'categories' ),
    'choices'    => array(
        'categories'        => __( 'Categories', 'exponent' ),
        'author'            => __( 'Author', 'exponent' ),
        'date'              => __( 'Date', 'exponent' ),
    ),
) );

Be_Options::add_field( array(
    'type'       => 'sortable',
    'settings'   => 'blog_single_secondary_meta',
    'label'      => __( 'Secondary Meta', 'exponent' ),
    'section'    => 'blog_single',
    'default'    => array( 'author', 'date' ),
    'choices'    => array(
        'categories'        => __( 'Categories', 'exponent' ),
        'author'            => __( 'Author', 'exponent' ),
        'date'              => __( 'Date', 'exponent' ),
    ),
) );

Be_Options::add_field( array(
    'type'       => 'sortable',
    'settings'   => 'blog_single_tertiary_meta',
    'label'      => __( 'Tertiary Meta', 'exponent' ),
    'section'    => 'blog_single',
    'default'    => array(),
    'choices'    => array(
        'categories'        => __( 'Categories', 'exponent' ),
        'author'            => __( 'Author', 'exponent' ),
        'date'              => __( 'Date', 'exponent' ),
    ),
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_single_meta_author_image',
    'label'       => __( 'Show Author Profile Photo ?', 'exponent' ),
    'section'     => 'blog_single',
    'default'     => '1',
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_single_meta_date_icon',
    'label'       => __( 'Show Date Icon ?', 'exponent' ),
    'section'     => 'blog_single',
    'default'     => '1',
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_single_labeled_cat',
    'label'       => __( 'Use Label Style for Category Meta ?', 'exponent' ),
    'section'     => 'blog_single',
    'default'     => '0',
) );

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Post Navigation Settings', 'exponent' ),
    'section'   => 'blog_single'
) );

Be_Options::add_field( array (
    'type'          => 'toggle',
    'settings'      => 'single_nav_sticky',
    'label'         => __( 'Float Navigation bar', 'exponent' ),
    'description'   => __( 'Work only when Single Posts Navigation is enabled', 'exponent' ),
    'section'       => 'blog_single',
    'default'       => '0',
    'required'      => array (
        array (
            'setting'   => 'single_nav',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array (
    'type'          => 'toggle',
    'settings'      => 'single_posts_share',
    'label'         => __( 'Show Social Share buttons ?', 'exponent' ),
    'section'       => 'blog_single',
    'default'       => '1',
) );

Be_Options::add_field( array (
    'type'      => 'be_title',
    'settings'  => be_themes_get_options_decorator_setting(),
    'label'     => __( 'Related Posts Settings', 'exponent' ),
    'section'   => 'blog_single'
) );

Be_Options::add_field( array (
    'type'          => 'toggle',
    'settings'      => 'related_posts',
    'label'         => __( 'Show Related Posts ?', 'exponent' ),
    'section'       => 'blog_single',
    'default'       => '0',
) );

Be_Options::add_field( array(
	'type'        => 'number',
	'settings'    => 'related_posts_aspect_ratio',
	'label'       => __( 'Aspect Ratio', 'exponent' ),
	'section'     => 'blog_single',
    'default'     => 1.25,
	'choices'     => array(
		'min'  => 0,
		'max'  => 3,
		'step' => 0.01,
    ),
) );


Be_Options::add_field( array (
    'type'        => 'radio-buttonset',
    'settings'    => 'related_posts_alignment',
    'label'       => __( 'Alignment', 'exponent' ),
    'section'     => 'blog_single',
    'default'     => 'left',
    'choices'     => array (
        'left'        => __( 'Left', 'exponent' ),
        'center'      => __( 'Center', 'exponent' ),
        'right'       => __( 'Right', 'exponent' ),
    ),
    'required'      => array (
        array (
            'setting'   => 'related_posts',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array (
    'type'          => 'toggle',
    'settings'      => 'related_posts_full_width',
    'label'         => __( 'Use Full Width for Related Posts ?', 'exponent' ),
    'section'       => 'blog_single',
    'default'       => '0',
    'required'      => array (
        array (
            'setting'   => 'related_posts',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array (
    'type'          => 'slider',
    'settings'      => 'related_posts_cols',
    'label'         => __( 'Posts Per Row', 'exponent' ),
    'section'       => 'blog_single',
    'default'       => '3',
    'choices'       => array(
        'min'       => '2',
        'max'       => '5',
        'step'      => '1',
    ),
    'required'      => array (
        array (
            'setting'   => 'related_posts',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array (
    'type'          => 'number',
    'settings'      => 'related_posts_gutter',
    'label'         => __( 'Spacing Between Posts', 'exponent' ),
    'section'       => 'blog_single',
    'default'       => '10',
    'required'      => array (
        array (
            'setting'   => 'related_posts',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array(
    'type'       => 'sortable',
    'settings'   => 'blog_related_primary_meta',
    'label'      => __( 'Primary Meta', 'exponent' ),
    'section'    => 'blog_single',
    'default'    => array( 'categories' ),
    'choices'    => array(
        'categories'        => __( 'Categories', 'exponent' ),
        'author'            => __( 'Author', 'exponent' ),
        'date'              => __( 'Date', 'exponent' ),
    ),
    'required'      => array (
        array (
            'setting'   => 'related_posts',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array(
    'type'       => 'sortable',
    'settings'   => 'blog_related_secondary_meta',
    'label'      => __( 'Secondary Meta', 'exponent' ),
    'section'    => 'blog_single',
    'default'    => array( 'author', 'date' ),
    'choices'    => array(
        'categories'        => __( 'Categories', 'exponent' ),
        'author'            => __( 'Author', 'exponent' ),
        'date'              => __( 'Date', 'exponent' ),
    ),
    'required'      => array (
        array (
            'setting'   => 'related_posts',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array(
    'type'       => 'sortable',
    'settings'   => 'blog_related_tertiary_meta',
    'label'      => __( 'Tertiary Meta', 'exponent' ),
    'section'    => 'blog_single',
    'default'    => array(),
    'choices'    => array(
        'categories'        => __( 'Categories', 'exponent' ),
        'author'            => __( 'Author', 'exponent' ),
        'date'              => __( 'Date', 'exponent' ),
    ),
    'required'      => array (
        array (
            'setting'   => 'related_posts',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_related_meta_author_image',
    'label'       => __( 'Show Author Profile Photo ?', 'exponent' ),
    'section'     => 'blog_single',
    'default'     => '0',
    'required'      => array (
        array (
            'setting'   => 'related_posts',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_related_meta_date_icon',
    'label'       => __( 'Show Date Icon ?', 'exponent' ),
    'section'     => 'blog_single',
    'default'     => '0',
    'required'      => array (
        array (
            'setting'   => 'related_posts',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );

Be_Options::add_field( array (
    'type'        => 'toggle',
    'settings'    => 'blog_related_labeled_cat',
    'label'       => __( 'Use Label Style for Category meta', 'exponent' ),
    'section'     => 'blog_single',
    'default'     => '0',
    'required'      => array (
        array (
            'setting'   => 'related_posts',
            'operator'  => '==',
            'value'     => '1',
        )
    ),
) );