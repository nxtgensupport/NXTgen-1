<?php

if( !function_exists( 'exponent_cart' ) ) {
    function exponent_cart( $atts, $content, $tag ) {
        $atts = shortcode_atts( array(
            'icon_color' => '',
            'hover_icon_color'  => '',
            'key' => be_uniqid_base36(true)
        ), $atts, $tag );
    
        extract( $atts );
    
        $output = '';
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $key, 'Header' );
        $unique_class = 'tatsu-'.$key;
        $classes = array( 'tatsu-header-module', 'exponent-cart', $unique_class );

        $css_id = be_get_id_from_atts( $atts );
        $visibility_classes = be_get_visibility_classes_from_atts( $atts );
        $animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ;

        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }
        if( !empty( $animate ) ) {
            $classes[] = $animate;
        }

        $data_animations = be_get_animation_data_atts( $atts );
    
        ob_start();
        ?>
            <a <?php echo $css_id; ?> href="<?php echo wc_get_cart_url(); ?>" class="<?php echo implode( ' ', $classes ); ?>" <?php echo $data_animations; ?>>   
                <div class="exponent-cart-icon-count-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="29" viewBox="0 0 23 29">
                        <g fill="none" fill-rule="evenodd" stroke-width="2" transform="translate(0 1)">
                        <path d="M3.62646846,7 C3.10637982,7 2.67311371,7.3986624 2.6299227,7.91695452 L1.19737474,25.1075301 C1.1950729,25.1351521 1.19392049,25.1628579 1.19392049,25.1905756 C1.19392049,25.7428603 1.64163574,26.1905756 2.19392049,26.1905756 L20.8031792,26.1905756 C20.8308969,26.1905756 20.8586027,26.1894232 20.8862247,26.1871213 C21.4366017,26.1412566 21.8455897,25.6579071 21.7997249,25.1075301 L20.367177,7.91695452 C20.323986,7.3986624 19.8907199,7 19.3706312,7 L3.62646846,7 Z"/>
                        <path stroke-linecap="round" d="M7,9.27272727 C6.49128382,3.09090909 7.99128382,4.33408493e-16 11.5,0 C15.0087162,0 16.5087162,3.09090909 16,9.27272727"/>
                        </g>
                    </svg>
                    <div class="exponent-cart-count">
                        <?php echo is_object( WC()->cart ) ? esc_html( WC()->cart->get_cart_contents_count() ) : ''; ?>
                    </div>
                </div>
                <?php echo !empty( $custom_style_tag ) ? $custom_style_tag : ''; ?>
            </a>
        <?php
        $output = ob_get_clean();
        return $output;
    }
}
if( !function_exists( 'exponent_cart_prevent_autop' ) ) {
    function exponent_cart_prevent_autop( $content_filter, $tag ) {
        if( 'exponent_cart' === $tag ) {
            return false;
        }
        return $content_filter;
    }
    add_filter( 'tatsu_shortcode_output_content_filter', 'exponent_cart_prevent_autop', 10, 2 );
}

if( !function_exists( 'tatsu_register_shopping_cart' ) ) {
    function tatsu_register_shopping_cart() {
        $controls = array (
            'icon' => get_stylesheet_directory_uri().'/img/modules.svg#product',
            'title' => __( 'Shopping Cart', 'exponent' ),
            'is_js_dependant' => false,
            'child_module' => '',
            'type' => 'single',
            'inline' => true,
            'is_built_in' => false,
            'group_atts'  => array (
                array (
                    'type'  => 'tabs',
                    'group' => array (
                        array (
                            'type'  => 'tab',
                            'title' => __( 'Style', 'exponent' ),
                            'group' => array (
                                'icon_color',
                                'hover_icon_color',
                            )
                        ),
                        array (
                            'type'  => 'tab',
                            'title' => __( 'Advanced', 'exponent' ),
                            'group' => array (

                            )
                        ),
                    )
                )
            ),
            'atts' => array (
                array (
                    'att_name' => 'icon_color',
                    'type' => 'color',
                    'label' => __( 'Icon Color', 'exponent' ),
                    'default' => '#212121', 
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID}' => array(
                            'property' => 'color',
                        ),
                    ),
                ),
                array (
                    'att_name' => 'hover_icon_color',
                    'type' => 'color',
                    'label' => __( 'Icon Hover Color', 'exponent' ),
                    'default' => '#212121', 
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID}:hover' => array(
                            'property' => 'color',
                        ),
                    ),
                ),
            ),	        
        );
        tatsu_register_header_module( 'exponent_cart', $controls, 'exponent_cart', true );
    }
    add_action( 'tatsu_register_header_modules', 'tatsu_register_shopping_cart' );
}

