<?php
if( !function_exists( 'exponent_wc_register_theme_support' ) ) {
    function exponent_wc_register_theme_support() {
        add_theme_support( 'woocommerce', array (
            'gallery_thumbnail_image_width' => 200,
        ) );
        add_theme_support( 'wc-product-gallery-zoom' );
    }
}

if( !function_exists( 'exponent_wc_catalog_columns' ) ) {
    function exponent_wc_catalog_columns( $columns ) {
        $sidebar = be_themes_get_option( 'wc_loop_sidebar' );
        $full_width = be_themes_get_option( 'wc_archive_full_width' );
        $cols = 3;
        if( !empty( $sidebar ) && !empty( $full_width ) ) {
            $cols = be_themes_get_option( 'woocommerce_catalog_4_cols' );
        }else if( empty( $sidebar ) && !empty( $full_width ) ) {
            $cols = be_themes_get_option( 'woocommerce_catalog_6_cols' );
        }else if( empty( $sidebar ) && empty( $full_width ) ) {
            $cols = be_themes_get_option( 'woocommerce_catalog_3_cols' );
        }else if( !empty( $sidebar ) && empty( $full_width ) ){
            $cols = be_themes_get_option( 'woocommerce_catalog_4_cols_alt' );
        }else {
            $cols = 2;
        }
        if( !empty( $cols ) ) {
            return $cols;
        }
        return $columns;
    }
}

if( !function_exists( 'exponent_wc_add_custom_script' ) ) {
    function exponent_wc_add_custom_script() {
        $theme_version = be_themes_get_theme_info( 'version' );
        $suffix = be_themes_should_minify_assets() ? '.min' : '';
        wp_enqueue_script( 'wc-add-to-cart-variation' );
        wp_enqueue_script( 'exponent_wc_script', trailingslashit( get_template_directory_uri() ) . 'js/woocommerce/woocommerce' . $suffix . '.js', array( 'jquery', 'asyncloader', 'wc-add-to-cart-variation' ), $theme_version, true );
        wp_localize_script( 'exponent_wc_script', 'exponent_wc_script_data', array( 
			'show_cart_added_sidebar' => apply_filters( 'be_theme_exponent_show_cart_added_sidebar', true ),
		) );
    }
}

if( !function_exists( 'exponent_wc_add_custom_style' ) ) {
    function exponent_wc_add_custom_style() {
        $theme_version = be_themes_get_theme_info( 'version' );
        $suffix =  be_themes_should_minify_assets() ? '.min' : '';
        wp_enqueue_style( 'exponent_wc_style', trailingslashit( get_template_directory_uri() ) . 'css/woocommerce/woocommerce' . $suffix . '.css', array( 'exponent-main-css' ), $theme_version );
    }
}

if( !function_exists( 'exponent_wc_enqueue_styles_and_scripts' ) ) {
    function exponent_wc_enqueue_styles_and_scripts() {
        //remove default woocommerce styles
        add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

        //add custom styles and scripts
        add_action( 'wp_enqueue_scripts', 'exponent_wc_add_custom_style' );
        add_action( 'wp_enqueue_scripts', 'exponent_wc_add_custom_script' );
    }
}

if( !function_exists( 'exponent_wc_archive_wrapper_start' ) ) {
    function exponent_wc_archive_wrapper_start() {
        $sidebar = be_themes_get_option( 'wc_loop_sidebar' );
        $full_width = be_themes_get_option( 'wc_archive_full_width' );
        if( empty( $full_width ) ) {
            echo '<div class="' . be_themes_get_class( 'wrap' ) . '">';
        }
        if( !empty( $sidebar ) ) {
            $sidebar_position = be_themes_get_option( 'wc_loop_sidebar_position' );
            if( !empty( $sidebar_position ) ) {
                set_query_var( 'be_sidebar_position', $sidebar_position );
            }
            if( !empty( $full_width ) ) {
                set_query_var( 'be_sidebar_with_margin' , true);
            }
            get_template_part( 'template-parts/posts/sidebar', 'start' );
        }
    }
}

if( !function_exists( 'exponent_wc_archive_wrapper_end' ) ) {
    function exponent_wc_archive_wrapper_end() {

        $sidebar = be_themes_get_option( 'wc_loop_sidebar' );
        $full_width = be_themes_get_option( 'wc_archive_full_width' );
        if( !empty( $sidebar ) ) {
            get_template_part( 'template-parts/posts/sidebar', 'end' );
        }
        if( empty( $full_width ) ) {
            echo '</div>'; //End exp-wrap
        }
    }
}

if( !function_exists( 'exponent_wc_output_content_wrapper' ) ) {
    function exponent_wc_output_content_wrapper() {
        $is_archive = is_woocommerce() && is_archive();
        $wrapper_class = is_product() ? be_themes_get_class( 'product-single' ) : ( $is_archive ? be_themes_get_class( 'product-archive' ) : '' );
        do_action('tatsu_head');
        if( !is_page_template(  "page-templates/product_fixed.php" ) ) {
            get_template_part( 'template-parts/partials/content-pad', 'start' );
        }
        $content = sprintf( '<div class="%s">', $wrapper_class );
        echo wp_kses_post( $content );  

    }
}

if( !function_exists( 'exponent_wc_output_content_wrapper_end' ) ) {
    function exponent_wc_output_content_wrapper_end() {
        if( !is_page_template(  "page-templates/product_fixed.php" ) ) {
            get_template_part( 'template-parts/partials/content-pad', 'end' );
        }
        echo '</div>'; //End exp-content
    }
}

if( !function_exists( 'exponent_wc_get_gutter_value' ) ) {
    function exponent_wc_get_gutter_value() {
        $gutter = be_themes_get_option( 'wc_grid_gutter' );
        $gutter_value = 0;
        switch( $gutter ) {
            case 'tiny' : 
                $gutter_value = '10';
                break;
            case 'small' :
                $gutter_value = '20';
                break;
            case 'medium' :
                $gutter_value = '50';
                break;
            case 'large' :
                $gutter_value = '70';
                break;
            default :
            $gutter_value = '20';
                break;
        }
        return $gutter_value;
    }
}

if( !function_exists( 'exponent_wc_product_loop_start' ) ) {
    function exponent_wc_product_loop_start() {
        $cols =  wc_get_loop_prop( 'columns' );
        $data_attrs = array();
        $loop_name = wc_get_loop_prop( 'name' );
        $sidebar = be_themes_get_option( 'wc_loop_sidebar' );
        $mobile_two_cols = be_themes_get_option( 'wc_loop_mobile_two_cols' );
        $class = array();
        $class[] = 'columns-' . $cols;
        $data_attrs[] = 'data-cols = "' . $cols .'"';
        if( !empty( $mobile_two_cols ) ) {
            $data_attrs[] = 'data-mobile-cols="2"';
        }
        //related/upsells products loop
        if( 'related' === $loop_name || 'up-sells' === $loop_name ) {
            $lazy_load = be_themes_get_option( 'lazy_load' );
            if( 'related' === $loop_name ) {
                $class[] = be_themes_get_class( 'related-products' );
            }else if( 'up-sells' === $loop_name ) {
                $class[] = be_themes_get_class( 'upsells' );
            }
            $class[] = 'be-slider';
            $class[] = 'be-slider-cols-' . $cols;
            if( !empty( $lazy_load ) ) {
                $data_attrs[] = 'data-lazy-load = "1"';
            }
            $data_attrs[] = 'data-gutter = "30"';
            $data_attrs[] = 'data-arrows = "1"';
            $data_attrs[] = 'data-outer-arrows="1"';
        }else {
            $display_type = woocommerce_get_loop_display_mode();
            $cropping = get_option( 'woocommerce_thumbnail_cropping', '1:1' );
            $full_width = be_themes_get_option( 'wc_archive_full_width' );
            $gutter = be_themes_get_option( 'wc_grid_gutter' );
            $class[] = "be-grid";
            $class[] = "be-cols-" . $cols;
            $class[] = 'be-grid-gutter-' . $gutter;
            if( !empty( $full_width ) && empty( $sidebar ) ) {
                $class[] = 'be-grid-with-margin';
            }
            if( 'uncropped' === $cropping ) {
                $gutter_value = exponent_wc_get_gutter_value();
                $data_attrs[] = 'data-layout = "masonry"';
                $data_attrs[] = 'data-scroll-reveal = "1"';
                $data_attrs[] = 'data-gutter = "' . $gutter_value . '"';    
            }
            if( 'subcategories' !== $display_type ) {
                $add_to_cart = be_themes_get_option( 'wc_enable_add_to_cart' );
                $add_to_cart_style = be_themes_get_option( 'wc_add_to_cart_style' );
                if( !empty( $add_to_cart ) ) {
                    $class[] = be_themes_get_class( 'product-loop-cart-style-' . $add_to_cart_style );
                }
            }
            if( 'subcategories' === $display_type ) {
                $class[] = 'categories';
            }else {
                $class[] = $display_type;
            }
        }
        $class_string = implode( ' ', $class );
        $data_attrs_string = implode( ' ', $data_attrs );

        $output = '';
        $output .= '<div class="'. be_themes_get_class( 'product-loop' ) . '">';
        $output .= '<ul class="' . $class_string .  '" ' . $data_attrs_string . '>';
        return $output;
    }
}

if( !function_exists( 'exponent_wc_product_loop_end' ) ) {
    function exponent_wc_product_loop_end() {
        $output = '</ul>'; // grid/slider end
        $output .= '</div>'; //product loop end
        return $output;
    }
}

if( !function_exists( 'exponent_wc_archive_product_wrapper' ) ) {
    function exponent_wc_archive_product_wrapper() {
        $loop_name = wc_get_loop_prop( 'name' );
        $classes = array( 'exp-product-inner' );
        if( 'related' === $loop_name || 'up-sells' === $loop_name || 'cross-sells' === $loop_name ) {
            $classes[] = 'be-slide-inner';
        }
        echo '<div class="' . implode( ' ', $classes ) . '">';
    }
}

if( !function_exists( 'exponent_wc_archive_product_wrapper_end' ) ) {
    function exponent_wc_archive_product_wrapper_end() {
        echo '</div>'; //End product inner
    }
}

if( !function_exists( 'exponent_wc_archive_product_thumb_wrapper' ) ) {
    function exponent_wc_archive_product_thumb_wrapper() {
        echo '<div class="exp-thumb-wrap">';
    }
}

if( !function_exists( 'exponent_wc_archive_product_thumb' ) ) {
    function exponent_wc_archive_product_thumb() {
        echo '<a class="exp-thumb" href="' . get_the_permalink() .'">';
    }
}

if( !function_exists( 'exponent_wc_archive_product_thumb_end' ) ) {
    function exponent_wc_archive_product_thumb_end() {
        echo '</a>';
    }
}

if( !function_exists( 'exponent_wc_archive_get_loop_thumb' ) ) {
    function exponent_wc_archive_get_loop_thumb() {
        global $product;
        $class = array();
        $attrs = array();
        $loop_name = wc_get_loop_prop( 'name' );
        $lazy_load = be_themes_get_option( 'lazy_load' ) && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) && !( defined( 'REST_REQUEST' ) && REST_REQUEST );
        $prod_id = $product->get_id();
        $thumb_id = get_post_thumbnail_id( $prod_id );
        $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
        $image_details = wp_get_attachment_image_src( $thumb_id, $image_size );
        if( empty( $image_details ) ) {
            return;
        }
        $class[] = be_themes_get_class( 'img-object-fit' );
        $alt_text = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
        $attrs[] = sprintf( 'alt = "%s"', !empty( $alt_text ) ? $alt_text : '' );
        if( !empty( $lazy_load ) ) {
            if( 'related' === $loop_name || 'up-sells' === $loop_name || 'cross-sells' === $loop_name ) {
                $class[] = 'be-slider-lazy-load';
                $attrs[] = 'data-flickity-lazyload = "' . esc_url( $image_details[0] ) . '"';
            }else {
                $class[] = 'be-lazy-load';
                $attrs[] = 'data-src = "' . esc_url( $image_details[0] ) . '"';
            }
        }else {
            $attrs[] = 'src = "' . esc_url($image_details[0]) . '"'; 
        }
        echo sprintf( '<img class="%s" %s/>', implode( ' ', $class ), implode( ' ', $attrs ) );
    }
}

