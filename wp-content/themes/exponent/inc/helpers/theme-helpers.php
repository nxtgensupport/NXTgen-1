<?php

if( !function_exists( 'be_themes_option_default' ) ) {
    function be_themes_option_default( $option ) {
		extract( be_get_color_hub() );
        $defaults = array (
			'wc_archive_style'              => 'style1',
			'blog_archive_auto_height_thumb'=> '0',
            'wc_loop_sidebar'               => '0',
			'wc_loop_sidebar_position'      => 'right',
			'wc_loop_sidebar_name'			=> '',
			'wc_loop_pagination_alignment'	=> 'left',
			'blog_loop_sidebar_name'		=> '',
            'wc_archive_full_width'         => '0',
			'woocommerce_catalog_4_cols_alt'=> '2',
			'woocommerce_catalog_4_cols'    => '3',
            'woocommerce_catalog_3_cols'    => '3',
            'woocommerce_catalog_6_cols'    => '3',
            'wc_loop_mobile_two_cols' => '0',
            'wc_grid_gutter'                => 'medium',
            'wc_enable_archive_category'    => '1',
			'wc_enable_archive_rating'      => '1',
			'wc_single_product_gallery_zoom'=> '0',
			'wc_enable_archive_price'       => '1',
			'wc_enable_breadcrumb'			=> '1',
			'wc_enable_archive_title'		=> '1',
			'wc_enable_orderby_filter'		=> '1',
            'wc_alt_image_on_hover'         => '1',
            'wc_enable_quick_view'          => '1',
            'wc_enable_add_to_cart'         => '1',
            'wc_enable_add_to_wishlist'     => '1',
            'wc_add_to_cart_style'          => 'icon',
			'wc_archive_show_cart_on_hover' => '0',
			'wc_single_product_breadcrumbs'	=> '1',
			'wc_single_product_meta'		=> '1',
			'woocommerce_related_products_count' => 4,
            'form_style'                    => 'rounded',
            'button_style'                  => 'rounded',
            'blog_archive_style'            => 'style1',
            'blog_loop_sidebar'             => '1',
            'blog_loop_sidebar_position'    => 'right',
            'blog_loop_sidebar_sticky'      => '0',
            'blog_primary_meta'             => array( 'categories' ),
            'blog_secondary_meta'           => array ( 'author', 'date' ),
            'blog_tertiary_meta'            => array (),
            'blog_meta_date_icon'           => '0',
            'blog_meta_author_image'        => '0',
            'blog_read_more_style'          => 'underlined',
            'blog_hide_content'             => '0',
			'blog_archive_alignment'        => 'left',
			'blog_archive_pagination_alignment' => 'left',
            'blog_loop_normal_3_cols'       => 3,
            'blog_loop_normal_4_cols'       => 3,
            'blog_loop_normal_4_cols_alt'   => 3,
            'blog_loop_normal_5_cols'       => 3,
            'blog_loop_metro_4_cols'        => 3,
            'blog_loop_metro_3_cols'        => 3,
            'blog_loop_metro_3_cols_alt'    => 3,
            'blog_loop_primary_meta'        => array( 'categories' ),
            'blog_loop_secondary_meta'      => array ( 'author', 'date' ),
            'blog_loop_tertiary_meta'       => array (),
            'blog_loop_meta_date_icon'      => '1',
            'blog_loop_meta_author_image'   => '0',
            'blog_loop_labeled_cat'         => '0',
            'blog_grid_full_width'          => '0',
            'blog_gutter'                   => 'medium',
            'blog_archive_thumb_shadow'     => 'none',
            'blog_archive_shadow'           => 'none',
            'blog_archive_border_radius'    => 5,
            'blog_post_details_custom_pad'  => '0',
            'blog_post_detials_pad'         => '40px 40px',
            'blog_post_details_color'       => '',
			'blog_aspect_ratio'             => 1.25,
			'page_loader'					=> 'none',
            'lazy_load'                     => '0',
            'metas_on_thumb'                => '1',
            'thumb_height'                  => '500',
			'single_nav'                    => '0',
			'blog_single_auto_height_thumb' => '0',
			'blog_single_title'				=> '1',
            'single_nav_sticky'             => '0',
            'single_posts_share'            => '1',
            'single_title_style'            => 'wrap',
			'single_title_alignment'        => 'center',
			'blog_single_blur_thumb'		=> '1',
            'blog_single_sidebar'           => '0',
            'blog_single_sidebar_position'  => 'right',
            'blog_single_sidebar_sticky'    => '0',
            'blog_single_primary_meta'      => array( 'categories' ),
            'blog_single_secondary_meta'    => array ( 'author', 'date' ),
            'blog_single_tertiary_meta'     => array (),
            'blog_single_meta_date_icon'    => '1',
            'blog_single_meta_author_image' => '1',
            'blog_single_labeled_cat'       => '0',
            'featured_posts'                => '0',
			'featured_posts_grid_cols'      => 3,
			'featured_posts_grid_with_margin'=> '1',
			'featured_posts_type'           => 'slider',
			'featured_posts_slide_width'	=> '90',
			'featured_posts_gutter'         => '30',
			'featured_posts_shadow'			=> 'none',
            'featured_posts_height'         => '500',
            'blog_featured_primary_meta'      => array( 'categories' ),
            'blog_featured_secondary_meta'    => array ( 'author', 'date' ),
            'blog_featured_tertiary_meta'     => array (),
            'blog_featured_meta_date_icon'    => '0',
            'blog_featured_meta_author_image' => '0',
            'blog_featured_labeled_cat'       => '0',
			'related_posts'                 => '0',
			'related_posts_aspect_ratio'	=> 1.25,
			'related_posts_alignment'		=> 'left',
            'related_posts_full_width'      => '0',
            'related_posts_cols'            => '3',
			'related_posts_gutter'          => '10',
			'related_thumb_shadow'			=> 'none',
			'related_posts_shadow'			=> 'none',
            'blog_related_primary_meta'     => array( 'categories' ),
            'blog_related_secondary_meta'   => array( 'author', 'date' ),
            'blog_related_tertiary_meta'    => array (),
            'blog_related_meta_date_icon'   => '0',
            'blog_related_meta_author_image'=> '0',
            'blog_related_labeled_cat'      => '0',
            'author_custom_header'          => '0',
            'author_hero_height'            => '60',
            'author_hero_background'        => array(
													'background-color' => $color_scheme,
												),
            'author_hero_overlay'           => '0',
            'author_hero_overlay_color'     => 'rgba(0,0,0,0.5)',
            'posts_with_entry_header'       => array('page', 'post'),
			'entry_header_bg'               => array (
													'background-color'     => '#F5F6FA',
												),
			'entry_header_pad'				=> '80',
            'entry_header_color'            => '#313233',
			'entry_header_nav_color'        => '1',
			'posts_with_nav'				=> array( 'post', 'portfolio' ),
			'posts_nav_pad'					=> '20',
            'portfolio_aspect_ratio'        => '1.6',
            'gallery_aspect_ratio'          => '1.6',
            'minify_assets'                 => '0',
            'back_to_top_btn'               => '1',
            'site_status'                   => '0',
            'cdn_address'                   => '',
            'header_bg'                     => '',
            'footer_widget_bg'              => '',
            'content_bg'                    => '',
            'footer_bg'                     => '',
            'body_bg'                       => array(
													'background-color' => '#ffffff',
												),
            'custom_sidebar'                => array(),
            'comments_on_page'              => '1',
            'enable_header'                 => '1',
			'enable_footer'                 => '1',
			'footer_content'				=> 'Copyright 2019 Brand Exponents. All Rights Reserved',
            'enable_footer_widgets'         => '1',
        );
        if( !empty( $defaults[ $option ] ) ) {
            return $defaults[ $option ];
        }
        return false;
    }
}

