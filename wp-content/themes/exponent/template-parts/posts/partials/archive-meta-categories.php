<?php
    $anchor_class = array ();
    $sep = ', ';
    $color = false;
    $bg_color = false;
    if( !empty( $be_meta_labeled_cat ) ) {
        $color = true;
        $bg_color = true;
        $sep = '';
    }

    if( !empty( $be_animated_cat ) ) {
        $anchor_class[] = be_themes_get_class( 'lively-link-style1' );
    }
    echo be_themes_get_terms( get_the_ID(), 'category', be_themes_get_class( 'post-categories', !empty( $be_meta_labeled_cat ) ? 'post-categories-labeled' : 'post-categories-normal' ), implode( ' ', $anchor_class ), $sep, $color, $bg_color );
?>
    