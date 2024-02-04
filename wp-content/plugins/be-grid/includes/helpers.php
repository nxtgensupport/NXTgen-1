<?php

if( !function_exists( 'be_grid_portfolio_get_template_part' ) ){
    function be_grid_portfolio_get_template_part( $slug, $name = null, $values = array() ){

        $template = '';
        if( $name ){
            $template = locate_template(array( "/portfolio/{$slug}-{$name}.php", get_template_directory()."/portfolio/{$slug}-{$name}.php" ) );
        }
        if( !$template ){
            if( $name && file_exists( BE_GRID_PLUGIN_DIR . "template-parts/{$slug}-{$name}.php" ) ){
                $template = BE_GRID_PLUGIN_DIR . "template-parts/{$slug}-{$name}.php";
            }else if( file_exists( BE_GRID_PLUGIN_DIR . "template-parts/{$slug}.php" ) ) {
                $template = BE_GRID_PLUGIN_DIR . "template-parts/{$slug}.php";
            }
        }
        extract( $values );
        if( $template ){
            include( $template );
        }

    }
}

if ( ! function_exists( 'be_grid_change_post_type_slug' ) ) {
	function be_grid_change_post_type_slug() {
		return get_theme_mod('portfolio_slug', 'portfolio');
	}
	add_filter('be_grid_post_type_slug', 'be_grid_change_post_type_slug'); 
}
if ( ! function_exists( 'get_be_themes_portfolio_category_list' ) ) :
	function get_be_themes_portfolio_category_list( $id, $link = false ) {
		$terms = wp_get_object_terms( $id, 'portfolio_categories' );
		$category = "";
		$taxonomies = get_the_term_list( $id, 'portfolio_categories', '', ' / ', '' );
		$taxonomies = strip_tags( $taxonomies );
		$term_count = count( $terms );
		$i = 0;
		if($link) {
			foreach ( $terms as $term ) {
				$term_link = get_term_link( $term );
				if( ++$i === $term_count ) {
					$category .= '<a href="'.$term_link.'" class="cat-list">'.$term->name.'</a>';
				}
				else {
					$category .= '<a href="'.$term_link.'" class="cat-list">'.$term->name.'</a><span> &middot; </span>';
				}
			}
		} else {
			foreach ( $terms as $term ) {
				if( ++$i === $term_count ) {
					$category .= $term->slug;
				}
				else {
					$category .= $term->slug." | ";
				}
			}
		}
		return $category;
	}
endif;
if ( ! function_exists( 'be_get_share_button' ) ) :
	function be_get_share_button($url, $title, $id, $stacked = false, $stack_direction = 'left', $class_names = '' ) {
		$output = '';
		$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );
		$media =  ( $attachment ) ? $attachment[0] : '';
		if( !$stacked ) {
			$output .= '<a href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($url).'" class="custom-share-button" target="_blank"><i class="font-icon tatsu-icon-facebook"></i></a>';
			$output .= '<a href="https://twitter.com/home?status='.urlencode($url.' '.$title).'" class="custom-share-button" target="_blank"><i class="font-icon tatsu-icon-twitter"></i></a>';
			// $output .= '<a href="https://plus.google.com/share?url='.urlencode($url).'" class="custom-share-button" target="_blank"><i class="font-icon tatsu-icon-gplus"></i></a>';
			$output .= '<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url='.urlencode($url).'&amp;title='.urlencode($title).'" class="custom-share-button" target="_blank"><i class="font-icon tatsu-icon-linkedin"></i></a>';
			$output .= '<a href="https://www.pinterest.com/pin/create/button/?url='.urlencode($url).'&media='.urlencode($media).'&description='.urlencode($title).'" class="custom-share-button" target="_blank"  data-pin-do="buttonPin" data-pin-config="above"><i class="font-icon tatsu-icon-pinterest"></i></a>';
		}else {
			$output .= '<span class = "be-share-stack be-stack-' . $stack_direction . ' ' . $class_names .'" >';
			$output .= '<a href = "#" class = "be-share-trigger-placeholder"><i class = "font-icon icon-share"></i></a>';
			$output .= '<span class = "be-share-stack-mask">';
			$output .= '<a href = "#" class = "be-share-trigger"><i class = "font-icon icon-share"></i></a>';
			$output .= '<a href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($url).'" class="custom-share-button" target="_blank"><i class="font-icon icon-social_facebook"></i></a>';
			$output .= '<a href="https://twitter.com/home?status='.urlencode($url.' '.$title).'" class="custom-share-button" target="_blank"><i class="font-icon icon-social_twitter"></i></a>';
			// $output .= '<a href="https://plus.google.com/share?url='.urlencode($url).'" class="custom-share-button" target="_blank"><i class="font-icon icon-social_googleplus"></i></a>';
			$output .= '<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url='.urlencode($url).'&amp;title='.urlencode($title).'" class="custom-share-button" target="_blank"><i class="font-icon icon-social_linkedin"></i></a>';
			$output .= '<a href="https://www.pinterest.com/pin/create/button/?url='.urlencode($url).'&media='.urlencode($media).'&description='.urlencode($title).'" class="custom-share-button" target="_blank"  data-pin-do="buttonPin" data-pin-config="above"><i class="font-icon icon-social_pinterest"></i></a>';			
			$output .= '</span>';
			$output .= '</span>';
		}
		return $output;
	}
endif;

if ( ! function_exists( 'be_get_taxonomies_by_id' ) ) {
	function be_get_taxonomies_by_id($id, $filteres_to_use) {
		return $terms=wp_get_object_terms( get_the_ID(), $filteres_to_use );
	}
}

if (!function_exists('be_get_portfolio_image')) {
	function be_get_portfolio_image($id, $column, $masonry) {
		$image = array();
		$width_wide = get_post_meta( $id, 'be_themes_double_width', true );
		$height_wide = get_post_meta( $id, 'be_themes_double_height', true );
		if($column == '3' || $column == '4' || $column == '5') {
			if($masonry === '1' ) {
				$image['size'] = 'portfolio-masonry';
			} else {
				if($width_wide && $height_wide) {
					$image['size'] = '3col-portfolio-wide-width-height';
				} else if($width_wide) {
					$image['size'] = '3col-portfolio-wide-width';
				} else if($height_wide) {
					$image['size'] = '3col-portfolio-wide-height';
				} else {
					$image['size'] = 'portfolio';
				}
			}
		} elseif($column == '2') {
			if($masonry === '1' ) {
				$image['size'] = '2col-portfolio-masonry';
			} else {
				$image['size'] = '2col-portfolio';
			}
		} elseif($column == '1') { 
			$image['size'] = 'full';
		} else {
			$image['size'] = 'portfolio';
		}
		if($column != '1'){
			if($width_wide) {
				$image['class'] = 'wide';
			} else {
				$image['class'] = 'not-wide';
			}
			if($width_wide && $height_wide) {
				$image['alt_class'] = 'wide-width-height';
			} else if($width_wide) {
				$image['alt_class'] = 'wide-width';
			} else if($height_wide) {
				$image['alt_class'] = 'wide-height';
			} else {
				$image['alt_class'] = 'no-wide-width-height';
			}
		}else{
			$image['class'] = 'not-wide';
			$image['alt_class'] = 'no-wide-width-height';
		}
		return $image;
	}
}