if( !function_exists( 'exponent_wc_add_to_cart_fragments' ) ) {
    function exponent_wc_add_to_cart_fragments( $fragments ) {
        global $woocommerce;
        ob_start();
        ?>
            <div class="exponent-cart-count">
                <?php echo esc_html( $woocommerce->cart->cart_contents_count ); ?>
            </div>
        <?php
        $fragments['.exponent-cart-count'] = ob_get_clean();
        return $fragments;
    }
    add_filter( 'woocommerce_add_to_cart_fragments', 'exponent_wc_add_to_cart_fragments' );
}

if( !function_exists( 'exponent_products' ) ) {
    function exponent_products( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
            'limit'             => '8',
            'category'          => '',
            'columns'           => '4',
            'visibility'        => 'all',
            'category_select'   =>  '0',
            'order_by'          => 'date',
            'key'               => be_uniqid_base36(true),
        ), $atts, $tag );
        extract($atts);

        $shortcode_atts = array();
        $shortcode_atts['limit'] = $limit;
        $custom_style_tag = be_generate_css_from_atts($atts, $tag, $key);
		$custom_class_name = 'tatsu-'.$key;

        $classes = array('exp-products', 'tatsu-shortcode', $custom_class_name);
        $animate = ( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) ? ' tatsu-animate' : '' ;

        $css_id = be_get_id_from_atts( $atts );
        $visibility_classes = be_get_visibility_classes_from_atts( $atts );
        if( !empty( $visibility_classes ) ) {
            $classes[] = $visibility_classes;
        }
        if( !empty( $css_classes ) ) {
            $classes[] = $css_classes;
        }
        if( !empty( $animate ) ) {
            $classes[] = $animate;
        }
        $data_animations = be_get_animation_data_atts( $atts );

        if( !empty( $category ) ) {
            $shortcode_atts[ 'category' ] = $category;
            if( $category_select == '0' ){
               $shortcode_atts[ 'cat_operator' ] = "AND"; 
            }else{
               $shortcode_atts[ 'cat_operator' ] = "IN";
            }
        }
        $shortcode_atts['columns'] = $columns;
        if( !empty( $visibility ) ) {
            if( 'all' === $visibility ) {
                $shortcode_atts['visibility'] = 'visible';
            }
            if( 'featured' === $visibility ) {
                $shortcode_atts['visibility'] = 'featured';
            }
            if( 'on_sale' === $visibility ) {
                $shortcode_atts['on_sale'] = 'true';
            }
            if( 'top_rated' === $visibility ) {
                $shortcode_atts[ 'top_rated' ] = 'true';
            }
        }
        $shortcode_atts['orderby'] = $order_by;

        $shortcode_atts_string = '';
        if( !empty( $shortcode_atts ) ) {
            foreach( $shortcode_atts as $cur_atts_key => $cur_atts_val ) {
                $shortcode_atts_string .= $cur_atts_key . '=' . '"' . $cur_atts_val . '" ';
            }
        }
        $shortcode_str = '[products ' . $shortcode_atts_string . ' ]';
        ob_start();
        ?>
        <div <?php echo $css_id; ?> class="<?php echo implode( ' ', $classes ); ?>" <?php echo $data_animations; ?>>
            <?php echo !empty( $custom_style_tag ) ? $custom_style_tag : ''; ?>
            <?php
                if( shortcode_exists( 'products' ) ) {
                    echo do_shortcode( $shortcode_str ); 
                }
            ?>
        </div>
        <?php return ob_get_clean();
    }
}
if( !function_exists( 'exponent_products_prevent_autop' ) ) {
    function exponent_products_prevent_autop( $content_filter, $tag ) {
        if( 'exponent_products' === $tag ) {
            $content_filter = false;
        }
        return $content_filter;
    }
    add_filter( 'tatsu_shortcode_output_content_filter', 'exponent_products_prevent_autop', 10, 2 );
}