if( !function_exists( 'exponent_wc_archive_get_alt_thumb' ) ) {
    function exponent_wc_archive_get_alt_thumb() {
        $image_on_hover = be_themes_get_option( 'wc_alt_image_on_hover' );
        if( empty( $image_on_hover ) ) {
            return;
        }
        global $product;
        $loop_name = wc_get_loop_prop( 'name' );
        $lazy_load = be_themes_get_option( 'lazy_load' ) && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) && !( defined( 'REST_REQUEST' ) && REST_REQUEST );
        $attachment_ids = $product->get_gallery_image_ids();
        $class = array();
        $attrs = array();
        $class[] = be_themes_get_class( 'show-on-hover' );
        $class[] = be_themes_get_class( 'archive-alt-thumb' );
        $class[] = be_themes_get_class( 'img-object-fit' );            
        if( !empty( $attachment_ids ) ) {                    
            foreach ( $attachment_ids as $attachment_id ) {
                $image_link = wp_get_attachment_url( $attachment_id );
                if ( empty( $image_link ) ) {
                    continue;
                }
                $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
                $image_details = wp_get_attachment_image_src( $attachment_id, $image_size );
                $alt_text = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
                $attrs[] = sprintf( 'alt = "%s"', !empty( $alt_text ) ? $alt_text : '' );
                if( !empty( $lazy_load ) ) {
                    if( 'related' === $loop_name || 'up-sells' === $loop_name || 'cross-sells' === $loop_name ) {
                        $class[] = 'be-slider-lazy-load';
                        $attrs[] = 'data-flickity-lazyload = "' . esc_url( $image_details[0] ) . '"';
                    }else {
                        $class[] = 'be-lazy-load';
                        $attrs[] = 'data-src = "' . esc_url( $image_details[0] ) . '"';
                    }
                }else {
                    $attrs[] = 'src = "' . esc_url($image_details[0]) . '"'; 
                }
                $alt_image = sprintf( '<img class="%s" %s/>', implode( ' ', $class ), implode( ' ', $attrs ) );
                echo apply_filters( 'exponent_wc_get_alt_product_thumbnail', $alt_image, $attachment_id );
                break;
            }
        }

    }
}

if( !function_exists( 'exponent_wc_archive_quick_view_button' ) ) {
    function exponent_wc_archive_quick_view_button() {
        global $product;
        $loader_html = be_themes_get_loader();
        $quick_view = sprintf( '<a class="exp-quick-view" data-product-id="%s" href="#quick-view"><span class="exp-quick-view-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
        <path d="M569.354 231.631C512.969 135.949 407.81 72 288 72 168.14 72 63.004 135.994 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.031 376.051 168.19 440 288 440c119.86 0 224.996-63.994 281.354-159.631a47.997 47.997 0 0 0 0-48.738zM288 392c-75.162 0-136-60.827-136-136 0-75.162 60.826-136 136-136 75.162 0 136 60.826 136 136 0 75.162-60.826 136-136 136zm104-136c0 57.438-46.562 104-104 104s-104-46.562-104-104c0-17.708 4.431-34.379 12.236-48.973l-.001.032c0 23.651 19.173 42.823 42.824 42.823s42.824-19.173 42.824-42.823c0-23.651-19.173-42.824-42.824-42.824l-.032.001C253.621 156.431 270.292 152 288 152c57.438 0 104 46.562 104 104z"/>
    </svg>%s</span>%s</a>', $product->get_id(), esc_html__( 'Quick View', 'exponent' ) , $loader_html );
        echo apply_filters( 'be_quick_view_button_html', $quick_view );
    }
}

if( !function_exists( 'exponent_wc_archive_product_meta_on_hover' ) ) {
    function exponent_wc_archive_product_meta_on_hover() {
        $quick_view = be_themes_get_option( 'wc_enable_quick_view' );
        if( !empty( $quick_view ) ) {
            echo '<div class="exp-thumb-tools">';
            exponent_wc_archive_quick_view_button();
            echo '</div>';
        }
    }
}

if( !function_exists( 'exponent_wc_add_to_cart' ) ) {
    function exponent_wc_add_to_cart() {
        global $product;
        $add_to_cart = be_themes_get_option( 'wc_enable_add_to_cart' );
        $add_to_cart_style = be_themes_get_option( 'wc_add_to_cart_style' );
        $be_add_to_wishlist = be_themes_get_option( 'wc_enable_add_to_wishlist' );
        $wishlist_possible = $be_add_to_wishlist && function_exists( 'exponent_yith_add_wishlist_shop_page' );
        if( ( !empty( $add_to_cart ) && 'icon' === $add_to_cart_style && $product->is_type( 'simple' ) ) || !empty( $wishlist_possible ) ) {
            echo '<div class="be-row exp-archive-add-to-cart-wrap">';
            if( !empty( $add_to_cart ) && 'icon' === $add_to_cart_style && $product->is_type( 'simple' ) && $product->is_in_stock() ) {
                woocommerce_template_loop_add_to_cart();
            }
            if( $wishlist_possible ) {
                exponent_yith_add_wishlist_shop_page();
            }
            echo '</div>';
        }                
    }
}

if( !function_exists( 'exponent_wc_add_to_cart_args' ) ) {
    function exponent_wc_add_to_cart_args( $args, $product ) {
        if( !empty( $args ) && array_key_exists( 'class', $args ) ) {
            $wc_add_to_cart_style = be_themes_get_option( 'wc_add_to_cart_style' );
            $wc_show_cart_on_hover = be_themes_get_option( 'wc_archive_show_cart_on_hover' );
            $class = $args[ 'class' ];
            $class_array = explode( ' ', $class );
            if( !empty( $class_array ) ) {
                if( 'icon' === $wc_add_to_cart_style && $product->is_type( 'simple' ) && $product->is_in_stock() ) {
                    $class_array[0] = 'exp-wc-add-to-cart-icon';
                }else {
                    $class_array[0] = 'exp-wc-add-to-cart-button';
                }
                $class_array[] = 'exp-add-to-cart';
                if( 'icon' === $wc_add_to_cart_style && !empty( $wc_show_cart_on_hover ) ) {
                    $class_array[] = 'exp-show-on-hover';
                }
                $class = implode( ' ', $class_array );
                $args[ 'class' ] = $class;
            }
        }
        return $args;
    }
}

if( !function_exists( 'exponent_wc_add_to_cart_link' ) ) {
    function exponent_wc_add_to_cart_link( $add_to_cart_link, $product, $args ) {
        $wc_add_to_cart_style = be_themes_get_option( 'wc_add_to_cart_style' );
        $add_cart_content = '';
        if( 'icon' === $wc_add_to_cart_style && $product->is_type( 'simple' ) && $product->is_in_stock() ) {
            $add_cart_content = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path d="M11.5555556,14.2222222 C11.5555556,15.2035556 12.3502222,16 13.3333333,16 C14.3146667,16 15.1111111,15.2035556 15.1111111,14.2222222 C15.1111111,13.2391111 14.3146667,12.4444444 13.3333333,12.4444444 C12.3502222,12.4444444 11.5555556,13.2391111 11.5555556,14.2222222 Z M2.66666667,14.2222222 C2.66666667,15.2035556 3.46222222,16 4.44444444,16 C5.42488889,16 6.22222222,15.2035556 6.22222222,14.2222222 C6.22222222,13.2391111 5.42488889,12.4444444 4.44444444,12.4444444 C3.46222222,12.4444444 2.66666667,13.2391111 2.66666667,14.2222222 Z M5.81955556,9.93066667 L15.6577778,7.12 C15.8453333,7.06577778 16,6.86311111 16,6.66666667 L16,1.77777778 L3.55555556,1.77777778 L3.55555556,0.355555556 C3.55555556,0.16 3.39466667,0 3.20088889,0 L0.354666667,0 C0.16,0 0,0.16 0,0.355555556 L0,1.77777778 L1.77777778,1.77777778 L3.47555556,9.73955556 L3.55555556,10.5777778 L3.55555556,12.0435556 C3.55555556,12.2382222 3.71555556,12.3991111 3.91111111,12.3991111 L15.6444444,12.3991111 C15.84,12.3991111 16,12.2373333 16,12.0435556 L16,10.6666667 L6.00177778,10.6666667 C4.97955556,10.6666667 4.95822222,10.1768889 5.81955556,9.93066667 Z"/></svg>';
        } else {
            $add_cart_content = esc_html( $product->add_to_cart_text() );
        }        
        if( !empty( $add_cart_content ) ) {    
            $loader_html = be_themes_get_loader();
            $add_to_cart_link = sprintf( '<div class="%s"><a href="%s" data-quantity="%s" class="%s" %s>%s</a>%s</div>',
                        be_themes_get_class( 'wc-add-to-cart-wrap' ),
                        esc_url( $product->add_to_cart_url() ),
                        esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                        esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                        $add_cart_content,
                        $loader_html );
        }
        return $add_to_cart_link;
    }
}

if( !function_exists( 'exponent_wc_price' ) ) {
    function exponent_wc_price() {
        global $product;
        if ( $price_html = $product->get_price_html() ) :
        ?>
            <span class="price <?php echo be_themes_get_class( 'wc-loop-price' ); ?>">
                <?php echo wp_kses_post( $price_html ); ?>
            </span>
        <?php
        endif;
    }
}

if( !function_exists( 'exponent_wc_archive_product_thumb_wrapper_end' ) ) {
    function exponent_wc_archive_product_thumb_wrapper_end() {
        echo '</div>';
    }
}

if( !function_exists( 'exponent_wc_archive_product_details_wrapper' ) ) {
    function exponent_wc_archive_product_details_wrapper() {
        echo '<div class="exp-product-details">';
    }
}

if( !function_exists( 'exponent_wc_archive_product_details_inner_wrapper' ) ) {
    function exponent_wc_archive_product_details_inner_wrapper() {
        echo '<div class="exp-product-details-inner">';
    }
}

if( !function_exists( 'exponent_wc_archive_product_details_inner_wrapper_end' ) ) {
    function exponent_wc_archive_product_details_inner_wrapper_end() {
        echo '</div>';
    }
}

if( !function_exists( 'exponent_wc_archive_product_details_wrapper_end' ) ) {
    function exponent_wc_archive_product_details_wrapper_end() {
        echo '</div>';
    }
}

if( !function_exists( 'exponent_wc_archive_product_categories' ) ) {
    function exponent_wc_archive_product_categories() {
        $product_cat_class = be_themes_get_class( 'product-categories' );
        echo '<div class="exp-product-categories-wrap">';
        $product_cat_html = be_themes_get_terms( get_the_ID(), 'product_cat', $product_cat_class, '', ', ' );
        echo apply_filters( 'be_wc_product_categories', $product_cat_html );
        echo '</div>';
    }
}

if( !function_exists( 'exponent_wc_archive_product_primary_meta' ) ) {
    function exponent_wc_archive_product_primary_meta() {
        $cats_enabled = be_themes_get_option( 'wc_enable_archive_category' );
        if( !empty( $cats_enabled ) ) {
            exponent_wc_archive_product_categories();
        }
    }
}

if( !function_exists( 'exponent_wc_archive_product_title' ) ) {
    function exponent_wc_archive_product_title() {
        $title_text = get_the_title();
        $title = '<h3 class="' . be_themes_get_class( 'product-title' ) . '"><a class="'. be_themes_get_class( 'product-title-link' ) . '" href="' . esc_url( get_permalink() ) . '" >' .  $title_text . '</a></h3>';
        echo apply_filters( 'exponent_wc_archive_product_title', $title, $title_text );
    }
}

if( !function_exists( 'exponent_wc_archive_product_secondary_meta' ) ) {
    function exponent_wc_archive_product_secondary_meta() {
        global $product;
        $rating_enabled = be_themes_get_option( 'wc_enable_archive_rating' );
        $prod_rating = $product->get_average_rating();
        if( !empty( $rating_enabled ) && 0 < $prod_rating ) {
            echo '<div class="exp-product-rating">';
            woocommerce_template_loop_rating();
            echo '</div>';
        }
    }
}

if( !function_exists( 'exponent_wc_archive_product_price' ) ) {
    function exponent_wc_archive_product_price() {
        $archive_price = be_themes_get_option( 'wc_enable_archive_price' );
        if( !empty( $archive_price ) ) {
            echo '<div class="exp-product-price">';
            exponent_wc_price();
            echo '</div>';
        }
    }
}

if( !function_exists( 'exponent_wc_archive_product_tertiary_meta' ) ) {
    function exponent_wc_archive_product_tertiary_meta() {
        global $product;
        $archive_add_to_cart = be_themes_get_option( 'wc_enable_add_to_cart' );
        $archive_add_to_cart_style = be_themes_get_option( 'wc_add_to_cart_style' );
        if( !empty( $archive_add_to_cart ) && ( 'button' === $archive_add_to_cart_style || !$product->is_type( 'simple' ) || !$product->is_in_stock()) ) {
            echo '<div class="' . be_themes_get_class( 'wc-price-cart-wrap' ) .'">';
            exponent_wc_archive_product_price();
            woocommerce_template_loop_add_to_cart(); 
            echo '</div>';
        }else {
            exponent_wc_archive_product_price();
        }
    }
}

if( !function_exists( 'exponent_wc_before_mini_cart_contents' ) ) {
    function exponent_wc_before_mini_cart_contents() {
        echo sprintf( '<div class="%s">', be_themes_get_class( 'wc-cart-contents-wrap' ) );
    }
}

if( !function_exists( 'exponent_wc_after_mini_cart_contents' ) ) {
    function exponent_wc_after_mini_cart_contents() {
        echo '</div>';
    }
}

if( !function_exists( 'exponent_wc_mini_cart_item_class' ) ) {
    function exponent_wc_mini_cart_item_class( $class_name ) {
        return $class_name . ' ' . be_themes_get_class( 'wc-mini-cart-item' );
    }
}

if( !function_exists( 'exponent_wc_cart_info' ) ) {
    function exponent_wc_cart_info( $current_html, $cart_item, $cart_item_key ) {
        $product = $cart_item[ 'data' ];
        if( $product && $product->exists() ) {
            $product_name = $product->get_name();
            $product_permalink = $product->is_visible() ? $product->get_permalink( $cart_item ) : '';
            echo '<div class="' . be_themes_get_class( 'wc-cart-info' ) . '">';
            echo !empty( $product_permalink ) ? '<a class="' . be_themes_get_class( 'wc-cart-product-title' ) . '" href="' . esc_url( $product_permalink ) . '">' . $product_name . '</a>'
                                                : '<span class="' . be_themes_get_class( 'wc-cart-title' ) . '">' . $product_name . '</span>';
            echo '<span class="' . be_themes_get_class( 'wc-mini-cart-meta' ) . '">'. $cart_item[ 'quantity' ] . ' &times ' . WC()->cart->get_product_price( $product ) . '</span>';
            echo '</div>';
        }
    }
}

if( !function_exists( 'exponent_wc_lost_pwd_link_start' ) ) {
    function exponent_wc_lost_pwd_link_start() {
        ob_start();
    }
}

if( !function_exists( 'exponent_wc_lost_pwd_link_end' ) ) {
    function exponent_wc_lost_pwd_link_end() {
        ob_end_clean();
        ?>
        <p class="form-row">
            <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'exponent' ); ?></span>
            </label>
            <button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Log in', 'exponent' ); ?>"><?php esc_html_e( 'Log in', 'exponent' ); ?></button>
        </p>
        <p class="woocommerce-LostPassword lost_password">
            <a class="<?php echo be_themes_get_class( 'lively-link-style1' ); ?>" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'exponent' ); ?></a>
        </p>
        <?php
    }
}

