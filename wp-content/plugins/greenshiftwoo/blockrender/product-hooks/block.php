<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductHooks{

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
        'shophook'       => array(
            'type'    => 'string',
            'default' => '',
        ),
	);

	public function render_block($settings = array(), $inner_content=''){
		extract($settings);

		$blockId = 'gspb_id-'.$id;
		$blockClassName = 'gspb-woo-hooks '.$blockId.' '.(!empty($className) ? $className : '').'';

		$out = '<div class="'.$blockClassName.'"'.gspb_AnimationRenderProps($animation).'>';
            if($shophook){
                ob_start();
                if($shophook == 'generate_product_data'){
                    echo \WC_Structured_Data::generate_product_data();
                }else if($shophook == 'generate_website_data'){
                    $structure = new \WC_Structured_Data;
                    echo $structure->generate_website_data();
                }else if($shophook == 'woocommerce_breadcrumb'){
                    echo \woocommerce_breadcrumb();
                }else if($shophook == 'woocommerce_account_content'){
					echo '<div class="woocommerce"><div class="woocommerce-MyAccount-content">';
					if(function_exists('greenshift_generate_incss')){
						echo greenshift_generate_incss('woomyaccount');
					}
                    do_action('woocommerce_account_content');
					echo '</div></div>';
                }else{
                    $shophook = esc_attr($shophook);
                    do_action($shophook);
                }
                $form = ob_get_clean();
                $out .= $form;
            }
		$out .='</div>';
		return $out;
	}
}

new ProductHooks;