/**
 * Check if WooCommerce is activated
 * @source - https://docs.woocommerce.com/document/query-whether-woocommerce-is-activated/
 */
if ( ! function_exists( 'be_themes_is_woocommerce_activated' ) ) {
	function be_themes_is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}

/* ---------------------------------------------  */
// Function to trim content to the required characters
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_trim_content' ) ) {
	function be_themes_trim_content( $content, $count ) {
		if(strlen( $content ) > $count ) {
			return substr( $content, 0, $count ) . ' ...';
		} else {
			return substr( $content, 0, $count );
		}
	}
}

/* ---------------------------------------------  */
// Function to restrict excerpt length
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_custom_excerpt_length' ) ) {
	function be_themes_custom_excerpt_length( $length ) {
		return 30;
	}
	add_filter( 'excerpt_length', 'be_themes_custom_excerpt_length', 999 );
}

/* ---------------------------------------------  */
// Filter to handle empty search query
/* ---------------------------------------------  */
// if ( ! function_exists( 'be_themes_request_filter' ) ) {
// 	function be_themes_request_filter( $query_vars ) {
// 	    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
// 	        $query_vars['s'] = " ";
// 	    }
// 	    return $query_vars;
// 	}
// 	add_filter( 'request', 'be_themes_request_filter' );
// }

/* ---------------------------------------------  */
// Filter to remove empty widget title <h> tags
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_empty_widget_title' ) ) {
	function be_themes_empty_widget_title($title) {
	    return $title == '&nbsp;' ? '' : $title;
	}
	add_filter( 'widget_title', 'be_themes_empty_widget_title' ); 
}

/* ---------------------------------------------  */
// Filter to execute shortcodes in widgets
/* ---------------------------------------------  */
add_filter( 'widget_text', 'do_shortcode' );

/* ---------------------------------------------  */
// Add Video URL field to media uploader
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_attachment_field_add' ) ) {
	function be_themes_attachment_field_add( $form_fields, $post ) {
		$form_fields['be-themes-featured-video-url'] = array(
			'label' => 'Youtube/Vimeo/Self-Hosted MP4 Video URL',
			'input' => 'text',
			'value' => get_post_meta( $post->ID, 'be_themes_featured_video_url', true ),
			'helps' => 'Enter a Youtube/Vimeo/Self-Hosted MP4 Video URL to be linked to the featured image',
		);
		return $form_fields;
	}
	add_filter( 'attachment_fields_to_edit', 'be_themes_attachment_field_add', 10, 2 );
}

/* ---------------------------------------------  */
// Add Video URL field to media uploader
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_attachment_field_save' ) ) {
	function be_themes_attachment_field_save( $post, $attachment ) {
		if( isset( $attachment['be-themes-featured-video-url'] ) ) {
			update_post_meta( $post['ID'], 'be_themes_featured_video_url', $attachment['be-themes-featured-video-url'] );
		}
		return $post;
	}
	add_filter( 'attachment_fields_to_save', 'be_themes_attachment_field_save', 10, 2 );
}

