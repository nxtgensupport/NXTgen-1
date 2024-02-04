<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('show_search_form')) {
    function show_search_form()
    {
        echo '<div class="comp-search rhhidden">
              <button id="btn_search_close" class="btn-search-close" aria-label="Close search form"><svg width="22px" fill="white" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="122.878px" height="122.88px" viewBox="0 0 122.878 122.88"><g><path d="M1.426,8.313c-1.901-1.901-1.901-4.984,0-6.886c1.901-1.902,4.984-1.902,6.886,0l53.127,53.127l53.127-53.127 c1.901-1.902,4.984-1.902,6.887,0c1.901,1.901,1.901,4.985,0,6.886L68.324,61.439l53.128,53.128c1.901,1.901,1.901,4.984,0,6.886 c-1.902,1.902-4.985,1.902-6.887,0L61.438,68.326L8.312,121.453c-1.901,1.902-4.984,1.902-6.886,0 c-1.901-1.901-1.901-4.984,0-6.886l53.127-53.128L1.426,8.313L1.426,8.313z"/></g></svg></button>
              <form class="comp-search-form" action="' . home_url('/') . '">
                  <input class="comp-search-input" name="s" type="search" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
                  <span class="comp-search-info">' . __('Type name of products', 'greenshiftwoo') . '</span>
              </form>
              <div class="comp-ajax-search-wrap"></div>
          </div>';
    }
}

if(!function_exists('gspb_get_user_ip')){
    function gspb_get_user_ip() {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                $ip = $_SERVER[$key];
                if(strpos($ip, ',') !== false) {
                    $ip = explode(',', $ip);
                    $ip = $ip[0];
                }
                if($ip){substr_replace($ip,0,-1);} //GDRP
                return esc_attr($ip);
            }
        }
        return '127.0.0.3';
    }
}

if (!function_exists('GSAlreadycompare')) {
    if (!function_exists('GSAlreadycompare')) {
        function GSAlreadycompare($post_id)
        { // test if user liked before

            if (is_user_logged_in()) { // user is logged in
                global $current_user;
                $user_id = $current_user->ID; // current user
                $meta_USERS = get_post_meta($post_id, "_user_compareed"); // user ids from post meta
                $liked_USERS = ""; // set up array variable     
                if (!empty($meta_USERS) && count($meta_USERS) != 0) { // meta exists, set up values
                    $liked_USERS = $meta_USERS[0];
                }
                if (!is_array($liked_USERS)) // make array just in case
                    $liked_USERS = array();
                if (in_array($user_id, $liked_USERS)) { // True if User ID in array
                    return true;
                }
                return false;
            } else { // user is anonymous, use IP address for voting  
                $meta_IPS = get_post_meta($post_id, "_usercompare_IP"); // get previously voted IP address
                $ip = gspb_get_user_ip(); // Retrieve current user IP
                $liked_IPS = ""; // set up array variable
                if (is_array($meta_IPS) && count($meta_IPS) != 0) { // meta exists, set up values
                    $liked_IPS = $meta_IPS[0];
                }
                if (!is_array($liked_IPS)) // make array just in case
                    $liked_IPS = array();
                if (in_array($ip, $liked_IPS)) { // True is IP in array
                    return true;
                }
                return false;
            }
        }
    }
}
add_action('wp_ajax_nopriv_gscomparecounter', 'gscomparecounter_function');
add_action('wp_ajax_gscomparecounter', 'gscomparecounter_function');

