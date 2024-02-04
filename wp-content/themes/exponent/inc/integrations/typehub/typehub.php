<?php

/**
 * Typehub Integrations.
 */
if( !function_exists( 'be_themes_typehub_add_options' ) ) {
    function be_themes_typehub_add_options() {
        $typehub_config = array();

        foreach( glob( trailingslashit( get_template_directory() ) . 'inc/integrations/typehub/*.php' ) as $config_path ){
            $file_name = basename( $config_path, '.php' );
            if( 'typehub' === $file_name ) {
                continue;
            }
            $new_config = include $config_path;
            $typehub_config = array_merge( $typehub_config, $new_config );
        }
        if( !empty( $typehub_config ) ) {
            $typehub_config = array('Headings' => $typehub_config['Headings']) + $typehub_config;
            foreach( $typehub_config as $category => $options ) {
                typehub_register_options( $options, $category );
            }
        }
    }
    add_action( 'typehub_register_options', 'be_themes_typehub_add_options', 11 );
}