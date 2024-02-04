<?php

function exp_modules_tatsu_gallery_atts( $image,$key ){

    if( $image['has_video'] ){

        $video_details_large = be_get_video_details($image['full_image_url'],'large');
        $video_details_small = be_get_video_details($image['full_image_url'],'small');
        
        $thumb = $video_details_small[ 'thumb_url' ];
        $poster = $video_details_large[ 'thumb_url' ];
        return array(
            'class' => array(
                'image' => 'mobx'
            ),
            'data' => array(
                'data-thumb="'.$thumb.'"',
                'data-poster="'.$poster.'"',
                'data-rel="my-gallery'.$key.'"',
            ),
            'html_att' => array(
                'data-type' => "HTML"
            )
        );
    } else {
        return array( 
                'class' => array(
                    'image' => 'mobx'
                ),
                'data'  => array(
                    'data-rel="my-gallery'.$key.'"',
                )
            );
    }

}
add_filter( 'tatsu_gallery_lightbox_atts', 'exp_modules_tatsu_gallery_atts', 10, 2 );