<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductBreadcrumbs{

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
        'delimiter'       => array(
            'type'    => 'string',
            'default' => '',
        ),
		'home'       => array(
            'type'    => 'string',
            'default' => 'Home',
        ),
	);

	public function render_block($settings = array(), $inner_content=''){
		extract($settings);
        $delimiter = isset($delimiter) ? esc_attr($delimiter) : '';

		$blockId = 'gspb_id-'.$id;
		$blockClassName = 'gspb-breadcrumbsbox '.$blockId.' '.(!empty($className) ? $className : '').'';

		$out = '<div class="'.$blockClassName.'"'.gspb_AnimationRenderProps($animation).'>';
			
			ob_start();
            woocommerce_breadcrumb(array(
				'delimiter'   => $delimiter ? '<span class="gspb_breadcrumbs_delimiter">'.$delimiter.'</span>' : '<span class="gspb_breadcrumbs_delimiter"> / </span>',
				'before'      => '<span class="gspb_breadcrumbs_value">',
				'after'       => '</span>',
				'home'		=> $home,
			));
			$output = ob_get_clean();
			$out .= $output;
		$out .='</div>';
		return $out;
	}
}

new ProductBreadcrumbs;