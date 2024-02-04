<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductDiscount{

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

		$blockId = 'gspb_id-'.$id;
		$blockClassName = 'gspb-discountbox '.$blockId.' '.(!empty($className) ? $className : '').'';

        $discount = self::get_discount_percentage($_product);

		$out = '<div class="'.$blockClassName.'"'.gspb_AnimationRenderProps($animation).'>';
        if(strlen($discount)) {
            $out .= '<span class="gspb_discount_wrap">';
            if($label){
                $out .= '<span class="gspb_discount_label">' . $label . ' </span>';
            }
            $out .= '<span class="gspb_discount_value">'. self::get_discount_percentage($_product) .'</span>';
            if($postfix){
                $out .= '<span class="gspb_discount_postfix"> ' . $postfix . '</span>';
            }
            $out .= '</span>';
        }
		$out .='</div>';
		return $out;
	}

    static function get_discount_percentage( $product ) {

        $percentage = '';

        if( $product->is_type('variable')){
            $percentages = array();

            // Get all variation prices
            $prices = $product->get_variation_prices();

            // Loop through variation prices
            foreach( $prices['price'] as $key => $price ){
                // Only on sale variations
                if( $prices['regular_price'][$key] !== $price ){
                    // Calculate and set in the array the percentage for each variation on sale
                    $percentages[] = round( 100 - ( floatval($prices['sale_price'][$key]) / floatval($prices['regular_price'][$key]) * 100 ) );
                }
            }
            // We keep the highest value
            if(count($percentages)){
                $percentage = max($percentages) . '%';
            }

        } elseif( $product->is_type('grouped') ){
            $percentages = array();

            // Get all variation prices
            $children_ids = $product->get_children();

            // Loop through variation prices
            foreach( $children_ids as $child_id ){
                $child_product = wc_get_product($child_id);

                $regular_price = (float) $child_product->get_regular_price();
                $sale_price    = (float) $child_product->get_sale_price();

                if ( $sale_price != 0 || ! empty($sale_price) ) {
                    // Calculate and set in the array the percentage for each child on sale
                    $percentages[] = round(100 - ($sale_price / $regular_price * 100));
                }
            }
            // We keep the highest value
            $percentage = max($percentages) . '%';

        } else {
            $regular_price = (float) $product->get_regular_price();
            $sale_price    = (float) $product->get_sale_price();

            if ( $sale_price != 0 || ! empty($sale_price) ) {
                $percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
            } else {
                return '';
            }
        }

        return $percentage;
    }
}

new ProductDiscount;