/* ---------------------------------------------  */
// Breadcrumbs
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_get_breadcrumbs' ) ) {
	function be_themes_get_breadcrumbs() {
		$post = get_post();
	    $sep = ' &#47; ';
		$output = '';
	    if ( ! is_front_page() ) {
			if( be_themes_is_woocommerce_activated() && ( is_woocommerce() || is_cart() || is_checkout() ) ) {
				$shop_breadcrumbs = be_themes_get_option( 'wc_enable_breadcrumb' );
				if( !empty($shop_breadcrumbs) ) {
					ob_start();
					woocommerce_breadcrumb();
					$output = ob_get_clean();
				}
			}else {
				$output .= '<div class="' . be_themes_get_class( 'breadcrumbs' ) . '">';
				$output .= '<a href="';
				$output .= esc_url( home_url() );
				$output .= '">';
				$output .= apply_filters( 'be_breadcrumb_home_title', esc_html__( 'Home', 'exponent' ) );
				$output .= '</a>';
				if( is_singular( 'post' ) ) {
					$post_breadcrumb_tax = apply_filters( 'be_themes_post_single_breadcrumbs_tax', 'category' );
					$terms = 'category' === $post_breadcrumb_tax ? get_the_category() : get_the_tags();
					if( !empty( $terms ) ) {
						$chosen_term = $terms[ 0 ];
						$term_parents = '';
						if( 'category' === $post_breadcrumb_tax && !empty( $chosen_term->parent ) ) {
							$term_parents = be_themes_get_terms_parent( $chosen_term->term_id );
						}
						$term_link = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $chosen_term->term_id ) ), esc_html( $chosen_term->name ) );	
						$output .= $sep . $term_parents . $term_link;
						$output .= $sep . 'Here';
					}
				} else if( is_archive() && 'post' === get_post_type() ) {
					if ( is_category() ) {
						$cur_cat = get_queried_object();
						$cat_parents = '';
						if( !empty( $cur_cat->parent ) ) {
							$cat_parents = be_themes_get_terms_parent( $cur_cat->term_id );
						}
						$cat_title = $sep . $cat_parents . single_cat_title( '', false );
						$output .= $cat_title;
					} else if( is_tag() ) {
						$cur_tag = get_queried_object();
						if( !empty( $cur_tag ) ) {
							$output .= $sep . $cur_tag->name;
						}
					}else if( is_day() ) {
						$output .= $sep . get_the_date();
					}else if( is_month() ) {
						$output .= $sep . get_the_date( _x( 'F Y', 'monthly archives date format', 'exponent' ) );
					}else if( is_year() ) {
						$output .= $sep . get_the_date( _x( 'Y', 'yearly archives date format', 'exponent' ) ); 
					}else {
						$output .= $sep . esc_html__( 'Blog Archive', 'exponent' );
					}
				} elseif ( ( is_archive() || is_single() ) && (is_tax( 'portfolio_categories' ) || is_tax( 'portfolio_tags' ))) {
					global $wp_query;
					$term =	$wp_query->queried_object;
					if ( is_day() ) {
						$output .= get_the_date();
					} elseif(is_tax( 'portfolio_categories' )) {
							$chosen_term = $term;
							$term_parents = '';
							if( !empty( $chosen_term->parent ) ) {
								$cat_parent = get_term( $chosen_term->parent );
								$term_parents = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $cat_parent->term_id ) ), esc_html( $cat_parent->name ) );
	
								$term_parents .= $sep;
							}
							$term_link = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $chosen_term->term_id ) ), esc_html( $chosen_term->name ) );	
							$output .= $sep . $term_parents . $term_link;
							$output .= $sep . 'Here';

					} elseif(is_tax( 'portfolio_tags' )) {
						$output .= $sep.'<a href="'.esc_url( get_term_link( $term->term_id, 'portfolio_tags' ) ).'" >'.esc_html( $term->name ).'</a>';
					} else {
						$output .= esc_html__('Portfolio Archives','exponent');
					}
				}
				if( is_singular('portfolio') ) {
					$cat =  get_the_terms( $post->ID, 'portfolio_categories' ) ;

					if( !empty( $cat ) ) {
						$chosen_term = $cat[ 0 ];
						$term_parents = '';
						if( !empty( $chosen_term->parent ) ) {
							$cat_parent = get_term( $chosen_term->parent );
							$term_parents = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $cat_parent->term_id ) ), esc_html( $cat_parent->name ) );

							$term_parents .= $sep;
						}
						$term_link = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $chosen_term->term_id ) ), esc_html( $chosen_term->name ) );	
						$output .= $sep . $term_parents . $term_link;
						$output .= $sep . 'Here';
					}
				}
				if ( is_home() ) {
					$page_for_posts_id = get_option( 'page_for_posts' );
					if ( !empty( $page_for_posts_id ) ) { 
						$post = get_post( $page_for_posts_id );
						$output .= $sep . apply_filters( 'be_breadcrumb_home_title',  $post->post_title );
					}
				}
				if ( is_page() ) {
					$parents = get_ancestors( get_the_ID(),'page' );
					if( !empty( $parents ) && is_array( $parents ) ){
						$parents = array_reverse( $parents );
						foreach ( $parents as $parent ) {
							$output .= $sep. '<a href="'.esc_url( get_permalink($parent) ).'">'.get_the_title( $parent ).'</a>';
						}
					}
					$output .= $sep. '<a href="'.esc_url( get_permalink( get_the_ID() ) ).'">'.get_the_title().'</a>';
				}
				$output .= '</div>';
			}
	    }
		return $output;
	}
}

/**
 * Menu args
 */
if (!function_exists('be_themes_toggle_post_formats')) {
	function be_themes_page_menu_args( $args ) {
		if ( ! isset( $args['show_home'] ) ) {
			$args['show_home'] = true;
			$args['menu_class'] = 'menu';
		}
		return $args;
	}
	add_filter( 'wp_page_menu_args', 'be_themes_page_menu_args' );
}

/**
 * Single Page Loader
 */
if( !function_exists( 'be_themes_page_loader' ) ) {
	function be_themes_page_loader() {
		$page_loader = be_themes_get_option( 'page_loader' );
		if( !empty( $page_loader ) && 'none' !== $page_loader ) :
			?>
				<div id="be-themes-loader-container">
					<div id="be-themes-page-loader">
						<?php if($page_loader === 'spin' ) : ?> 
							<div class= "style-spin" ></div>
						<?php endif; ?>
						<?php if( $page_loader === 'ring' ) : ?> 
							<div class="style-ring" ><div></div><div></div><div></div><div></div></div>
						<?php endif; ?>
						<?php if( $page_loader === 'ellipsis' ) : ?> 
							<div class="style-ellipsis" ><div></div><div></div><div></div><div></div></div>
						<?php endif; ?>
						<?php if( $page_loader === 'ripple' ) : ?> 
							<div class="style-ripple"><div></div><div></div></div>
						<?php endif; ?>
					</div>
				</div>
			<?php
		endif;
	}
	add_action( 'be_themes_before_body', 'be_themes_page_loader' );
}

/**
 * Add style tag to the list of allowed tags 
 */
if( !function_exists( 'be_themes_add_tags_to_wp_kses' ) ) {
	function be_themes_add_tags_to_wp_kses( $tags ) {
		$tags['style'] = array(
			'class' => true,
			'id' => true
		);
		if( !empty( $tags['img'] ) && is_array( $tags['img'] ) ) {
			$tags[ 'img' ]['data-src'] = true;
		}
		return $tags;
	}
	add_filter('wp_kses_allowed_html', 'be_themes_add_tags_to_wp_kses');
}

