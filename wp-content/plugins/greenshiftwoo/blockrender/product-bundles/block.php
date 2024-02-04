<?php

namespace greenshiftwoo\Blocks;
defined( 'ABSPATH' ) OR exit;

class ProductBundles {

    public function __construct() {
        add_action( 'init', [$this, 'init_handler'] );
    }

    public function init_handler() {
        register_block_type(
            __DIR__,
            [
                'render_callback' => [$this, 'render_block'],
                'attributes'      => $this->attributes
            ]
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
        'mainTitle'       => array(
            'type'    => 'string',
            'default' => 'Bundles',
        ),
        'buttonText'       => array(
            'type'    => 'string',
            'default' => 'Add To Cart',
        ),
        'saveText'       => array(
            'type'    => 'string',
            'default' => 'Save {amount}%',
        ),
        'finalPrice'       => array(
            'type'    => 'string',
            'default' => '{amount} for {number} item(s)',
        ),
        'currentProductLabel'       => array(
            'type'    => 'string',
            'default' => 'This Product:',
        ),
        'showCategory'       => array(
            'type'    => 'boolean',
            'default' => true,
        ),
        'showTitle'       => array(
            'type'    => 'boolean',
            'default' => true,
        ),
        'showProductList'       => array(
            'type'    => 'boolean',
            'default' => true,
        ),
        'titleTag'       => array(
            'type'    => 'string',
            'default' => '',
        ),

	);

    public function render_block( $settings = [], $inner_content = '' ) {
        if ( ! function_exists( '\WC' ) || is_admin() ) {
            return;
        }

        $__attributes = [
            "showCategory" => true
        ];

        $settings = wp_parse_args( $settings, $__attributes );
        // error_log( print_r( $settings, 1 ) );

        extract( $settings );

        $animationClass = '';
        if ( isset( $animation ) ) {
            $animationClass = gspb_AnimationRenderProps( $animation );
        }

        $blockId        = 'gspb_id-' . $id;
        $blockClassName = get_block_wrapper_attributes(
            [
                'class' => ' gspb-product-bundle ' . $blockId . ' ' . ( ! empty( $className ) ? $className : '' )
            ]
        );

        $html = '';
        $html = '<div id='.$blockId.' '.$blockClassName.$animationClass.'>';
        $args = [
            'mainTitle'             => $mainTitle,
            'buttonText'       => $buttonText,
            'saveText'         => $saveText,
            'finalPrice'       => $finalPrice,
            'currentProductLabel'     => $currentProductLabel,
            'showCategory'     => $showCategory,
            'showTitle'        => $showTitle,
            'showProductList' => $showProductList,
            'titleTag'         => $titleTag
        ];
        $html .= \GREENSHIFT_WOO_BUNDLE_WC_Custom_Bundles::gspbwoo_get_bundle_product( false, $args, false );
        $html .= '</div>';
        return $html;
    }
}

new ProductBundles;