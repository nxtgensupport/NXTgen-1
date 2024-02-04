<?php
/**
 * Greenshift Woocommerce Helper Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* Get WooCommerce Grouped Attributes for a Product */
function gspbwoo_get_attributes_group( $product ){
    if (!is_object($product)) return;
    $attributes = apply_filters( 'woocommerce_display_product_attributes', $product->get_attributes(), $product);
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'attribute_group',
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'suppress_filters' => 0,
        'no_found_rows' => 1,
        'order' => 'ASC',
    );
    $attribute_groups = get_posts( $args );
    $temp = array();
    $haveGroup = array();

    if(!empty($attribute_groups)){
        foreach ($attribute_groups as $attribute_group) {

            // Attribut Group Name and a Key in the Group array
            $attribute_group_name = $attribute_group->post_title;
            $attribute_group_key = $attribute_group->post_name;

            // Attribut Group Image
            /*
            $attributeGroupImage = get_post_meta($attribute_group->ID, 'woocommerce_group_attributes_image' , true);
            $img = "";
            if(!empty($attributeGroupImage)){
                $img = '<img src="' . $attributeGroupImage . '" alt="' . $attribute_group_name . '" class="attribute-group-image" />';
            }
            */

            $attributes_in_group = get_post_meta($attribute_group->ID, 'woocommerce_group_attributes_attributes');

            if(is_array($attributes_in_group[0])) {
                $attributes_in_group = $attributes_in_group[0];
            } else {
                $attributes_in_group = $attributes_in_group;
            }

            if(!empty($attributes_in_group)){
                foreach ($attributes_in_group as $attribute_in_group) {

                    $attribute_in_group = wc_get_attribute($attribute_in_group);

                    foreach ($attributes as $attribute) {
                        if($attribute['is_visible'] == 0){
                            continue;
                        }

                        if(is_object($attribute_in_group) && $attribute_in_group->slug == $attribute['name']){
                            if( apply_filters( 'gspbwoo_multiple_attributes_in_groups', false ) == false ) {
                                unset($attributes[$attribute['name']]);
                            }

                            $temp[$attribute_group_key]['name'] = $attribute_group_name;
                            /* $temp[$attribute_group_key]['img'] = $img; */
                            $temp[$attribute_group_key]['attributes'][] = $attribute;
                            $haveGroup[] = $attribute['name'];
                        } else {
                            $temp[$attribute['name']] = $attribute;
                        }
                    }
                }
            }
        }
    } else {
        $temp = $attributes;
    }

    foreach ($temp as $key=>$asd) {
        if(is_array($asd)) {
            continue;
        }
        $name = $asd->get_name();
        if(!in_array($name, $haveGroup)){
            $temp['gsothergroup']['name'] = esc_html__( 'Specification', 'greenshiftwoo');
            /* $temp['other']['img'] = ''; */
            $temp['gsothergroup']['attributes'][] = $asd;
        }
        unset($temp[$key]);
    }

    return $temp;
}