/**
 * Get page id
 */
if (!function_exists( 'be_themes_get_page_id' )) {
	function be_themes_get_page_id() {
		global $post;
		if( !is_object($post) ) {
	        return;
	    }			
		if( be_themes_is_woocommerce_activated() && function_exists('is_shop') && is_shop() ) {
			$post_id = get_option('woocommerce_shop_page_id');
		} else if(is_home()) {
			$post_id = get_option( 'page_for_posts' );
		} else if(is_search() || is_tag() || is_archive() || is_category()) {
			$post_id = 0;
		} else {
			$post_id = get_the_ID();
		} 
		return $post_id;
	}
}

/**
 * Remove [...] at the end of excerpts
 */
if (!function_exists( 'be_themes_excerpt_more' )) {
	function be_themes_excerpt_more( $more ) {
		return '';
	}
	add_filter( 'excerpt_more', 'be_themes_excerpt_more' );
}

/**
 *	Simple Wrapper around get_theme_mod.
 */
if( !function_exists( 'be_themes_get_option' ) ) {
	function be_themes_get_option( $option = '' ) {
		if( function_exists( 'be_themes_option_default' ) ) {
			return get_theme_mod( $option, be_themes_option_default($option) );
		}else {
			return get_theme_mod( $option );
		}
	}
}

/**
 * Wrapper to get option values which could be overriden with metas.
 */
if( !function_exists( 'be_themes_get_option_with_override' ) ) {
	function be_themes_get_option_with_override( $option = '', $override = '', $post_id = '' ) {
		$post_id = empty( $post_id ) ? get_the_ID() : $post_id; 
		if( empty( $post_id ) ) {
			return false;
		}
		$override = get_post_meta( $post_id, be_themes_get_meta_prefix() . $override, true );
		if( !empty( $override ) ) {
			return get_post_meta( $post_id, be_themes_get_meta_prefix() . $option, true );
		}else {
			return be_themes_get_option( $option );
		}
	}
}

/**
 *  Get current theme information.
 */
if( !function_exists( 'be_themes_get_theme_info' ) ) {
	function be_themes_get_theme_info( $data = array( 'name', 'version' ) ) {
		if( empty( $data ) ) {
			return false;
		}else {
			$theme_data = wp_get_theme();
			//if child theme, fetch parent
			if( false !== ( $theme_data->parent() ) ) {
				$theme_data = $theme_data->parent();
			}
			if( !empty( $theme_data ) && is_object( $theme_data ) ) {
				if( is_string( $data ) ) {
					$data = ucfirst( $data );
					return $theme_data->get( $data );
				}else if( is_array( $data ) ) {
					$return = array();
					foreach( $data as $prop ) {
						$uc_prop = ucfirst( $prop );
						$prop_value = $theme_data->get( $uc_prop );
						if( !empty( $prop_value ) ) {
							$return[ $prop ] = $prop_value;
						}
					}
					return !empty( $return ) ? $return : false;
				}
				return false;
			}
		}
	}
}

/**
 * Check if in SCRIPT DEBUG mode
 */
if( !function_exists( 'be_themes_should_minify_assets' ) ) {
	function be_themes_should_minify_assets() {
		$minified_assets = be_themes_get_option( 'minify_assets' );
		return !( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) && !empty( $minified_assets );
	}
}

/**
 * 	Get theme specific class names
 */
if( !function_exists( 'be_themes_get_class' ) ) {
    function be_themes_get_class_callback( $class ) {
        global $be_class_prefix;
        return $be_class_prefix . '-' .$class;
    }
    function be_themes_get_class() {
        global $be_class_prefix;
        $be_class_prefix = '';
        $prefixed_class = '';

        if( function_exists( 'be_themes_get_theme_info' ) ) {
            $cur_theme_name = be_themes_get_theme_info( 'name' );
            $be_class_prefix = substr( $cur_theme_name, 0, 3 );
        }else {
            $theme_data = wp_get_theme();
            if( !empty( $theme_data ) && is_object( $theme_data ) ) {
                $cur_theme_name = $theme_data->get( 'Name' );
                $be_class_prefix = substr( $cur_theme_name, 0, 3 );
            }
        }
        $be_class_prefix = strtolower( $be_class_prefix );
        $args = func_get_args();
        $prefixed_args = array_map( 'be_themes_get_class_callback', array_filter( $args ) );
        $prefixed_class = implode( ' ', $prefixed_args );
        return esc_attr( $prefixed_class );
    }
}

/**
 * Simple Css loader
 */
if( !function_exists( 'be_themes_get_loader' ) ) {
    function be_themes_get_loader() {
        $loader_html = sprintf( '<div class="%s"><div class="%s"></div></div>', be_themes_get_class( 'loader-wrap' ), be_themes_get_class( 'loader' ) );
        return apply_filters( 'be_themes_loader_html', $loader_html );
    } 
}

/**
 * Get terms of post types
 */
