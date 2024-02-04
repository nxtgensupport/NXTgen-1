<?php

require_once be_themes_integrations_dir() . '/be-tgm-plugins.php';

if( class_exists( 'Typehub' ) ) {
    require be_themes_integrations_dir() . '/typehub/typehub.php';
}

if ( be_themes_is_woocommerce_activated() && class_exists( 'YITH_WCWL' ) ) {
    require be_themes_integrations_dir() . '/yith_wishlist/wishlist.php';
}

if ( class_exists( 'Be_Gdpr' ) ) {
    require be_themes_integrations_dir() . '/be-gdpr.php';
}

if( be_themes_is_woocommerce_activated() && class_exists( 'Tatsu' ) ) {
    require be_themes_integrations_dir() . '/tatsu.php';
}