////////////////////////////////////////////////////////////////////
//// Product swatches
////////////////////////////////////////////////////////////////////
function gs_init_wc_attribute_swatches(){
    require_once 'class_wc_attribute_swatches.php';
}
add_action( 'admin_init', 'gs_init_wc_attribute_swatches' );
if(!function_exists('gspbwoo_wc_dropdown_variation_attribute_options')){
    function gspbwoo_wc_dropdown_variation_attribute_options( $html, $args ){
        $product = $args['product'];
        $options = $args['options'];
        $taxonomy = $args['attribute'];
        $att_id = wc_attribute_taxonomy_id_by_name( $taxonomy );
        $attribute = wc_get_attribute( $att_id );

        if(!is_object($attribute)) return $html;

        $swatch_type = $attribute->type;
        $allowed = array(
            'color' ,
            'image' ,
            'text' ,
            'image_tag'
        );
        if( !in_array($swatch_type, $allowed) )
            return $html;

        wp_enqueue_script('gsswatches');

        if ( false === $args['selected'] && $taxonomy && $product instanceof WC_Product ) {
            $selected_key = 'attribute_' . sanitize_title( $taxonomy );
            $args['selected'] = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $selected_key ] ) ) : $product->get_variation_default_attribute( $taxonomy );
        }

        $name = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $taxonomy );
        $output = '';

        if ( empty( $options ) && !empty( $product ) && !empty( $taxonomy ) ) {
            $attributes = $product->get_variation_attributes();
            $options = $attributes[$taxonomy];
        }
        if ( !empty( $options ) ){

            $terms = wc_get_product_terms( $product->get_id(), $taxonomy, array( 'fields' => 'all' ) );
            $output .= '<div class="gs-var-selector" data-attribute="'.esc_attr( $name ).'">';

            foreach ( $terms as $term ) {
                if ( in_array( $term->slug, $options, true ) ) {

                    if($swatch_type === 'image_tag') {
                        $term_swatch_image = get_term_meta( $term->term_id, "gspbwoo_swatch_image_tag", true );
                        $term_swatch_label = get_term_meta( $term->term_id, "gspbwoo_swatch_text_tag", true );
                    } else{
                        $term_swatch = get_term_meta( $term->term_id, "gspbwoo_swatch_{$swatch_type}", true );
                    }

                    $term_tooltip = get_term_meta( $term->term_id, "gspbwoo_swatch_tooltip", true );
                    $term_tooltip_content = $term_tooltip ? '<span class="gspb_swatch_tooltip"><span class="gspb_swatch_tooltip-top">'.esc_attr($term_tooltip).'<i></i></span></span>' : '';

                    switch( $swatch_type ) {
                        case 'color':
                            $style = 'background-color:'. $term_swatch .';';
                            break;
                        case 'image':
                            $style = 'background-image:url('. esc_url( wp_get_attachment_thumb_url( $term_swatch ) ) .');';
                            break;
                        default:
                            $style = '';
                    }

                    $id = $taxonomy .'_'. $term->slug;
                    if('text' == $swatch_type){
                        $label = $term_swatch;
                        if(!$label) {
                            $label = $term->name;
                        }
                    } else if('image_tag' == $swatch_type){
                        $label = '<span class="img-bg" style="background-image: url(' . esc_url( wp_get_attachment_thumb_url( $term_swatch_image ) ) . ')"></span>';
                        $label .= '<span>' . $term_swatch_label . '</span>';
                    } else{
                        $label = '';
                        if(!$term_swatch){
                            $style = '';
                            $label = $term->name;
                            $swatch_type = 'text';
                        }
                    }

                    $hash = mt_rand(0, 1000);

                    $output .='<input id="'. esc_attr( $id ) .$hash.'" type="radio" name="'. esc_attr( $name ) .'" value="'. esc_attr( $term->slug ) .'" '. checked( sanitize_title( $args['selected'] ), $term->slug, false ) .' class="gs-var-input" />';
                    $output .='<label for="'. esc_attr( $id ) .$hash.'" title="'. $term->name .'" class="gs-var-label '.$swatch_type.'-label-gs" style="'. $style .'" data-value="'. esc_attr( $term->slug ) .'">'. $term_tooltip_content.$label .'</label>';
                }
            }

            $output .= '</div>';
  
        }
        $output .= '<style scoped>select[name="'.esc_attr( $name ).'"]{display:none !important}</style>';
        return $html . $output;
    }
}
if(!function_exists('gspbwoo_show_swatch_in_attr')){
    function gspbwoo_show_swatch_in_attr($wpautop, $attribute, $values){
        if(!isset($attribute['id'])) {
            return $wpautop;
        }
        $attribute_id = $attribute['id'];
        $att = wc_get_attribute( $attribute_id );
        if(!is_object($att)){
            return $wpautop;
        }
        $swatch_type = $att->type;
        $allowed = array(
            'color' ,
            'image' ,
            'text' ,
            'image_tag'
        );
        if( !in_array($swatch_type, $allowed) )
            return $wpautop;

        global $product;
        if(empty($product)) {
            return $wpautop;
        }
        $currentslug = $att->slug;
        $has_archive = $att->has_archives;

        $terms = wc_get_product_terms( $product->get_id(), $currentslug, array( 'fields' => 'all' ) );
        $result = '';
        foreach ( $terms as $term ) {

            if($swatch_type === 'image_tag') {
                $term_swatch_image = get_term_meta( $term->term_id, "gspbwoo_swatch_image_tag", true );
                $term_swatch_label = get_term_meta( $term->term_id, "gspbwoo_swatch_text_tag", true );
            } else{
                $term_swatch = get_term_meta( $term->term_id, "gspbwoo_swatch_{$swatch_type}", true );
            }

            $term_tooltip = get_term_meta( $term->term_id, "gspbwoo_swatch_tooltip", true );
            $term_tooltip_content = $term_tooltip ? '<span class="gspb_swatch_tooltip"><span class="gspb_swatch_tooltip-top">'.esc_attr($term_tooltip).'<i></i></span></span>' : '';

            if(!empty($term_swatch) || !empty($term_swatch_image) || !empty($term_swatch_label)){
                switch( $swatch_type ) {
                    case 'color':
                        $style = 'background-color:'. $term_swatch .';';
                        break;
                    case 'image':
                        $style = 'background-image:url('. esc_url( wp_get_attachment_thumb_url( $term_swatch ) ) .');';
                        break;
                    default:
                        $style = '';
                }
                if('text' == $swatch_type){
                    $label = $term_swatch;
                    if(!$label) {
                        $label = $term->name;
                    }
                } else if('image_tag' == $swatch_type){
                    $label = '<span class="img-bg" style="background-image: url(' . esc_url( wp_get_attachment_thumb_url( $term_swatch_image ) ) . ')"></span>';
                    $label .= '<span>' . $term_swatch_label . '</span>';
                }
                else{
                    $label = '';
                }
                if ( $has_archive ) {
                    $result .= '<a href="' . esc_url( get_term_link( $term->term_id, $currentslug ) ) . '" rel="tag">';
                }
                $nonselect = $has_archive ? '' : ' label-non-selectable';
                $result .='<span class="gs-var-label'.$nonselect.' '.$swatch_type.'-label-gs" style="'. $style .'">'.$term_tooltip_content.$label .'</span>';
                if ( $has_archive ) {
                    $result .='</a>';
                }

            }
            else{
                return $wpautop;
            }
        }
        return $result;

    }
}
if(!function_exists('gspbwoo_show_swatch_in_filters')){
    function gspbwoo_show_swatch_in_filters($term_html, $term, $link, $count){

        $attribute_id = wc_attribute_taxonomy_id_by_name( $term->taxonomy );
        if($attribute_id){
            $attribute = wc_get_attribute( $attribute_id );
            if(!empty($attribute)){
                $swatch_type = $attribute->type;
                $allowed = array(
                    'color' ,
                    'image' ,
                    'text' ,
                    'image_tag'
                );
                if( in_array($swatch_type, $allowed) ){

                    if($swatch_type === 'image_tag') {
                        $term_swatch_image = get_term_meta( $term->term_id, "gspbwoo_swatch_image_tag", true );
                        $term_swatch_label = get_term_meta( $term->term_id, "gspbwoo_swatch_text_tag", true );
                    } else{
                        $term_swatch = get_term_meta( $term->term_id, "gspbwoo_swatch_{$swatch_type}", true );
                    }

                    $term_tooltip = get_term_meta( $term->term_id, "gspbwoo_swatch_tooltip", true );
                    $term_tooltip_content = $term_tooltip ? '<span class="gspb_swatch_tooltip"><span class="gspb_swatch_tooltip-top">'.esc_attr($term_tooltip).'<i></i></span></span>' : '';

                    if(!empty($term_swatch) || !empty($term_swatch_image) || !empty($term_swatch_label)){
                        switch( $swatch_type ) {
                            case 'color':
                                $style = 'background-color:'. $term_swatch .';';
                                break;
                            case 'image':
                                $style = 'background-image:url('. esc_url( wp_get_attachment_thumb_url( $term_swatch ) ) .');';
                                break;
                            default:
                                $style = '';
                        }
                        $attributelabel = 'text' == $swatch_type ? $term_swatch : '';

                        if('image_tag' == $swatch_type){
                            $label = '<span class="img-bg" style="background-image: url(' . esc_url( wp_get_attachment_thumb_url( $term_swatch_image ) ) . ')"></span>';
                            $attributelabel .= '<span>' . $term_swatch_label . '</span>';
                        }

                        $result = '<span class="gs-var-label label-non-selectable '.$swatch_type.'-label-gs" style="'. $style .'">'. $term_tooltip_content.$attributelabel .'</span>';
                        $termname = esc_html( $term->name ).'</a>';
                        $termwithswatch = $result.'<span class="gspbwoo_attr_name">'.$termname.'</span></a>';
                        $termrel = 'rel="nofollow"';
                        $termlinkclass = 'rel="nofollow" class="gspbwoo_swatch_filter gspbwoo_swatch_'.$swatch_type.'"';
                        $term_html = str_replace($termname, $termwithswatch, $term_html);
                        $term_html = str_replace($termrel, $termlinkclass, $term_html);
                    }
                }
            }
        }

        return $term_html;
    }
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'gspbwoo_wc_dropdown_variation_attribute_options', 10, 2 );
add_filter('woocommerce_attribute', 'gspbwoo_show_swatch_in_attr', 10,3);
add_filter('woocommerce_layered_nav_term_html', 'gspbwoo_show_swatch_in_filters', 10, 4);


