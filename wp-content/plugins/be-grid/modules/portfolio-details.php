<?php
/**************************************
			PORTFOLIO DETAILS
**************************************/
if ( ! function_exists( 'be_grid_portfolio_details' ) ) {
	function be_grid_portfolio_details( $atts, $content, $tag ) {
		extract( shortcode_atts( array (
			'style' => 'style1',
	        'alignment'=> 'left'
		),$atts, $tag ) );
		$is_not_ajax = ( ( !( wp_doing_ajax() || ( defined('REST_REQUEST') && REST_REQUEST ) ) ) ) ? 1 : 0;
	    global $be_themes_data;
	    $style = (!isset($style) || empty($style)) ? 'style1' : $style;
		$alignment = (!isset($alignment) || empty($alignment)) ? 'left' : $alignment;	  
		
		$custom_style_tag = be_generate_css_from_atts( $atts, 'be_portfolio_details', $atts['key'] );
		$custom_class_name = 'tatsu-'.$atts['key'];
		$css_id = be_get_id_from_atts( $atts );
		$visibility_classes = be_get_visibility_classes_from_atts( $atts ); 
		$data_animations = be_get_animation_data_atts( $atts );
		$animate = ( 'none' != $animation_type ) ? 'tatsu-animate' : '' ;

		global $post;
		$output = '';
		$post_type = get_post_type();
		if( $post_type != 'portfolio' && $is_not_ajax ) {
			return '';
		} else {
			$output .= '<div '.$css_id.' class="tatsu-module be-portfolio-details '.$visibility_classes.' '.$css_classes.' '.$animate.' '.$custom_class_name.' align-'.$alignment .' '.$style.' " style="text-align: '.$alignment.'" '.$data_animations.' >';
			if((!is_page_template( 'gallery.php' )) || (!is_page_template( 'portfolio.php' ))) {
				if(get_post_meta($post->ID,'be_themes_portfolio_client_name',true) || !$is_not_ajax ) {
					$output .= '<div class="gallery-side-heading-wrap portfolio-client-name clearfix"><h6 class="gallery-side-heading">'.__('Client', 'be-grid').'</h6>';
					$output .= '<p><span class="project_client">'.(get_post_meta($post->ID, 'be_themes_portfolio_client_name', true) ? get_post_meta($post->ID, 'be_themes_portfolio_client_name', true) : '[ CLIENT NAME ]' ).'</span></p></div>';
				}
				if(get_post_meta($post->ID,'be_themes_portfolio_project_date',true)  || !$is_not_ajax ) {
					$output .= '<div class="gallery-side-heading-wrap portfolio-project-date clearfix"><h6 class="gallery-side-heading">'.__('Project Date', 'be-grid').'</h6>';
					$output .= '<p><span class="project_client">'. (get_post_meta($post->ID, 'be_themes_portfolio_project_date', true) ? get_post_meta($post->ID, 'be_themes_portfolio_project_date', true) : '[ PROJECT DATE ]' ).'</span></p></div>';
				}
				if(get_be_themes_portfolio_category_list($post->ID, true) ) {
					$output .= '<div class="gallery-side-heading-wrap portfolio-category clearfix"><div class="gallery-cat-list-wrap">';
					$output .= '<h6 class="gallery-side-heading">'.__('Category', 'be-grid').'</h6>';
					$output .= '<p>'.get_be_themes_portfolio_category_list($post->ID, true).'</p>';
					$output .= '</div></div>';
				}
			}
			$output .= '<div class="gallery-side-heading-wrap portfolio-share clearfix"><h6 class="gallery-side-heading">'.__('Share This', 'be-grid').'</h6>';
			$output .= '<p>';
			$output .= be_get_share_button(get_permalink($post->ID), get_the_title($post->ID) , $post->ID);
			$output .= '</p></div>';
			if(get_post_meta($post->ID,'be_themes_portfolio_visitsite_url',true)) {
				if(!isset($be_themes_data['portfolio_visit_site_style']) || empty($be_themes_data['portfolio_visit_site_style'])) {
					$be_themes_data['portfolio_visit_site_style'] = 'style1';
				}

				$output .= '<div class="gallery-side-heading-wrap portfolio-project-button"><a href="'.get_post_meta($post->ID,'be_themes_portfolio_visitsite_url',true).'" class="mediumbtn be-button " target="_blank">'.__('View Project', 'be-grid').'</a></div>';
			}
			$output .= $custom_style_tag;
			$output .= '</div>';
			return $output;
		}

	}
}


add_action( 'tatsu_register_modules', 'be_grid_register_portfolio_details', 11);
if( !function_exists( 'be_grid_register_portfolio_details' ) ){
    function be_grid_register_portfolio_details() {
            $controls = array (
                'icon' => '',
                'title' => __( 'Portfolio Details', 'be_portfolio_post' ),
                'is_js_dependant' => false,
                'type' => 'single',
				'is_built_in' => false,
				'group_atts' => array(
					array(
						'type'		=> 'tabs',
						'style'		=> 'style1',
						'group'		=> array(
							//Tab1
							array(
								'type' => 'tab',
								'title' => __('Style', 'tatsu'),
								'group'	=> array(
									'style',
									'alignment',
								),
							),
							//Tab2
							array(
								'type' => 'tab',
								'title' => __('Advanced', 'tatsu'),
								'group'	=> array(

								),
							),
						),
					),
				),
                'atts' => array (
                    array (
                        'att_name' => 'style',
                        'type' => 'button_group',
                        'label' => __( 'Style', 'be_portfolio_post' ),
                        'options'=> array(
                            'style1' => 'Style 1', 
                            'style2' => 'Style 2',
                            'style3' => 'Style 3'	 
                        ),
						'default'=> 'style1',
						'is_inline' => true,
                        'tooltip' => ''
                    ),	        	
                    array (
                        'att_name' => 'alignment',
                        'type' => 'button_group',
                        'label' => __( 'Alignment', 'be_portfolio_post' ),
                        'options' => array(
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right'
                        ),
                        'default' => 'left',
						'is_inline' => true,
                        'tooltip' => ''
                    )
                ),
            );
            tatsu_remap_modules( [ 'be_portfolio_details', 'project_details' ], $controls, 'be_grid_portfolio_details' );
    }
}

?>