if( !function_exists( 'exponent_wc_customize_login' ) ) {
    function exponent_wc_customize_login() {
        add_filter( 'woocommerce_login_form', 'exponent_wc_lost_pwd_link_start' );
        add_filter( 'woocommerce_login_form_end', 'exponent_wc_lost_pwd_link_end' );
    }
}

if( !function_exists( 'exponent_wc_mini_cart_item_title' ) ) {
    function exponent_wc_mini_cart_item_title() {
        return '';
    }
}

if( !function_exists( 'exponent_wc_mini_cart_remove_item_title' ) ) {
    function exponent_wc_mini_cart_remove_item_title() {
        add_filter( 'woocommerce_cart_item_name', 'exponent_wc_mini_cart_item_title' );
    }
}

if( !function_exists( 'exponent_wc_customize_mini_cart' ) ) {
    function exponent_wc_customize_mini_cart() {
        add_action( 'woocommerce_before_mini_cart_contents', 'exponent_wc_before_mini_cart_contents' );
        add_action( 'woocommerce_before_mini_cart', 'exponent_wc_mini_cart_remove_item_title' );
        add_action( 'woocommerce_mini_cart_contents', 'exponent_wc_after_mini_cart_contents' );
        add_filter( 'woocommerce_mini_cart_item_class', 'exponent_wc_mini_cart_item_class' );
        add_filter( 'woocommerce_widget_cart_item_quantity', 'exponent_wc_cart_info', 10, 3 );
    }
}

if( !function_exists( 'exponent_wc_mini_cart' ) ) {
    function exponent_wc_mini_cart() {
        exponent_wc_customize_mini_cart();
    }
}

if( !function_exists( 'exponent_wc_cart_background' ) ) {
    function exponent_wc_cart_background() {
        ?>
            <div class="<?php echo be_themes_get_class( 'wc-cart-header' ); ?>">
                <div class="<?php echo be_themes_get_class( 'wc-cart-header-inner' ); ?>">
                    <h2 class="<?php echo be_themes_get_class( 'wc-cart-header-title' ); ?>">
                        <?php echo esc_html__( 'Your Shopping Cart', 'exponent' ); ?>
                    </h2>
                    <div class="<?php echo be_themes_get_class( 'wc-cart-header-description' ); ?>">
                        <?php echo esc_html__( 'Missed something ?', 'exponent' ); ?>
                        <a class="<?php echo be_themes_get_class( 'lively-link-style1' ); ?>" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
                            <?php echo esc_html__( 'Continue Shopping', 'exponent' ); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php
    }
}

if( !function_exists( 'exponent_wc_cart_content_wrap' ) ) {
    function exponent_wc_cart_content_wrap() {
        get_template_part( 'template-parts/partials/content-pad', 'start' );
        echo '<div class="' . be_themes_get_class( 'wrap' ) . '">';
    }
}

if( !function_exists( 'exponent_wc_cart_content_wrap_end' ) ) {
    function exponent_wc_cart_content_wrap_end() {
        echo '</div>';
        get_template_part( 'template-parts/partials/content-pad', 'end' );
    }
}

if( !function_exists( 'exponent_wc_cart_row_wrap' ) ) {
    function exponent_wc_cart_row_wrap() {
        echo '<div class="be-row ' . be_themes_get_class( 'cart-layout' ) . '">';
    }
}

if( !function_exists( 'exponent_wc_cart_row_wrap_end' ) ) {
    function exponent_wc_cart_row_wrap_end() {
        echo '</div>';
    }
}

if( !function_exists( 'exponent_wc_cart_table_wrap' ) ) {
    function exponent_wc_cart_table_wrap() {
        echo '<div class="' . be_themes_get_class( 'wc-cart-form-inner' ) . '">';
    }
}

if( !function_exists( 'exponent_wc_cart_table_wrap_end' ) ) {
    function exponent_wc_cart_table_wrap_end() {
        echo '</div>';
    }
}

if( !function_exists( 'exponent_wc_cart_coupon_start' ) ) {
    function exponent_wc_cart_coupon_start() {
        ob_start();
    }
}

if( !function_exists( 'exponent_wc_cart_coupon_end' ) ) {
    function exponent_wc_cart_coupon_end() {
        ob_end_clean();
        ?>
        <tr>
            <td colspan="6" class="actions">
                <?php if ( wc_coupons_enabled() ) { ?>
                    <div class="coupon">
                        <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'exponent' ); ?>" />
                        <button class="exp-wc-apply-coupon" type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'exponent' ); ?>">
                            <?php esc_attr_e( 'Apply coupon', 'exponent' ); ?>
                        </button>
                        <?php do_action( 'woocommerce_cart_coupon' ); ?>
                    </div>
                <?php } ?>
                <div class="exp-wc-update-cart">
                    <div class="exp-wc-update-cart-icon">
                    <svg width="17" height="17" viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.84378 3.81299C1.49377 6.18005 1.45377 9.99194 3.71576 12.424L6.02277 10.101L6.03778 15.9351L0.527771 15.634L2.26877 13.882C-0.795227 10.64 -0.757233 5.521 2.39175 2.35095C3.73676 0.995972 5.43378 0.213013 7.18875 0L7.25775 2.07703C6.00775 2.26599 4.80576 2.84399 3.84378 3.81299ZM10.3777 6.29895L10.3628 0.464966L15.8728 0.765015L14.1318 2.51892C17.1958 5.75891 17.1578 10.8779 14.0098 14.0499C12.6638 15.4039 10.9668 16.187 9.21176 16.4L9.14276 14.324C10.3928 14.135 11.5958 13.557 12.5568 12.588C14.9068 10.223 14.9467 6.41101 12.6848 3.97693L10.3777 6.29895Z"/>
                    </svg>
                    </div>
                    <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'exponent' ); ?>">
                        <?php esc_html_e( 'Update Your Cart', 'exponent' ); ?>
                    </button>
                </div>
                <?php do_action( 'woocommerce_cart_actions' ); ?>
                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
            </td>
        </tr>
        <?php
    }
}

if( !function_exists( 'exponent_wc_cart_collateral_inner_start' ) ) {
    function exponent_wc_cart_collateral_inner_start() {
        echo '<div class="exp-wc-cart-collaterals-inner">';
    }
}

if( !function_exists( 'exponent_wc_cart_collateral_inner_end' ) ) {
    function exponent_wc_cart_collateral_inner_end() {
        echo '</div>';
    }
}

if( !function_exists( 'exponent_wc_cart_form_wrap' ) ) {
    function exponent_wc_cart_form_wrap() {
        echo '<div class="' . be_themes_get_class( 'wc-checkout-form-wrap' ) . '">';
    }
}

if( !function_exists( 'exponent_wc_cart_form_wrap_end' ) ) {
    function exponent_wc_cart_form_wrap_end() {
        echo '</div>';
    }
}

if( !function_exists( 'exponent_wc_cart' ) ) {
    function exponent_wc_cart() {
        remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message' );
        remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices' );
        add_action( 'woocommerce_cart_is_empty', 'exponent_wc_cart_background', 5 );
        add_action( 'woocommerce_before_cart', 'exponent_wc_cart_background', 5 );
        add_action( 'woocommerce_before_cart', 'exponent_wc_cart_content_wrap', 5 );
        add_action( 'woocommerce_before_cart', 'exponent_wc_cart_row_wrap', 5 );
        add_action( 'woocommerce_before_cart_table', 'exponent_wc_cart_table_wrap' );
        add_action( 'woocommerce_cart_contents', 'exponent_wc_cart_coupon_start' );
        //add_action( 'woocommerce_after_cart_contents', 'exponent_wc_cart_coupon_end' );
        add_action( 'woocommerce_cart_collaterals', 'exponent_wc_cart_collateral_inner_start', 9 );
        add_action( 'woocommerce_cart_collaterals', 'exponent_wc_cart_collateral_inner_end', 11 );
        add_action( 'woocommerce_after_cart_table', 'exponent_wc_cart_table_wrap_end' );
        add_action( 'woocommerce_after_cart', 'exponent_wc_cart_row_wrap_end' );
        add_action( 'woocommerce_after_cart', 'exponent_wc_cart_content_wrap_end' );
    }
}

if( !function_exists( 'exponent_wc_coupon_message' ) ) {
    function exponent_wc_coupon_message( $message ) {
        return esc_html__( 'Have a coupon?', 'exponent' ) . ' <a href="#" class="showcoupon exp-lively-link-style1">' . esc_html__( 'Click here to enter your code', 'exponent' ) . '</a>';
    }
}

if( !function_exists( 'exponent_wc_login_message' ) ) {
    function exponent_wc_login_message( $message ) {
        return esc_html__( 'Returning customer?', 'exponent' ) . ' <a href="#" class="showlogin">' . esc_html__( 'Click here to login', 'exponent' ) . '</a>';
    }
}

if( !function_exists( 'exponent_wc_form_field_args' ) ) {
    function exponent_wc_form_field_args( $args ) {
        if( is_array( $args ) ) {
            if( !empty( $args['label'] ) && empty( $args[ 'placeholder' ] ) ) {
                $args['placeholder'] = $args['label'];
            }
            $args['label'] = '';
        }
        return $args;
    }
}

