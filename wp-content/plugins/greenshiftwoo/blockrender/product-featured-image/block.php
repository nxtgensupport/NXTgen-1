<?php


namespace greenshiftwoo\Blocks;

defined('ABSPATH') or exit;


class ProductFeaturedImage
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
		'disablelazy'       => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'link_enable'       => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'image_size'  => array(
			'type'    => 'string',
			'default' => 'woocommerce_thumbnail',
		),
		'additional'  => array(
			'type'    => 'string',
			'default' => 'no',
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

		$additional_classes = $additional !== 'no' ? $additional : '';
		if ($disablelazy) $additional_classes .= ' no-lazyload';

		$image = get_the_post_thumbnail($postId, $image_size, ['class' => $additional_classes, 'loading' => $disablelazy ? 'eager' : 'lazy']);
		if(empty($image) && function_exists('wc_placeholder_img')){
			$image = wc_placeholder_img($image_size, ['class' => $additional_classes]);
		}

		$blockId = 'gspb_id-' . $id;
		$blockClassName = 'gspb-product-featured-image ' . $blockId . ' ' . (!empty($className) ? $className : '') . ' ';

		$out = '<div class="' . $blockClassName . '"' . gspb_AnimationRenderProps($animation) . '>';
		if ($link_enable) $out .= '<a href="' . get_permalink($postId) . '" title="'.get_the_title($postId).'">';
		$out .= $image;
		if ($link_enable) $out .= '</a>';
		$out .= '</div>';
		return $out;
	}
}

new ProductFeaturedImage;
