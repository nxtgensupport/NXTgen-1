<?php
add_filter( 'rwmb_meta_boxes', 'be_grid_prefix_register_meta_boxes' );
if( !function_exists( 'be_grid_prefix_register_meta_boxes' ) ){
	function be_grid_prefix_register_meta_boxes( $meta_boxes ) {

		$prefix = 'be_themes_';
		$meta_boxes[] = array (
			'id' => 'portfolio',
			'title' => 'BE - Portfolio Options',
			'post_types' => 'portfolio',
			'context' => 'normal',
			'priority' => 'high',

			'tabs' =>  array(
				'general' => array(
					'label' => __( 'Single Portfolio Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'portfolio_details'  => array(
					'label' => __( 'Portfolio Details', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'thumbnail'  => array(
					'label' => __( 'Portfolio Grid - Thumbnail Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				),
				'entry_header' => array(
					'label' => __( 'Entry Header Settings', 'rwmb' ),
					'icon'  => '', // Dashicon
				)
			),

		// Tab style: 'default', 'box' or 'left'. Optional
		'tab_style' => 'left',
		
		// Show meta box wrapper around tabs? true (default) or false. Optional
		'tab_wrapper' => true,

		'fields' => array(

			// SINGLE PORTFOLIO STYLE TAB
			array (
				'name'	=>	__('Portfolio Style','be-grid'),
				'id'	=>	"{$prefix}single_portfolio_slider_note6",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'general'
			),
			array (
				'name'	=> __('Portfolio Single Page Style','be-grid'),
				'id'	=> "{$prefix}portfolio_single_page_style",
				'desc'	=> 'Advanced Settings for SLIDER type portfolio is given under Slider Settings tab',
				'type' 	=> 'select',
				'options'	=> array (
					'normal' => 'Single Page - Page Builder',
					'be-ribbon-carousel' => 'Ribbon Carousel Slider',
					'lightbox' => 'LightBox',
					'lightbox-gallery' => 'LightBox Gallery',
					'fixed-left' => 'Single Page - Fixed Left Sidebar',
					'fixed-right' => 'Single Page - Fixed Right Sidebar',
					'none' => 'None',
				),
				'std'  => 'normal',
				'tab'		=> 'general'
			),
			array (
				'name'		=> __('Portfolio Images','be-grid'),
				'id'	=> "{$prefix}single_portfolio_slider_images",
				'desc'		=> '',
				'type'		=> 'image_advanced',
				// 'max_file_uploads' => '',
				'tab'		=> 'general',
				'visible'	=> array('be_themes_portfolio_single_page_style','!=','normal')
			),
			// PORTFOLIO DETAILS TAB
			array (
				'name'	=>	__('Portfolio Details','be-grid'),
				'id'	=>	"{$prefix}single_portfolio_slider_note4",
				'desc'	=>	'To publish these details in the Front End, use the Portfolio Details module in the Page Builder',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'portfolio_details'
			),
			array (
				'name'		=> __('Client Name','be-grid'),
				'id'	=> "{$prefix}portfolio_client_name",
				'desc'		=> '',
				'type'		=> 'text',
				'std'		=> '',
				'tab'		=> 'portfolio_details'
			),		
			array (
				'name'		=> __('Project Date','be-grid'),
				'id'	=> "{$prefix}portfolio_project_date",
				'desc'		=> '',
				'type'		=> 'text',
				'std'		=> '',
				'tab'		=> 'portfolio_details'
			),
			array (
				'name'		=> __('Project URL','be-grid'),
				'id'	=> "{$prefix}portfolio_visitsite_url",
				'desc'		=> 'VIEW PROJECT button will appear if a Project URL is provided',
				'type'		=> 'text',
				'tab'		=> 'portfolio_details'
			),

			//GRID THUMBNAIL SETTINGS TAB
			
			array (
				'name'	=>	__('Portfolio Grid - Thumbnail Settings','be-grid'),
				'id'	=>	"{$prefix}single_portfolio_slider_note3",
				'desc'	=>	'',
				'type'	=>	'heading',
				'std'  	=>	0,
				'tab'	=> 'thumbnail'
			),
			array (
				'name' => __('Open Thumbnail in New tab','be-grid'),
				'id'   => "{$prefix}portfolio_open_new_tab",
				'type' => 'checkbox',
				'std'  => '',
				'tab'		=> 'thumbnail'
			),		
			array (
				'name'		=> __('Link Thumbnail To','be-grid'),
				'id'	=> "{$prefix}portfolio_link_to",
				'desc'		=> '',
				'type' => 'radio',
				'options'	=> array (
					'single_portfolio' => 'Single Portfolio Page',
					'external_url' => 'External Url',
				),
				'std'  => 'single_portfolio',
				'tab'		=> 'thumbnail'
			),
			array (
				'name'		=> __('External URL','be-grid'),
				'id'	=> "{$prefix}portfolio_external_url",
				'desc'		=> 'If thumbnail should be linked to external site.',
				'type'		=> 'text',
				'tab'		=> 'thumbnail',
				'visible' => array('be_themes_portfolio_link_to','external_url' )
			),
			array (
				'name' => __('Double Width','be-grid'),
				'id'   => "{$prefix}double_width",
				'type' => 'checkbox',
				'std'  => '',
				'tab'		=> 'thumbnail'
			),
			array (
				'name' => __('Double Height','be-grid'),
				'id'   => "{$prefix}double_height",
				'type' => 'checkbox',
				'std'  => '',
				'tab'		=> 'thumbnail'
			),
			array (
				'name'		=> __('Overlay Color','be-grid'),
				'id'	=> "{$prefix}single_overlay_color",
				'desc'		=> '',
				'type'		=> 'color',
				'alpha_channel' => true,
				'std'		=> '',
				'tab'		=> 'thumbnail'
			),
			array (
				'name'		=> __('Portfolio Title Color','be-grid'),
				'id'	=> "{$prefix}single_overlay_title_color",
				'desc'		=> '',
				'type'		=> 'color',
				'alpha_channel' => true,
				'std'		=> '',
				'tab'		=> 'thumbnail'
			),
			array (
				'name'		=> __('Portfolio Categories Color','be-grid'),
				'id'	=> "{$prefix}single_overlay_cat_color",
				'desc'		=> '',
				'type'		=> 'color',
				'alpha_channel' => true,
				'std'		=> '',
				'tab'		=> 'thumbnail'
			),
			array (
				'name'		=> __( 'Enable Page Title', 'be-grid' ),
				'id'		=> "{$prefix}entry_header",
				'type' 	=> 'select',
				'options'	=> array (
					'inherit' => 'Inherit',
					'show' => 'Show',
					'hide' => 'Hide',
				),
				'std'		=> 'inherit',
				'tab'		=> 'entry_header'
			),
		)
	);

		// Add more meta boxes if you want
		// $meta_boxes[] = ...

		return $meta_boxes;
}
}