if( !function_exists( 'exponent_wc_add_billing_address_field_classes' ) ) {
    function exponent_wc_add_billing_address_field_classes( $address_fields ) {
        if( is_array( $address_fields ) ) {
            if( array_key_exists( 'billing_phone', $address_fields ) ) {
                $address_fields[ 'billing_phone' ][ 'class' ] = array( 'form-row-last' );
            }
            if( array_key_exists( 'billing_postcode', $address_fields ) ) {
                $address_fields[ 'billing_postcode' ][ 'class' ] = array( 'form-row-first' );
            }
        }
        return $address_fields;
    }
}

if( !function_exists( 'exponent_wc_add_default_address_field_classes' ) ) {
    function exponent_wc_add_default_address_field_classes( $address_fields ) {
        if( is_array( $address_fields ) ) {
            if( array_key_exists( 'city', $address_fields ) ) {
                $address_fields[ 'city' ][ 'class' ] = array( 'form-row-first' );
            }
            if( array_key_exists( 'state', $address_fields ) ) {
                $address_fields[ 'state' ][ 'class' ] = array( 'form-row-last' );
            }
        }
        return $address_fields;
    }
}

if( !function_exists( 'exponent_wc_login_form_start' ) ) {
    function exponent_wc_login_form_start() {
        ob_start();
    }
}

if( !function_exists( 'exponent_wc_login_form_end' ) ) {
    function exponent_wc_login_form_end() {
        ob_end_clean();
        ?>
            <div class="woocommerce-form-login-inner">
                <div class="be-row">
                    <div class="form-row">
                        <input type="text" class="input-text" name="username" id="username" placeholder = "<?php esc_html_e( 'Username or email*', 'exponent' ); ?>" autocomplete="username" />
                    </div>
                    <div class="form-row">
                        <input class="input-text" placeholder = "<?php esc_html_e( 'Password*', 'exponent' ); ?>" type="password" name="password" id="password" autocomplete="current-password" />
                    </div>
                    <?php do_action( 'woocommerce_login_form' ); ?>
                    <div class="form-row">
                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <button type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'exponent' ); ?>"><?php esc_html_e( 'Login', 'exponent' ); ?></button>
                        <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
                    </div>
                </div>
                <div class="lost_password">
                    <a class="exp-lively-link-style1" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'exponent' ); ?></a>
                </div>
                <div class="exp-wc-login-info">
                    <span class="exp-wc-login-info-note">
                        *Note
                    </span>
                    <?php echo esc_html__( 'If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing &amp; Shipping section.', 'exponent' ); ?>
                </div>
            </div>
        <?php
    }
}

if( !function_exists( 'exponent_wc_customize_checkout' ) ) {
    function exponent_wc_customize_checkout() {
        add_filter( 'woocommerce_form_field_args', 'exponent_wc_form_field_args', 10, 3 );
        add_filter( 'woocommerce_billing_fields', 'exponent_wc_add_billing_address_field_classes' );
        add_filter( 'woocommerce_default_address_fields', 'exponent_wc_add_default_address_field_classes' );
    }
}

if( !function_exists( 'be_is_quickview' ) ) {
    function be_is_quickview() {
        return defined( 'BE_WC_QUICKVIEW' ) && BE_WC_QUICKVIEW;
    }
}

function exponent_wc_quickview() {
    global $post, $product;
    $prod_id = $_POST[ 'product' ];
    if( !defined( 'BE_WC_QUICKVIEW' ) ) {
        define( 'BE_WC_QUICKVIEW', true );
    }
    $post = get_post( $prod_id );
    $product = wc_get_product( $prod_id );
    wc_get_template( 'content-quick-view.php' );
    die();
}

if( !function_exists( 'exponent_wc_quickview_gallery' ) ) {
    function exponent_wc_quickview_gallery( $product ) {
        $quickview_image_size = apply_filters( 'be_wc_quickview_gallery_image_size', 'woocommerce_single' ); 
        if( has_post_thumbnail() ) {
            $main_image_id = $product->get_image_id();
            $attachment_ids = $product->get_gallery_image_ids();
            $lazy_load = be_themes_get_option( 'lazy_load' );
            $data_attrs = array( 'data-dots="1"', 'data-arrows="1"' );
            if( !empty( $lazy_load ) ) {
                $data_attrs[] = 'data-lazy-load = "1"';
            }
        ?>
            <div class="be-slider exp-quickview-slider" <?php echo implode( ' ', $data_attrs ); ?>>
                <?php 
                    $image_details = wp_get_attachment_image_src( $main_image_id, $quickview_image_size ); 
                    if( is_array($image_details) && !empty($image_details) ) :
                ?>
                <div class="be-slide">
                    <div class="be-slide-inner">
                        <img class="<?php echo !empty( $lazy_load ) ? 'be-slide-lazy-load' : ''; ?>" <?php echo !empty( $lazy_load ) ? ('data-flickity-lazyload = "' . $image_details[0] .'"') : ('src = "' . $image_details[0] . '"'); ?> />
                    </div>
                </div>
                <?php endif; ?>
                <?php foreach( $attachment_ids as $attachment_id ) : ?>
                <?php 
                    $image_details = wp_get_attachment_image_src( $attachment_id, $quickview_image_size ); 
                    $alt_text = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
                    $alt_text = sprintf( 'alt = "%s"', !empty( $alt_text ) ? $alt_text : '' );
                    if( is_array($image_details) && !empty($image_details) ) :
                ?>
                <div class="be-slide">
                    <div class="be-slide-inner">
                        <img class="<?php echo !empty( $lazy_load ) ? 'be-slide-lazy-load' : ''; ?>" <?php echo !empty( $lazy_load ) ? ('data-flickity-lazyload = "' . $image_details[0] .'"') : ('src = "' . $image_details[0] . '"'); ?> <?php echo esc_attr( $alt_text ); ?> />
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php
            echo ob_get_clean();
        }
    }  
}

if( !function_exists( 'exponent_wc_quickview_summary' ) ) {
    function exponent_wc_quickview_summary( $product ) {
        ?>
            <div class="<?php echo be_themes_get_class( 'wc-product-info-inner' ); ?>">
                <a class="<?php echo be_themes_get_class( 'wc-product-title-wrap' ); ?>" href="<?php the_permalink(); ?>">
                    <?php woocommerce_template_single_title() ?>
                </a>
                <?php
                    exponent_wc_single_rating();
                    exponent_wc_single_price();
                    woocommerce_template_single_excerpt();
                    woocommerce_template_single_add_to_cart(); 
                ?>
            </div>
        <?php
    }
}

function exponent_wc_init_quick_view() {
    $theme_name = be_themes_get_theme_info( 'name' );
    $theme_name = lcfirst( $theme_name );
    $ajax_admin_hook = 'wp_ajax_' . $theme_name . '_quickview';
    $ajax_public_hook = 'wp_ajax_nopriv_' . $theme_name . '_quickview';
    add_action( $ajax_admin_hook, 'exponent_wc_quickview' );
    add_action( $ajax_public_hook, 'exponent_wc_quickview' );

    add_action( 'exponent_wc_quickview_product_slider', 'exponent_wc_quickview_gallery' );
    add_action( 'exponent_wc_quickview_product_summary', 'exponent_wc_quickview_summary' );
}

if( !function_exists( 'exponent_wc_custom_product_searchform' ) ) {
    function exponent_wc_custom_product_searchform( $form ) {
        $form_style = be_themes_get_option( 'form_style' );
        if( 'border-with-underline' === $form_style || 'rounded-with-underline' === $form_style ) {
            $placeholder = '';
        }else {
            $placeholder = 'placeholder = "' . esc_attr__( 'Search Products', 'exponent' ). '"';
        }
		ob_start();
		?>
			<form role="search" method="get" class="woocommerce-product-search <?php echo be_themes_get_class( 'form', 'form-' . $form_style ); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
                <div class="<?php echo be_themes_get_class( 'form-field' ); ?>">
                    <input type="hidden" name="post_type" value="product" />
					<input type="text" value="<?php echo get_search_query(); ?>" name="s" class="search" <?php echo !empty( $placeholder ) ? $placeholder : ''; ?> />
					<?php if( 'border-with-underline' === $form_style || 'rounded-with-underline' === $form_style ) : ?>
						<label class="<?php echo be_themes_get_class( 'form-field-label' ); ?>">
							<?php echo esc_html__( 'Search Products', 'exponent' ); ?>
                        </label>
                        <span class="<?php echo be_themes_get_class( 'form-border' ); ?>"></span>
					<?php endif; ?>
					<span class="<?php echo be_themes_get_class( 'searchform-icon' ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21">
							<g fill="none" fill-rule="evenodd" stroke-width="2" transform="rotate(-45 9.27 7.257)">
								<circle cx="7.846" cy="7.846" r="6.846"></circle>
								<path stroke-linecap="round" d="M8.02203654,14.7239099 L8.02203654,23.1736574"></path>
							</g>
						</svg>
					</span>
				</div>
			</form>
		<?php
		return ob_get_clean();
    }
}

if( !function_exists( 'exponent_wc_tagcloud_widget' ) ) {
    function exponent_wc_tagcloud_widget( $args ) {
        $args['smallest'] = 13;
        $args['largest'] = 13;
        $args['unit'] =  'px';	  
        return $args;
    }
}

if( !function_exists( 'exponent_wc_layered_nav_remove_parenthesis' ) ) {
    function exponent_wc_layered_nav_remove_parenthesis( $text, $count ) {
        return '<span class="count">' . absint( $count ) . '</span>';
    }
}

if( !function_exists( 'exponent_wc_customize_widgets' ) ) {
    function exponent_wc_customize_widgets() {
        add_filter( 'get_product_search_form' , 'exponent_wc_custom_product_searchform' );
        add_filter( 'woocommerce_product_tag_cloud_widget_args' , 'exponent_wc_tagcloud_widget' );
        add_filter( 'woocommerce_layered_nav_count', 'exponent_wc_layered_nav_remove_parenthesis', 10, 2 );
    }
}

function exponent_wc_post_class( $classes, $class, $post_id ) {
    $is_loop = !empty( $GLOBALS['woocommerce_loop'] );
    if( $is_loop ) {
        $loop_name = wc_get_loop_prop( 'name' );
        if( 'related' === $loop_name || 'up-sells' === $loop_name || 'cross-sells' === $loop_name ) {
            $classes[] = 'be-slide';
        }else if( !be_is_quickview() && !is_product() ) {
            $classes[] = 'be-col';
        }
    }
    return $classes;
}

function exponent_wc_single_product_fixed_gallery_image( $image_id = '', $image_size = '' ) {
    $image_html        = '';
    $lazy_load = be_themes_get_option( 'lazy_load' );
    $placeholder_padding = be_themes_get_placeholder_padding( $image_id, $image_size );
    $image_details     = wp_get_attachment_image_src( $image_id, $image_size );
    if( empty( $image_details ) ) {
        return;
    }
    $sanitized_src = $image_details[0];
    $full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
    $full_src          = wp_get_attachment_image_src( $image_id, $full_size );
    $alt_text = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
    $alt_text = sprintf( 'alt = "%s"', !empty( $alt_text ) ? $alt_text : '' );
    ob_start();
    ?>
    <div class="woocommerce-product-gallery__image">
        <a class="woocommerce-product-gallery__image-inner" href="<?php echo esc_url($full_src[0]) ?>">
            <div style = "padding-bottom : <?php echo esc_attr( $placeholder_padding ); ?>%;background : #e5e5e5;" class="woocommerce-product-gallery__image-placeholder">
            </div>
            <img <?php echo !empty( $lazy_load ) ? ( 'data-src = "' . $sanitized_src . '"' ) : ( 'src = "' . $sanitized_src . '"' ); ?> class="<?php echo !empty( $lazy_load ) ? 'be-lazy-load' : ''; ?> woocommerce-product-fixed-gallery__image-img exp-img-object-fit" <?php echo esc_attr( $alt_text ); ?> />
        </a>
    </div>
    <?php
    $image_html = ob_get_clean();
    return $image_html;
}

function exponent_wc_single_product_fixed_gallery() {
    if( is_page_template(  "page-templates/product_fixed.php" ) ) {
        global $product;
        $attachment_ids = $product->get_gallery_image_ids();
        $html = '<div class="exp-wc-product-images-wrap woocommerce-product-gallery woocommerce-product-fixed-gallery images">';
        if( has_post_thumbnail() ) {
            $image_size = apply_filters( 'woocommerce_fixed_gallery_image_size', 'full' );
            $post_thumbnail_id = $product->get_image_id();
            $html .= exponent_wc_single_product_fixed_gallery_image( $post_thumbnail_id, $image_size );
            if( !empty( $attachment_ids ) ) {
                foreach( $attachment_ids as $attachment_id ) {
                    $html .= exponent_wc_single_product_fixed_gallery_image( $attachment_id, $image_size );
                }
            }
        }else {
            $html  .= '<div class="woocommerce-product-gallery__image--placeholder">';
            $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'exponent' ) );
            $html .= '</div>';       
        }
        $html .= '</div>';
        echo wp_kses_post( $html );
    }
}