if(!function_exists('gspbwoo_show_swatch_show')){
    function gspbwoo_show_swatch_show($att, $product, $field=''){
        if(!is_object($att) || !is_object($product)){
            return;
        }
        $swatch_type = $att->type;
        $allowed = array(
            'color' ,
            'image' ,
            'text' ,
            'image_tag'
        );
        if( !in_array($swatch_type, $allowed) ){
            return $product->get_attribute(esc_html($field));
        }else{
            $currentslug = $att->slug;
            $has_archive = $att->has_archives;

            $terms = wc_get_product_terms( $product->get_id(), $currentslug, array( 'fields' => 'all' ) );
            $result = '';
            foreach ( $terms as $term ) {

                $gs_swatch_prefix = apply_filters('gs_swatch_prefix', 'gspbwoo_swatch_');

                if($swatch_type === 'image_tag') {
                    $term_swatch_image = get_term_meta( $term->term_id, "{$gs_swatch_prefix}image_tag", true );
                    $term_swatch_label = get_term_meta( $term->term_id, "{$gs_swatch_prefix}text_tag", true );
                } else{
                    $term_swatch = get_term_meta( $term->term_id, "{$gs_swatch_prefix}{$swatch_type}", true );
                }

                if(!empty($term_swatch) || !empty($term_swatch_image) || !empty($term_swatch_label)){
                    switch( $swatch_type ) {
                        case 'color':
                            $style = 'background-color:'. $term_swatch .';';
                            break;
                        case 'image':
                            $style = 'background-image:url('. esc_url( wp_get_attachment_thumb_url( $term_swatch ) ) .');';
                            break;
                        default:
                            $style = '';
                    }
                    if('text' == $swatch_type){
                        $label = $term_swatch;
                        if(!$label) {
                            $label = $term->name;
                        }
                    } else if('image_tag' == $swatch_type){
                        $label = '<span class="img-bg" style="background-image: url(' . esc_url( wp_get_attachment_thumb_url( $term_swatch_image ) ) . ')"></span>';
                        $label .= '<span>' . $term_swatch_label . '</span>';
                    }
                    else{
                        $label = '';
                    }
                    if ( $has_archive ) {
                        $result .= '<a href="' . esc_url( get_term_link( $term->term_id, $currentslug ) ) . '" rel="tag">';
                    }
                    $nonselect = $has_archive ? '' : ' label-non-selectable';
                    $result .='<span class="gs-var-label'.$nonselect.' '.$swatch_type.'-label-gs" style="'. $style .'">'. $label .'</span>';
                    if ( $has_archive ) {
                        $result .='</a>';
                    }

                }
                else{
                    return;
                }
            }
            return $result;
        }
    }
}


