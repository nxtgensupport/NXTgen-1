<?php


namespace greenshiftwoo\Blocks;

defined('ABSPATH') or exit;


class ProductTitle
{

	public function __construct()
	{
		add_action('init', array($this, 'init_handler'));
	}

	public function init_handler()
	{
		register_block_type(
			__DIR__,
			array(
				'render_callback' => array($this, 'render_block'),
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
		'headingTag' => array(
			'type' => 'string',
			'default' => 'h2'
		),
		'link_enable'       => array(
			'type'    => 'boolean',
			'default' => true,
		),
	);

	public function render_block($settings = array(), $inner_content = '')
	{
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

		if (!$_product) return __('Product not found.', 'greenshiftwoo');

		$title = $_product->get_title();
		$link = $_product->get_permalink();

		$blockId = 'gspb_id-' . $id;
		$blockClassName = 'gspb-product-title ' . $blockId . ' ' . (!empty($className) ? $className : '') . ' ';

		$out = '<div  class="' . $blockClassName . '"' . gspb_AnimationRenderProps($animation) . '>';
		$out .= '<' . $headingTag . '>';
		if ($link_enable) $out .= '<a href="' . esc_url($link) . '">';
		$out .= $title;
		if ($link_enable) $out .= '</a>';
		$out .= '</' . $headingTag . '>';
		$out .= '</div>';
		return $out;
	}
}

new ProductTitle;