if( !function_exists( 'be_themes_get_terms' ) ) {
	function be_themes_get_terms( $id = null, $tax = 'category', $class = '', $anchor_class = '', $sep = ',', $color = false, $bg_color = false ) {
		if( !empty( $id ) ) {
			$terms = get_the_terms( $id, $tax );
			if( !empty( $terms ) ) {
				$terms_html = '';
				$term_style = '';
				$meta_prefix = be_themes_get_meta_prefix();
				$term_class = be_themes_get_class( 'term-link' );
				$last_term = end( $terms );
				$wrapper_class = be_themes_get_class( 'tax-list' );
				if( !empty( $class ) ) {
					$wrapper_class .= ' ' . $class;
				}
				if( true === $color || true === $bg_color ) {
					extract( be_get_color_hub() );
				}
				$terms_html = '<div class="' . $wrapper_class . '">';
				foreach( $terms as $term ) {
					$term_color = '';
					$data_term_color = '';
					$term_bg_color = '';
					$data_term_bg_color = '';
					if( true === $color ) {
						if( metadata_exists( 'term', $term->term_id, "{$meta_prefix}cat_color" ) ) {
							$term_color = get_term_meta( $term->term_id, "{$meta_prefix}cat_color", true );
							if( !empty( $term_color ) ) {
								if( be_themes_check_valid_colorhex( $term_color ) ) {
									$data_term_color = sprintf( 'data-color = "#%s"', $term_color );
									$term_color = "color : #{$term_color};";
								}else {
									$data_term_color = sprintf( 'data-color = "%s"', $term_color );
									$term_color = "color : {$term_color};";
								}
							}
						}else {
							$data_term_color = sprintf( 'data-color = "%s"', $alt_bg_text_color );
							$term_color = "color : $alt_bg_text_color;";
						}
					}
					if( true === $bg_color ) {
						if( metadata_exists( 'term', $term->term_id, "{$meta_prefix}cat_bg_color" ) ) {
							$term_bg_color = get_term_meta( $term->term_id, "{$meta_prefix}cat_bg_color", true );
							if( !empty( $term_bg_color ) ) {
								if( be_themes_check_valid_colorhex( $term_bg_color ) ) {
									$data_term_bg_color = sprintf( 'data-bg-color = "#%s"', $term_bg_color );
									$term_bg_color = "background : #{$term_bg_color};";
								}else {
									$data_term_bg_color = sprintf( 'data-bg-color = "%s"', $term_bg_color );
									$term_bg_color = "background : {$term_bg_color};";
								}
							}
						}else {
							$data_term_bg_color = sprintf( 'data-bg-color = "%s"', $color_scheme );
							$term_bg_color = "background : $color_scheme;";
						}
					}
					if( !empty( $term_bg_color ) || !empty( $term_color ) ) {
						$term_style = 'style = "' . $term_color . $term_bg_color . '"';
					}
					$terms_html .= '<a href ="' . get_term_link( $term ) . '" class="' . ( !empty( $anchor_class ) ? ( $anchor_class . ' ' ) : '' ) . be_themes_get_class( 'term', !empty( $term_color ) ? 'term-with-custom-color' : '' ) . '" ' . $term_style . ' ' . $data_term_bg_color . ' ' . $data_term_color . '>' . $term->name .'</a>';
					if( !empty( $sep ) && $last_term->term_id !== $term->term_id ) {
						$terms_html .= $sep;
					}
				}
				$terms_html .= '</div>';
				return $terms_html;
			}
		}
		return false;
	}
}

/** 
 * Get Be Theme Meta Prefix
 */
if( !function_exists( 'be_themes_get_meta_prefix' ) ) {
    function be_themes_get_meta_prefix() {
        $theme_name = be_themes_get_theme_info( 'name' );
        $meta_prefix = $theme_name . '_';
        return $meta_prefix;
    }
}

/**
 * Get Related Posts for any post type
 */
if( !function_exists( 'be_themes_get_related_posts' ) ) {
    function be_themes_get_related_posts( $post_id, $related_count = 6 ) {
        if( !empty( $post_id ) ) {
            $related_args = array(
                'post_type'      => get_post_type( $post_id ),
                'posts_per_page' => $related_count,
                'post_status'    => 'publish',
                'post__not_in'   => array( $post_id ),
                'tax_query'      => array()
            );
            $post       = get_post( $post_id );
            $taxonomies = get_object_taxonomies( $post, 'names' );
            foreach ( $taxonomies as $taxonomy ) {
                $terms = get_the_terms( $post_id, $taxonomy );
                if ( empty( $terms ) ) {
                    continue;
                }
                $term_list = wp_list_pluck( $terms, 'slug' );
                $related_args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $term_list
                        );
                }
            if ( count( $related_args['tax_query'] ) > 1 ) {
                $related_args['tax_query']['relation'] = 'OR';
            }
            return $related_args;
        }
        return false;
    }
}

/**
 * Author Share
 */
if( !function_exists( 'be_themes_get_author_share' ) ) {
	function be_themes_get_author_share( $args = array() ) {
		$facebook_link = get_the_author_meta( 'facebook' );
		$twitter_link = get_the_author_meta( 'twitter' );
		$linkedin_link = get_the_author_meta( 'linkedin' );
		$pinterest_link = get_the_author_meta( 'pinterest' );
		// $googleplus_link = get_the_author_meta( 'googleplus' );
		$author_share = array (
			'facebook'		=> array (
				'link' 		=> $facebook_link,
				'icon'		=> 'exponent-icon-facebook',
			),
			'twitter'		=> array (
				'link' 		=> $twitter_link,
				'icon'		=> 'exponent-icon-twitter'
			),
			// 'googleplus'	=> array (
			// 	'link' 		=> $googleplus_link,
			// 	'icon'		=> 'exponent-icon-gplus',
			// ),
			'linkedin'		=> array (
				'link' 		=> $linkedin_link,
				'icon'		=> 'exponent-icon-linkedin'
			),
			'pinterest'		=> array (
				'link'		=> $pinterest_link,
				'icon'		=> 'exponent-icon-pinterest'
			)		
		);
		$defaults = array (
			'parent_class'	=> be_themes_get_class( 'reset-line-height' ),
			'icon_class'	=> ''
		);
		$args = apply_filters( 'be_themes_author_share_args', wp_parse_args( $args, $defaults ) );
		if( !empty( $facebook_link ) || !empty( $twitter_link ) || !empty( $linkedin_link ) || !empty( $pinterest_link ) || !empty( $googleplus_link ) ) {
			extract( $args );
			ob_start();
		?>
			<div class="<?php echo  sprintf( "%s %s", be_themes_get_class( 'author-share' ), $parent_class ); ?>">
				<?php foreach( $author_share as $share_element ) { ?>
					<?php if( !empty( $share_element[ 'link' ] ) ) { ?>
						<a class="custom-share-button" href="<?php echo esc_attr( $share_element[ 'link' ] ); ?>" target = "_blank">
							<i class="<?php echo sprintf( "%s %s", esc_attr( $share_element[ 'icon' ] ), esc_attr( $icon_class ) ); ?>"></i>
						</a>
					<?php } ?>
				<?php } ?>
			</div>
		<?php
			return ob_get_clean();
		}
	}
}

