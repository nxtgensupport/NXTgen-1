<?php

add_action( 'tatsu_register_modules', 'exp_reregister_tatsu_modules', 12 );
function exp_reregister_tatsu_modules() {
	$tatsu_modules = Tatsu_Module_Options::getInstance()->get_modules();

	//Testomonial Carousel
	tatsu_remap_modules( array( 'tatsu_testimonials_carousel', 'testimonials', 'exp_testimonials' ), $tatsu_modules['tatsu_testimonials_carousel'], 'tatsu_testimonials_carousel' );
	tatsu_remap_modules( array( 'tatsu_testimonial_carousel', 'testimonial', 'exp_testimonial' ), $tatsu_modules['tatsu_testimonial_carousel'], 'tatsu_testimonial_carousel' );

	//Process
	tatsu_remap_modules( array( 'tatsu_process', 'process_style1', 'exp_process' ), $tatsu_modules['tatsu_process'], 'tatsu_process' );
	tatsu_remap_modules( array( 'tatsu_process_col', 'process_col', 'exp_process_col' ), $tatsu_modules['tatsu_process_col'], 'tatsu_process_col' );

	//Tabs
	tatsu_remap_modules( array( 'tatsu_tabs', 'tabs', 'exp_tabs' ), $tatsu_modules['tatsu_tabs'], 'tatsu_tabs' );
	tatsu_remap_modules( array( 'tatsu_tab', 'tab', 'exp_tab' ), $tatsu_modules['tatsu_tab'], 'tatsu_tab' );

	//Accordion
	tatsu_remap_modules( array( 'tatsu_accordion', 'accordion', 'exp_accordion' ), $tatsu_modules['tatsu_accordion'], 'tatsu_accordion' );
	tatsu_remap_modules( array( 'tatsu_toggle', 'toggle', 'exp_toggle' ), $tatsu_modules['tatsu_toggle'], 'tatsu_toggle' );

	//Team
	tatsu_remap_modules( array( 'tatsu_team', 'team', 'exp_team' ), $tatsu_modules['tatsu_team'], 'tatsu_team' );

	//Skills
	tatsu_remap_modules( array( 'tatsu_skills', 'skills' ), $tatsu_modules['tatsu_skills'], 'tatsu_skills' );
	tatsu_remap_modules( array( 'tatsu_skill', 'skill' ), $tatsu_modules['tatsu_skill'], 'tatsu_skill' );

	//Animated Link
	tatsu_remap_modules( array( 'tatsu_animated_link', 'oshine_animated_link', 'exp_animated_link' ), $tatsu_modules['tatsu_animated_link'], 'tatsu_animated_link' );

	//Gallery
	tatsu_remap_modules( array( 'tatsu_gallery', 'gallery', 'oshine_gallery' ), $tatsu_modules['tatsu_gallery'], 'tatsu_gallery' );

	//Special Heading 6
	tatsu_remap_modules( array( 'tatsu_special_heading', 'be_special_heading6', 'exp_special_heading6' ), $tatsu_modules['tatsu_special_heading'], 'tatsu_special_heading' );

	//interactive box
	tatsu_remap_modules( array( 'tatsu_interactive_box', 'exp_interactive_box' ), $tatsu_modules['tatsu_interactive_box'], 'tatsu_interactive_box' );

	//image carousel
	tatsu_remap_modules( array( 'tatsu_image_carousel', 'exp_image_carousel' ), $tatsu_modules['tatsu_image_carousel'], 'tatsu_img_slider' );

	//icon card
	tatsu_remap_modules( array( 'tatsu_icon_card', 'exp_icon_card' ), $tatsu_modules['tatsu_icon_card'], 'tatsu_icon_card' );

	//Svg Icon
	tatsu_remap_modules( array( 'tatsu_svg_icon', 'exp_svg_icon' ), $tatsu_modules['tatsu_svg_icon'], 'tatsu_svg_icon' );

	//star rating
	tatsu_remap_modules( array( 'tatsu_star_rating', 'exp_star_rating' ), $tatsu_modules['tatsu_star_rating'], 'tatsu_star_rating' );

}
?>