<?php   
    $url = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'audio_embed', true );
    $embed = wp_oembed_get( $url );
    
    if( empty( $embed ) ) {
        $default_types = wp_get_audio_extensions();
        $type = wp_check_filetype( $url, wp_get_mime_types() );
        if ( !empty( $type[ 'ext' ] ) && in_array( strtolower( $type[ 'ext' ] ), $default_types ) ) {
            $audio_args = array ( 'src' => $url );
            $audio_html = wp_audio_shortcode( $audio_args );
            echo !empty( $audio_html ) ? $audio_html : '';
        }
    }else {
        if( !function_exists( 'be_gdpr_privacy_ok' ) ){
            echo !empty( $embed ) ? $embed : '';
        } else {
            echo be_gdpr_embed_audio( $url ); 
        }
    }