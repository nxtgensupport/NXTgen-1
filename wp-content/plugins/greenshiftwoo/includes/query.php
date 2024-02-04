<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

add_action( 'wp_ajax_gspbwoo_taxonomies_list', 'gspbwoo_taxonomies_list');
add_action( 'wp_ajax_gspbwoo_products_title_list', 'gspbwoo_products_title_list' );
add_action( 'wp_ajax_gspbwoo_taxonomy_terms', 'gspbwoo_taxonomy_terms');
add_action( 'wp_ajax_gspbwoo_taxonomy_terms_search', 'gspbwoo_taxonomy_terms_search' );
add_action( 'wp_ajax_gspbwoo_post_type_el', 'gspbwoo_post_type_el');


function gspbwoo_post_type_el() {
    $post_types = get_post_types( array('public' => true) );
    $post_types_list = array();
    foreach ( $post_types as $post_type ) {
        if ( $post_type !== 'revision' && $post_type !== 'nav_menu_item' && $post_type !== 'attachment') {
            $post_types_list[] = array(
                'label' => $post_type,
                'value' => $post_type
            );
        }
    }
    wp_send_json_success($post_types_list);
}

function gspbwoo_taxonomy_terms_search(){
    global $wpdb;
    $taxonomy = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : '';
    $query = [
        "select" => "SELECT SQL_CALC_FOUND_ROWS a.term_id AS id, b.name as name, b.slug AS slug
                    FROM {$wpdb->term_taxonomy} AS a
                    INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id",
        "where"  => "WHERE a.taxonomy = '{$taxonomy}'",
        "like"   => "AND (b.slug LIKE '%s' OR b.name LIKE '%s' )",
        "offset" => "LIMIT %d, %d"
    ];

    $search_term = '%' . $wpdb->esc_like( $_POST['search'] ) . '%';
    $offset = 0;
    $search_limit = 100;

    $final_query = $wpdb->prepare( implode(' ', $query ), $search_term, $search_term, $offset, $search_limit );
    // Return saved values

    $results = $wpdb->get_results( $final_query );

    $total_results = $wpdb->get_row("SELECT FOUND_ROWS() as total_rows;");
    $response_data = [
        'results'       => [],
    ];

    if ( $results ) {
        foreach ( $results as $result ) {
            $response_data['results'][] = [
                'id'        => esc_html( $result->slug ),
                'label'     => esc_html( $result->name ),
                'value'     => (int)$result->id
            ];
        }
    }

    wp_send_json_success( $response_data );
}

function gspbwoo_taxonomy_terms() {
    $response_data = [
        'results' => []
    ];

    if ( empty( $_POST['taxonomy'] ) ) {
        wp_send_json_success( $response_data );
    }

    $taxonomy = sanitize_text_field($_POST['taxonomy']);
    $selected = isset($_POST['selected']) ? $_POST['selected'] : '';
    $terms = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'number' => 15,
        'exclude' => $selected
    ]);

    foreach ( $terms as $term ) {
        $response_data['results'][] = [
            'id'        => $term->slug,
            'label'     => esc_html( $term->name ),
            'value'     => $term->term_id
        ];
    }

    wp_send_json_success( $response_data );
}

function gspbwoo_filter_empty_values( $haystack ) {
    foreach ( $haystack as $key => $value ) {
        if ( is_array( $value ) ) {
            $haystack[ $key ] = gspbwoo_filter_empty_values( $haystack[ $key ]);
        }
        if ( empty( $haystack[ $key ] ) ) {
            unset( $haystack[ $key ] );
        }
    }
    return $haystack;
}

function gspbwoo_taxonomies_list() {
    $exclude_list = array_flip([
        'nav_menu', 'link_category', 'post_format',
        'elementor_library_type', 'elementor_library_category', 'action-group'
    ]);
    $response_data = [
        'results' => []
    ];
    $args = [];
    foreach ( get_taxonomies($args, 'objects') as $taxonomy => $object ) {
        if ( isset( $exclude_list[ $taxonomy ] ) ) {
            continue;
        }

        $taxonomy = esc_html( $taxonomy );
        $response_data['results'][] = [
            'value'    => $taxonomy,
            'label'  => esc_html( $object->label ),
        ];
    }
    wp_send_json_success( $response_data );
}

