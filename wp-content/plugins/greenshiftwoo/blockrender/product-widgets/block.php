<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductWidgets{

	public function __construct(){
		add_action('init', array( $this, 'init_handler' ));
	}

	public function init_handler(){
		register_block_type(__DIR__, array(
                'render_callback' => array( $this, 'render_block' ),
                'attributes'      => $this->attributes
            )
		);
	}

	public $attributes = array(
		'id' => array(
			'type'    => 'string',
			'default' => null,
		),
		'inlineCssStyles' => array(
			'type'    => 'string',
			'default' => '',
		),
		'animation' => array(
			'type' => 'object',
			'default' => array(),
		),
        'title'       => array(
            'type'    => 'string',
            'default' => 'Filter By',
        ),
		'attributeSlug'       => array(
            'type'    => 'string',
            'default' => '',
        ),
		'query_type'       => array(
            'type'    => 'string',
            'default' => 'AND',
        ),
		'display_type'       => array(
            'type'    => 'string',
            'default' => 'list',
        ),
		'widget_type'       => array(
            'type'    => 'string',
            'default' => 'attribute',
        ),
	);

	public function render_block($settings = array(), $inner_content=''){
		extract($settings);
        $divider = isset($divider) ? esc_attr($divider) : '';
		$widget_args = apply_filters( 'gspb_woo_widget_args', array(
			'before_widget' => '<div class="widget %s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="title">',
			'after_title'   => '</div>',
			) );

		$blockId = 'gspb_id-'.$id;
		$blockClassName = 'gspb-classicwoofilterbox '.$blockId.' '.(!empty($className) ? $className : '').'';

		$out = '<div class="'.$blockClassName.'"'.gspb_AnimationRenderProps($animation).'>';
			
			ob_start();
			if($widget_type == 'attribute' && !empty($attributeSlug)){
				the_widget( 'WC_Widget_Layered_Nav', array( 'title' => esc_attr($title), 'attribute'=> esc_attr(str_replace('pa_', '', $attributeSlug)), 'display_type'=> esc_attr($display_type), 'query_type'=> esc_attr($query_type) ), $widget_args );
			}else if($widget_type == 'price'){
				the_widget( 'WC_Widget_Price_Filter', array( 'title' => esc_attr($title) ), $widget_args );
			}else if($widget_type == 'rating'){
				the_widget( 'WC_Widget_Rating_Filter', array( 'title' => esc_attr($title) ), $widget_args );
			}else if($widget_type == 'activefilters'){
				the_widget( 'WC_Widget_Layered_Nav_Filters', array( 'title' => esc_attr($title) ), $widget_args );
			}

			$output = ob_get_clean();
			$out .= $output;
		$out .='</div>';
		return $out;
	}
}

new ProductWidgets;