if (!function_exists('gscomparecounter_function')) {
    function gscomparecounter_function()
    {
        $nonce = sanitize_text_field($_POST['comparenonce']);
        if (!wp_verify_nonce($nonce, 'comparenonce'))
            die('Nope!');

        if (isset($_POST['compare_count'])) {
            $post_id = intval($_POST['post_id']); // post id
            $posthot = get_post($post_id);
            $postauthor = $posthot->post_author;
            $post_compare_count = get_post_meta($post_id, "post_compare_count", true); // post like count  
            $overall_post_comparees = get_user_meta($postauthor, "overall_post_comparees", true); // get overall post likes of user   
            if (is_user_logged_in()) { // user is logged in
                global $current_user;
                $user_id = $current_user->ID; // current user
                $meta_POSTS = get_user_meta($user_id, "_compareed_posts"); // post ids from user meta
                $meta_USERS = get_post_meta($post_id, "_user_compareed"); // user ids from post meta
                $liked_POSTS = ""; // setup array variable
                $liked_USERS = ""; // setup array variable          
                if (count($meta_POSTS) != 0) { // meta exists, set up values
                    $liked_POSTS = $meta_POSTS[0];
                }
                if (!is_array($liked_POSTS)) // make array just in case
                    $liked_POSTS = array();
                if (count($meta_USERS) != 0) { // meta exists, set up values
                    $liked_USERS = $meta_USERS[0];
                }
                if (!is_array($liked_USERS)) // make array just in case
                    $liked_USERS = array();
                $liked_POSTS['post-' . $post_id] = $post_id; // Add post id to user meta array
                $liked_USERS['user-' . $user_id] = $user_id; // add user id to post meta array
                $user_likes = count($liked_POSTS); // count user likes

                if ($_POST['compare_count'] == 'add') {
                    if (!GSAlreadycompare($post_id)) {
                        update_post_meta($post_id, "post_compare_count", ++$post_compare_count); // +1 count post meta
                        update_post_meta($post_id, "_user_compareed", $liked_USERS); // Add user ID to post meta
                        update_user_meta($user_id, "_compareed_posts", $liked_POSTS); // Add post ID to user meta
                        update_user_meta($user_id, "_user_compare_count", $user_likes); // +1 count user meta    
                        update_user_meta($postauthor, "overall_post_comparees", ++$overall_post_comparees); // +1 count to post author overall likes             
                    } else {
                        // update_post_meta( $post_id, "post_compare_count", $post_compare_count+2 );
                    }
                }
                if ($_POST['compare_count'] == 'remove') {
                    update_post_meta($post_id, "post_compare_count", $post_compare_count - 1);
                    update_user_meta($postauthor, "overall_post_comparees", --$overall_post_comparees);
                    update_user_meta($user_id, "_user_compare_count", $user_likes - 1);

                    $userkeyip = 'user-' . $user_id;
                    unset($liked_USERS[$userkeyip]);
                    update_post_meta($post_id, "_user_compareed", $liked_USERS);

                    $postkeyip = 'post-' . $post_id;
                    unset($liked_POSTS[$postkeyip]);
                    update_user_meta($user_id, "_compareed_posts", $liked_POSTS);
                }
                $posts_ids = $liked_POSTS;
            } else { // user is not logged in (anonymous)
                $ip = gspb_get_user_ip(); // user IP address
                $postidarray = array();
                $guest_comparees_transients = get_transient('re_guest_comparees_' . $ip);
                $meta_IPS = get_post_meta($post_id, "_usercompare_IP"); // stored IP addresses
                $liked_IPS = ""; // set up array variable           
                if (count($meta_IPS) != 0) { // meta exists, set up values
                    $liked_IPS = $meta_IPS[0];
                }
                if (!is_array($liked_IPS)) // make array just in case
                    $liked_IPS = array();
                if (!in_array($ip, $liked_IPS)) // if IP not in array
                    $liked_IPS['ip-' . $ip] = $ip; // add IP to array 

                if ($_POST['compare_count'] == 'add') {
                    if (!GSAlreadycompare($post_id)) {
                        update_post_meta($post_id, "post_compare_count", ++$post_compare_count); // +1 count post meta
                        update_post_meta($post_id, "_usercompare_IP", $liked_IPS); // Add user IP to post meta  
                        update_user_meta($postauthor, "overall_post_comparees", ++$overall_post_comparees); // +1 count to post author overall likes   
                        if (empty($guest_comparees_transients)) {
                            $postidarray[] = $post_id;
                            set_transient('re_guest_comparees_' . $ip, $postidarray, 30 * DAY_IN_SECONDS);
                            $posts_ids = $postidarray;
                        } else {
                            if (is_array($guest_comparees_transients)) {
                                $guest_comparees_transients[] = $post_id;
                                set_transient('re_guest_comparees_' . $ip, $guest_comparees_transients, 30 * DAY_IN_SECONDS);
                                $posts_ids = $guest_comparees_transients;
                            }
                        }
                    } else {
                        //update_post_meta( $post_id, "post_compare_count", $post_compare_count+2 );
                    }
                }
                if ($_POST['compare_count'] == 'remove') {
                    update_post_meta($post_id, "post_compare_count", $post_compare_count - 1);
                    update_user_meta($postauthor, "overall_post_comparees", --$overall_post_comparees);

                    $keyip = 'ip-' . $ip;
                    unset($meta_IPS[$keyip]);
                    update_post_meta($post_id, "_usercompare_IP", $meta_IPS);
                    $keydelete = array_search($post_id, $guest_comparees_transients);
                    unset($guest_comparees_transients[$keydelete]);
                    set_transient('re_guest_comparees_' . $ip, $guest_comparees_transients, 30 * DAY_IN_SECONDS);
                    $posts_ids = $guest_comparees_transients;
                }
            }

            $modifiedLinks = [];
            $currentLink = '';

            if(!empty($_POST['links'])) {
                $linksToComparePages = [];
                $links = explode(';', $_POST['links']);
                foreach ($links as $link) {
                    if(empty($link)) continue;
                    $linkId = explode('--', $link);
                    $linksToComparePages[$linkId[0]] = $linkId[1];
                }

                foreach ($linksToComparePages as $key => $value) {
                    if(!empty($posts_ids)) $modifiedLinks[$key] = $value . '?compareids=' . implode(',', array_values($posts_ids));
                    else $modifiedLinks[$key] = $value;
                }
            }

            if(!empty($_POST['is_compare_page'])) {
                $current_url = explode('?', $_SERVER['HTTP_REFERER'])[0];
                if(!empty($posts_ids)) $currentLink = $current_url . '?compareids=' . implode(',', array_values($posts_ids));
                else $currentLink = $current_url;
            }

            do_action('rh_overall_post_comparees_add');
            wp_send_json(['links' => $modifiedLinks, 'currentLink' => $currentLink]);
        }
        exit;
    }
}

