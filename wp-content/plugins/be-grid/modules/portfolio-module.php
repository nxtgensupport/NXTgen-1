<?php
/**************************************
			PORTFOLIO
**************************************/
if (!function_exists('be_grid_portfolio')) {
	function be_grid_portfolio( $atts, $content, $tag ) {
		$atts = shortcode_atts( array (
			'col' => '3',
			'gutter_style' => 'style1',
			'gutter_width' => 40,
			'show_filters' => '1',
			'filter_alignment' => 'center',
	        'tax_name' => 'portfolio_categories',
	        'filter' => 'categories',        
            'category' => '',
            'tag'   => '',
			'items_per_page' => '-1',
			'initial_load_style' => '',
			'masonry' => '0',
			'gallery' => '0',
			'prebuilt_hover_style' => 'style1',
			'overlay_color' => '',
			'title_color' => '',
			'cat_color' => '',
			'placeholder_color' => '',
			'cat_hide' => 0,
			'lazy_load' => 0,
            'delay_load' => 0,
            'two_col_mobile' => '0',
			'delay' => '200',
			'title_cats_alignment'	=> 'left',
			'enable_shadow'		=> '0',
			'more_color'	=> '',
			'more_hover_color'	=> '',
			'like_button' => 0,
			'key' =>  be_uniqid_base36(true),
		) , $atts, $tag );

		extract( $atts );
		$tax_name = ((!isset($filter)) || empty($filter)) ? 'portfolio_categories' : $filter;
		$items_per_page = ((!isset($items_per_page)) || empty($items_per_page)) ? '-1' : $items_per_page;
        $masonry_enable = ((!isset($masonry)) || empty($masonry)) ? "0" : "1";
        if( 'portfolio_categories' === $filter ) {
            $terms = explode( ',', $category );
        }else {
            $terms = explode( ',', $tag );
        }
		if( $prebuilt_hover_style === 'style5' ){
			$masonry_enable = '1';
		}
		$output = '';
		ob_start();

		be_grid_portfolio_get_template_part( 'before-loop',null, $atts );
		
		$output .= ob_get_contents();

		ob_clean();
		if( empty( $terms[0] ) ) {
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $items_per_page,
				'orderby'=> apply_filters('be_portfolio_order_by','date'),
				'order'=> apply_filters('be_portfolio_order','DESC'),
				'post_status'=> 'publish'
			);
		} else {
			$args = array (
				'post_type' => 'portfolio',
				'posts_per_page' => $items_per_page,
				'orderby'=> apply_filters('be_portfolio_order_by','date'),
				'order'=> apply_filters('be_portfolio_order','DESC'),
				'post_status'=> 'publish',
				'tax_query' => array (
					array (
						'taxonomy' => $tax_name,
						'field' => 'slug',
						'terms' => $terms,
						'operator' => 'IN',
					),
				),
			);	
        }

		$the_query = new WP_Query( $args );
		$delay = 0;
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : 
				$the_query->the_post();
				if ( has_post_thumbnail( get_the_ID() ) ) :
					$delay += 200;
					$isdwdh = false;
					$filter_classes = $permalink = '';
					$mfp_class = 'mfp-image';
					$attachment_id = get_post_thumbnail_id(get_the_ID());
					$image_atts = be_get_portfolio_image(get_the_ID(), $col, $masonry_enable);
					$attachment_thumb = wp_get_attachment_image_src( $attachment_id, $image_atts['size']);
					$attachment_full = wp_get_attachment_image_src( $attachment_id, 'full');
					if( !$attachment_thumb || empty( $attachment_thumb ) || ( '1' == $masonry_enable && ( !$attachment_full || empty( $attachment_full ) ) ) ) {
						continue;
					}

					be_grid_portfolio_get_template_part( 'portfolio-loop',null,$atts );
					$output .= ob_get_contents();
					ob_clean();

				endif;	
			endwhile;
		endif;
		wp_reset_postdata();

		be_grid_portfolio_get_template_part( 'after-loop',null,$atts );
		$output .= ob_get_contents();
		ob_clean();

		return $output;
	}
}
?>