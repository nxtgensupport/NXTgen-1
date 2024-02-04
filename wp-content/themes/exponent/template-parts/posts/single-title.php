<?php
    $single_post_override = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'single_post_override', true );

    if( !empty( $single_post_override ) ) {
        $metas_on_thumb = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'metas_on_thumb', true );
    }else {
        $metas_on_thumb = be_themes_get_option( 'metas_on_thumb' );
    }

    if( empty( $metas_on_thumb ) ) {
        echo sprintf( '<div class="%s">', be_themes_get_class( 'post-single-title' ) );
        get_template_part( 'template-parts/posts/partials/archive', 'title' );
        echo '</div>';
    }
