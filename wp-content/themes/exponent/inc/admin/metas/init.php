<?php

    //metas using metabox.io plugin
    if( !function_exists( 'be_themes_register_meta_boxes' ) ) {
        add_filter( 'rwmb_meta_boxes', 'be_themes_register_meta_boxes' );
        function be_themes_register_meta_boxes( $meta_boxes ) {
            foreach( glob( trailingslashit( get_template_directory() ) . 'inc/admin/metas/rwmb-metas/*.php' ) as $config ){
                $meta_config = include $config;
                $meta_boxes = array_merge( $meta_boxes, $meta_config );
            }
            return $meta_boxes;
        }
    }

    //TODO - Convet this to use metabox plugin
    //custom metas
    foreach( glob( trailingslashit( get_template_directory() ) . 'inc/admin/metas/custom-metas/*.php' ) as $config ){
        include_once $config;
    }