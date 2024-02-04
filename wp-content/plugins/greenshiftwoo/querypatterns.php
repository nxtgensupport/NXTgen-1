<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

//////////////////////////////////////////////////////////////////
// Query block and styles
//////////////////////////////////////////////////////////////////

function gspb_woocommerce_register_block_patterns() {

	if ( function_exists( 'register_block_pattern_category_type' ) ) {
		register_block_pattern_category_type( 'gspbwoocommerce', array( 'label' => __( 'Greenshift Woocommerce', 'greenshiftwoo' ) ) );
	}

	$block_pattern_categories = array(
		'gspb_woocommerce-query'   => array(
			'label'         => __( 'Greenshift Woocommerce Loop', 'greenshiftwoo' ),
			'categoryTypes' => array( 'gspbwoocommerce' ),
		),
		'gspb_woocommerce-templates'   => array(
			'label'         => __( 'Greenshift Woocommerce FSE templates', 'greenshiftwoo' ),
			'categoryTypes' => array( 'gspbwoocommerce' ),
		),
	);

	foreach ( $block_pattern_categories as $name => $properties ) {
		register_block_pattern_category( $name, $properties );
	}

	$block_patterns = array(
		'query/querywoogrid',
		'query/querywoogridajax',
		'template/shop',
		'template/single',
		'template/search',
		'template/singlegallery',
	);

	foreach ( $block_patterns as $block_pattern ) {
		register_block_pattern(
			'gspb_woo/' . $block_pattern,
			require GREENSHIFTWOO_DIR_PATH .'patterns/' . $block_pattern . '.php'
		);
	}

}

add_action( 'init', 'gspb_woocommerce_register_block_patterns', 9 );