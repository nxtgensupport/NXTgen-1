<?php

namespace greenshiftwoo\Blocks;

defined( 'ABSPATH' ) OR exit;

class ProductCombo {

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
            'default' => 'Combos',
        ),
        'buttonText'       => array(
            'type'    => 'string',
            'default' => 'Add To Cart',
        ),
        'saveText'       => array(
            'type'    => 'string',
            'default' => 'Save {amount}',
        ),
        'finalPrice'       => array(
            'type'    => 'string',
            'default' => 'Only {amount}',
        ),
        'showTitle'       => array(
            'type'    => 'boolean',
            'default' => true,
        ),
        'titleTag'       => array(
            'type'    => 'string',
            'default' => 'h2',
        ),
        'combosWithLabel'       => array(
            'type'    => 'string',
            'default' => 'Combo with: ',
        ),
        'saveLabel'       => array(
            'type'    => 'string',
            'default' => 'Combo price: ',
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

        extract( $settings, EXTR_SKIP );

        $animationClass = '';
        if ( isset( $animation ) ) {
            $animationClass = gspb_AnimationRenderProps( $animation );
        }

        $blockId        = 'gspb_id-' . $id;
        $blockClassName = get_block_wrapper_attributes(
            [
                'class' => 'gspb-product-combo ' . $blockId . ' ' . ( ! empty( $className ) ? $className : '' )
            ]
        );

        ob_start();
        echo '<div id='.$blockId.' '.$blockClassName.$animationClass.'>';


        gspbwoo_get_view_file( 'product_combo', array_merge( $settings, [
            'titleTag'   => $titleTag ?? 'h2',
            'show_title'  => $showTitle ?? true,
            'isTab'       => false,
            'title'       => $mainTitle ?? false,
            'offer_label' => $saveLabel ?? false,
            'offer_text'  => $saveText ?? false,
            'with_text'   => $combosWithLabel ?? false,
            'final_price' => $finalPrice ?? false,
            'button_text' => $buttonText ?? false
        ] ) );

        echo '</div>';
        return ob_get_clean();
    }
}

new ProductCombo;