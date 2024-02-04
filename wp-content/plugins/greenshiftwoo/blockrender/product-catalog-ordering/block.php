<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductCatalogOrdering{

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
	);

	public function render_block($settings = array(), $inner_content=''){
		extract($settings);
        $divider = isset($divider) ? esc_attr($divider) : '';

		$blockId = 'gspb_id-'.$id;
		$blockClassName = 'gspb-catalog-ordering-box '.$blockId.' '.(!empty($className) ? $className : '').'';

		$out = '<div class="'.$blockClassName.'"'.gspb_AnimationRenderProps($animation).'>';
			ob_start();
			if(function_exists('woocommerce_catalog_ordering')){
				$out .= woocommerce_catalog_ordering();
			}
			$output = ob_get_clean();
			$out .= $output;
		$out .='</div>';
		return $out;
	}
}

new ProductCatalogOrdering;