function exponent_wc_single_product_gallery_image( $image_id, $placeholder_padding = '', $image_size = '', $main_gallery = true ) {
    $image_details     = wp_get_attachment_image_src( $image_id, $image_size );
    $lightbox_string = '';
    $image_attrs = array();
    $classes = array();
    $classes[] = 'be-slide';
    $slide_attrs = array();
    $alt_text = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
    $image_attrs[] = sprintf( 'alt = "%s"', !empty( $alt_text ) ? $alt_text : '' );
    if( $main_gallery ) {
        $image_full_details = wp_get_attachment_image_src( $image_id, 'full' );   
        $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
        $thumb_image_size = apply_filters( 'woocommerce_thumbnail_gallery_image_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
        $image_thumbnail_details = wp_get_attachment_image_src( $image_id, $thumb_image_size );
        $slide_attrs[] = 'data-rel = "product-gallery"';
        $slide_attrs[] = 'data-src = "' . esc_url( $image_full_details[0] ) . '"';
        $slide_attrs[] = 'data-thumb = "' . esc_url( $image_thumbnail_details[0] ) . '"';

        $image_attrs[] = 'data-large_image = "' . esc_url( $image_full_details[0] ) . '"';
        $image_attrs[] = 'data-large_image_width = "' . esc_attr( $image_full_details[1] ) . '"';
        $image_attrs[] = 'data-large_image_height = "' . esc_attr( $image_full_details[2] ) . '"';

        $classes[] = 'exp-wc-main-slider__image';
        $classes[] = 'product-gallery-lightbox';
    }else {
        $classes[] = 'exp-wc-thumb-slider__image';
    }
    $image_html        = '';
    $lazy_load = be_themes_get_option( 'lazy_load' );
    if( !empty( $lazy_load ) ) {
        $image_attrs[] = 'data-flickity-lazyload = "' . esc_url( $image_details[0] ) . '"';
    }
    if( !empty( $image_details ) ) {
        ob_start();
        ?>
            <div <?php echo implode( ' ', $slide_attrs ) ?> class="<?php echo implode( ' ', $classes ) ?>">
                <div class="be-slide-inner">
                    <div style = "padding-bottom : <?php echo esc_attr( $placeholder_padding ); ?>%;background : #e5e5e5;" class="<?php echo be_themes_get_class( 'slider-placeholder' ); ?>">
                    </div>
                    <img <?php echo implode( ' ', $image_attrs ) ?> class="exp-img-object-fit <?php echo !empty($lazy_load) ? 'be-slide-lazy-load' : ''; ?> <?php echo be_themes_get_class( 'wc-product-gallery-image' ); ?>" <?php echo empty( $lazy_load ) ? ( 'src = "' . esc_url( $image_details[0] ) . '"' ) : ''; ?> />
                </div>
            </div>
        <?php 
        $image_html = ob_get_clean();
    }
    return $image_html;
}

function exponent_wc_single_product_gallery() {
    if( !is_page_template(  "page-templates/product_fixed.php" ) ) {
        global $product;
        $columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
        $post_thumbnail_id = $product->get_image_id();
        $lazy_load = be_themes_get_option( 'lazy_load' );
        $attachment_ids = $product->get_gallery_image_ids();
        $wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
            'woocommerce-product-gallery',
            'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
            'woocommerce-product-gallery--columns-' . absint( $columns ),
            'images',
        ) );
        $main_slider_class =  be_themes_get_class('wc-main-slider' );
        $main_slider_class = apply_filters( 'be_wc_main_slider_class', $main_slider_class . ' be-slider woocommerce-product-gallery__wrapper' );
        $data_attrs   = array();
        if( !empty( $lazy_load ) ) {
            $data_attrs[] = 'data-lazy-load = "1"';
        }
        $data_attrs[] = 'data-arrows = "1"';
        ?>
            <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
                <figure class=" <?php echo esc_attr( $main_slider_class ); ?>" <?php echo apply_filters( 'be_wc_main_slider_atts', implode( ' ', $data_attrs ) ); ?>>
                    <?php
                    if ( has_post_thumbnail() ) {
                        $image_size = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
                        $placeholder_padding = be_themes_get_placeholder_padding( $post_thumbnail_id, $image_size );
                        $html  = exponent_wc_single_product_gallery_image( $post_thumbnail_id, $placeholder_padding, $image_size );
                        if( !empty( $attachment_ids ) ) {
                            foreach( $attachment_ids as $attachment_id ) {
                                $html .= exponent_wc_single_product_gallery_image( $attachment_id, $placeholder_padding, $image_size );
                            }
                        }
                    } else {
                        $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                        $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'exponent' ) );
                        $html .= '</div>';
                    }
                    echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );                    
                    ?>
                </figure>
                <?php do_action( 'woocommerce_product_thumbnails' ); ?>
            </div>
        <?php
    }
}

function exponent_wc_single_product_thumbnails() {
    global $product;
    $attachment_ids = $product->get_gallery_image_ids();
    $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
    $html = '';
    $image_size   = apply_filters( 'woocommerce_thumbnail_gallery_image_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
    $data_attrs   = array();
    $classes = array();
    $classes[] = 'be-slider';
    $classes[] = be_themes_get_class( 'wc-thumb-slider' );
    $classes[] = 'be-slider-cols-' . apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
    $data_attrs[] = 'data-lazy-load = "1"';
    $data_attrs[] = 'data-gutter = "16"';
    $data_attrs[] = 'data-cols = "' . apply_filters( 'woocommerce_product_thumbnails_columns', 4 ) . '"';
    $data_attrs[] = 'data-cell-align = "left"';
    $data_attrs[] = 'data-as-nav-for = ".' . be_themes_get_class( 'wc-main-slider' ) . '"';
    if( has_post_thumbnail() && !empty( $attachment_ids ) ) {
    ?>
        <div class="<?php echo apply_filters( 'be_wc_thumb_slider_class', implode( ' ', $classes ) ); ?>" <?php echo apply_filters( 'be_wc_thumb_slider_atts', implode( ' ', $data_attrs ) ); ?>>
            <?php
                $post_thumbnail_id = $product->get_image_id();
                $placeholder_padding = be_themes_get_placeholder_padding( $post_thumbnail_id, $image_size );                    
                $html  = exponent_wc_single_product_gallery_image( $post_thumbnail_id, $placeholder_padding, $image_size, false );
                if( !empty( $attachment_ids ) ) {
                    foreach( $attachment_ids as $attachment_id ) {
                        $html .= exponent_wc_single_product_gallery_image( $attachment_id, $placeholder_padding, $image_size, false );
                    }
                }
                echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
            ?>
        </div>
    <?php
    }
}

function exponent_wc_single_product_main_gallery( $html, $post_thumb_id ) {
    global $product;
    $attachment_ids = $product->get_gallery_image_ids();
    $html = '';
    if( has_post_thumbnail() ) {
        $html = '<div class="' . be_themes_get_class( 'wc-product-main-slider' ) . '">';
        $html .= wc_get_gallery_image_html( $post_thumb_id, true );
        if( !empty( $attachment_ids ) ) {
            foreach( $attachment_ids as $attachment_id ) {
                $html .= wc_get_gallery_image_html( $attachment_id, true );
            }
        }
        $html .= '</div>';
    }else {
        $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
        $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'exponent' ) );
        $html .= '</div>';                
    }
    return $html;
}

if( !function_exists( 'exponent_wc_single_product_thumbnail_cols' ) ) {
    function exponent_wc_single_product_thumbnail_cols() {
        return 5;
    }
}

function exponent_wc_get_gallery_thumbnail_html( $attachment_id ) {
    if( !empty( $attachment_id ) ) {
        $gallery_thumbnail =  wc_get_image_size( 'gallery_thumbnail' );
        $thumbnail_size    =  array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] );
        $image_size        =  apply_filters( 'exponent_wc_gallery_thumb_size', $thumbnail_size );
        $image             =  wp_get_attachment_image( $attachment_id, $image_size, false, array(
            'title'                   => get_post_field( 'post_title', $attachment_id ),
            'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
            'class'                   => be_themes_get_class( 'wc-gallery-thumbnail' ),
        ) );
        $gallery_thumb_html = sprintf( '<div class="%s">%s</div>', be_themes_get_class( 'wc-product-gallery-thumb-wrap' ), $image );
        return $gallery_thumb_html;
    }
    return '';
}

function exponent_wc_single_product_gallery_class( $wrapper_classes = array() ) {
    $vertical_slider = be_themes_get_option( 'wc_vertical_slider' );
    if( !empty( $vertical_slider ) ) {
        $wrapper_classes[] = be_themes_get_class( 'wc-vertical-gallery' );
    }
    return $wrapper_classes;
}

function exponent_wc_single_product_footer_wrapper() {
    echo '<div class="' . be_themes_get_class( 'wc-product-footer' ) . '">';
}

function exponent_wc_single_product_footer_outer_wrapper() {
    if( is_page_template(  "page-templates/product_fixed.php" ) ) {
        echo '<div class="' . be_themes_get_class( 'wrap' ) . '">';
    }
}

if( !function_exists( 'exponent_wc_single_default_fixed_content_wrap' ) ) {
    function exponent_wc_single_default_fixed_content_wrap() {
        if( !is_page_template() || is_page_template( "page-templates/product_fixed.php" ) ) {
            echo '<div class="' . be_themes_get_class( 'wrap' ) . '">';
        }
    }
}

if( !function_exists( 'exponent_wc_single_default_fixed_content_wrap_end' ) ) {
    function exponent_wc_single_default_fixed_content_wrap_end() {
        if( !is_page_template() || is_page_template( "page-templates/product_fixed.php" ) ) {
            echo '</div>';
        }
    }
}

function exponent_wc_single_product_footer_outer_wrapper_end() {
    if( is_page_template(  "page-templates/product_fixed.php" ) ) {
        echo '</div>';
    }
}

function exponent_wc_single_product_footer_wrapper_end() {
    echo '</div>';
}

function exponent_wc_single_product_breadcrumb() {
    $breadcrumb = be_themes_get_option( 'wc_single_product_breadcrumbs' );
    if( !empty( $breadcrumb ) ) {
        woocommerce_breadcrumb();
    }
}

function exponent_wc_single_rating() {
    global $product;
    if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
        return;
    }
    $rating_count = $product->get_rating_count();
    $review_count = $product->get_review_count();
    $average      = $product->get_average_rating();
    if ( $rating_count > 0 ) : ?>
        <div class="woocommerce-product-rating <?php echo be_themes_get_class( 'product-single-rating' ); ?>">
            <?php echo wc_get_rating_html( $average, $rating_count ); ?>
            <?php if ( comments_open() ) : ?>
                <a href="#reviews" class="woocommerce-review-link" rel="nofollow">
                    <?php echo _n( 'View review', 'View reviews', $review_count, 'exponent' ); ?>
                </a>
            <?php endif ?>
        </div>

    <?php endif; ?>
<?php
}

function exponent_wc_single_price() {
    global $product;
    ?>
        <p class="price <?php echo be_themes_get_class( 'wc-single-price' ); ?>">
            <?php echo wp_kses_post( $product->get_price_html() ); ?>
        </p>
    <?php
}

function exponent_wc_product_info_inner_wrap() {
    echo '<div class="' . be_themes_get_class( 'wc-product-info-inner', is_page_template(  "page-templates/product_fixed.php" ) ? 'wrap' : '' ) . '">';
}

function exponent_wc_product_info_inner_wrap_end() {
    echo '</div>';
}

