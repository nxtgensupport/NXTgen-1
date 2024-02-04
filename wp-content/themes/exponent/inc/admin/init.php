<?php
//include customizer options
if ( is_customize_preview() && current_user_can( 'manage_options' ) && class_exists( 'Kirki' ) ) {
    require_once trailingslashit( get_template_directory() ) . 'inc/classes/class-be-options.php'; 
}

//include metas
if ( is_admin() ) {
    require_once trailingslashit( get_template_directory() ) . 'inc/admin/metas/init.php';
}