/**
 * Create background style from kirki background field value.
 */
if( !function_exists( 'be_themes_get_background' ) ) {
	function be_themes_get_background( $background = array () ) {
		
		$bg_style_array = array ();
		if( !empty( $background[ 'background-color' ] ) ) {
			$bg_style_array[] = $background[ 'background-color' ];
		}
		if( !empty( $background[ 'background-image' ] ) ) {
			$background_position = $background[ 'background-position' ];
			$background_size = $background[ 'background-size' ];
			$background_postion_size = '';
			if( !empty( $background_size ) && !empty( $background_position ) ) {
				$background_postion_size = $background_position . '/' . $background_size;
			}else if( !empty( $background_position ) || !empty( $background_size ) ) {
				$background_postion_size = !empty( $background_size ) ? 'center center/' . $background_size : $background_position . '/cover';
			}else {
				$background_postion_size = 'center center/cover';
			}
			$bg_style_array[] = 'url(' . $background[ 'background-image' ] . ')';
			if( !empty( $background_postion_size ) ) {
				$bg_style_array[] = $background_postion_size;
			}
			if( !empty( $background[ 'background-attachment' ] ) ) {
				$bg_style_array[] = $background[ 'background-attachment' ];
			}	
		}
		return !empty( $bg_style_array ) ? implode( ' ', $bg_style_array ) : '' ;
	}
}

/**
 * Get Placeholder padding 
 */
if( !function_exists( 'be_themes_get_placeholder_padding' ) ) {
    function be_themes_get_placeholder_padding( $id = '', $post_thumb_size = 'full' ) {
        if( !empty( $id ) ) {
            $img_details = wp_get_attachment_image_src( $id, $post_thumb_size );
            if( !empty( $img_details ) ) {
                $width = !empty( $img_details[ 1 ] ) && is_numeric( $img_details[ 1 ] ) && 0 !== $img_details[ 1 ] ? $img_details[ 1 ] : 100;
                $height = !empty( $img_details[ 2 ] ) && is_numeric( $img_details[ 2 ] ) && 0 !== $img_details[ 2 ] ? $img_details[ 2 ] : 100;
                $aspect_ratio = $width/$height;
                $padding = round( ( 1/ $aspect_ratio ), 5 );
                $padding = $padding * 100;
                return $padding;
            }
        }
        return 100;
    }
}

/**
 * Check if valid hex color.
 * 
 * @source http://php.net/manual/en/function.ctype-xdigit.php
 */
if( !function_exists( 'be_themes_check_valid_colorhex' ) ) {
    function be_themes_check_valid_colorhex( $color_code ) {
        // If user accidentally passed along the # sign, strip it off
        $color_code = ltrim( $color_code, '#' );
        if ( ctype_xdigit( $color_code ) && ( strlen( $color_code ) == 6 || strlen( $color_code ) == 3 ) ) {
            return true;
        }
        return false;
    }
}

/**
 * Integrations directory
 */
if( !function_exists( 'be_themes_integrations_dir' ) ) {
    function be_themes_integrations_dir() {
        return get_template_directory() . '/inc/integrations';
    }
}

/**
 * Get Category Parents
 */
if( !function_exists( 'be_themes_get_terms_parent' ) ) {
    function be_themes_get_terms_parent( $term_id, $tax = 'category', $include_child_term = false, $sep = ' / ' ) {
        if( empty( $term_id ) ) {
            return '';
        }
        $args = array (
            'inclusive'	=> $include_child_term,
            'separator'	=> $sep
        );
        return get_term_parents_list( $term_id, $tax, $args );
    }
}

/* ---------------------------------------------  */
// Function for generating dynamic css
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_options_css' ) ) {
	function be_themes_options_css() {

		$theme_name = be_themes_get_theme_info( 'name' );
		$theme_name = lcfirst( $theme_name );
		$transient_option_name = $theme_name . '_dynamic_css';
		$site_status = be_themes_get_option( 'site_status' );
		if( empty( $site_status ) ) {
			delete_transient( $transient_option_name );
		}
		if ( false === ( $css = get_transient( $transient_option_name ) ) ) {
			ob_start(); // Capture all output (output buffering)
			require(get_template_directory() .'/css/dynamic/be-themes-styles.php'); // Generate CSS
			$css = ob_get_clean(); // Get generated CSS (output buffering)
			set_transient( $transient_option_name, $css );
		}
		echo '<style id="be-dynamic-css" type="text/css"> '.$css.' </style>';
		// }
	
	}
	add_action( 'wp_head', 'be_themes_options_css' );
}

/**
 * Function for creating a separate file for dynamic css
 */
if( !function_exists( 'be_themes_options_saved' ) ) {
	function be_themes_options_saved( $value ) {

		$external_css = be_themes_get_option( 'external_css' );
		if( !empty( $external_css ) ) {
			$theme_name = be_themes_get_theme_info( 'name' );
			$theme_name = lcfirst( $theme_name );	
			$external_css_possible_option_name = $theme_name . '_external_css_possible';
			global $wp_filesystem;
			$access_type = get_filesystem_method();
			$be_is_multi_site = is_multisite();
			if( 'direct' !== $access_type || $be_is_multi_site ) {
				if( false !== get_option( $external_css_possible_option_name ) ) {
					update_option( $external_css_possible_option_name, '0' );
				}else{
					add_option( $external_css_possible_option_name, '0' );
				}
				return;	
			}
			if ( empty( $wp_filesystem ) ) {
				require_once ( ABSPATH.'/wp-admin/includes/file.php' );
				WP_Filesystem();
			}
			$folder_name = '/' . $theme_name . '_dynamic_css';
			$file_name = '/' . $theme_name . '_dynamic.css';
			$wp_upload_abs_path = wp_upload_dir();
			$css_dir = $wp_upload_abs_path[ 'basedir' ] . $folder_name;
			$css_file = $css_dir . $file_name;
			ob_start(); 
			require(get_template_directory() .'/css/dynamic/be-themes-styles.php'); 
			$css = ob_get_clean(); 
			$css = be_themes_should_minify_assets() ? be_minify_css( $css ) : $css;
			if ( wp_mkdir_p( $css_dir ) && $wp_filesystem->put_contents( $css_file, $css, 0644 ) ) {
				if( false !== get_option( $external_css_possible_option_name ) ) {
					update_option( $external_css_possible_option_name, '1' );
				}else{
					add_option( $external_css_possible_option_name, '1' );
				}
			}else {
				if( false !== get_option( $external_css_possible_option_name ) ) {
					update_option( $external_css_possible_option_name, '0' );
				}else {
					add_option( $external_css_possible_option_name, '0' );
				}	
			}
		}else {
			delete_option( $external_css_possible_option_name );
		}

	}
	add_action( 'customize_save_after', 'be_themes_options_saved' );
}