if (!function_exists('gspb_query_comparison')) {
    function gspb_query_comparison($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'post_id' => NULL,
            'type' => 'button',
            'icon' => '',
            'comparisonadd' => '',
            'comparisonadded' => '',
            'comparisonpage' => '',
            'loginpage' => '',
            'noitemstext' => '',
            'table_type' => '',
            'predefined_by' => 'product_ids',
            'is_backend_editor' => false,
            'productsIds' => [],
            'categoryId' => '',
            'tagId' => '',
            'disable_fields' => [],
            'additional_shortcode' => '',
            'additional_shortcode_label' => '',
            'searchbtn' => false,
        ), $atts));

        if ($type == 'button') {
            if (!$post_id) {
                global $post;
                if (is_object($post)) {
                    $post_id = $post->ID;
                }
            }
            wp_enqueue_script('gspbproductcomparison');
            $like_count = get_post_meta($post_id, "post_compare_count", true); // get post likes
            if ((!$like_count) || ($like_count && $like_count == "0")) { // no votes, set up empty variable
                $temp = '0';
            } elseif ($like_count && $like_count != "0") { // there are votes!
                $temp = esc_attr($like_count);
            }
            $output = '<div class="gs-comparison-wrap">';
            $onlyuser_class = '';
            $loginurl = '';
            if ($loginpage) {
                if (is_user_logged_in()) {
                    $onlyuser_class = '';
                } else {
                    $loginurl = ' data-type="url" data-customurl="' . esc_url($loginpage) . '"';
                    $onlyuser_class = ' act-rehub-login-popup restrict_for_guests';
                }
            } else {
                $onlyuser_class = '';
            }
            $outputtext = '';
            if ($comparisonadd) {
                $outputtext .= '<span class="compareaddwrap" id="compareadd' . $post_id . '">';
                $outputtext .= $comparisonadd . '</span>';
            }
            if ($comparisonadded) {
                $outputtext .= '<span class="compareaddedwrap" id="compareadded' . $post_id . '">';
                $outputtext .= $comparisonadded . '</span>';
            }

            $iconwrap = '<span class="compareiconwrap">' . $icon  . '</span>';
            if (GSAlreadycompare($post_id)) { // already liked, set up unlike addon
                $output .= '<span class="alreadycompare gscompareplus" data-post_id="' . $post_id . '" data-informer="' . $temp . '" data-comparelink="' . esc_url($comparisonpage) . '">' . $iconwrap . '<span class="gscomparetext">' . $outputtext . '</span></span>';
            } else {
                $output .= '<span class="gscompareplus' . $onlyuser_class . '"' . $loginurl . ' data-post_id="' . $post_id . '" data-informer="' . $temp . '">' . $iconwrap . '<span class="gscomparetext">' . $outputtext . '</span></span>';
            }
            $output .= '<span id="comparecount' . $post_id . '" class="comparisoncount';
            $output .= '">' . $temp . '</span> ';
            $output .= '</div>';

            return $output;
        } else if ($type == 'icon' || $type == 'table') {

            $comparisonids = $likedposts = array();

            if($type == 'table') {
                if($table_type == 'predefined_items') {
                    if($predefined_by == 'product_ids' && !empty($productsIds))  {
                        $args = array(
                            'post_status' => 'publish',
                            'post_type'=> 'product',
                            'post__in' => $productsIds,
                        );
                        $products = new WP_Query($args);
                        wp_reset_query();
                        $comparisonids = wp_list_pluck( $products->posts, 'ID' );
                    } else if ($predefined_by == 'by_product_category' && !empty($categoryId)) {
                        $args = array(
                            'post_status' => 'publish',
                            'post_type'=> 'product',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'term_id',
                                    'terms'    => explode(',', $categoryId),
                                )
                            ),
                        );
                        $products = new WP_Query($args);
                        wp_reset_query();
                        $comparisonids = wp_list_pluck( $products->posts, 'ID' );
                    } else if ($predefined_by == 'by_product_tag' && !empty($tagId)) {
                        $args = array(
                            'post_status' => 'publish',
                            'post_type'=> 'product',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field'    => 'term_id',
                                    'terms'    => explode(',', $tagId),
                                )
                            ),
                        );
                        $products = new WP_Query($args);
                        wp_reset_query();
                        $comparisonids = wp_list_pluck( $products->posts, 'ID' );
                    }
                } else { // dynamically_created
                    if($is_backend_editor) {
                        $args = array(
                            'post_status' => 'publish',
                            'posts_per_page'=> 5,
                            'post_type'=> 'product'
                        );
                        $products = new WP_Query($args);
                        wp_reset_query();
                        $comparisonids = wp_list_pluck( $products->posts, 'ID' );
                    } else {
                        if (!empty($_GET['compareids'])) {
                            $comparisonids = explode(',', esc_html($_GET['compareids']));
                        } else {
                            if (is_user_logged_in()) { // user is logged in
                                global $current_user;
                                $user_id = $current_user->ID; // current user
                                $likedposts = get_user_meta($user_id, "_compareed_posts", true);
                            } else {
                                $ip = gspb_get_user_ip(); // user IP address
                                $likedposts = get_transient('re_guest_comparees_' . $ip);
                            }
                            $comparisonids = $likedposts;
                        }
                    }
                }
            } else {
                if (!empty($_GET['compareids'])) {
                    $comparisonids = explode(',', esc_html($_GET['compareids']));
                } else {
                    if (is_user_logged_in()) { // user is logged in
                        global $current_user;
                        $user_id = $current_user->ID; // current user
                        $likedposts = get_user_meta($user_id, "_compareed_posts", true);
                    } else {
                        $ip = gspb_get_user_ip(); // user IP address
                        $likedposts = get_transient('re_guest_comparees_' . $ip);
                    }
                    $comparisonids = $likedposts;
                }
            }

            if ($type == 'icon') {
                $countvalue = (!empty($comparisonids) && is_array($comparisonids)) ? count($comparisonids) : 0;
                $link = !empty($comparisonids) ? esc_url($comparisonpage) . '?compareids='.implode(',', $comparisonids) : esc_url($comparisonpage);
                $output = '<a href="' . $link .'" class="gs-comparison-wrap gs-comparison-icon-link-to-compare" data-clear-link="'.esc_url($comparisonpage).'"><span class="gs-compare-icon-notice">' . $icon . '<span class="gs-compare-icon-counter">' . $countvalue . '</span></span></a>';
                return $output;
            } else if ($type == 'table') {
                ob_start();
                if (!empty($comparisonids)) {
                    $comparisonids = array_reverse($comparisonids);

                    foreach ($comparisonids as $comparisonid) {
                        if ('publish' != get_post_status($comparisonid)) {
                            if (!empty($user_id)) {
                                $postkeyip = 'post-' . $comparisonid;
                                unset($likedposts[$postkeyip]);
                                update_user_meta($user_id, "_compareed_posts", $likedposts);
                            } else {
                                $keydelete = array_search($comparisonid, $likedposts);
                                unset($likedposts[$keydelete]);
                                set_transient('re_guest_comparees_' . $ip, $likedposts, 30 * DAY_IN_SECONDS);
                            }
                        }
                    }

                    $disable_fields_string = implode(',', array_keys(array_filter($disable_fields, function($val, $key) {
                        return $val;
                    }, ARRAY_FILTER_USE_BOTH)));

                    echo do_shortcode('[gspb_comparison_table ids="'.implode(',', $comparisonids).'" disable_fields_string="'.$disable_fields_string.'" is_backend_editor="'.$is_backend_editor.'" searchbtn="'.$searchbtn.'" table_type="'.$table_type.'"]');

                    if(!empty($additional_shortcode_label) || !empty($additional_shortcode)){
                        echo '<div class="additional-shortcode">';
                            if(!empty($additional_shortcode_label)) {
                                echo '<div class="additional-shortcode-label">';
                                    echo esc_attr($additional_shortcode_label);
                                echo '</div>';
                            }
                            if(!empty($additional_shortcode)) {
                                echo '<div class="additional-shortcode-shortcode">';
                                    if($is_backend_editor) echo ''.$additional_shortcode;
                                    else echo do_shortcode($additional_shortcode);
                                echo '</div>';
                            }
                        echo '</div>';
                    }
                } else {
                    echo esc_attr($noitemstext);
                }
                $output = ob_get_contents();
                ob_end_clean();
                return $output;
            }
        }
    }
}

