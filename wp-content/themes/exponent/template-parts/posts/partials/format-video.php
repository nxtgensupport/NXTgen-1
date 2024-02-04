<?php   
    $url = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'video_embed', true );
    if( be_themes_valid_video_embed( $url ) ) {
        echo be_get_embed( $url );
    }else if( be_themes_valid_video_format( $url ) ) {
        $video_args = array ( 'src' => $url );
        echo sprintf( '<div class="%s">%s</div>', be_themes_get_class( 'fluid-video' ), wp_video_shortcode( $video_args ) );
    }