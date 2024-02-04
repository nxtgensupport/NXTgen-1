<?php
/**
 * Greenshift Woocommerce Helper Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


//////////////////////////////////////////////////////////////////
// Include the view files 
//////////////////////////////////////////////////////////////////

if(!function_exists('gspbwoo_get_view_file')){
    function gspbwoo_get_view_file($name, $data = []){
        $file = GREENSHIFTWOO_DIR_PATH . 'parts/' . $name . '.php';
        extract( $data, EXTR_SKIP );
        include $file;
    }
}