add_action('wp_ajax_nopriv_gscomparerecount', 'gscomparerecount_function');
add_action('wp_ajax_gscomparerecount', 'gscomparerecount_function');
if (!function_exists('gscomparerecount_function')) {
    function gscomparerecount_function(){
        $nonce = sanitize_text_field($_POST['comparenonce']);
        if (!wp_verify_nonce($nonce, 'comparenonce')) die('Nope!');

        $current_user = get_current_user_id();

        if ($current_user != '0') {
            $comparisonids = get_user_meta($current_user, "_compareed_posts", true);
        } else {
            $ip = gspb_get_user_ip();
            $comparisonids = get_transient('re_guest_comparees_' . $ip);
        }

        $comparisonids = !empty($comparisonids) ? $comparisonids : array();
        wp_send_json(array('comparisonids' => implode(',',$comparisonids), 'comparecounter' => count($comparisonids)));
    }
        
}

add_shortcode( 'gspb_comparison_table', 'gspb_comparison_table_view_shortcode' );
if(!function_exists('gspb_comparison_table_view_shortcode')) {
    function gspb_comparison_table_view_shortcode( $atts, $content = null ) {
        wp_enqueue_script('gspbproductcomparison-table');
        extract(shortcode_atts(array(
            'ids' => '',
            'searchbtn' => false,
            'is_backend_editor' => false,
            'posttype' => 'product', // comma separated post types
            'taxonomy' => 'product_cat',
            'terms' => '', // comma separated term slugs
            'disable' => '',
            'topcontent'=> '',
            'contentlabel'=> 'Additionally',
            'disable_fields_string'=> '',
            'table_type' => '',
        ), $atts));
        ob_start();
        $compareids = array();
        if($ids):
            $compareids = explode(',', $ids);
        else :
            $compareids = (get_query_var('compareids')) ? explode(',', get_query_var('compareids')) : '';
        endif;

        #user identity
        $ip = gspb_get_user_ip();
        $userid = get_current_user_id();
        $userid = empty($userid) ? $ip : $userid;
        $post_ids = get_transient('re_compare_' . $userid);
        if(empty($post_ids) && !empty($compareids)){
            $newvalue = implode(',', $compareids);
            set_transient('re_compare_' . $userid, $newvalue, 30 * DAY_IN_SECONDS);
        }

        if($searchbtn && $table_type == 'dynamically_created'){
            wp_enqueue_script('gspbcompare');
            wp_enqueue_style('gspbcomparesearch');wp_enqueue_style('gspbajaxsearch');
            echo '<div class="search-wrap"><a href="#" id="btn_search"><svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="24px" height="24px">    <path d="M 9 2 C 5.1458514 2 2 5.1458514 2 9 C 2 12.854149 5.1458514 16 9 16 C 10.747998 16 12.345009 15.348024 13.574219 14.28125 L 14 14.707031 L 14 16 L 20 22 L 22 20 L 16 14 L 14.707031 14 L 14.28125 13.574219 C 15.348024 12.345009 16 10.747998 16 9 C 16 5.1458514 12.854149 2 9 2 z M 9 4 C 11.773268 4 14 6.2267316 14 9 C 14 11.773268 11.773268 14 9 14 C 6.2267316 14 4 11.773268 4 9 C 4 6.2267316 6.2267316 4 9 4 z"/></svg> '.__('Add more items', 'greenshiftwoo').'</a><input type="hidden" id="compare_search_data" data-posttype="'. esc_attr($posttype) .'" data-terms="'. (int)$terms .'" data-taxonomy="'. esc_attr($taxonomy) .'"></div>';
        }

        if($disable_fields_string){
            $disable_fields = explode(',', $disable_fields_string);
            if(is_array($disable_fields)){
                $addstyles = '';
                if(!$is_backend_editor) {
                    wp_register_style( 'rhheader-inline-style', false );
                    wp_enqueue_style( 'rhheader-inline-style' );
                }

                foreach( $disable_fields as $item){
                    if($item == 'description'){
                        $addstyles .= '.row_chart_2{display: none}';
                    }
                    if($item == 'overview'){
                        $addstyles .= '.row_chart_1{display: none}';
                    }
                    if($item == 'brand'){
                        $addstyles .= '.row_chart_5{display: none}';
                    }
                    if($item == 'stock'){
                        $addstyles .= '.row_chart_7{display: none}';
                    }
                    if($item == 'userrate'){
                        $addstyles .= '.row_chart_3{display: none}';
                    }
                    if($item == 'review'){
                        $addstyles .= '.row_chart_6{display: none}';
                    }
                }
                $is_backend_editor = boolval($is_backend_editor);
                if($is_backend_editor) {
                    echo '<style>'.$addstyles.'</style>';
                } else {
                    wp_add_inline_style('rhheader-inline-style', $addstyles);
                }
            }
        }
        if(!empty($compareids)):
            if(count($compareids) > 1){

                $comparedarray = get_transient( 'rh_latest_compared_ids' );
                if(empty($comparedarray)){
                    $comparedarray = array();
                }
                $saveids = array_slice($compareids, 0, 2);
                $saveids = implode(',', $saveids);
                if (!in_array($saveids, $comparedarray)) {
                    array_unshift($comparedarray , $saveids);
                }
                $comparesave = array_slice($comparedarray, 0, 8);
                set_transient( 'rh_latest_compared_ids', $comparesave, DAY_IN_SECONDS * 31 );
            }


            ?>
            <?php $args = array(
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'orderby' => 'post__in',
            'post__in' => $compareids,
            'posts_per_page'=> -1,
            'post_type'=> 'product'

        );
            ?>

            <?php $common_attributes = $attributes_group = array(); ?>
            <?php $common = new WP_Query($args); if ($common->have_posts()) : ?>
            <?php while ($common->have_posts()) : $common->the_post(); global $product; global $post; ?>
                <?php
                $attributes_group = (function_exists('rh_get_attributes_group')) ? rh_get_attributes_group( $product ) : '';
                if(is_array($attributes_group)){
                    $countgroup = count($attributes_group);
                }else{
                    $countgroup = 0;
                }
                ?>

                <?php if($countgroup > 1): ?>
                    <?php foreach( $attributes_group as $group_key => $attribute_group ): ?>
                        <?php
                        if(!is_array($attribute_group['attributes'])) continue;
                        ksort($attribute_group['attributes']);
                        $common_attributes[$group_key]['name'] = $attribute_group['name'];
                        $attributes = $attribute_group['attributes'];
                        foreach ($attributes as $key => $attribute) {
                            $key = $attribute['name'];
                            if(!empty($common_attributes[$group_key]['attributes']) && array_key_exists($key, $common_attributes[$group_key]['attributes'])){
                                continue;
                            }
                            $common_attributes[$group_key]['attributes'][$key] = $attribute;
                        }
                        ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php $attributes = $product->get_attributes();?>
                    <?php
                    foreach ($attributes as $key => $attribute) {
                        if($attribute['is_visible'] == 1){
                            $key = $attribute['name'];
                            if(!empty($common_attributes) && array_key_exists($key, $common_attributes)){
                                continue;
                            }
                            $common_attributes[$key] = $attribute;
                        }
                    }
                    ?>
                <?php endif; ?>
            <?php endwhile; endif; wp_reset_query(); ?>

            <?php $wp_query = new WP_Query($args); $ci=0; if ($wp_query->have_posts()) : ?>

            <?php wp_enqueue_script('carouFredSel'); wp_enqueue_script('touchswipe'); wp_enqueue_script('rehubtablechart');wp_enqueue_style('rhchartbuilder'); ?>
            <div class="top_chart table_view_charts loading">
                <div class="top_chart_first">
                    <ul>
                        <li class="row_chart_0 image_row_chart">
                            <div><br /><label class="diff-label"><input class="re-compare-show-diff" name="re-compare-show-diff" type="checkbox" /><?php esc_html_e('Show only differences', 'greenshiftwoo');?></label></div>
                        </li>
                        <li class="row_chart_1 heading_row_chart">
                            <?php esc_html_e('Overview', 'greenshiftwoo');?>
                        </li>
                        <li class="row_chart_2 meta_value_row_chart">
                            <?php esc_html_e('Description', 'greenshiftwoo');?>
                        </li>
                        <li class="row_chart_7 meta_value_row_chart">
                            <?php esc_html_e('Availability', 'greenshiftwoo');?>
                        </li>
                        <li class="row_chart_3 meta_value_row_chart">
                            <?php esc_html_e('User Rating', 'greenshiftwoo');?>
                        </li>
                        <?php if(!empty($common_attributes)): ?>
                            <?php if($countgroup > 1): ?>
                                <?php $i = 7; foreach($common_attributes as $common_attribute):?>
                                    <?php $i++; ?>
                                    <li class="row_chart_<?php echo (int)$i;?> heading_row_chart sub_heading_row_chart"><?php echo esc_attr($common_attribute['name']); ?></li>
                                    <?php foreach($common_attribute['attributes'] as $attribute_name => $attribute_value): ?>
                                        <?php $i++; ?>
                                        <li class="row_chart_<?php echo (int)$i;?> meta_value_row_chart"><?php echo wc_attribute_label( $attribute_name ); ?></li>
                                    <?php endforeach;?>
                                <?php endforeach;?>
                            <?php else: ?>
                                <li class="row_chart_8 heading_row_chart"><?php esc_html_e('Specification', 'greenshiftwoo');?></li>
                                <?php $i = 8; foreach($common_attributes as $attribute_value):?>
                                    <?php $i++;?>
                                    <li class="row_chart_<?php echo (int)$i;?> meta_value_row_chart"><?php echo wc_attribute_label( $attribute_value['name'] ); ?></li>
                                <?php endforeach;?>
                            <?php endif;?>
                        <?php else:?>
                            <?php $i = 7;?>
                        <?php endif;?>
                        <?php if ($content && !$topcontent):?>
                            <?php $i++;?>
                            <li class="row_chart_<?php echo (int)$i;?> shortcode_row_chart">
                                <?php echo esc_attr($contentlabel);?>
                            </li>
                        <?php endif;?>
                    </ul>
                </div>
                <div class="top_chart_wrap woocommerce <?php echo ($table_type == 'predefined_items') ? 'top_chart_wrap_predefined_items' : ''?>"><div class="top_chart_carousel">
                        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); global $product, $post; $ci ++?>
                            <div class="top_rating_item activecol top_chart_item compare-item-<?php echo (int)$post->ID;?>" id='rank_<?php echo (int)$ci?>' data-compareid="<?php echo (int)$post->ID;?>">
                                <ul>
                                    <li class="row_chart_0 image_row_chart">
                                        <div class="product_image_col">
                                            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 122.88" class="remove-from-compare-icon">
                                               <path d="M61.44,0A61.44,61.44,0,1,1,0,61.44,61.44,61.44,0,0,1,61.44,0ZM74.58,36.8c1.74-1.77,2.83-3.18,5-1l7,7.13c2.29,2.26,2.17,3.58,0,5.69L73.33,61.83,86.08,74.58c1.77,1.74,3.18,2.83,1,5l-7.13,7c-2.26,2.29-3.58,2.17-5.68,0L61.44,73.72,48.63,86.53c-2.1,2.15-3.42,2.27-5.68,0l-7.13-7c-2.2-2.15-.79-3.24,1-5l12.73-12.7L36.35,48.64c-2.15-2.11-2.27-3.43,0-5.69l7-7.13c2.15-2.2,3.24-.79,5,1L61.44,49.94,74.58,36.8Z"/></svg>
                                            <figure>
                                                <?php if ( $product->is_featured() ) : ?>
                                                    <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . esc_html__( 'Featured!', 'greenshiftwoo' ) . '</span>', $post, $product ); ?>
                                                <?php endif; ?>
                                                <?php if ( $product->is_on_sale()) : ?>
                                                    <?php
                                                    $percentage=0;
                                                    $featured = ($product->is_featured()) ? ' onsalefeatured' : '';
                                                    if ($product->get_regular_price() && is_numeric($product->get_regular_price()) && $product->get_regular_price() !=0) {
                                                        $percentage = round( ( ( $product->get_regular_price() - $product->get_price() ) / $product->get_regular_price() ) * 100 );
                                                    }
                                                    if ($percentage && $percentage>0 && !$product->is_type( 'variable' )) {
                                                        $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'"><span>- ' . $percentage . '%</span></span>', $post, $product );
                                                    }
                                                    else{
                                                        $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'">' . esc_html__( 'Sale!', 'greenshiftwoo' ) . '</span>', $post, $product );
                                                    }
                                                    ?>
                                                    <?php echo ''.$sales_html; ?>
                                                <?php endif; ?>
                                                <a href="<?php the_permalink();?>">
                                                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
                                                          $image = empty($image[0]) ? wc_placeholder_img_src( 'thumbnail' ) : $image[0];
                                                    ?>
                                                    <img src="<?php  echo esc_url($image); ?>">
                                                </a>
                                            </figure>
                                            <h2>
                                                <a href="<?php the_permalink();?>">
                                                    <?php echo the_title();?>
                                                </a>
                                            </h2>
                                            <div class="price-in-compare-flip">

                                                <?php if ($product->get_price() !='') : ?>
                                                    <span class="price-woo-compare-chart rehub-btn-font rehub-main-color fontbold"><?php echo ''.$product->get_price_html(); ?></span>
                                                   
                                                <?php endif;?>

                                                <?php if ( $product->add_to_cart_url() !='') : ?>
                                                <?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                                    sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="wp-element-button re_track_btn btn_offer_block btn-woo-compare-chart woo_loop_btn %s %s product_type_%s"%s%s>%s</a>',
                                                        esc_url( $product->add_to_cart_url() ),
                                                        esc_attr( $product->get_id() ),
                                                        esc_attr( $product->get_sku() ),
                                                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                                        $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                                                        esc_attr( $product->get_type() ),
                                                        $product->get_type() =='external' ? ' target="_blank"' : '',
                                                        $product->get_type() =='external' ? ' rel="nofollow"' : '',
                                                        esc_html( $product->add_to_cart_text() )
                                                    ),
                                                    $product );?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="row_chart_1 heading_row_chart">
                                    </li>
                                    <li class="row_chart_2 meta_value_row_chart">
                                        <?php the_excerpt(); ?>
                                    </li>
                                    <li class="row_chart_7 meta_value_row_chart">
                                        <?php if ( $product->is_in_stock() ):?>
                                            <span class="greencolor"><?php esc_html_e( 'In stock', 'greenshiftwoo' ) ;?></span>
                                        <?php else :?>
                                            <span class="redcolor"><?php esc_html_e( 'Out of stock', 'greenshiftwoo' ) ;?></span>
                                        <?php endif;?>
                                    </li>
                                    <li class="row_chart_3 meta_value_row_chart">
                                        <?php if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes'):?>
                                            <?php $avg_rate_score 	= number_format( $product->get_average_rating(), 1 ) * 20 ;?>
                                            <?php if ($avg_rate_score):?>
                                                <div class="star-rating" role="img">
                                                    <?php echo wc_get_star_rating_html($product->get_average_rating(), $product->get_rating_count()) ;?>
                                                </div>
                                            <?php else:?>
                                                -
                                            <?php endif;?>
                                        <?php else:?>
                                            -
                                        <?php endif;?>
                                    </li>
                                    <?php if(!empty($common_attributes)): ?>
                                        <?php $attrnames = array(); ?>
                                        <?php if($countgroup > 1): ?>
                                            <?php $i = 7; foreach($common_attributes as $attr_group): ?>
                                                <?php $i++;?>
                                                <li class="row_chart_<?php echo (int)$i; ?> heading_row_chart sub_heading_row_chart"></li>
                                                <?php $currentattr =  $attr_group['attributes']; ?>
                                                <?php foreach($currentattr as $attribute):?>
                                                    <?php $i++;?>
                                                    <li class="row_chart_<?php echo (int)$i; ?> meta_value_row_chart">
                                                        <?php
                                                        if($attribute['is_visible'] != 1) continue;
                                                        //	if(!in_array()) continue;
                                                        if ($attribute['is_taxonomy']) {
                                                            $values = wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'names' ) );
                                                            if(!empty($values)){
                                                                echo apply_filters('woocommerce_attribute', wpautop(wptexturize(implode(', ', $values))), $attribute, $values );
                                                            }
                                                        } else {
                                                            if($product->get_attribute($attribute['name'])){
                                                                echo wc_implode_text_attributes($attribute->get_options());
                                                            }
                                                        }
                                                        ?>
                                                    </li>
                                                <?php endforeach;?>
                                            <?php endforeach;?>
                                        <?php else: ?>
                                            <?php $i = 8;?>
                                            <li class="row_chart_<?php echo (int)$i; ?> heading_row_chart"></li>
                                            <?php $currentattr =  $product->get_attributes(); ?>
                                            <?php foreach ($currentattr as $key => $attr) {
                                                if($attr['is_visible'] == 1){
                                                    $key = $attr['name'];
                                                    $attrnames[$key] = $attr;
                                                }
                                            }
                                            ?>
                                            <?php foreach($common_attributes as $attkey => $attribute):?>
                                                <?php $i++;?>
                                                <li class="row_chart_<?php echo (int)$i;?> meta_value_row_chart">
                                                    <?php
                                                    $currentname = $attribute['name'];
                                                    if(array_key_exists($currentname, $attrnames)){
                                                        if ( $attribute['is_taxonomy'] ) {
                                                            $values = wc_get_product_terms( $product->get_id(), $currentname, array( 'fields' => 'names' ) );
                                                            if(!empty($values)){
                                                                echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
                                                            }
                                                        } else {
                                                            $curtextattr = $attrnames[$currentname];
                                                            echo wc_implode_text_attributes( $curtextattr->get_options() );
                                                        }
                                                    }
                                                    ?>
                                                </li>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                    <?php else:?>
                                        <?php $i = 7;?>
                                    <?php endif;?>
                                    <?php if ($content && !$topcontent):?>
                                        <?php $i++;?>
                                        <li class="row_chart_<?php echo (int)$i;?> shortcode_row_chart">
                                            <?php echo do_shortcode(wp_kses_post($content));?>
                                        </li>

                                    <?php endif;?>
                                </ul>
                            </div>
                        <?php endwhile; ?>
                    </div></div>
                <span class="top_chart_row_found" data-rowcount="<?php echo (int)$i + 1;?>"></span>
            </div>
        <?php else: ?><?php esc_html_e('No posts for this criteria.', 'greenshiftwoo'); ?>
        <?php endif; ?>
            <?php wp_reset_query(); ?>

        <?php
        else:
            echo '<div class="mb30 clearfix"></div>';
            echo esc_html__('No products for comparison', 'greenshiftwoo');
            echo '<div class="mb30 clearfix"></div>';
        endif;

        $output = ob_get_contents();
        ob_end_clean();
        return $output;

    }
}