function exponent_wc_product_rating( $html, $rating, $count ) {
    $rating_percent = ( $rating/5 ) * 100;
    ob_start();
    ?>
        <div class="exp-product-star-wrap exp-star-hollow">
            <span class="exp-product-star">   
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon fill="none" points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg> 
            </span>                                  
            <span class="exp-product-star">    
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon fill="none" points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>         
            </span>                                 
            <span class="exp-product-star">     
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon fill="none" points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>      
            </span>                                 
            <span class="exp-product-star">    
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon fill="none" points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>    
            </span>                                 
            <span class="exp-product-star">           
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon fill="none" points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>     
            </span>    
        </div>
        <div style="width : <?php echo esc_attr( $rating_percent ) . '%'; ?>;" class="exp-product-star-wrap exp-star-filled">
            <span class="exp-product-star">    
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
            </span>                                  
            <span class="exp-product-star">    
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
            </span>                                 
            <span class="exp-product-star">     
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
            </span>                                 
            <span class="exp-product-star">    
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>    
            </span>                                 
            <span class="exp-product-star">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
            </span>    
        </div>
    <?php
    return ob_get_clean();
}

if( !function_exists( 'exponent_wc_single_product_zoom' ) ) {
    function exponent_wc_single_product_zoom() {
        $product = wc_get_product();
        $zoom_enabled = false;
        $single_product_zoom_meta = get_post_meta( $product->get_id(), be_themes_get_meta_prefix() . 'product_gallery_zoom', true );
        if( empty( $single_product_zoom_meta ) || 'inherit' === $single_product_zoom_meta ) {
            $zoom_enabled = be_themes_get_option( 'wc_single_product_gallery_zoom' );
        }else if( 'yes' === $single_product_zoom_meta ) {
            $zoom_enabled = true;
        }
        if( !empty($zoom_enabled) && get_theme_support( 'wc-product-gallery-zoom' ) ) {
            return true;
        }
        return false;
    }
}

function exponent_wc_single_product_gallery_wrapper() {
    echo '<div class="' . be_themes_get_class( 'wc-product-gallery-wrap' ) . '">';     
}

function exponent_wc_single_product_gallery_inner_wrapper() {
    if( is_page_template(  "page-templates/product_fixed.php" ) ) {
        echo '<div class="' . be_themes_get_class( 'wc-product-gallery-inner-wrap' ) . '">';
    }
}

function exponent_wc_single_product_gallery_inner_wrapper_end() {
    if( is_page_template(  "page-templates/product_fixed.php" ) ) {
        echo '</div>';
    }
}

function exponent_wc_single_product_gallery_wrapper_end() {
    echo '</div>';
}

function exponent_wc_single_meta() {
    $single_product_meta = be_themes_get_option( 'wc_single_product_meta' );
    if( !empty( $single_product_meta ) ) :
        global $product;
        $sku = $product->get_sku();
        ?>
            <div class="product_meta <?php echo be_themes_get_class( 'wc-product-meta' ); ?>">
                <?php do_action( 'woocommerce_product_meta_start' ); ?>
                <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
                    <div class="<?php echo be_themes_get_class( 'wc-sku-wrapper', 'wc-meta-wrap' ); ?> sku_wrapper">
                        <div class="<?php echo be_themes_get_class( 'wc-meta-label' ); ?>">
                            <?php esc_html_e( 'SKU:', 'exponent' ); ?> 
                        </div>
                        <div class="sku <?php echo be_themes_get_class( 'wc-meta-value' ); ?>"><?php echo !empty( $sku ) ? esc_attr( $sku ) : esc_html__( 'N/A', 'exponent' ); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                    $category_prefix = '<div class="' . be_themes_get_class( 'wc-meta-label' ) . '">'._n( 'Category: ', 'Categories: ', count( $product->get_category_ids() ), 'exponent' ).'</div><div class="' . be_themes_get_class( 'wc-meta-value' ) . '">';
                    $tag_prefix = '<div class="' . be_themes_get_class( 'wc-meta-label' ) . '">'._n( 'Tag: ', 'Tags: ', count( $product->get_tag_ids() ), 'exponent' ).'</div><div class="' . be_themes_get_class( 'wc-meta-value' ) . '">';
                ?>
                <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="posted_in ' . be_themes_get_class( 'wc-meta-wrap' ) . '">' . $category_prefix.' ' , '</div></div>' ); ?>
                <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<div class="tagged_as ' . be_themes_get_class( 'wc-meta-wrap' ) . '">' . $tag_prefix.' ' , '</div></div>' ); ?>
                <?php do_action( 'woocommerce_product_meta_end' ); ?>
            </div>
        <?php
    endif;
}

if( !function_exists( 'exponent_wc_single_share' ) ) {
    function exponent_wc_single_share() {
        if( function_exists( 'exponent_get_share_button' ) ) :
        ?>
            <div class="<?php echo be_themes_get_class( 'wc-product-share' ); ?>">
                <div class="<?php echo be_themes_get_class( 'wc-product-share-label' ); ?>">
                    <?php echo esc_html__( 'Share', 'exponent' ); ?>
                </div>
                <div class="<?php echo be_themes_get_class( 'wc-product-share-icons' ); ?>">
                    <?php echo exponent_get_share_button( get_the_permalink(), get_the_title(), get_the_ID(), 'tiny' ); ?>
                </div>
            </div>
        <?php
        endif;
    }
}

function exponent_wc_archive_product_grid_placeholder() {
    $cropping = get_option( 'woocommerce_thumbnail_cropping', '1:1' );
    $aspect_ratio_inv = 0;
    if( 'uncropped' === $cropping ) {
        global $product;
        $prod_id = $product->get_id();
        if( has_post_thumbnail( $prod_id ) ) {
            $post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $prod_id ), 'woocommerce_thumbnail' );
            if( !empty( $post_thumbnail ) ) {
                $width = $post_thumbnail[1];
                $height = $post_thumbnail[2];
                if( !empty( $width ) ) {
                    $aspect_ratio_inv = $height/$width;
                }
            }
        }
    }else if( 'custom' === $cropping ) {
        $width = max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_width', '4' ) );
        $height = max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_height', '3' ) );
        $aspect_ratio_inv = $height/$width;
    }else {
        $aspect_ratio_inv = 1;
    }
    echo '<div class="' . be_themes_get_class( 'thumb-placeholder' ) . '" style = "padding-bottom : ' . ( $aspect_ratio_inv * 100 ) . '%;">';
}

function exponent_wc_archive_product_grid_placeholder_end() {
    echo '</div>'; // End grid placeholder
}

function exponent_wc_single_product_content_wrapper() {
    if( !is_page_template(  "page-templates/product_fixed.php" ) ) {
        echo '<div class="' . be_themes_get_class( 'wrap' ) . '">';
    }
}

function exponent_wc_single_product_content_wrapper_end() {
    if( !is_page_template(  "page-templates/product_fixed.php" ) ) {
        echo '</div>';
    }
}

if( !function_exists( 'exponent_wc_single_product_notices_wrap' ) ) {
    function exponent_wc_single_product_notices_wrap() {
        if( is_page_template(  "page-templates/product_fixed.php" ) ) {
            $all_notices  = WC()->session->get( 'wc_notices', array() );
            if( !empty( $all_notices ) ) {
                global $exp_wc_has_notice;
                $exp_wc_has_notice = true;
                echo '<div class="' . be_themes_get_class( 'wrap' ) . '">';
            }
        }
    }
}

if( !function_exists( 'exponent_wc_single_product_notices_wrap_end' ) ) {
    function exponent_wc_single_product_notices_wrap_end() {
        global $exp_wc_has_notice;
        if( !empty( $exp_wc_has_notice ) ) {
            echo '</div>';
        }
    }
}

function exponent_wc_single_product_sidebar_start() {
    if( is_page_template(  "page-templates/product_right-sidebar.php" ) || is_page_template(  "page-templates/product_left-sidebar.php" ) ) {
        $position = is_page_template(  "page-templates/product_right-sidebar.php" ) ? 'right' : 'left';
        if( !empty( $position ) ) {
            set_query_var( 'be_sidebar_position', $position );
        }
        get_template_part( 'template-parts/posts/sidebar', 'start' );
    }
}

function exponent_wc_single_product_sidebar_end() {
    if( is_page_template(  "page-templates/product_right-sidebar.php" ) || is_page_template(  "page-templates/product_left-sidebar.php" ) ) {
        get_template_part( 'template-parts/posts/sidebar', 'end' );
    }
}

function exponent_wc_single_product_main_wrapper() {
    echo '<div class="' . be_themes_get_class( 'wc-product-main' ) . '">';
}

function exponent_wc_single_product_main_inner_wrapper() {
    echo '<div class="be-row">';
}

function exponent_wc_single_product_main_inner_wrapper_end() {
    echo '</div>';
}

function exponent_wc_single_product_main_wrapper_end() {
    echo '</div>';
}

if( !function_exists( 'exponent_wc_default_template_content_wrapper_end' ) ) {
    function exponent_wc_default_template_content_wrapper_end() {
        if( !is_page_template() ) {
            echo '</div>'; //end exp wrap;
        }
    }
}

if( !function_exists( 'exponent_wc_customize_reviews_tab' ) ) {
    function exponent_wc_customize_reviews_tab( $tabs ) {
        if( is_array( $tabs ) && isset( $tabs[ 'reviews' ] ) ) {
            $tabs[ 'reviews' ][ 'callback' ] = 'exponent_wc_reviews_tab_callback';
        }
        return $tabs;
    }
}

if( !function_exists( 'exponent_wc_reviews_tab_callback' ) ) {
    function exponent_wc_reviews_tab_callback() {
        if ( ! did_action( 'tatsu_head' ) ) {
			do_action( 'tatsu_head' );
		}
        //var_dump('hi');
        echo '<div class="be-themes-content-padding ' . be_themes_get_class( 'wrap' ) . '">';
        comments_template();
        echo '</div>';
    }
}

function exponent_wc_list_product_attributes( $product ) {
    $attributes = array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' );
    $display_dimensions = apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() );
    if ( ! did_action( 'tatsu_head' ) ) {
        do_action( 'tatsu_head' );
    }
    //var_dump('hi');
    ?>
        <div class="shop_attributes <?php echo ( !is_page_template() || is_page_template( 'page-templates/product_fixed.php' ) ) ? 'be-themes-content-padding' : ''; ?>  <?php echo be_themes_get_class( 'wc-shop-attributes', ( !is_page_template() || is_page_template( 'page-templates/product_fixed.php' ) ) ? 'wrap' : '' ); ?>">
            <?php if ( $display_dimensions && $product->has_weight() ) : ?>
                <div class="<?php echo be_themes_get_class( 'wc-shop-attribute' ); ?>">
                    <div class="<?php echo be_themes_get_class( 'wc-shop-attribute-label' ); ?>">
                        <?php esc_html_e( 'Weight', 'exponent' ) ?>
                    </div>
                    <div class="<?php echo be_themes_get_class( 'wc-shop-attribute-value' ); ?>">
                        <?php echo esc_html( wc_format_weight( $product->get_weight() ) ); ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ( $display_dimensions && $product->has_dimensions() ) : ?>
                <div class="<?php echo be_themes_get_class( 'wc-shop-attribute' ); ?>">
                    <div class="<?php echo be_themes_get_class( 'wc-shop-attribute-label' ); ?>">
                        <?php esc_html_e( 'Dimensions', 'exponent' ) ?>
                    </div>
                    <div class="<?php echo be_themes_get_class( 'wc-shop-attribute-value' ); ?>">
                        <?php echo esc_html( wc_format_dimensions( $product->get_dimensions( false ) ) ); ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php foreach ( $attributes as $attribute ) : ?>
                <div class="<?php echo be_themes_get_class( 'wc-shop-attribute' ); ?>">
                    <div class="<?php echo be_themes_get_class( 'wc-shop-attribute-label' ); ?>">
                        <?php echo wc_attribute_label( $attribute->get_name() ); ?>
                    </div>
                    <div class="<?php echo be_themes_get_class( 'wc-shop-attribute-value' ); ?>">
                        <?php
                            $values = array();

                            if ( $attribute->is_taxonomy() ) {
                                $attribute_taxonomy = $attribute->get_taxonomy_object();
                                $attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

                                foreach ( $attribute_values as $attribute_value ) {
                                    $value_name = esc_html( $attribute_value->name );

                                    if ( $attribute_taxonomy->attribute_public ) {
                                        $values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
                                    } else {
                                        $values[] = $value_name;
                                    }
                                }
                            } else {
                                $values = $attribute->get_options();

                                foreach ( $values as &$value ) {
                                    $value = make_clickable( esc_html( $value ) );
                                }
                            }

                            echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php
}