if( !function_exists( 'tatsu_register_exponent_products' ) ) {
    function tatsu_register_exponent_products() {
        $all_product_cats = get_categories( array(
            'taxonomy'     => 'product_cat',
            'orderby'      => 'name',
        ) );
        $cats_option = array();
        if( !empty( $all_product_cats ) ) {
            foreach( $all_product_cats as $product_cat ) {
                $cats_option[ $product_cat->slug ] = $product_cat->name;
            }
        }
        $controls = array (
            'icon' => '',
            'title' => __( 'Products', 'exponent' ),
            'is_js_dependant' => false,
            'child_module' => '',
            'type' => 'single',
            'is_built_in' => false,
            'group_atts'    => array (
                array (
                    'type'  => 'tabs',
                    'group' => array (
                        array (
                            'type'  => 'tab',
                            'title' => __( 'Content', 'exponent' ),
                            'group' => array (
                                'category_select',
                                'category',
                                'limit',
                                'visibility',
                                'order_by',
                            )
                        ),
                        array (
                            'type'  => 'tab',
                            'title' => __( 'Style', 'exponent' ),
                            'group' => array (
                                'columns'
                            )
                        ),
                        array (
                            'type'  => 'tab',
                            'title' => __( 'Advanced', 'exponent' ),
                            'group' => array (

                            )
                        ),
                    )
                )
            ),
            'atts' => array (
                array (
                    'att_name'      => 'limit',
                    'label'         => __( 'Products Count', 'exponent' ),
                    'type'          => 'number',
                    'options'  => array (
                        'unit' => '',
                    ),
                    'is_inline' => true,
                    'default'       => '8',
                ),
                array(
                    'att_name'  => 'category_select',
                    'label'     => esc_html__('Atleast one category?', 'tatsu'),                    
                    'type'      => 'switch',
                    'tooltip'   => 'Display products which have atleast one of the selected categories below. Default will display products which must have all selected categories below.',
                    'default'   => '0',
                ),
                array (
                    'att_name'      => 'category',
                    'label'         => __( 'Categories', 'exponent' ),
                    'type'          => 'grouped_checkbox',
                    'options'       => $cats_option,
                    'default'       => '',
                ),
                array (
                    'att_name'      => 'columns',
                    'label'         => __( 'Columns', 'exponent' ),
                    'type'          => 'slider',
                    'options'       => array (
                        'min'       => '2',
                        'max'       => '6',
                        'step'      => '1',
                        'unit'      => '',
                    ),
                    'default'   => '4',
                ),
                array (
                    'att_name'      => 'visibility',
                    'label'         => __( 'Show', 'exponent' ),
                    'type'          => 'select',
                    'options'       => array (
                        'all'       => 'All Products',
                        'on_sale'   => 'On Sale',
                        'featured'  => 'Featured',
                        'top_rated' => 'Top Rated',
                    ),
                    'default'       => 'all',
                ),
                array (
                    'att_name'      => 'order_by',
                    'label'         => __( 'Order By', 'exponent' ),
                    'type'          => 'select',
                    'options'       => array (
                        'date'      => 'Date',
                        'popularity'=> 'Popularity',
                        'rand'      => 'Random'
                    ),
                    'default'       => 'date'
                ),
            )
        );
        tatsu_register_module( 'exponent_products', $controls, 'exponent_products' );
    }
    add_action( 'tatsu_register_modules', 'tatsu_register_exponent_products' );
}