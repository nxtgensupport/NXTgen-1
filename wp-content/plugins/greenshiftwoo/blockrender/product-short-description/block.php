<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductShortDescription{

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
		'postId'       => array(
            'type'    => 'number',
            'default' => 0,
        ),
		'sourceType'       => array(
            'type'    => 'string',
            'default' => 'latest_item',
        ),
	);

	public function render_block($settings = array(), $inner_content=''){
		extract($settings);

		if($sourceType == 'latest_item'){
			global $post;
			if(is_object($post)){
				if($post->post_type == 'product'){
					$postId = $post->ID;
				}else{
					$postId = 0;
				}
			}else{
				$postId = 0;
			}
		}else{
			$postId = (isset($postId) && $postId > 0) ? (int)$postId : 0;
		}
		$_product = gspbwoo_get_product_object_by_id($postId);
        if(!$_product) return __('Product not found.', 'greenshiftwoo');

		$blockId = 'gspb_id-'.$id;
		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'class' => $blockId . ' gspb-short-description',
			)
		);

		$out = '<div '.$wrapper_attributes.gspb_AnimationRenderProps($animation).'>';
			ob_start();
            echo ''.$_product->get_short_description();
			$output = ob_get_clean();
			$out .= $output;
		$out .='</div>';
		return $out;
	}
}

new ProductShortDescription;