function exponent_wc_product_review_header( $comment ) {
    $verified = wc_review_is_from_verified_owner( $comment->comment_ID );
    ?>
        <div class="<?php echo be_themes_get_class('wc-review-header');?>">
            <div class="<?php echo be_themes_get_class( 'wc-user-image' ); ?>">
                <?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '' ); ?>
            </div>
            <div class="<?php echo be_themes_get_class( 'wc-rating-details' ); ?>">
                <?php if ( '0' === $comment->comment_approved ): ?>
                    <div class="woocommerce-review__awaiting-approval <?php echo be_themes_get_class( 'wc-review-pending' ); ?>">
                        <?php esc_html_e( 'Your review is awaiting approval', 'exponent' ); ?>
                    </div>
                <?php else: ?>
                    <div class="<?php echo be_themes_get_class( 'wc-review-author-wrap' ); ?>">
                        <h2 class="woocommerce-review__author <?php echo be_themes_get_class( 'wc-review-author' ); ?>">
                            <?php comment_author(); ?>
                        </h2>
                        <?php if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) : ?>
                                <em class="woocommerce-review__verified verified"><?php echo esc_attr__( 'verified owner', 'exponent' ); ?></em>
                        <?php endif; ?>
                    </div>
                    <div class="<?php echo be_themes_get_class( 'wc-product-rating-wrap' ); ?>">
                        <div class="woocommerce-review__published-date <?php echo be_themes_get_class( 'wc-review-timestamp' ); ?>">
                            <?php echo esc_html( get_comment_date( wc_date_format() ) ); ?>
                        </div>
                        <div class="<?php echo be_themes_get_class( 'wc-review-rating' ); ?>">
                            <?php woocommerce_review_display_rating() ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php
}

function exponent_wc_product_review_comment_form_args( $comment_form ) {

    $form_style = be_themes_get_option( 'form_style' );
    $button_style = be_themes_get_option( 'button_style' );
    $comment_form[ 'class_form' ] = be_themes_get_class( 'comment-form', 'form-' . $form_style, 'form', 'button-' . $button_style );
    $commenter = wp_get_current_commenter();
    $comment_form[ 'title_reply' ] = have_comments() ? esc_html__( 'Submit Your Review', 'exponent' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'exponent' ), get_the_title() );
    $comment_form[ 'comment_notes_before' ] = '';
    $comment_form[ 'label_submit' ] = esc_html__( 'Submit Review', 'exponent' );
    $comment_form[ 'comment_field' ] = '';
    if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
        $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'exponent' ) . '</label><select name="rating" id="rating" aria-required="true" required>
            <option value="">' . esc_html__( 'Rate&hellip;', 'exponent' ) . '</option>
            <option value="5">' . esc_html__( 'Perfect', 'exponent' ) . '</option>
            <option value="4">' . esc_html__( 'Good', 'exponent' ) . '</option>
            <option value="3">' . esc_html__( 'Average', 'exponent' ) . '</option>
            <option value="2">' . esc_html__( 'Not that bad', 'exponent' ) . '</option>
            <option value="1">' . esc_html__( 'Very poor', 'exponent' ) . '</option>
        </select></div>';
    }
    if( 'border-with-underline' === $form_style || 'rounded-with-underline' == $form_style ) {
        $comment_form[ 'fields' ] = array (
            'author'  => sprintf( '<div class="%s"><input value = "%s" required type = "text" id="author" name = "author" aria-required = "true"/><label for = "author" class="%s">%s</label><span class="%s"></span></div>', be_themes_get_class( 'form-field' ), esc_attr( $commenter['comment_author'] ), be_themes_get_class( 'form-field-label' ), esc_html__( 'Name', 'exponent' ), be_themes_get_class( 'form-border' ) ),
            'email'	  => sprintf( '<div class="%s"><input value = "%s" required type = "text" id="email" name = "email" aria-required = "true"/><label for = "email" class="%s">%s</label><span class="%s"></span></div>', be_themes_get_class( 'form-field' ), esc_attr( $commenter['comment_author_email'] ), be_themes_get_class( 'form-field-label' ), esc_html__( 'Email', 'exponent' ), be_themes_get_class( 'form-border' ) ),
        );
        $comment_form[ 'comment_field' ] .= sprintf( '<div class="%s"><textarea required id="comment" name="comment" cols="45" rows="15" aria-required="true"></textarea><label for = "comment" class="%s">%s</label><span class="%s"></span></div>', be_themes_get_class( 'form-field', 'comment-field' ), be_themes_get_class( 'form-field-label' ), esc_html__( 'Description', 'exponent' ), be_themes_get_class( 'form-border' ) );
    }else {
        $comment_form[ 'fields' ] = array (
            'author'  => sprintf( '<div class="%s"><input value = "%s" placeholder = "%s" type = "text" id="author" name = "author" aria-required = "true"/></div>', be_themes_get_class( 'form-field' ), esc_attr( $commenter['comment_author'] ), esc_html__( 'Name', 'exponent' ) ),
            'email'	  => sprintf( '<div class="%s"><input value = "%s" placeholder = "%s" type = "text" id="email" name = "email" aria-required = "true"/></div>', be_themes_get_class( 'form-field' ), esc_attr( $commenter['comment_author_email'] ), esc_html__( 'Email', 'exponent' ) ),
        );
        $comment_form[ 'comment_field' ] .= sprintf( '<div class="%s"><textarea placeholder = "%s" id="comment" name="comment" cols="45" rows="15" aria-required="true"></textarea></div>', be_themes_get_class( 'form-field', 'comment-field' ), esc_html__( 'Description', 'exponent' ) );
    }
    return $comment_form;
}

function exponent_wc_entry_header() {
    if( is_archive() ) {
        $full_width = be_themes_get_option( 'wc_archive_full_width' );
        $prevent_entry_header = false;
        if( is_shop() ) {
            $page_id = wc_get_page_id('shop');
            $prevent_entry_header = ( function_exists( 'edited_once_with_tatsu' ) && edited_once_with_tatsu( $page_id ) ) || isset( $_GET['tatsu-frame'] );
        }
        if( $prevent_entry_header ) {
            return;
        }
        if( !empty( $full_width ) ) {
            $gutter_value = exponent_wc_get_gutter_value();
            set_query_var( 'be_entry_header_wrap', false );
            set_query_var( 'be_entry_header_horizontal_pad', $gutter_value );    
            set_query_var( 'be_entry_header_horizontal_pad', $gutter_value );    
            set_query_var( 'be_entry_header_horizontal_pad', $gutter_value );    
        }else {
            set_query_var( 'be_entry_header_wrap', true );
        }
        get_template_part( 'template-parts/partials/entry', 'header' );
    }
}

if( !function_exists( 'exponent_wc_print_the_content' ) ) {
    function exponent_wc_print_the_content() {
        if( is_shop() ) {
            $page_id = wc_get_page_id('shop');
            $shop_post = get_post($page_id);
            $content = $shop_post->post_content;
            $content = apply_filters('the_content', $content);
            if( !empty( $content ) ) {
                echo '<div id="be-content" class="be-shop-intro">';
                echo !empty( $content ) ? $content : '';
                echo '</div>';
            }
        }
    }
}

function exponent_wc_single_variation_add_checkout_button() {
    global $product;
    if( !is_page_template(  "page-templates/product_fixed.php" ) && $product->is_type( 'variable' ) ) {
        $checkout_url = get_permalink( wc_get_page_id( 'checkout' ) );
        echo '<a class="' . be_themes_get_class( 'wc-single-variation-checkout' ) . '" href="' . esc_url( $checkout_url ) . '">Checkout</a>';
    }
}

function exponent_wc_related_products_args( $args ) {
    $related_products_count = be_themes_get_option( 'woocommerce_related_products_count' );
    if( is_page_template(  "page-templates/product_right-sidebar.php" ) || is_page_template(  "page-templates/product_left-sidebar.php" ) ) {
        $args['columns'] = 3;
    }
    $args['posts_per_page'] = $related_products_count;
    return $args;
}

function exponent_wc_breadcrumbs( $args ) {
    $args[ 'delimiter' ] = '<span class="' . be_themes_get_class( 'wc-breadcrumb-delimiter' ) . '">&#47;</span>';
    $args[ 'wrap_before' ] = '<nav class="woocommerce-breadcrumb ' . be_themes_get_class( 'breadcrumbs' ) . '">';
    return $args;
}

function exponent_wc_orderby_and_count() {
    if( is_shop() || is_product_category() || is_product_category() || is_product_tag() ) {
        $shop_filters = be_themes_get_option( 'wc_enable_orderby_filter' );
        if( !empty( $shop_filters ) ) {
            echo '<div class="' . be_themes_get_class( 'wc-count-order-wrap' ) . '">';
            woocommerce_result_count();
            woocommerce_catalog_ordering();
            echo '</div>';
        }
    }
}

if( !function_exists( 'exponent_wc_orderby_and_count_filter_class' ) ) {
    function exponent_wc_orderby_and_count_filter_class( $classes ) {
        if( is_shop() || is_product_category() || is_product_category() || is_product_tag() ) {
            $shop_filters = be_themes_get_option( 'wc_enable_orderby_filter' );
            if( !empty( $shop_filters ) ) {
                $classes .= ' exp-has-filters';
            }
        }
        return $classes;
    } 
}

function exponent_wc_page_title( $enable_title ) {
    return false;
}

function exponent_loop_shop_products_per_page ( $count ) {
    $products = get_posts( array(
        'post_type' => 'product', 
        'post_status' => 'publish', 
        'fields' => 'ids', 
        'posts_per_page' => '-1'
    ) );
    $product_count = count( $products );
    return 10;
} 

if( !function_exists( 'exponent_wc_pagination_args' ) ) {
    function exponent_wc_pagination_args( $args ) {
        $args[ 'prev_text' ] = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 16 13">
        <g fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-width="2" transform="matrix(-1 0 0 1 15 1)">
          <polyline points="7.526 0 12.945 5.216 7.526 10.432"/>
          <path d="M12.6578947,5.13157895 L0.342105263,5.13157895"/>
        </g>
      </svg>';
        $args[ 'next_text' ] = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 16 13">
        <g fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-width="2" transform="translate(1 1)">
          <polyline points="7.526 0 12.945 5.216 7.526 10.432"/>
          <path d="M12.6578947,5.13157895 L0.342105263,5.13157895"/>
        </g>
      </svg>';
        $args[ 'type' ] = 'plain';
        $args[ 'before_page_number' ] = sprintf( '<span class="%s">', be_themes_get_class( 'page-number' ) );
        $args[ 'after_page_number' ] =  '</span>';
        $args[ 'end_size' ] = 2;
        $args[ 'mid_size' ] = 2;
        return $args;
    }
}

if( !function_exists( 'exponent_wc_archive_remove_default_wrappers' ) ) {
    function exponent_wc_archive_remove_default_wrappers() {
        
        //default archive page wrappers.
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
        remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
        remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
        remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description' );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

        //categories loop
        remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title' );
        remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open' );
        remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail' );

        //default archive product loop wrappers.
        remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
        remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );

    }
}

if( !function_exists( 'exp_wc_categories_loop_title' ) ) {
    function exp_wc_categories_loop_title( $category ) {
        ?>
        <h5 class="woocommerce-loop-category__title">
			<?php
			echo esc_html( $category->name );

			if ( $category->count > 0 ) {
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">(' . esc_html( $category->count ) . ')</span>', $category ); // WPCS: XSS ok.
			}
			?>
		</h5>
        <?php
    }
}

if( !function_exists( 'exp_wc_categories_loop_thumb_open' ) ) {
    function exp_wc_categories_loop_thumb_open($category) {
        $cropping = get_option( 'woocommerce_thumbnail_cropping', '1:1' );
        $aspect_ratio_inv = 0;
        if( 'uncropped' === $cropping ) {
            $small_thumbnail_size = apply_filters( 'subcategory_archive_thumbnail_size', 'woocommerce_thumbnail' );
            $thumbnail_id         = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
            $aspect_ratio_inv = 1;
            if ( $thumbnail_id ) {
                $image        = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
                $width = $image[1];
                $height = $image[2];
                if( is_numeric($height) && is_numeric($width) && !empty( $width ) ) {
                    $aspect_ratio_inv = $height/$width;
                }
            }
        }else if( 'custom' === $cropping ) {
            $width = max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_width', '4' ) );
            $height = max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_height', '3' ) );
            $aspect_ratio_inv = $height/$width;
        }else {
            $aspect_ratio_inv = 1;
        }
        echo '<a class="exp-category-loop-thumb" href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '">';
        echo '<div class="' . be_themes_get_class( 'thumb-placeholder' ) . '" style = "padding-bottom : ' . ( $aspect_ratio_inv * 100 ) . '%;"></div>';
    }
}

