<?php


namespace greenshiftwoo\Blocks;

defined('ABSPATH') or exit;


class WooCartButton
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

	public function convertPlaceholders($value, $cartvalue, $cartcurrent, $cartleft){
		$value = str_replace('{{VALUE}}', '<span class="gspb-min-value">'.wc_price($cartvalue).'</span>', $value);
		$value = str_replace('{{CURRENT}}', '<span class="gspb-cart-value">'.wc_price($cartcurrent).'</span>', $value);
		$value = str_replace('{{MORE}}', '<span class="gspb-cart-left">'.wc_price($cartleft).'</span>', $value);
		return wp_kses_post($value);
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
		'align'       => array(
			'type'    => 'string',
			'default' => '',
		),
		'woobtn'       => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'slidingPanelOnClick'       => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'cartHeading' => array(
			'type'    => 'string',
			'default' => 'SHOPPING CART',
		),
		'enableBar' => array(
			'type'    => 'boolean',
			'default' => false,
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

	public function render_block($settings = array(), $inner_content = '')
	{
		extract($settings);

		$blockId = 'gspb_id-' . $id;
		$panelId = 'gspb_id-panel-' . $id;
		$blockClassName = 'gspb-woo-cart-button ' . $blockId . ' ' . (!empty($className) ? $className : '') . ' ';

		$cartbtn = !empty($woobtn) ? 'gspb-menu-cart-btn' : '';
		$panelOnClickClass = $slidingPanelOnClick ? 'gspb-menu-cart-btn-panel-open' : '';

		global $woocommerce;
		if (!$woocommerce || !$woocommerce->cart)
			return 'No Woocommerce plugin detected';

		wp_enqueue_script( 'wc-cart-fragments' );

		$out = '<div  class="' . $blockClassName . '"' . gspb_AnimationRenderProps($animation) . '>';
		$out .= '<div class="gspb_cart_button_value">';
		$out .= '
				<div class="gspb_woocartmenu_cell">
					<span class="' . $cartbtn . ' ' . $panelOnClickClass . '">
						<a class="gspb_woocartmenu-link cart-contents cart_count_' . $woocommerce->cart->cart_contents_count . '" href="' . wc_get_cart_url() . '">
							<span class="gspb_woocartmenu-icon">
								' . $inner_content . '
								<span class="gspb-woocartmenu-count">' . $woocommerce->cart->cart_contents_count . '</span>
							</span>
							<span class="gspb_woocartmenu-amount">' . $woocommerce->cart->get_total() . '</span>
						</a>
					</span>
					<div class="woocommerce widget_shopping_cart"></div>
				</div>';
		$out .= '</div>';
		$out .= '</div>';
		if ($slidingPanelOnClick) {
			$bar = '';
			if($enableBar){
				$enableAnimationClass = $enableAnimation ? ' gspb-inview' : '';
				$cartvalue = $minValue;
				$cartcurrent = $woocommerce->cart->get_total('raw');
				$cartleft = $cartvalue - $cartcurrent;
				$success = false;
				if($cartleft < 0){
					$cartleft = 0;
					$success = true;
				}
				$width = $cartcurrent / $cartvalue * 100;
				$titleBar = $success ? $this->convertPlaceholders($titleSuccess, $cartvalue, $cartcurrent, $cartleft) : $this->convertPlaceholders($title, $cartvalue, $cartcurrent, $cartleft);
				$bar = '<div class="gs-shipping-bar-in-cartpanel">';
				$bar .= '<div class="gs-progressbar__labels"><div class="gs-progressbar__title">'.$titleBar.'</div></div>';
				$bar .= '<div class="gs-progressbar__progress" data-reachpoint="'.$cartvalue.'">
					<div class="gs-progressbar__bar'.$enableAnimationClass.'" style="width:'.$width.'%"></div>
				</div>';
				$bar .='</div>';
			}
			$out .= '        
			<div id="gspb-woo-cart-panel" class="gspb-sslide-panel '.$panelId.'">
				<div id="gspb-woo-cart-panel-wrap" class="gspb-sslide-panel-wrap">
					<div id="gspb-woo-cart-panel-heading" class="gspb-sslide-panel-heading">
						<span>' . esc_attr($cartHeading) . '
							<svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" height="24px" class="close-panel-svg">
								<path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z" />
							</svg>
						</span>
					</div>
					<div id="gspb-woo-cart-panel-tabs" class="gspb-sslide-panel-tabs">
						'.$bar.'
						<div class="gspb-sslide-panel-inner woocommerce widget_shopping_cart" id="gspb-woo-cart-panel-content">
						</div>
					</div>
				</div>
			</div>';
		}
		return $out;
	}
}

new WooCartButton;
