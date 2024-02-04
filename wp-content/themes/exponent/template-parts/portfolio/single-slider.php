<?php

$images = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');

$images_id = '';
$count = 1;
foreach( $images as $image ){

    $images_id .= $image . '::,';

}

if( shortcode_exists( 'exp_image_carousel' ) ) {
    echo do_shortcode('[exp_image_carousel type= "centered_ribbon" swipe_to_slide="1" images="'.esc_attr( $images_id ).'" center_scale= "0" lazy_load= "0" slide_gutter= "20" height= "{"d":"150"}" full_screen= "0" full_screen_offset= "" slides_to_show= "5" border_radius= "0" slide_bg_color= "#e5e5e5" arrows= "0" pagination= "0" slide_show= "0" slide_show_speed= "2000" margin= "{"d":"0 0 60px 0"}" style= "client_carousel" key= "rJk1uC4o7"][/exp_image_carousel]');
}
if( get_theme_mod('portfolio_navigation_in_all_items', false) && shortcode_exists( 'be_portfolio_navigation' ) ){
    echo '<div class="be-single-portfolio-navigation-wrap" ><div class="exp-wrap" >';
    echo do_shortcode( '[be_portfolio_navigation title_align= "center" nav_links_color= "" animate= "0" animation_type= "fadeIn"][/be_portfolio_navigation]' );
    echo '</div></div>';
}