//////////////////////////////////////////////////////////////////
// Ajax add to cart variations support 
//////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_woocommerce_add_to_cart_variable_gspb', 'woocommerce_add_to_cart_variable_gspb_callback' );
add_action( 'wp_ajax_nopriv_woocommerce_add_to_cart_variable_gspb', 'woocommerce_add_to_cart_variable_gspb_callback' );
function woocommerce_add_to_cart_variable_gspb_callback() {
	ob_start();
	
	$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
	$quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
	$variation_id = $_POST['variation_id'];		

	$cart_item_data = $_POST;
	unset($cart_item_data['quantity']);
	
	$variation = array();

	foreach ($cart_item_data as $key => $value) {
		if (preg_match("/^attribute*/", $key)) {
			$variation[$key] = $value;
		}
	}
	
	foreach ($variation as $key=>$value) { $variation[$key] = stripslashes($value); }
	$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

	if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation, $cart_item_data  ) ) {
		do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
			wc_add_to_cart_message( $product_id );
		}
		global $woocommerce;
		$items = $woocommerce->cart->get_cart();
		wc_setcookie( 'woocommerce_items_in_cart', count( $items ) );
		wc_setcookie( 'woocommerce_cart_hash', md5( json_encode( $items ) ) );
		do_action( 'woocommerce_set_cart_cookies', true );
		// Return fragments
		WC_AJAX::get_refreshed_fragments();
	
	} else {

		// If there was an error adding to the cart, redirect to the product page to show any errors
		$data = array(
			'error' => true,
			'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
		);
		wp_send_json_error( $data );
	}
} 