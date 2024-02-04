<?php

add_action( 'tatsu_register_modules', 'be_grid_register_portfolio_options', 11);
if( !function_exists( 'be_grid_register_portfolio_options' ) ){
    function be_grid_register_portfolio_options() {

        $portfolio_categories = get_terms('portfolio_categories');
        $category_options = array();
        foreach ( $portfolio_categories as $category ) {
            if( is_object( $category ) ) {
                $category_options[$category->slug] = $category->name;
            }
        }

        $portfolio_tags = get_terms('portfolio_tags');
        $tag_options = array();
        foreach ( $portfolio_tags as $tag ) {
            if( is_object( $tag ) ) {
                $tag_options[$tag->slug] = $tag->name;
            }
        }
        $controls = array (
            'icon' => '',
            'title' => __( 'Portfolio', 'be_portfolio_post' ),
            'is_js_dependant' => true,
            'type' => 'single',
            'is_built_in' => false,
            'group_atts'  => array (
                array (
                    'type'  => 'tabs',
                    'group' => array (
                        array (
                            'type'  => 'tab',
                            'title' => __( 'Content', 'be_portfolio_post' ),
                            'group' => array (
                                'filter',
                                'category',
                                'tag',
                                'show_filters',
                                'items_per_page',
                                'cat_hide'
                            )
                        ),
                        array (
                            'type'  => 'tab',
                            'title' => __( 'Style', 'be_portfolio_post' ),
                            'group' => array (
                                array (
                                    'type' => 'accordion' ,
                                    'active' => array(0),
                                    'group' => array (
                                        array (
                                            'type' => 'panel',
                                            'title' => __( 'Layout', 'be_portfolio_post' ),
                                            'group' => array (
                                                'col',
                                                'two_col_mobile',
                                                'gutter_style',
                                                'gutter_width',
                                                'masonry',
                                                'filter_alignment'
                                            )
                                        ),	
                                        array (
                                            'type' => 'panel',
                                            'title' => __( 'Loading', 'be_portfolio_post' ),
                                            'group' => array (
                                                'lazy_load',
                                                'delay_load',
                                                'initial_load_style'
                                            )
                                        ),
                                        array (
                                            'type' => 'panel',
                                            'title' => __( 'Hover Style & Colors', 'be_portfolio_post' ),
                                            'group' => array (
                                                'prebuilt_hover_style',
                                                'overlay_color',
                                                'title_color',
                                                'cat_color',
                                                'more_color',
                                                'more_hover_color',
                                                'enable_shadow',
                                                'title_cats_alignment',
                                                'placeholder_color',
                                            )
                                        ),
                                    ),
                                ),
                            )
                        ),
                        array (
                            'type'  => 'tab',
                            'title' => __( 'Advanced', 'be_portfolio_post' ),
                            'group' => array (
        
                            )
                        ),
                    )
                ),
            ),
            'atts' => array (
                array (
                    'att_name' => 'col',
                    'type' => 'select',
                    'label' => __( 'Number of Columns', 'be_portfolio_post' ),
                    'options'=> array (
                        '1' => 'One',
                        '2' => 'Two',
                        '3' => 'Three',
                        '4' => 'Four',
                        '5' => 'Five', 
                    ),
                    'default' => '3',
                    'tooltip' => ''
                ),
                array (
                    'att_name'  => 'two_col_mobile',
                    'label' => __( '2 Column Grid in Mobile', 'tatsu' ),
                    'type'  => 'switch',
                    'default' => '0',
                    'tooltip' => '',  
                ),
                array (
                    'att_name' => 'gutter_style',
                    'type' => 'select',
                    'label' => __( 'Gutter Style', 'be_portfolio_post' ),
                    'options' => array (
                        'style1' => 'With Margin',
                        'style2' => 'Without Margin',
                    ),
                    'default' => 'style1',
                    'tooltip' => ''
                ),
                array (
                    'att_name' => 'gutter_width',
                    'type' => 'number',
                    'is_inline' => true,
                    'label' => __('Gutter Width','be_portfolio_post'),
                    'options' => array(
                        'unit' => 'px',
                    ),
                    'default' => '40',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .be-portfolio-container' => array(
                            'property' => 'margin',
                            'prepend' => '0 -',
                            'append' => 'px',
                            'operation' => array( '/', '2' ),
                            'when' => array( 'gutter_style','=','style2' ),
                        ),
                        '.tatsu-{UUID}.be-portfolio-wrap .be-portfolio-container' => array(
                            'property' => 'padding',
                            'prepend' => '0 ',
                            'append' => 'px',
                            'operation' => array( '/', '2' ),
                            'when' => array( 'gutter_style','=','style1' ),
                        ),
                        '.tatsu-{UUID} .be-portfolio-container .portfolio-item.be-col' => array(
                            'property' => 'margin-bottom',
                            'append' => 'px'
                        ),
                        '.tatsu-{UUID} .be-portfolio-container .portfolio-item.be-col ' => array(
                            'property' => 'padding',
                            'prepend' => '0 ',
                            'append' => 'px',
                            'operation' => array( '/','2' ),
                        ),
                        '.tatsu-{UUID}.be-portfolio-module .be-portfolio-container' => array(
                            'property' => 'margin-bottom',
                            'prepend' => '-',
                            'append' => 'px',
                            'when' => array( 'prebuilt_hover_style', '!=', 'style5' ),

                        ),
                    ),
                ),
                array (
                    'att_name' => 'masonry',
                    'type' => 'switch',
                    'label' => __( 'Preserve Image Aspect Ratio', 'be_portfolio_post' ),
                    'default' => 0,
                    'tooltip' => '',
                ),        	
                array (
                    'att_name' => 'show_filters',
                    'type' => 'switch',
                    'label' => __( 'Filterable Portfolio', 'be_portfolio_post' ),
                    'default' => 1,
                    'tooltip' => '',
                ),
                array (
                    'att_name' => 'filter_alignment',
                    'type' => 'button_group',
                    'is_inline' => true,
                    'label' => __( 'Filter Alignment', 'be_portfolio_post' ),
                    'options' => array (
                        'left' 		=> 'Left',
                        'center' 	=> 'Center',
                        'right'	=> 'Right',
                    ),
                    'default' => 'center',
                    'visible' => array( 'show_filters','=','1' ),
                    'tooltip' => ''
                ),
                array (
                    'att_name' => 'filter',
                    'type' => 'button_group',
                    'is_inline' => true,
                    'label' => __( 'Filter To Use', 'be_portfolio_post' ),
                    'options'=> array(
                        'portfolio_categories' => 'Categories', 
                        'portfolio_tags' => 'Tags', 
                    ),
                    'default' => 'portfolio_categories',
                    'tooltip' => ''
                ),	
                array (
                    'att_name' => 'category',
                    'type' => 'grouped_checkbox',
                    'label' => __( 'Portfolio Categories', 'be_portfolio_post' ),
                    'visible'	=> array( 'filter', '=', 'portfolio_categories' ),
                    'options' => $category_options,
                ),	
                array (
                    'att_name' => 'tag',
                    'type' => 'grouped_checkbox',
                    'label' => __( 'Portfolio Tags', 'be_portfolio_post' ),
                    'visible'	=> array( 'filter', '=', 'portfolio_tags' ),
                    'options' => $tag_options,
                ),	        	
                array (
                    'att_name' => 'lazy_load',
                    'type' => 'switch',
                    'label' => __( 'Lazy Load', 'be_portfolio_post' ),
                    'default' => 1,
                    'tooltip' => 'Lazy Load'
                ),
                array (
                    'att_name' => 'delay_load',
                    'type' => 'switch',
                    'label' => __( 'Reveal items only on scroll', 'be_portfolio_post' ),
                    'default' => 1,
                    'tooltip' => 'Delay Load Grid'
                ),
                array (
                    'att_name' => 'placeholder_color',
                    'type' => 'color',
                    'label' => __( 'Grid Placeholder Color', 'be_portfolio_post' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .portfolio-thumb-img-wrap' => array(
                            'property' => 'background',
                        ),
                    ),
                ),			
                array (
                    'att_name' => 'items_per_page',
                    'type' => 'text',
                    'label' => __( 'Number of Items', 'be_portfolio_post' ),
                    'default' => '9',
                    'tooltip' => ''
                ),	        	
                array (
                    'att_name' => 'initial_load_style',
                    'type' => 'select',
                    'label' => __( 'Image Load Animation', 'be_portfolio_post' ),
                    'options' => array (
                        'init-slide-left' => 'Slide Left',
                        'init-slide-right' => 'Slide Right',
                        'init-slide-top' => 'Slide Top',
                        'init-slide-bottom' => 'Slide Bottom',
                        'init-scale' => 'Scale',
                        'fadeIn' => 'Fade In',
                        'none' => 'None',
                    ),
                    'default' => 'fadeIn',
                    'tooltip' => ''
                ),
                array (
                    'att_name'	=> 'prebuilt_hover_style',
                    'type'		=> 'select',
                    'label'		=> __('Hover Styles', 'be_portfolio_post'),
                    'options'	=> array (
                        'style1'	=> 'Style 1',
                        'style2'	=> 'Style 2',
                        'style3'	=> 'Style 3',
                        'style4'	=> 'Style 4',
                        'style5'    => 'Style 5',
                        'style6'    => 'Style 6'
                    ),
                    'default'	=> 'style1',
                    'tooltip'	=> 'none',			 
                ),     	
                array (
                    'att_name' => 'overlay_color',
                    'type' => 'color',
                    'options' => array(
                        'gradient' => true,
                    ),
                    'label' => __( 'Thumbnail Overlay Color', 'be_portfolio_post' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .thumb-bg' => array(
                            'property' => 'background',
                            'when' => array( 
                                array( 'prebuilt_hover_style', '=', 'style4' ),
                                array( 'prebuilt_hover_style', '=', 'style5' ),
                            ),
                            'relation' => 'or'
                        ),
                        '.tatsu-{UUID} .be-thumb-overlay-wrap' => array(
                            'property' => 'background',
                            'when' => array( 'prebuilt_hover_style', '=', 'style3' ),
                        ),
                        '.tatsu-{UUID} .be-prebuilt-overlay-wrapper' => array(
                            'property' => 'background',
                            'when' => array( 'prebuilt_hover_style', '=', 'style2' ),
                        ),
                    )
                ),
                array (
                    'att_name'      => 'title_cats_alignment',
                    'type'          => 'button_group',
                    'label'         => __( 'Title Area Alignment', 'be_portfolio_post' ),
                    'default'       => 'left',
                    'options'       => array (
                        'left'      => 'Left',
                        'center'    => 'Center',
                        'right'     => 'Right',
                    ),
                    'tooltip'       => '',
                    'visible'       => array (
                        'prebuilt_hover_style', '=', 'style5'
                    )
                ),
                array (
                    'att_name' => 'enable_shadow',
                    'type' => 'switch',
                    'label' => __( 'Enable Box Shadow', 'be_portfolio_post' ),
                    'default' => 0,
                    'tooltip' => '',
                    'visible'       => array (
                        'prebuilt_hover_style', '=', 'style5'
                    )
                ),
                array (
                    'att_name' => 'title_color',
                    'type' => 'color',
                    'label' => __( 'Title Color', 'be_portfolio_post' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .thumb-title' => array(
                            'property' => 'color',
                        ),
                    ),
                ),
                array (
                    'att_name' => 'cat_color',
                    'type' => 'color',
                    'label' => __( 'Categories Color', 'be_portfolio_post' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .portfolio-item-cats' => array(
                            'property' => 'color',
                        ),
                    ),
                ),	
                array (
                    'att_name' => 'more_color',
                    'type' => 'color',
                    'label' => __( 'Learn More Color', 'be_portfolio_post' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .thumb-animated-link' => array(
                            'property' => 'color',
                        ),
                    ),
                    'visible'       => array (
                        'prebuilt_hover_style', '=', 'style5'
                    )
                ),
                array (
                    'att_name' => 'more_hover_color',
                    'type' => 'color',
                    'label' => __( 'Learn More Hover Color', 'be_portfolio_post' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .thumb-animated-link:hover' => array(
                            'property' => 'color',
                        ),
                    ),
                    'visible'       => array (
                        'prebuilt_hover_style', '=', 'style5'
                    )
                ),
                array (
                    'att_name' => 'cat_hide',
                    'type' => 'switch',
                    'label' => __( 'Hide Categories ?', 'be_portfolio_post' ),
                    'default' => 0,
                    'tooltip' => '',
                ) 		        	
            ),			
            'presets' => array(
                'default' => array(
                    'title' => '',
                    'image' => '',
                    'preset' => array(
                        'col' => '3',
                        'placeholder_color' => '#fff',
                        'delay_load' => '1',
                        'initial_load_style' => 'fadeIn',
                        'prebuilt_hover_style' => 'style1',
                        'overlay_color' => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
                        'title_color' => '#fff',
                        'cat_color' => '#fff',
                        'more_color'    => '#fff',
                        'more_hover_color'  => array( 'id' => 'palette:0', 'color' => tatsu_get_color( 'tatsu_accent_color' ) ),
                    ),
                )
            ),
        );

        tatsu_remap_modules( [ 'be_portfolio', 'portfolio' ], $controls, 'be_grid_portfolio' );
    }
}