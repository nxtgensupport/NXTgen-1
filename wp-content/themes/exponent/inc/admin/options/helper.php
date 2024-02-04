<?php
    if( !function_exists( 'be_themes_get_options_decorator_setting' ) ) {
        function be_themes_get_options_decorator_setting() {
            static $decorator_count = 0;
            return 'decorator_setting_' . $decorator_count++;
        }
    }
    
    if( !function_exists( 'exponent_get_all_pages' ) ) {
        function exponent_get_all_pages() {
            $pages_array = array( 'none' => 'None');
    
            $pages = get_posts(array( 'post_type' => 'page', 'numberposts' => -1) );
            if( $pages ) {
                foreach( $pages as $page ) {
                    $pages_array[ (string) $page->ID ] =  $page->post_title;
                }
                wp_reset_postdata();
            }
    
            return $pages_array;
        }
    }    