<?php
/********************************************
			REGISTER WIDGET AREA
*********************************************/


add_action( 'widgets_init', 'be_themes_widgets_init' );
function be_themes_widgets_init() {
	register_sidebar(
		array(
           'name' => esc_html__( 'Default Sidebar', 'exponent' ),
           'id'   => 'default-sidebar',
           'description'   => esc_html__( 'Widget area of Sidebar template pages', 'exponent' ),
           'before_widget' => '<div class="%2$s widget">', 
           'after_widget'  => '</div>',
           'before_title'  => '<h6>',
           'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
           'name' => esc_html__( 'Footer Column 1', 'exponent' ),
           'id'   => 'footer-widget-1',
           'description'   => esc_html__( 'Footer widget area', 'exponent' ),
           'before_widget' => '<div class="%2$s widget">', 
           'after_widget'  => '</div>',
           'before_title'  => '<h6>',
           'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
           'name' => esc_html__( 'Footer Column 2', 'exponent' ),
           'id'   => 'footer-widget-2',
           'description'   => esc_html__( 'Footer widget area', 'exponent' ),
           'before_widget' => '<div class="%2$s widget">', 
           'after_widget'  => '</div>',
           'before_title'  => '<h6>',
           'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
           'name' => esc_html__( 'Footer Column 3', 'exponent' ),
           'id'   => 'footer-widget-3',
           'description'   => esc_html__( 'Footer widget area', 'exponent' ),
           'before_widget' => '<div class="%2$s widget">', 
           'after_widget'  => '</div>',
           'before_title'  => '<h6>',
           'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
           'name' => esc_html__( 'Footer Column 4', 'exponent' ),
           'id'   => 'footer-widget-4',
           'description'   => esc_html__( 'Footer widget area', 'exponent' ),
           'before_widget' => '<div class="%2$s widget">', 
           'after_widget'  => '</div>',
           'before_title'  => '<h6>',
           'after_title'   => '</h6>',
		)
	);

	$custom_sidebars = be_themes_get_option( 'custom_sidebar' );
	if( is_array( $custom_sidebars ) && sizeof( $custom_sidebars ) > 0 ) {
		foreach( $custom_sidebars as $sidebar ) {
			if( !empty( $sidebar )) {
				register_sidebar( 
					array(
					'name' => $sidebar['sidebar'],
					'id' => be_generate_slug( $sidebar['sidebar'], 45 ),
		            'description'   => '',
		            'before_widget' => '<div class="%2$s widget">', 
		            'after_widget'  => '</div>',
		            'before_title'  => '<h6>',
		            'after_title'   => '</h6>',
					) 
				);
			}
		}
	}
}

?>