/**
 * Single Page Comments
 */
if( !function_exists( 'be_themes_single_page_comments' ) ) {
	function be_themes_single_page_comments() {
		$comments = be_themes_get_option( 'comments_on_page' );
		if( !empty( $comments ) ) {
			?>
				<div class="be-themes-comments <?php echo be_themes_get_class( 'wrap' ); ?>">
					<?php comments_template( '', true ); ?>
				</div> <!--  End Optional Page Comments -->
			<?php
		}
	}
	add_action( 'be_themes_after_single_page_content', 'be_themes_single_page_comments' );
}

/**
 * Default Content Wrap
 */
if( !function_exists( 'be_themes_should_wrap_content' ) ) {
	function be_themes_should_wrap_content() {
		$wrap = true;
		if( be_themes_is_woocommerce_activated() && ( is_cart() || is_checkout() || is_account_page() ) ) {
			$wrap = false;
		}else if( be_themes_is_woocommerce_activated() && class_exists( 'YITH_WCWL' ) && be_themes_yith_is_wishlist() ) {
			$wrap = false;
		}else if( !is_singular( 'page' ) && !is_singular( 'post' ) && !is_attachment() && !( be_themes_is_woocommerce_activated() && ( is_product() || is_shop() ) ) ) {
			$wrap = false;
		}else if( is_page() && post_password_required() ) {
			$wrap = false;
		}
		$wrap = apply_filters( 'be_enable_content_wrap', $wrap );
		return $wrap;
	}
}

if ( ! function_exists( 'be_themes_content_wrap' ) ) {
	function be_themes_content_wrap( $content ) {
		global $post;
		$content_wrap_class = '';
		$should_wrap = be_themes_should_wrap_content();
		if( $should_wrap ) {
			if( 'post' === get_post_type() ) {
				$content_wrap_class .= ' ' . be_themes_get_class( 'smart-read' );
			}else if( 'page' === get_post_type() ) {
				$page_template = get_page_template_slug();
				if( empty( $page_template ) ) {
					$content_wrap_class .= ' be-themes-content-padding clearfix';
				}
				$content_wrap_class .= ' ' . be_themes_get_class( 'wrap' ); 
			}else if( be_themes_is_woocommerce_activated() && ( is_product() || is_shop() ) ) {
				$content_wrap_class .= ' exp-wrap be-themes-content-padding cleafix';
			} else if( is_attachment() ) {
				$content_wrap_class = 'exp-smart-read' ;
			} else {
				$content_wrap_class = 'exp-wrap' ;
			}
			if( !function_exists( 'edited_once_with_tatsu' ) || false === edited_once_with_tatsu( $post->ID ) ) {
				$content = sprintf( '<div class="%s">%s</div>', $content_wrap_class, $content );
			}
		}
		return $content;
	}
	add_filter( 'the_content', 'be_themes_content_wrap' );
}


if( !function_exists( 'be_themes_menu_link_atts' ) ) {
	function be_themes_menu_link_atts( $atts, $item ) {
		$atts['title'] = $item->title;
		return $atts;
	};
	add_filter('nav_menu_link_attributes', 'be_themes_menu_link_atts', 10, 2);
}

/**
 * BE Portfolio change aspect ratio
 */
if ( ! function_exists( 'be_themes_portfolio_aspect_ratio_value' ) ) {
	function be_themes_portfolio_aspect_ratio_value( $content ){
		return get_theme_mod('portfolio_aspect_ratio', '1.6');
	}
	add_filter( 'portfolio_aspect_ratio', 'be_themes_portfolio_aspect_ratio_value' );
}

/**
 * Posts loop - home page content
 */
if( !function_exists( 'be_themes_print_home_page_content' ) ) {
	function be_themes_print_home_page_content() {
		if( 'page' === get_option( 'show_on_front' ) ) {
			$page_id = get_option( 'page_for_posts' );
			$enable_content =  ( function_exists( 'edited_once_with_tatsu' ) && edited_once_with_tatsu( $page_id ) ) || isset( $_GET['tatsu-frame'] );
			$enable_content = apply_filters( 'be_themes_enable_home_page_content', $enable_content );
			if( $enable_content ) : ?>
				<div id="be-content">
					<?php 
						$post = get_post($page_id); 
						$content = apply_filters('the_content', $post->post_content);
						echo !empty( $content ) ? $content : '';
					?>
				</div>
			<?php endif;
		}
	}
}

if( !function_exists( 'be_themes_link_pages' ) ) {
	function be_themes_link_pages() {
		$class = 'pages_list';
		if( is_page() ) {
			$class .= ' exp-wrap';
		}
		$args = array (
			'before'           => '<div class="' . esc_attr( $class ) . '">',
			'after'            => '</div>',
			'link_before'      => '',
			'link_after'       => '',
			'next_or_number'   => 'next',
			'nextpagelink'     => esc_html__('Next >','exponent'),
			'previouspagelink' => esc_html__('< Prev','exponent'),
			'pagelink'         => '%',
			'echo'             => 1 
		);
		wp_link_pages( $args );
	}
	add_action( 'be_themes_single_post_before_footer', 'be_themes_link_pages' );
	add_action( 'be_themes_after_single_page_content', 'be_themes_link_pages', 9 );
}

/**
 * Hook cdn address into dependent plugins
 */
