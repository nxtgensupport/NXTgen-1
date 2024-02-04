<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductStockNotice{

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
		'type' 	 => array(
			'type'    => 'string',
			'default' => 'real',
		),
		'minValue' => array(
			'type'    => 'number',
			'default' => 10,
		),
		'maxValue' => array(
			'type'    => 'number',
			'default' => 100,
		),
		'enableAnimation' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'reverseFill' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'title' => array(
			'type'    => 'string',
			'default' => 'Already Sold: {{SOLD%}}',
		),
		'label' => array(
			'type'    => 'string',
			'default' => 'Available: {{STOCK}}',
		),
	);

	public function convertPlaceholders($value, $stock_available, $stock_sold, $stock_sold_percentage){
		$value = str_replace('{{SOLD%}}', '<span class="gspb-sold-percentage">'.$stock_sold_percentage.'%</span>', $value);
		$value = str_replace('{{STOCK}}', '<span class="gspb-stock-available">'.(int)$stock_available.'</span>', $value);
		$value = str_replace('{{SOLD}}', '<span class="gspb-sold-out">'.$stock_sold.'</span>', $value);
		return $value;
	
	}

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

		$stock_available = 0;
		$stock_sold = 0;
		$total = 0;
		$stock_sold_percentage = 0;


		if($type == 'real'){
			$stock_available = get_post_meta( $postId, '_stock', true );
	        $stock_sold = get_post_meta( $postId, 'total_sales', true );
			if($stock_available > 0){
				if(!$stock_sold){
					$stock_sold = 0;
				}
				$total = $stock_available + $stock_sold;
				$stock_sold_percentage = round( $stock_sold / $total * 100 );
			}
			else{
				return '';
			}
		}else if($type == 'fake'){
			$stock_available = $maxValue;
			$stock_sold = get_transient('gs-soldout-'. $postId);
	        if(!$stock_sold){
	            $stock_sold = rand($minValue, ($maxValue-1));
	            set_transient( 'gs-soldout-'. $postId, $stock_sold, DAY_IN_SECONDS );
			}
			$total = $stock_available + $stock_sold;
			$stock_sold_percentage = round( $stock_sold / $total * 100 );
		}

		if($reverseFill){
			$stock_sold_percentage = 100 - $stock_sold_percentage;
		}

		$blockId = 'gspb_id-'.$id;
		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'class' => $blockId . ' gspb-stocknotice',
			)
		);

		$enableAnimationClass = $enableAnimation ? ' gspb-inview' : '';

		$out = '<div '.$wrapper_attributes.gspb_AnimationRenderProps($animation).'>';
			$out .= '<div class="gs-progressbar__labels">
				<div class="gs-progressbar__title">'.$this->convertPlaceholders($title, $stock_available, $stock_sold, $stock_sold_percentage).'</div>
				<div class="gs-progressbar__label">'.$this->convertPlaceholders($label, $stock_available, $stock_sold, $stock_sold_percentage).'</div>
			</div>';
			$out .= '<div class="gs-progressbar__progress">
				<div class="gs-progressbar__bar'.$enableAnimationClass.'" style="width:'.$stock_sold_percentage.'%"></div>
			</div>';
		$out .='</div>';
		if($type == 'real' && $stock_available == 0 && $stock_sold == 0){
			$out = '';
		}
		return $out;
	}
}

new ProductStockNotice;