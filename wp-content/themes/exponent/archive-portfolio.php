<?php
/**
* The template for displaying Category Archive pages.
* 
*/
?>
<?php 
get_header();
$posts_with_entry_headers = get_theme_mod( 'posts_with_entry_header',array() );

if( in_array( 'portfolio_archive' ,$posts_with_entry_headers ) ){
    echo get_template_part( 'template-parts/partials/entry', 'header' ); 
}

$col = get_theme_mod('portfolio_column_count','3');
$gutter_style = get_theme_mod('portfolio_gutter_style','style1');
$gutter_width = get_theme_mod('portfolio_gutter_width','40');
$masonry = get_theme_mod('portfolio_masonry','0');
$lazy_load = get_theme_mod('portfolio_lazy_load','0');
$delay_load = get_theme_mod('portfolio_delay_load','1');
$placeholder_color = get_theme_mod('portfolio_grid_placeholder_color','#f1f1f1');
$item_count = get_theme_mod('portfolio_item_count','-1');
$load_animation = get_theme_mod('portfolio_load_animation','fadeIn');
$hover_style = get_theme_mod('portfolio_hover_style','style1');
$thumb_overlay_color = get_theme_mod('portfolio_thumb_overlay_color',array('id' => 'palette:0'));
$title_color = get_theme_mod('portfolio_title_color','#ffffff');
$cat_color = get_theme_mod('portfolio_cat_color','#ffffff');
$hide_cat = get_theme_mod('portfolio_hide_cat','0');

if( shortcode_exists( 'be_portfolio' ) ) {
    echo do_shortcode('[be_portfolio col='.esc_attr( $col ).' gutter_style='.esc_attr( $gutter_style ).' gutter_width ='.esc_attr( $gutter_width ).' show_filters= "0" lazy_load='.esc_attr( $lazy_load ).' delay_load='.esc_attr( $delay_load ).' placeholder_color='.esc_attr( $placeholder_color ).' initial_load_style='.esc_attr( $load_animation ).' prebuilt_hover_style='.esc_attr( $hover_style ).' title_color='.esc_attr( $title_color ).' cat_color='.esc_attr( $cat_color ).'  items_per_page='.esc_attr( $item_count ).' overlay_color='.esc_attr( $thumb_overlay_color ).' cat_hide='.esc_attr( $hide_cat ).'  ]');
}
get_footer();