function gspbwoo_products_title_list() {
    global $wpdb;

    //$post_types = get_post_types( array('public'   => true) );
    //$placeholdersformat = array_fill(0, count( $post_types ), '%s');
    //$postformat = implode(", ", $placeholdersformat);

    $query = [
        "select" => "SELECT SQL_CALC_FOUND_ROWS ID, post_title FROM {$wpdb->posts}",
        "where"  => "WHERE post_type IN ('post', 'product', 'blog', 'page')",
        "like"   => "AND post_title NOT LIKE %s",
        "offset" => "LIMIT %d, %d"
    ];

    $search_term = '';
    if ( ! empty( $_POST['search'] ) ) {
        $search_term = $wpdb->esc_like( $_POST['search'] ) . '%';
        $query['like'] = 'AND post_title LIKE %s';
    }

    $offset = 0;
    $search_limit = 100;
    if ( isset( $_POST['page'] ) && intval( $_POST['page'] ) && $_POST['page'] > 1 ) {
        $offset = $search_limit * absint( $_POST['page'] );
    }

    $final_query = $wpdb->prepare( implode(' ', $query ), $search_term, $offset, $search_limit );
    // Return saved values

    if ( ! empty( $_POST['saved'] ) && is_array( $_POST['saved'] ) ) {
        $saved_ids = $_POST['saved'];
        $placeholders = array_fill(0, count( $saved_ids ), '%d');
        $format = implode(', ', $placeholders);

        $new_query = [
            "select" => $query['select'],
            "where"  => $query['where'],
            "id"     => "AND ID IN( $format )",
            "order"  => "ORDER BY field(ID, " . implode(",", $saved_ids) . ")"
        ];

        $final_query = $wpdb->prepare( implode(" ", $new_query), $saved_ids );
    }

    $results = $wpdb->get_results( $final_query );
    $total_results = $wpdb->get_row("SELECT FOUND_ROWS() as total_rows;");
    $response_data = [
        'results'       => [],
        'total_count'   => $total_results->total_rows
    ];

    if ( $results ) {
        foreach ( $results as $result ) {
            $response_data['results'][] = [
                'value'    => $result->ID,
                'id'    => $result->ID,
                'label'  => esc_html( $result->post_title )
            ];
        }
    }

    wp_send_json_success( $response_data );
}

function gspbwoo_custom_taxonomy_dropdown( $taxdrop, $limit = '40', $class = '', $taxdroplabel = '', $containerid ='', $taxdropids = '' ) {
    $args = array(
        'taxonomy'=> $taxdrop,
        'number' => $limit,
        'hide_empty' => true,
        'parent'        => 0,
    );
    if($taxdropids){
        $taxdropids = array_map( 'trim', explode(",", $taxdropids ));
        $args['include'] = $taxdropids;
        $args['parent'] = '';
        $args['orderby'] = 'include';
    }
    $terms = get_terms($args );
    $class = ( $class ) ? $class : 'gspbwoo_tax_dropdown';
    $output = '';
    if ( $terms && !is_wp_error($terms) ) {
        $output .= '<ul class="'.$class.'">';
        if (empty($taxdroplabel)){$taxdroplabel = esc_html__('Choose category', 'greenshiftwoo');}
        $output .= '<li class="label"><span class="gspbwoo_tax_placeholder">'.$taxdroplabel.'</span><span class="gspbwoo_choosed_tax"></span></li>';
        $output .= '<li class="gspbwoo_drop_item"><span data-sorttype="" class="gspbwoo_filtersort_btn" data-containerid="'.$containerid.'">'.esc_html__('All categories', 'greenshiftwoo').'</span></li>';
        foreach ( $terms as $term ) {
            $term_link = get_term_link( $term );
            if ( is_wp_error( $term_link ) ) {
                continue;
            }
            if(!empty($containerid)){
                $sort_array=array();
                $sort_array['filtertype'] = 'tax';
                $sort_array['filtertaxkey'] = $taxdrop;
                $sort_array['filtertaxtermslug'] = $term->slug;
                $json_filteritem = json_encode($sort_array);
                $output .='<li class="gspbwoo_drop_item"><span data-sorttype=\''.$json_filteritem.'\' class="gspbwoo_filtersort_btn" data-containerid="'.$containerid.'">';
                $output .= $term->name;
                $output .= '</span></li>';
            }
            else{
                $output .= '<li class="gspbwoo_drop_item"><span><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></span></li>';
            }
        }
        $output .= '</ul>';
    }
    return $output;
}

//////////////////////////////////////////////////////////////////
// Sanitize Arrays
//////////////////////////////////////////////////////////////////
function gspbwoo_sanitize_multi_arrays($data = array()) {
    if (!is_array($data) || empty($data)) {
        return array();
    }
    foreach ($data as $k => $v) {
        if (!is_array($v) && !is_object($v)) {
            if($k == 'contshortcode'){
                $data[sanitize_key($k)] = wp_kses_post($v);
            }elseif($k=='attrelpanel'){
                $data[sanitize_key($k)] = filter_var( $v, FILTER_SANITIZE_SPECIAL_CHARS );
            }else{
                $data[sanitize_key($k)] = sanitize_text_field($v);
            }
        }
        if (is_array($v)) {
            $data[$k] = gspbwoo_sanitize_multi_arrays($v);
        }
    }
    return $data;
}