if( !function_exists( 'be_themes_tatsu_cdn_address' ) ) {
	function be_themes_tatsu_cdn_address( $cdn_address ) {
		$cdn_address_from_theme = be_themes_get_option( 'cdn_address' );
		if( !empty( $cdn_address_from_theme ) ) {
			return $cdn_address_from_theme;
		}
		return $cdn_address;
	}
	add_action( 'tatsu_cdn_address', 'be_themes_tatsu_cdn_address' );
	add_action( 'be_portfolio_post_cdn_address', 'be_themes_tatsu_cdn_address' );
}

/**
 * Check if specific video format is supported
 */
if( !function_exists( 'be_themes_valid_video_format' ) ) {
	function be_themes_valid_video_format( $url = '' ) {
		$default_types = wp_get_video_extensions();
		$type = wp_check_filetype( $url, wp_get_mime_types() );
		if ( !empty( $type[ 'ext' ] ) && in_array( strtolower( $type[ 'ext' ] ), $default_types ) ) {
			return true;
		}
		return false;
	}
}

/**
 * Check if valid video embed url
 */
if( !function_exists( 'be_themes_valid_video_embed' ) ) {
	function be_themes_valid_video_embed( $url = '' ) {
		if( strpos( $url, 'youtu' ) > 0 || strpos( $url, 'vimeo' ) > 0 ) {
			return true;
		}
		return false;
	}
}

/**
 * Returns video embed from url
 */
if ( ! function_exists( 'be_get_video_type' ) ) {
	function be_get_video_type( $url = '' ) {
		if (strpos( $url, 'youtu' ) > 0) {
			return 'youtube';
		}elseif ( strpos( $url, 'vimeo' ) > 0 ) {
			return 'vimeo';
		} 
		return false;
	}
}

/**
 * Get youtube id
 */
if( !function_exists( 'be_get_youtube_id' ) ) {
	function be_get_youtube_id( $url = '' ) {
		if( preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match) ) {
			return $match[1];
		}
		return false;
	}
}

/**
 * Get Vimeo Id
 */
if( !function_exists( 'be_get_vimeo_id' ) ) {
	function be_get_vimeo_id( $url = '' ) {
		if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $output_array)) {
			return $output_array[5];
		}
		return false;
	}
}

/**
 * Get emebed html
 */
if( !function_exists( 'be_get_embed' ) ) {
	function be_get_embed( $url = '' ) {
		$type = be_get_video_type( $url );
		$embed_html = false;
		if( empty( $type ) ) {
			return $embed_html;
		} 
		switch( $type ) {
			case 'youtube' :
				$video_id = be_get_youtube_id( $url );
				if( !function_exists( 'be_gdpr_privacy_ok' ) ){
					$embed_html =  '<div class="be-youtube-embed" data-video-id="' . esc_attr( $video_id ) . '"></div>';	
				} else {
					if( !empty( $_COOKIE ) ) {
						if( !be_gdpr_privacy_ok( 'youtube' ) ){
							$video_details = be_get_video_details($url,'large');
							$embed_html = '<div class="gdpr-alt-image be-gdpr-alternative-absolute "><img src="'.esc_url( $video_details['thumb_url'] ).'"/><div class="gdpr-video-alternate-image-content" >'. shortcode_exists( 'be_gdpr_api_name' ) ? do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="youtube" ]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ) ) ) : '' .'</div></div>';
						} else {
							$embed_html =  '<div class="be-youtube-embed" data-video-id="' . esc_attr( $video_id ). '"></div>';
						}
					} else {
						$video_details = be_get_video_details($url,'large');
						$embed_html =  '<div class="be-youtube-embed be-gdpr-consent-required" data-video-id="' . esc_attr( $video_id ). '"></div>';

						$embed_html = '<div class="gdpr-alt-image be-gdpr-consent-message be-gdpr-alternative-absolute" ><img src="'.esc_url( $video_details['thumb_url'] ).'"/><div class="gdpr-video-alternate-image-content" >'. shortcode_exists( 'be_gdpr_api_name' ) ? do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="youtube" ]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ) ) ) : '' .'</div></div>';
					}
				}
				break;
			case 'vimeo'   :
				$video_id = be_get_vimeo_id( $url );
				if( !function_exists( 'be_gdpr_privacy_ok' ) ){
					$embed_html = '<div class="be-vimeo-embed" data-video-id="' . esc_attr( $video_id ). '"></div>';
				} else {
					if( !empty( $_COOKIE ) ) {
						if( !be_gdpr_privacy_ok( 'vimeo' ) ){
							$video_details = be_get_video_details($url,'large');
							$embed_html = '<div class="gdpr-alt-image be-gdpr-alternative-absolute "><img src="'.esc_url( $video_details['thumb_url'] ).'"/><div class="gdpr-video-alternate-image-content" >'. shortcode_exists( 'be_gdpr_api_name' ) ? do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="vimeo" ]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ) ) ) : '' .'</div></div>';
						} else {
							$embed_html =  '<div class="be-vimeo-embed" data-video-id="' . esc_attr( $video_id ). '"></div>';
						}
					} else {
						$video_details = be_get_video_details($url,'large');
						$embed_html =  '<div class="be-vimeo-embed be-gdpr-consent-required" data-video-id="' . esc_attr( $video_id ). '"></div>';

						$embed_html = '<div class="gdpr-alt-image be-gdpr-consent-message be-gdpr-alternative-absolute" ><img src="'.esc_url( $video_details['thumb_url'] ).'"/><div class="gdpr-video-alternate-image-content" >'. shortcode_exists( 'be_gdpr_api_name' ) ? do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="vimeo" ]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ) ) ) : '' .'</div></div>';
					}
				}
				
				break;
		}
		return '<div class="be-video-embed be-embed-placeholder">' . $embed_html . '</div>';
	}
}

if( !function_exists( 'be_themes_yith_is_wishlist' ) ) {
	function be_themes_yith_is_wishlist() {
		$post_id = get_the_ID();
		if( !empty( $post_id ) ) {
			$wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id', false );
			$wishlist_page_id = 'string' === gettype($wishlist_page_id) ? intval($wishlist_page_id) : $wishlist_page_id;
			if( $post_id === $wishlist_page_id ) {
				return true;
			}
		}
		return false;
	}
}