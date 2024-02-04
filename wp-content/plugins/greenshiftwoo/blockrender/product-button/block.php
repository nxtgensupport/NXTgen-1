<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductButton{

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
        'enableicon' => array(
            'type' => 'boolean',
            'default' => false
        ),
        'innerPage' => array(
            'type' => 'boolean',
            'default' => false
        ),
        'loopBlock' => array(
            'type' => 'boolean',
            'default' => false
        ),
        'simpleLabel'       => array(
            'type'    => 'string',
            'default' => '',
        ),
        'variableLabel'       => array(
            'type'    => 'string',
            'default' => '',
        ),
        'affiliateLabel'       => array(
            'type'    => 'string',
            'default' => '',
        ),
        'enableiconBuy' => array(
            'type' => 'boolean',
            'default' => false
        ),
        'enableBuyNow' => array(
            'type' => 'boolean',
            'default' => false
        ),
        'buyNowText'      => array(
            'type'    => 'string',
            'default' => 'Buy Now',
        ),

	);

	public function render_block($settings = array(), $inner_content=''){
		extract($settings);

        if($sourceType == 'latest_item'){
            global $product;
            if(is_object($product)){
                $postId = $product->get_id();
                $_product = $product;
            }else{
                global $post;
                if(is_object($post)){
                    if($post->post_type == 'product'){
                        $postId = $post->ID;
                    }else{
                        return;
                    }
                }else{
                    $postId = 0;
                }
                $_product = gspbwoo_get_product_object_by_id($postId);
                $product = $_product;
            }
        }else{
            $postId = (isset($postId) && $postId > 0) ? (int)$postId : 0;
            $_product = gspbwoo_get_product_object_by_id($postId);
        }

        $postfix = isset($postfix) ? esc_attr($postfix) : '';
        $label = isset($label) ? esc_attr($label) : '';

        if(!$_product) return __('Product not found.', 'greenshiftwoo');

		$blockId = 'gspb_id-'.$id;
		$blockClassName = 'gspb-buttonbox '.$blockId.' '.(!empty($className) ? $className : '').'';

        $buynowicon = '';
        if($enableiconBuy){
            $pattern = '/<span class="woobtniconBuy">(.*?)<\/span>/';
            preg_match($pattern, $inner_content, $matches);
            if (isset($matches[0])) {
                $inner_content = preg_replace($pattern, '', $inner_content);
                $buynowicon = $matches[0];
            }
            
        }

		$out = '<div class="'.$blockClassName.'"'.gspb_AnimationRenderProps($animation).'>';
            if($innerPage || $loopBlock){
                $btnText = $_product->single_add_to_cart_text();
                if($simpleLabel){
                    $btnText = $simpleLabel;
                }elseif($variableLabel && $_product->is_type('variable')){
                    $btnText = $variableLabel;
                }elseif($affiliateLabel && $_product->is_type('external')){
                    $btnText = $affiliateLabel;
                }
                if($loopBlock){
                    wp_enqueue_script('wc-add-to-cart-variation');
                    wp_enqueue_script('gsvariationajax');
                }
                ob_start();
                do_action( 'woocommerce_' . $_product->get_type() . '_add_to_cart' );
                $form = ob_get_clean();
                $form = str_replace( 'single_add_to_cart_button', 'single_add_to_cart_button wp-element-button ', $form );
                if($loopBlock){
                    $addclass = $_product->is_purchasable() && $_product->is_in_stock() ? ' add_to_cart_button' : '';
                    $ajaxclass = $_product->supports( 'ajax_add_to_cart' ) && $_product->is_purchasable() && $_product->is_in_stock() ? ' ajax_add_to_cart' : '';
                    $form = str_replace( 'single_add_to_cart_button', 'single_add_to_cart_button wp-element-button'.$addclass.$ajaxclass.' ', $form );                    
                }
                $form = str_replace( 'button alt', '', $form );
                $form = str_replace( '<button', '<button data-quantity="1" data-product_id="'.$_product->get_id().'"', $form );
                $form = str_replace( $_product->single_add_to_cart_text(), '<span class="gspb-buttonbox-textwrap">'.$inner_content.'<span>'.esc_html($btnText).'</span></span>', $form );
                if($enableBuyNow && $_product->is_purchasable() && $_product->is_in_stock()){
                    $text = $buyNowText ? esc_html($buyNowText) : esc_html__('Buy Now', 'greenshiftwoo');
                    $form = str_replace( '<button', '<div class="buttons-wrapper"><button', $form );
                    $buynow = '<button type="submit" value="'.$product->get_id().'" name="gspb-quick-buy-now" class="single_add_to_cart_button wp-element-button gspb-quick-buy-now-button"><span className="gspb-buttonbox-textwrap">'.$buynowicon.'<span>'.$text.'</span></span></button>';
                    $form = str_replace( '</form>', $buynow.'</div></form>', $form );
                }

                $out .= $form;
            }else{
                $out .= self::get_button($_product, $inner_content, $simpleLabel, $variableLabel, $affiliateLabel);
            }
		$out .='</div>';
		return $out;
	}

    static function get_button($_product, $inner_content='', $simpleLabel='', $variableLabel='', $affiliateLabel=''){
        $defaults = array(
            'quantity'   => 1,
            'class'      => implode(
                ' ',
                array_filter(
                    array(
                        'product_type_' . $_product->get_type(),
                        $_product->is_purchasable() && $_product->is_in_stock() ? 'add_to_cart_button' : '',
                        $_product->supports( 'ajax_add_to_cart' ) && $_product->is_purchasable() && $_product->is_in_stock() ? 'ajax_add_to_cart' : '',
                    )
                )
            ),
            'attributes' => array(
                'data-product_id'  => $_product->get_id(),
                'data-product_sku' => $_product->get_sku(),
                'aria-label'       => $_product->add_to_cart_description(),
                'rel'              => 'nofollow',
            ),
        );

        $btnText = $_product->single_add_to_cart_text();
        if($simpleLabel){
            $btnText = $simpleLabel;
        }elseif($variableLabel && $_product->is_type('variable')){
            $btnText = $variableLabel;
        }elseif($affiliateLabel && $_product->is_type('external')){
            $btnText = $affiliateLabel;
        }

        $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( [], $defaults ), $_product );

        if ( isset( $args['attributes']['aria-label'] ) ) {
            $args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
        }

        return apply_filters(
            'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
            sprintf(
                '<a href="%s" data-quantity="%s" class="%s wp-element-button" %s>%s<span>%s</span></a>',
                esc_url( $_product->add_to_cart_url() ),
                esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                $inner_content,
                esc_html( $btnText )
            ),
            $_product,
            $args
        );
    }
}

new ProductButton;