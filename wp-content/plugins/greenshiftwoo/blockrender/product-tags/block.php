<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductTags{

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
        'sourceType'       => array(
            'type'    => 'string',
            'default' => 'latest_item',
        ),
        'label'       => array(
            'type'    => 'string',
            'default' => '',
        ),
        'postfix'       => array(
            'type'    => 'string',
            'default' => '',
        ),
        'postId'       => array(
            'type'    => 'number',
            'default' => 0,
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

        $postfix = isset($postfix) ? esc_attr($postfix) : '';
        $label = isset($label) ? esc_attr($label) : '';
        $_product = gspbwoo_get_product_object_by_id($postId);

        if(!$_product) return __('Product not found.', 'greenshiftwoo');

        $tags = wc_get_product_tag_list( $_product->get_id() );
        $tags = !empty($tags) ? $tags : '';
		if(!$tags) return;

		$blockId = 'gspb_id-'.$id;
		$blockClassName = 'gspb-tagsbox '.$blockId.' '.(!empty($className) ? $className : '').'';

		$out = '<div class="'.$blockClassName.'"'.gspb_AnimationRenderProps($animation).'>';
            if($label){
                $out .= '<span class="gspb_tags_label">' . $label . ' </span>';
            }
            $out .= '<span class="gspb_tags_value">' . $tags . '</span>';
            if($postfix){
                $out .= '<span class="gspb_tags_postfix"> ' . $postfix . '</span>';
            }
		$out .='</div>';
		return $out;
	}
}

new ProductTags;