if (!function_exists('add_to_compare_search')){
    function add_to_compare_search() {

        check_ajax_referer( 'comparenonce', 'security' );
        #get search string
        if (empty($_POST['search_query']))
            return;

        $search_query = sanitize_text_field($_POST['search_query']);

        $buffer = '';
        $compare_ids_arr = array();

        #user identity
        $ip = gspb_get_user_ip();
        $userid = get_current_user_id();
        $userid = empty($userid) ? $ip : $userid;

        #get current comparing ids
        if(is_user_logged_in()){
            global $current_user;
            $user_id = $current_user->ID; // current user
            $compare_ids_arr = !empty(get_user_meta($user_id, "_compareed_posts")) ? array_values(get_user_meta($user_id, "_compareed_posts")[0]) : get_user_meta($user_id, "_compareed_posts"); // post ids from user meta
        } else {
            $ip = gspb_get_user_ip(); // user IP address
            $postidarray = array();
            $compare_ids_arr = get_transient('re_guest_comparees_' . $ip);
        }

        #the post types for search
        $posttype = explode(',', sanitize_text_field($_POST['posttype']));

        #build arguments fo WP_Query
        $args = array(
            's' => $search_query,
            'post_type' => $posttype,
            'posts_per_page' => 5,
            'post_status' => 'publish',
            'cache_results' => false,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'no_found_rows' => true
        );

        #add terms to arguments
        $taxonomy = sanitize_text_field($_POST['taxonomy']);

        if (!empty($_POST['terms'])) {
            $terms = explode(',', $_POST['terms']);
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'id',
                    'terms' => $terms
                )
            );
        }

        $search_query = new WP_Query($args);

        //build the results
        if (!empty($search_query->posts)) {
            foreach ($search_query->posts as $post) {
                $post_id = $post->ID;

                #get product / deal price
                $the_price = get_post_meta( $post_id, '_price', true);
                if ( '' != $the_price ) {
                    $the_price = strip_tags( wc_price( $the_price ) );
                }
                $terms = get_the_terms($post_id, 'product_visibility' );
                if ( ! is_wp_error($terms) && $terms ){
                    $termnames = array();
                    foreach ($terms as $term) {
                        $termnames[] = $term->name;
                    }
                    if (in_array('exclude-from-search', $termnames)){
                        continue;
                    }
                }

                if( has_post_thumbnail($post_id) ){
                    $image_id = get_post_thumbnail_id($post_id);
                    $image_url = wp_get_attachment_image_src($image_id, 'thumb');
                    $image_url = $image_url[0];
                }else {
                    $image_url = wc_placeholder_img_src() ;
                }

                $compare_active = ( in_array( $post_id, $compare_ids_arr ) ) ? ' comparing' : ' not-incompare';

                // HTML
                $buffer .= '<div class="re-search-result-div wpsm-button-new-compare addcompare-id-'. $post_id .''. $compare_active .'" data-addcompare-id="'. $post_id .'">';
                $buffer .= '<div class="re-search-result-thumb"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve"><g><path d="M474.045,173.813c-4.201,1.371-6.494,5.888-5.123,10.088c7.571,23.199,11.411,47.457,11.411,72.1c0,62.014-24.149,120.315-68,164.166s-102.153,68-164.167,68s-120.316-24.149-164.167-68S16,318.014,16,256S40.149,135.684,84,91.833s102.153-68,164.167-68c32.889,0,64.668,6.734,94.455,20.017c28.781,12.834,54.287,31.108,75.81,54.315c3.004,3.239,8.066,3.431,11.306,0.425c3.24-3.004,3.43-8.065,0.426-11.306c-23-24.799-50.26-44.328-81.024-58.047C317.287,15.035,283.316,7.833,248.167,7.833c-66.288,0-128.608,25.813-175.48,72.687C25.814,127.392,0,189.712,0,256c0,66.287,25.814,128.607,72.687,175.479c46.872,46.873,109.192,72.687,175.48,72.687s128.608-25.813,175.48-72.687c46.873-46.872,72.687-109.192,72.687-175.479c0-26.332-4.105-52.26-12.201-77.064C482.762,174.736,478.245,172.445,474.045,173.813z"/><path d="M504.969,83.262c-4.532-4.538-10.563-7.037-16.98-7.037s-12.448,2.499-16.978,7.034l-7.161,7.161c-3.124,3.124-3.124,8.189,0,11.313c3.124,3.123,8.19,3.124,11.314-0.001l7.164-7.164c1.51-1.512,3.52-2.344,5.66-2.344s4.15,0.832,5.664,2.348c1.514,1.514,2.348,3.524,2.348,5.663s-0.834,4.149-2.348,5.663L217.802,381.75c-1.51,1.512-3.52,2.344-5.66,2.344s-4.15-0.832-5.664-2.348L98.747,274.015c-1.514-1.514-2.348-3.524-2.348-5.663c0-2.138,0.834-4.149,2.351-5.667c1.51-1.512,3.52-2.344,5.66-2.344s4.15,0.832,5.664,2.348l96.411,96.411c1.5,1.5,3.535,2.343,5.657,2.343s4.157-0.843,5.657-2.343l234.849-234.849c3.125-3.125,3.125-8.189,0-11.314c-3.124-3.123-8.189-3.123-11.313,0L212.142,342.129l-90.75-90.751c-4.533-4.538-10.563-7.037-16.98-7.037s-12.448,2.499-16.978,7.034c-4.536,4.536-7.034,10.565-7.034,16.977c0,6.412,2.498,12.441,7.034,16.978l107.728,107.728c4.532,4.538,10.563,7.037,16.98,7.037c6.417,0,12.448-2.499,16.977-7.033l275.847-275.848c4.536-4.536,7.034-10.565,7.034-16.978S509.502,87.794,504.969,83.262z"/></g></svg><img src="'.$image_url.'" alt="'.get_the_title( $post_id ).'"/></div>';

                $buffer .= '<div class="re-search-result-info"><h3 class="re-search-result-title">'. get_the_title( $post_id ) .'</h3>';

                if( '' != $the_price ) {
                    $buffer .= '<span class="re-search-result-price greencolor">'.$the_price.'</span>';
                }else{
                    $buffer .= '<span class="re-search-result-meta">'.get_the_time(get_option( 'date_format' ), $post_id).'</span>';
                }

                $buffer .= '</div></div>';
            }
        }

        $current_url = explode('?', $_SERVER['HTTP_REFERER'])[0];
        if(!empty($compare_ids_arr)) $currentLink = $current_url . '?compareids=' . implode(',', $compare_ids_arr);
        else $currentLink = $current_url;

        $button = '<span class="add-to-compare-button re-compare-destin" data-compareurl="'.$currentLink.'">'. esc_html__('Add to Comparison', 'greenshiftwoo') .' <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M7.33 24l-2.83-2.829 9.339-9.175-9.339-9.167 2.83-2.829 12.17 11.996z"/></svg></span>';

        if (count($search_query->posts) == 0) {
            $buffer = '<div class="re-aj-search-wrap-results no-result">'. esc_html__('No results', 'greenshiftwoo') .'</div>';
        } else {
            $buffer = '<div class="re-aj-search-wrap-results">'. $buffer .''. $button .'</div>';
        }

        //prepare array for ajax
        $bufferArray = array(
            'compare_html' => $buffer,
        );

        //Return the String
        die(json_encode($bufferArray));
    }
    add_action( 'wp_ajax_nopriv_add_to_compare_search', 'add_to_compare_search' );
    add_action( 'wp_ajax_add_to_compare_search', 'add_to_compare_search' );
}