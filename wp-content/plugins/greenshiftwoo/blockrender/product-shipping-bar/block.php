<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductShippingBar{

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
		'minValue' => array(
			'type'    => 'number',
			'default' => 100,
		),

		'enableAnimation' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'title' => array(
			'type'    => 'string',
			'default' => 'Get free shipping for orders over {{VALUE}}',
		),
		'titleSuccess' => array(
			'type'    => 'string',
			'default' => 'Congratulations! You have free shipping!',
		),
	);

	public function convertPlaceholders($value, $cartvalue, $cartcurrent, $cartleft){
		$value = str_replace('{{VALUE}}', '<span class="gspb-min-value">'.wc_price($cartvalue).'</span>', $value);
		$value = str_replace('{{CURRENT}}', '<span class="gspb-cart-value">'.wc_price($cartcurrent).'</span>', $value);
		$value = str_replace('{{MORE}}', '<span class="gspb-cart-left">'.wc_price($cartleft).'</span>', $value);
		return wp_kses_post($value);
	
	}

	public function render_block($settings = array(), $inner_content=''){
		extract($settings);
		if (is_admin()) {
			return;
		}
		global $woocommerce;
		if(!is_object($woocommerce) || !is_object($woocommerce->cart)){
			return;
		}
		
		$cartvalue = $minValue;
		$cartcurrent = $woocommerce->cart->get_total('raw');
		$cartleft = $cartvalue - $cartcurrent;
		$success = false;
		if($cartleft < 0){
			$cartleft = 0;
			$success = true;
		}
		$width = $cartcurrent / $cartvalue * 100;


		$blockId = 'gspb_id-'.$id;
		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'class' => $blockId . ' gspb-shipping-bar',
			)
		);

		$enableAnimationClass = $enableAnimation ? ' gspb-inview' : '';
		$titleBar = $success ? $this->convertPlaceholders($titleSuccess, $cartvalue, $cartcurrent, $cartleft) : $this->convertPlaceholders($title, $cartvalue, $cartcurrent, $cartleft);

		$out = '<div '.$wrapper_attributes.gspb_AnimationRenderProps($animation).'>';
			$out .= '<div class="gs-progressbar__labels">
				<div class="gs-progressbar__title">'.$titleBar.'</div>
			</div>';
			$out .= '<div class="gs-progressbar__progress" data-reachpoint="'.$cartvalue.'">
				<div class="gs-progressbar__bar'.$enableAnimationClass.'" style="width:'.$width.'%"></div>
			</div>';
		$out .='</div>';
		return $out;
	}
}

new ProductShippingBar;