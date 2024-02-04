<?php
add_action( 'typehub_register_options', 'be_grid_typehub_options', 12 );
if( !function_exists( 'be_grid_typehub_options' ) ){
    function be_grid_typehub_options() {
        $typography_options = array(
            'portfolio_title' => array(
                'label' => __( 'Title on Portfolio Grid', 'be-grid' ),
                'selector' => '.thumb-title-wrap .thumb-title, .full-screen-portfolio-overlay-title',
                'responsive' => true,
                'img' => BE_GRID_PLUGIN_URL.'/assets/typehub/portfolio_title.jpg',
                'options' => array(
                    'font-size'     => '24px',
                    'line-height'   => '34px',
                    'font-family'   => 'schemes:primary',
                    'font-variant'   => '600',
                    'text-transform' => 'none',
                    'letter-spacing' => '-0.005em'
                )
            ),
            'portfolio_meta_typo' => array(
                'label' => __( 'Meta on Portfolio Grid', 'be-grid' ),
                'selector' => '.thumb-title-wrap .portfolio-item-cats',
                'responsive' => true,
                'img' => BE_GRID_PLUGIN_URL.'/assets/typehub/portfolio_meta_typo.jpg',
                'options' => array(
                    'font-size'     => '12px',
                    'line-height'   => '17px',
                    'text-transform' => 'uppercase',
                    'letter-spacing'   => '1px',
                )
            ),
            'portfolio_details_title' => array(
                'label' => __( 'Portfolio Details Module - Title', 'be-grid' ),
                'selector' => 'h6.gallery-side-heading',
                'responsive' => true,
                'img' => BE_GRID_PLUGIN_URL.'/assets/typehub/portfolio_details_title.jpg',
                'options' => array(
                    'font-size'     => '16px',
                    'line-height'   => '24px',
                    'font-family'   => 'schemes:primary',
                    'font-variant'   => '600',
                    'text-transform' => 'none',
                    'letter-spacing' => '0px'
                )
            ),
            'portfolio_details_content' => array(
                'label' => __( 'Portfolio Details Module - Content', 'be-grid' ),
                'selector' => '.be-portfolio-details .gallery-side-heading-wrap p',
                'responsive' => true,
                'img' => BE_GRID_PLUGIN_URL.'/assets/typehub/portfolio_details_content.jpg',
                'options' => array(
                    'font-size'     => '16px',
                    'line-height'   => '24px',
                    'font-family'   => 'schemes:secondary',
                    'font-variant'   => '400',
                    'text-transform' => 'none',
                    'letter-spacing' => '0px'
                )
            ),
            'portfolio_filter_typo' => array(
                'label' => __( 'Portfolio Filters', 'be-grid' ),
                'selector' => '.be-portfolio-wrap .portfolio-filter_item',
                'responsive' => true,
                'img' => BE_GRID_PLUGIN_URL.'/assets/typehub/portfolio_filter_typo.jpg',
                'options' => array(
                    'color'         => '#343638',
                    'font-size'     => '12px',
                    'line-height'   => '30px',
                    'font-family'   => 'schemes:primary',
                    'font-variant'   => '600',
                    'text-transform' => 'uppercase',
                    'letter-spacing' => '1px'
                )
            ),
        );

        typehub_register_options( $typography_options, 'Portfolio' );
}
}