if( !function_exists( 'exp_wc_categories_loop_thumbnail' ) ) {
    function exp_wc_categories_loop_thumbnail( $category ) {
        $small_thumbnail_size = apply_filters( 'subcategory_archive_thumbnail_size', 'woocommerce_thumbnail' );
        $lazy_load = be_themes_get_option( 'lazy_load' );
        $thumbnail_id         = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
        if ( $thumbnail_id ) {
            $image        = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
            $image        = $image[0];
        }else {
            $image        = wc_placeholder_img_src();
        }
        echo sprintf( '<img class="exp-img-object-fit%s" %s %s/>', 
            !empty( $lazy_load ) ? ' be-lazy-load' : '',
            !empty( $lazy_load ) ? ( 'data-src = "' . esc_url($image) . '"' ) : '',
            empty( $lazy_load ) ? ( 'src = "' . esc_url($image) . '"' ) : ''
        );
    }
}

if( !function_exists( 'exponent_wc_archive_add_custom_wrappers' ) ) {
    function exponent_wc_archive_add_custom_wrappers() { 
        
        //custom wrappers
        add_action( 'woocommerce_before_main_content', 'exponent_wc_print_the_content', 8 );
        add_action( 'woocommerce_before_main_content', 'exponent_wc_entry_header', 9 );
        add_action( 'woocommerce_before_shop_loop', 'exponent_wc_archive_wrapper_start', 40 );
        add_filter( 'woocommerce_product_loop_start', 'exponent_wc_product_loop_start', 9 );
        add_action( 'woocommerce_before_shop_loop_item', 'exponent_wc_archive_product_wrapper' );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_archive_product_thumb_wrapper', 9 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_archive_product_grid_placeholder', 9 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_archive_product_grid_placeholder_end', 9 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_archive_product_thumb', 9 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_archive_get_loop_thumb', 10 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_archive_get_alt_thumb', 11 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_archive_product_thumb_end', 11 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 11 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_archive_product_meta_on_hover', 11 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_archive_product_thumb_wrapper_end', 11 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_archive_product_details_wrapper', 11 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_add_to_cart', 11 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'exponent_wc_archive_product_details_inner_wrapper', 11 );
        add_action( 'woocommerce_shop_loop_item_title', 'exponent_wc_archive_product_primary_meta' );
        add_action( 'woocommerce_shop_loop_item_title', 'exponent_wc_archive_product_title' );
        add_action( 'woocommerce_shop_loop_item_title', 'exponent_wc_archive_product_secondary_meta' );
        add_action( 'woocommerce_shop_loop_item_title', 'exponent_wc_archive_product_tertiary_meta' );
        add_action( 'woocommerce_after_shop_loop_item_title', 'exponent_wc_archive_product_details_inner_wrapper_end' );
        add_action( 'woocommerce_after_shop_loop_item_title', 'exponent_wc_archive_product_details_wrapper_end' );
        add_action( 'woocommerce_after_shop_loop_item', 'exponent_wc_archive_product_wrapper_end' );
        add_filter( 'woocommerce_product_loop_end', 'exponent_wc_product_loop_end' );
        add_action( 'woocommerce_after_shop_loop', 'exponent_wc_archive_wrapper_end', 40 );


        //categories loop
        add_action( 'woocommerce_before_subcategory', 'exp_wc_categories_loop_thumb_open' );
        add_action( 'woocommerce_before_subcategory_title', 'exp_wc_categories_loop_thumbnail' );
        add_action( 'woocommerce_shop_loop_subcategory_title', 'exp_wc_categories_loop_title' );

        //loop cart
        add_filter( 'woocommerce_loop_add_to_cart_args', 'exponent_wc_add_to_cart_args', 10, 2 );
        add_filter( 'woocommerce_loop_add_to_cart_link', 'exponent_wc_add_to_cart_link', 10, 3 );
        //loop cols and products per page
        add_filter( 'loop_shop_columns', 'exponent_wc_catalog_columns' );
        add_filter( 'loop_shop_per_page', 'exponent_loop_shop_products_per_page' );
        add_filter( 'woocommerce_pagination_args', 'exponent_wc_pagination_args' );
    }
}

if( !function_exists( 'exponent_wc_single_remove_default_wrappers' ) ) {
    function exponent_wc_single_remove_default_wrappers() {
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs' );
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
        remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
        remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar' );
        remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating' );
        remove_action( 'woocommerce_review_meta', 'woocommerce_review_display_meta' );
        remove_action( 'woocommerce_product_additional_information', 'wc_display_product_attributes' );
    }
}

if( !function_exists( 'exponent_wc_single_add_custom_wrappers' ) ) {
    function exponent_wc_single_add_custom_wrappers() {
        add_action( 'woocommerce_before_single_product', 'exponent_wc_single_product_content_wrapper', 9 );
        add_action( 'woocommerce_before_single_product', 'exponent_wc_single_product_notices_wrap', '9' );
        add_action( 'woocommerce_before_single_product', 'exponent_wc_single_product_notices_wrap_end' );
        add_action( 'woocommerce_before_single_product', 'exponent_wc_single_product_sidebar_start' );
        add_action( 'woocommerce_before_single_product', 'exponent_wc_single_product_main_wrapper' );
        add_action( 'woocommerce_before_single_product_summary', 'exponent_wc_single_product_main_inner_wrapper', 5 );
        add_action( 'woocommerce_before_single_product_summary', 'exponent_wc_single_product_gallery_wrapper', 9 );
        add_action( 'woocommerce_before_single_product_summary', 'exponent_wc_single_product_gallery_inner_wrapper', 9 );
        add_action( 'woocommerce_before_single_product_summary', 'exponent_wc_single_product_gallery_inner_wrapper_end', 59 );
        add_action( 'woocommerce_before_single_product_summary', 'exponent_wc_single_product_gallery_wrapper_end', 60 );
        add_action( 'woocommerce_after_single_product_summary', 'exponent_wc_single_product_main_inner_wrapper_end', 60 );
        add_action( 'woocommerce_after_single_product', 'exponent_wc_single_product_main_wrapper_end', 5 );
        add_action( 'woocommerce_after_single_product', 'exponent_wc_default_template_content_wrapper_end', 5 );
        add_action( 'woocommerce_after_single_product', 'exponent_wc_single_product_footer_wrapper', 5 );
        add_action( 'woocommerce_after_single_product', 'woocommerce_output_product_data_tabs' );
        add_action( 'woocommerce_after_single_product', 'exponent_wc_single_default_fixed_content_wrap' );
        add_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display' );
        add_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products' );
        add_action( 'woocommerce_after_single_product', 'exponent_wc_single_default_fixed_content_wrap_end', 60 );
        add_action( 'woocommerce_after_single_product', 'exponent_wc_single_product_footer_wrapper_end', 60 );
        add_action( 'woocommerce_after_single_product', 'exponent_wc_single_product_sidebar_end', 61 );
        add_action( 'woocommerce_after_single_product', 'exponent_wc_single_product_content_wrapper_end', 61 );
        add_action( 'woocommerce_single_product_summary', 'exponent_wc_product_info_inner_wrap', 3 );
        add_action( 'woocommerce_single_product_summary', 'exponent_wc_single_product_breadcrumb', 4 );
        add_action( 'woocommerce_single_product_summary', 'exponent_wc_single_rating' );
        add_action( 'woocommerce_single_product_summary', 'exponent_wc_single_price' );
        add_action( 'woocommerce_single_product_summary', 'exponent_wc_single_meta', 40 );
        add_action( 'woocommerce_single_product_summary', 'exponent_wc_single_share', 40 );
        add_action( 'woocommerce_single_product_summary', 'exponent_wc_product_info_inner_wrap_end', 60 );
        add_action( 'woocommerce_review_before', 'exponent_wc_product_review_header' );
        add_filter( 'woocommerce_product_review_comment_form_args', 'exponent_wc_product_review_comment_form_args' );
        
        //product gallery
        add_action( 'woocommerce_before_single_product_summary', 'exponent_wc_single_product_gallery', 20 );
        add_action( 'woocommerce_before_single_product_summary', 'exponent_wc_single_product_fixed_gallery', 20 );
        
        //add_filter( 'woocommerce_single_product_image_thumbnail_html', 'exponent_wc_single_product_main_gallery', 10, 2 );
        add_filter( 'woocommerce_product_thumbnails_columns', 'exponent_wc_single_product_thumbnail_cols' );
        add_action( 'woocommerce_product_thumbnails', 'exponent_wc_single_product_thumbnails' );
        add_filter( 'woocommerce_single_product_image_gallery_classes', 'exponent_wc_single_product_gallery_class' );

        add_filter( 'woocommerce_output_related_products_args', 'exponent_wc_related_products_args' );

        //customize single product tabs
        add_filter( 'woocommerce_product_tabs', 'exponent_wc_customize_reviews_tab' );
        add_filter( 'woocommerce_product_additional_information_heading', '__return_empty_string' );
        add_filter( 'woocommerce_product_description_heading', '__return_empty_string' );
        add_action( 'woocommerce_product_additional_information', 'exponent_wc_list_product_attributes' );
    }
}

if( !function_exists( 'exponent_wc_header_cart_slidebar' ) ) {
    function exponent_wc_header_cart_slidebar() {
        ob_start();
        ?>
            <div class="<?php echo be_themes_get_class( 'wc-cart-slidebar-wrap' ); ?>">
                <div class="<?php echo be_themes_get_class( 'wc-cart-slidebar' ); ?>">
                    <div class="<?php echo be_themes_get_class( 'wc-cart-inner' ); ?>">
                        <div class="<?php echo be_themes_get_class( 'wc-cart-title' ); ?>">
                            <?php echo esc_html__( 'Cart Overview', 'exponent' ); ?>
                            <div class="<?php echo be_themes_get_class( 'wc-mini-cart-close-icon' ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14" fill="none">
                                    <path d="M1 1L6.91697 6.69554L1 12.3911" stroke-width="2"/>
                                </svg>
                            </div>
                        </div>
                        <!-- Insert cart placeholder - code in woocommerce.js will update this on page load through cart fragments api-->
                        <div class="widget_shopping_cart_content">
                        </div>
                    </div>
                </div>
                <div class="<?php echo be_themes_get_class( 'wc-cart-widget-overlay' ); ?>">
                </div>
            </div>
        <?php
        $cart_container_html = ob_get_clean();
        echo wp_kses_post( $cart_container_html );
    }
}

if( !function_exists( 'exp_wc_add_product_cat_class' ) ) {
    function exp_wc_add_product_cat_class( $classes ) {
        $classes[] = 'be-col';
        return $classes;
    }
}

if( !function_exists( 'exponent_wc_global_customizations' ) ) {
    function exponent_wc_global_customizations() {
        add_action( 'woocommerce_before_main_content', 'exponent_wc_output_content_wrapper', 10 );
        add_action( 'woocommerce_after_main_content', 'exponent_wc_output_content_wrapper_end', 10 );
        add_action( 'be_themes_breadcrumb_row_class', 'exponent_wc_orderby_and_count_filter_class' );
        add_action( 'be_after_entry_header', 'exponent_wc_orderby_and_count' );
        add_filter( 'woocommerce_breadcrumb_defaults', 'exponent_wc_breadcrumbs' );
        add_filter( 'woocommerce_show_page_title', 'exponent_wc_page_title' );
        add_filter( 'woocommerce_get_star_rating_html', 'exponent_wc_product_rating', 10, 3 );
        add_filter( 'post_class', 'exponent_wc_post_class', 10, 3 );
        add_filter( 'woocommerce_single_product_zoom_enabled', 'exponent_wc_single_product_zoom' );
        add_filter( 'wp_footer', 'exponent_wc_header_cart_slidebar' );
        add_filter( 'product_cat_class', 'exp_wc_add_product_cat_class' );
    }
}

exponent_wc_register_theme_support();
exponent_wc_enqueue_styles_and_scripts();

//archive customizations
exponent_wc_archive_remove_default_wrappers();
exponent_wc_archive_add_custom_wrappers();

//single product customizations
exponent_wc_single_remove_default_wrappers();
exponent_wc_single_add_custom_wrappers();

exponent_wc_global_customizations();
exponent_wc_mini_cart();
exponent_wc_cart();
exponent_wc_customize_login();
exponent_wc_customize_checkout();
exponent_wc_init_quick_view();
exponent_wc_customize_widgets();
