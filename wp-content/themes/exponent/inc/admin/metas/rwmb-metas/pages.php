<?php
    $pages_meta = array();
    $meta_prefix = be_themes_get_meta_prefix();

    $pages_meta[] = array (
		'title'         => __( 'Single Page Overrides', 'exponent' ),
		'pages'         => array( 'page' ),
        'context'       => 'normal',
        'priority'      => 'high',
        'fields'        => array (
            array (
                'name'		=> __( 'Enable Page Title Override', 'exponent' ),
                'id'		=> "{$meta_prefix}entry_header_override",
                'type'		=> 'checkbox',
                'std'		=> '',
            ),
            array (
                'name'		=> __( 'Enable Page Title', 'exponent' ),
                'id'		=> "{$meta_prefix}entry_header",
                'type'		=> 'checkbox',
                'std'		=> '',
            ),
        )
    );

    $pages_meta[] = array (
		'title'         => __( 'Other Settings', 'exponent' ),
		'pages'         => array( 'page' ),
        'context'       => 'normal',
        'fields'        => array (
            array (
                'name'		=> __( 'Enable Sticky Sections', 'exponent' ),
                'id'		=> "{$meta_prefix}sticky_sections",
                'type'		=> 'checkbox',
                'std'		=> '',
                'desc' => __( 'Works only if the page is built with Tatsu', 'exponent' ),
            ),
            array (
				'name' => __( 'Scroll Type', 'exponent' ),
				'id'   => "{$meta_prefix}sticky_scroll_type",
				'type' => 'select',
				'options' => array (
					'auto_scroll' => 'Auto Scroll',
					'normal_scroll' => 'Normal Scroll',
				),
				'std' => 'normal_scroll',
				'desc' => '',
				'visible' => array(
					"{$meta_prefix}sticky_sections", true
				),
			),
			array (
				'name'	=> __( 'Enable Overlay', 'exponent' ),
				'id' => "{$meta_prefix}sticky_overlay",
				'type' => 'checkbox',
				'std' => true,
				'desc' => '',
				'visible' => array(
					"{$meta_prefix}sticky_sections", true
				),
			),
        )
    );

    $pages_meta[] = array (
		'title' => 'Page Sidebar Options',
		'pages' => array( 'page' ),
		'show'   => array(
            'template' => array( 'page-templates/page_sidebar.php', 'page-templates/page_sidebar-full.php' ),
		),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array (
			array (
				'name' => __('Layout','exponent'),
				'id'   => "{$meta_prefix}page_sidebar_layout",
				'type' => 'select',
				'options'=>array (
					'right'=>'Right Sidebar', 
					'left'=>'Left Sidebar', 
					'no' => 'No Sidebar'
				),
				'std'  => 'right',
				'desc' => '',
			),									
			array (
				'name' => __('Sidebar','exponent'),
				'id'   => "{$meta_prefix}page_sidebar",
				'type' => 'sidebar',
				'std'  => '',
				'desc' => '',
			),
		)
	);

    return $pages_meta;