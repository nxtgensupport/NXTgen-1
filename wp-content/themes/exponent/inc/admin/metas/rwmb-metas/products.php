<?php
$products_meta = array();
$meta_prefix = be_themes_get_meta_prefix();

$products_meta[] = array (
    'title'         => __( 'Single Product Overrides', 'exponent' ),
    'pages'         => array( 'product' ),
    'context'       => 'normal',
    'priority'      => 'high',
    'fields'        => array (
        array (
            'name'		=> __( 'Product Gallery Zoom', 'exponent' ),
            'id'		=> "{$meta_prefix}product_gallery_zoom",
            'type'		=> 'select',
            'options'	=> array (
                'inherit'   => 'Inherit from Global Options', 
                'yes'  => 'Yes',
                'no'   => 'No',
            ),
            'std'		=> 'inherit',
        ),
    )
);

return $products_meta;