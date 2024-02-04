<?php
/* ---------------------------------------------  */
// Function to Main Navigation Menu
/* ---------------------------------------------  */
if( !function_exists( 'exponent_print_main_nav' ) ) {
    function exponent_print_main_nav( ) {

        $output = '';
        $defaults = array (
            'theme_location'=> 'main_nav',
            'depth'=> 3,
            'container_class'=>'exponent-menu ',
            'menu_class' => 'clearfix ',
            'echo' => false,
            'fallback_cb' => 'exponent_fallback_nav_menu',
            'walker' => new Exponent_Walker_Nav_Menu()
        );
        
        $mobile_defaults = array (
            'theme_location'=> 'main_nav',
            'depth'=> 3,
            'container_class'=>'exponent-mobile-menu ',
            'menu_class' => 'clearfix ',
            'echo' => false,
            'fallback_cb' => '',
            'walker' => new Exponent_Walker_Mobile_Nav_Menu()
        );
        $custom_style_tag = !empty( $custom_style_tag ) ? $custom_style_tag : '';
        $output .= '<nav class= "exponent-header-navigation clearfix ">'.wp_nav_menu( $defaults ).$custom_style_tag.'</nav>';
        $output .= '<div class= "exponent-mobile-navigation ">'.wp_nav_menu( $mobile_defaults ).'<div class="exponent-mobile-menu-icon"><span class="line-1"></span><span class="line-2"></span><span class="line-3"></span><span class="line-4"></span></div></div>' ;

        echo !empty( $output ) ? $output : '';

    }
}

if ( !class_exists('Exponent_Walker_Nav_Menu') ) {
    class Exponent_Walker_Nav_Menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
            $indent = str_repeat("\t", $depth);
            $sub_menu_indicator = '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"><polyline fill="none" stroke="#2F2F30" stroke-linecap="round" stroke-width="2" points="0 .649 3.613 4.127 0 7.604" transform="rotate(90 4 5)"/></svg>';
            $output .="\n$indent<span class=\"exponent-sub-menu-indicator\">$sub_menu_indicator</span><ul class=\"exponent-sub-menu clearfix\"><span class=\"exponent-header-pointer\"></span>\n";
		}
	}
}

if ( !class_exists('Exponent_Walker_Mobile_Nav_Menu') ) {
    class Exponent_Walker_Mobile_Nav_Menu extends Walker_Nav_Menu {
		function start_lvl(&$output, $depth=0, $args=array()) {
            $indent = str_repeat("\t", $depth);
            $sub_menu_indicator = '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"><polyline fill="none" stroke="#2F2F30" stroke-linecap="round" stroke-width="2" points="0 .649 3.613 4.127 0 7.604" transform="rotate(90 4 5)"/></svg>';

            $output .= "\n$indent<span class=\"exponent-sub-menu-indicator\">$sub_menu_indicator</span><ul class=\"exponent-sub-menu clearfix\">\n";
		}
	}
}

if( !function_exists( 'exponent_fallback_nav_menu' ) ){
    function exponent_fallback_nav_menu(){
        if( current_user_can( 'edit_theme_options' ) ) {
            echo '<a href="'.esc_url( admin_url("nav-menus.php") ).'">'.esc_html__( 'Set the Main Menu', 'exponent' ).'</a>';
        }
    }
}


if( !function_exists( 'exponent_has_blog_thumb' ) ) {
    function exponent_has_blog_thumb( $post_id = '', $post_format = '' ) {
        if( !empty( $post_id ) && !empty( $post_format ) ) {
            switch( $post_format ) {
                case 'video' :
                    $video_embed =  get_post_meta( $post_id, be_themes_get_meta_prefix() . 'video_embed', true );
                    return !empty( $video_embed ) ? true : false;
                case 'audio' :
                    $audio_embed =  get_post_meta( $post_id, be_themes_get_meta_prefix() . 'audio_embed', true );
                    return !empty( $audio_embed ) ? true : false;
                case 'gallery' :
                    $gallery_items =  get_post_meta( $post_id, be_themes_get_meta_prefix() . 'gallery_images', true );
                    return !empty( $gallery_items ) ? true : false;
                case 'quote' :
                    $quote = get_post_meta( $post_id, be_themes_get_meta_prefix() . 'quote', true );
                    return !empty( $quote ) ? true : false;
                case 'link' :
                    $link = get_post_meta( $post_id, be_themes_get_meta_prefix() . 'link', true );
                    return !empty( $link ) ? true : false;
                default : 
                    $post_thumb =  get_the_post_thumbnail( $post_id ); 
                    return !empty( $post_thumb ) ? true : false;
            };
        }
        return false;
    }
}

if( !function_exists( 'exponent_get_blog_default_cols' ) ) {
    function exponent_get_blog_default_cols() {
        $full_width = be_themes_get_option( 'blog_grid_full_width' );
        $blog_loop_sidebar = be_themes_get_option( 'blog_loop_sidebar' );
        $blog_style = be_themes_get_option( 'blog_archive_style' );
        $metro_styles = array( 'style3', 'style7' );
        $cols = 3;
        if( in_array( $blog_style, $metro_styles ) ) {
            if( empty( $full_width ) && !empty( $blog_loop_sidebar ) ) {
                $cols = 2;
            }else if( !empty( $full_width ) && empty( $blog_loop_sidebar ) ) {
                $cols = be_themes_get_option( 'blog_loop_metro_4_cols' );
            }else if( !empty( $full_width ) && !empty( $blog_loop_sidebar ) ) {
                $cols = be_themes_get_option( 'blog_loop_metro_3_cols_alt' );
            }else {
                $cols = be_themes_get_option( 'blog_loop_metro_3_cols' );
            }
        }else {
            if( empty( $full_width ) && !empty( $blog_loop_sidebar ) ) {
                $cols = be_themes_get_option( 'blog_loop_normal_3_cols' );
            }else if( empty( $full_width ) && empty( $blog_loop_sidebar ) ) {
                $cols = be_themes_get_option( 'blog_loop_normal_4_cols' );
            }else if( !empty( $full_width ) && !empty( $blog_loop_sidebar ) ) {
                $cols = be_themes_get_option( 'blog_loop_normal_4_cols_alt' );
            }else {
                $cols = be_themes_get_option( 'blog_loop_normal_5_cols' );
            }
        }
        return $cols;
    }
}

if( !function_exists( 'exponent_print_post_slide_or_cell_styles' ) ) {
    function exponent_print_post_slide_or_cell_styles() {
        $gutter = exponent_get_post_loop_prop( 'posts_gutter' );
        $arrangement = exponent_get_post_loop_prop( 'arrangement' );
        $post_shadow = exponent_get_post_loop_prop( 'post_shadow' );
        $gutter = is_numeric( $gutter ) ? $gutter : 20;

        $padding = sprintf( 'padding : 0 %spx;', $gutter/2 );

        if( 'grid' === $arrangement ) {
            $margin = "margin-bottom : {$gutter}px;";
        }else {
            $margin = '';
        }

        echo sprintf( 'style = "%s%s"', esc_attr( $padding ), esc_attr( $margin ) );
    }
}

/**
 * Remove paraentheses from post count.
 * https://iftekhar.net/blog/how-to-remove-parentheses-from-category-post-count-in-wordpress/
 */
if( !function_exists( 'exponent_customize_categories_widgets' ) ) {
	function exponent_customize_categories_widgets( $cat ) {
		$cat = str_replace( '(', sprintf( '<span class="%s">', be_themes_get_class( 'categories-post-count' ) ), $cat );
		$cat = str_replace( ')', '</span>', $cat );
		return $cat;
	}
	add_filter( 'wp_list_categories', 'exponent_customize_categories_widgets' );
	add_filter( 'wp_dropdown_cats', 'exponent_customize_categories_widgets' );
}

/**
 * Remove paraentheses from post count.
 * https://iftekhar.net/blog/how-to-remove-parentheses-from-category-post-count-in-wordpress/
 */
if( !function_exists( 'exponent_archive_postcount_filter' ) ) {
	function exponent_archive_postcount_filter( $archive ) {
		$archive = str_replace( '&nbsp;(', sprintf( '<span class="%s">', be_themes_get_class( 'archive-post-count' ) ), $archive );
		$archive = str_replace( ')', '</span>', $archive );
		return $archive;
	}
	add_filter('get_archives_link', 'exponent_archive_postcount_filter');
}

/**
 * Add wrapper to archive widgets
 */
if ( ! function_exists( 'exponent_archive_widget_args' ) ) {
	function exponent_archive_widget_args( $args = array() ) {
		$args[ 'before' ] = sprintf( '<li class="swap_widget_archive"><div class="%s">', be_themes_get_class( 'archive-widget-link' ) );
		$args[ 'after' ]  = '</div></li>';	
		return $args;
	}
	add_filter( 'widget_archives_args', 'exponent_archive_widget_args' );
}


if ( ! function_exists( 'exponent_category_widget_args' ) ) {
	function exponent_category_widget_args( $args = array() ) {
		$args[ 'be_wrapper' ] = true;
		return $args;
	}
	add_filter( 'widget_categories_args', 'exponent_category_widget_args' );
}

/**
 * Add wrapper to list type categories widget
 */
if ( ! function_exists( 'exponent_list_categories_add_wrapper' ) ) {
	function exponent_list_categories_add_wrapper( $output, $args ) {
		if( is_array( $args ) && !empty( $args[ 'be_wrapper' ] ) ) {
			$output = str_replace( '<a', '<div class="exp-categories-widget-link"><a', $output );
			$output = str_replace( '</li>', '</div></li>', $output );
		}
		return $output;
	}
	add_filter( 'wp_list_categories', 'exponent_list_categories_add_wrapper', 10, 2 );
}

/* ---------------------------------------------  */
// HTML5 Search
/* ---------------------------------------------  */
if ( ! function_exists( 'exponent_html5_search_form' ) ) {
	function exponent_html5_search_form( $form ) {
        $form_style = be_themes_get_option( 'form_style' );
        if( 'border-with-underline' === $form_style || 'rounded-with-underline' === $form_style ) {
            $placeholder = '';
        }else {
            $placeholder = 'placeholder = "' . esc_attr__( 'Search', 'exponent' ) . '"';
        }
		ob_start();
		?>
			<form role="search" method="get" class="searchform <?php echo be_themes_get_class( 'form', 'form-' . $form_style ); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
				<div class="<?php echo be_themes_get_class( 'form-field' ); ?>">
					<input type="text" value="<?php echo get_search_query(); ?>" name="s" class="search" <?php echo !empty( $placeholder ) ? $placeholder :  ''; ?> />
					<?php if( 'border-with-underline' === $form_style || 'rounded-with-underline' === $form_style ) : ?>
						<label class="<?php echo be_themes_get_class( 'form-field-label' ); ?>">
							<?php echo esc_html__( 'Search', 'exponent' ); ?>
                        </label>
                        <span class="<?php echo be_themes_get_class( 'form-border' ); ?>"></span>
					<?php endif; ?>
					<span class="<?php echo be_themes_get_class( 'searchform-icon' ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21">
							<g fill="none" fill-rule="evenodd" stroke-width="2" transform="rotate(-45 9.27 7.257)">
								<circle cx="7.846" cy="7.846" r="6.846"></circle>
								<path stroke-linecap="round" d="M8.02203654,14.7239099 L8.02203654,23.1736574"></path>
							</g>
						</svg>
					</span>
				</div>
			</form>
		<?php
		return ob_get_clean();
	}
	add_filter( 'get_search_form', 'exponent_html5_search_form' );
}

/* ---------------------------------------------  */
// Function to handle blog comments
/* ---------------------------------------------  */
if ( ! function_exists( 'exponent_comments' ) ) {
	function exponent_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		$comment_type = $comment->comment_type;
		$main_comment = '0' === $comment->comment_parent;
		$comment_classes = array();
		$comment_classes[] = be_themes_get_class( 'comment' );
		if( !empty( $args['has_children'] ) ) {
			$comment_classes[] = be_themes_get_class( 'comment-parent' );
		}
		if( $main_comment ) {
			$comment_classes[] = be_themes_get_class( 'comment-top' );
		}
		switch ( $comment_type ) {
			case 'pingback' :
			case 'trackback' :
            ?>
            <li class="<?php echo be_themes_get_class( 'comment-' . $comment_type ); ?>">
                <?php 
                    echo ucfirst( $comment_type ) . ":  "; 
                    comment_author_link(); 
                    edit_comment_link( esc_html__( 'Edit', 'exponent' ) , sprintf( '<span class="%s">', be_themes_get_class( 'comment-edit' ) ), '</span>' ); 
                ?>
            </li>
            <?php
			break;
			default :
            ?>
            <li <?php comment_class( $comment_classes ); ?> id="comment-<?php comment_ID(); ?>">
                <div class="<?php echo be_themes_get_class( 'comment-inner' ); ?>">
                    <div class="<?php echo be_themes_get_class( 'comment-author-image' ); ?>">
                        <?php echo get_avatar( $comment, $main_comment ? 68 : 62 ); ?>
                    </div>
                    <div class="<?php echo be_themes_get_class( 'comment-details' ); ?>">
                        <div class="<?php echo be_themes_get_class( 'comment-header' ); ?>">
                            <h6 class="<?php echo be_themes_get_class( 'comment-author' ); ?>">
                                <?php echo get_comment_author_link(); ?>
                            </h6>
                            <div class="<?php echo be_themes_get_class( 'comment-time' ); ?>">
                                <?php printf( "%s, %s",  get_comment_time( 'g:i A' ), get_comment_date('j F Y') ); ?>
                            </div>
                        </div>
                        <?php if ( '0' === $comment->comment_approved ) : ?>
                            <div class="<?php echo be_themes_get_class( 'comment-awaiting-moderation' ); ?>">
                                <?php echo esc_html__( 'Your comment is awaiting moderation.', 'exponent' ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="<?php echo be_themes_get_class( 'comment-content' ); ?>" >
                            <?php comment_text(); ?>
                        </div>
                            
                        <?php 
                            $reply_text = '<i class="exponent-icon-reply exp-icon tiny plain"></i>'. esc_html__('Reply', 'exponent'); 
                            $before = '<div class="' . be_themes_get_class( 'comment-reply' ) . '" >';
                            $after = '</div>';
                        ?>
                        <?php comment_reply_link( array_merge( $args, array( 'reply_text' => $reply_text, 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => $before, 'after' => $after ) ) ); ?>
                    </div>
                </div>
                <?php if( !empty( $args['has_children'] ) ) : ?>
                    <div class="<?php echo be_themes_get_class( 'comment-follow-line' ); ?>">
                    </div>
                <?php endif; ?>
            </li>
            <?php	
        }
    }
}

/* ---------------------------------------------  */
// Filter to adjust tag could font size
/* ---------------------------------------------  */
if ( ! function_exists( 'exponent_tag_font' ) ) {
	function exponent_tag_font( $args ) {
	  $args['smallest'] = 13;
	  $args['largest'] = 13;
	  $args['unit'] =  'px';	  
	  return $args;
	}
	add_filter( 'widget_tag_cloud_args' , 'exponent_tag_font' );
}


/**
 * Excerpt read more style
 */
if (!function_exists( 'exponent_excerpt_more_link' )) {
	function exponent_excerpt_more_link( $output ) {
		$read_more_style = exponent_get_post_loop_prop( 'read_more' );
		$arrangement = exponent_get_post_loop_prop( 'arrangement' );
		if( 'slider' !== $arrangement ) {
			$classes = be_themes_get_class( 'more-link' );
			$more_link =  sprintf(
						'%s<a href="%s" class="%s">%s</a>%s',
						'underlined' === $read_more_style ? '<div>' : '',
						esc_url( get_permalink() ),
						be_themes_get_class( 'read-more', 'read-more-' . $read_more_style ),
						'dots' === $read_more_style ? '...' : esc_html__( 'Read More', 'exponent' ),
						'underlined' === $read_more_style ? '</div>' : ''
            		);
			return $output . $more_link;	
		}
		return $output;
	}
	add_filter('get_the_excerpt', 'exponent_excerpt_more_link' );
}

/**
 * Read more link style
 */
if (!function_exists( 'exponent_read_more_link' )) {
	function exponent_read_more_link() {
		$read_more_style = exponent_get_post_loop_prop( 'read_more' );
		$classes = be_themes_get_class( 'more-link' );
		return  sprintf(
					'%s<a href="%s" class="%s">%s</a>%s',
					'underlined' === $read_more_style ? '<div>' : '',
					esc_url( get_permalink() ),
					be_themes_get_class( 'read-more', 'read-more-' . $read_more_style ),
					'dots' === $read_more_style ? '...' : esc_html__( 'Read More', 'exponent' ),
					'underlined' === $read_more_style ? '</div>' : ''
                );
	}
	add_filter( 'the_content_more_link', 'exponent_read_more_link' );
}

/**
 * Get comment form args
 */
if( !function_exists( 'exponent_get_comment_form_args' ) ) {
    function exponent_get_comment_form_args() {
        $form_style = be_themes_get_option( 'form_style' );
        $button_style = be_themes_get_option( 'button_style' );
        $args = array();
        if( 'border-with-underline' === $form_style || 'rounded-with-underline' == $form_style ) {
            $args[ 'fields' ] = array (
                'author'  => sprintf( '<div class="%s"><input required type = "text" id="author" name = "author" aria-required = "true"/><label for = "author" class="%s">%s</label><span class="%s"></span></div>', be_themes_get_class( 'form-field' ), be_themes_get_class( 'form-field-label' ), esc_html__( 'Name *', 'exponent' ), be_themes_get_class( 'form-border' ) ),
                'email'	  => sprintf( '<div class="%s"><input required type = "text" id="email" name = "email" aria-required = "true"/><label for = "email" class="%s">%s</label><span class="%s"></span></div>', be_themes_get_class( 'form-field' ), be_themes_get_class( 'form-field-label' ), esc_html__( 'Email *', 'exponent' ), be_themes_get_class( 'form-border' ) ),
                'url'	  => sprintf( '<div class="%s"><input required type = "text" id="url" name = "url" aria-required = "true"/><label for = "url" class="%s">%s</label><span class="%s"></span></div>', be_themes_get_class( 'form-field' ), be_themes_get_class( 'form-field-label' ), esc_html__( 'Website', 'exponent' ), be_themes_get_class( 'form-border' ) )
            );
            $args[ 'comment_field' ] = sprintf( '<div class="%s"><textarea required id="comment" name="comment" cols="45" rows="15" aria-required="true"></textarea><label for = "comment" class="%s">%s</label><span class="%s"></span></div>', be_themes_get_class( 'form-field', 'comment-field' ), be_themes_get_class( 'form-field-label' ), esc_html__( 'Comment', 'exponent' ), be_themes_get_class( 'form-border' ) );
        }else {
            $args[ 'fields' ] = array (
                'author'  => sprintf( '<div class="%s"><input placeholder = "%s" type = "text" id="author" name = "author" aria-required = "true"/></div>', be_themes_get_class( 'form-field' ), esc_html__( 'Name *', 'exponent' ) ),
                'email'	  => sprintf( '<div class="%s"><input placeholder = "%s" type = "text" id="email" name = "email" aria-required = "true"/></div>', be_themes_get_class( 'form-field' ), esc_html__( 'Email *', 'exponent' ) ),
                'url'	  => sprintf( '<div class="%s"><input placeholder = "%s" type = "text" id="url" name = "url" aria-required = "true"/></div>', be_themes_get_class( 'form-field' ), esc_html__( 'Website', 'exponent' ) )
            );
            $args[ 'comment_field' ] = sprintf( '<div class="%s"><textarea placeholder = "%s" id="comment" name="comment" cols="45" rows="15" aria-required="true"></textarea></div>', be_themes_get_class( 'form-field', 'comment-field' ), esc_html__( 'Comment', 'exponent' ) );
        }
        $args[ 'label_submit' ] = esc_html__( 'Submit', 'exponent' );
        $args[ 'class_form' ] = be_themes_get_class( 'comment-form', 'form-' . $form_style, 'form', 'button-' . $button_style );
        return $args;
    }
}

if( !function_exists( 'exponent_get_post_loop_arrangement' ) ) {
    function exponent_get_post_loop_arrangement( $style ) {
        $list_styles = array( 'style1', 'style4' );
        $arrangement = 'grid';
        if( in_array( $style, $list_styles ) ) {
            $arrangement = 'list';
        }
        return $arrangement;
    }
}

/**
 * Setup Posts Loop
 */
if( !function_exists( 'exponent_setup_post_loop' ) ) {
    function exponent_setup_post_loop( $args = array() ) {
        $full_width = be_themes_get_option( 'blog_grid_full_width' );
        $sidebar = be_themes_get_option( 'blog_loop_sidebar' );
        $default_args = array (
            'style'						  	=> be_themes_get_option( 'blog_archive_style' ),
            'alignment'					  	=> be_themes_get_option( 'blog_archive_alignment' ),
            'hide_content'				  	=> be_themes_get_option( 'blog_hide_content' ),
            'custom_post_details_padding' 	=> be_themes_get_option( 'blog_post_details_custom_pad' ),
            'post_details_padding'		  	=> be_themes_get_option( 'blog_post_detials_pad' ),
            'post_details_color'	      	=> be_themes_get_option( 'blog_post_details_color' ),
            'columns'						=> exponent_get_blog_default_cols(),
            'grid_aspect_ratio'             => be_themes_get_option( 'blog_aspect_ratio' ),
            'grid_with_margin'				=> !empty( $full_width ) && empty( $sidebar ) ,// only for grid layout
            'primary_meta'					=> be_themes_get_option( 'blog_loop_primary_meta' ),
            'secondary_meta'				=> be_themes_get_option( 'blog_loop_secondary_meta' ),
            'tertiary_meta'					=> be_themes_get_option( 'blog_loop_tertiary_meta' ),
            'labeled_cat'					=> be_themes_get_option( 'blog_loop_labeled_cat' ),
            'meta_date_icon'				=> be_themes_get_option( 'blog_loop_meta_date_icon' ),
            'meta_author_image'				=> be_themes_get_option( 'blog_loop_meta_author_image' ),
            'posts_gutter'					=> be_themes_get_option( 'blog_gutter' ),
            'border_radius'					=> be_themes_get_option( 'blog_archive_border_radius' ),
            'arrangement'					=> exponent_get_post_loop_arrangement(be_themes_get_option( 'blog_archive_style' )),// can be grid or slider or list
            'type'							=> 'blog',     //can be blog, recent posts, featured or related posts
            'thumb_shadow'					=> be_themes_get_option( 'blog_archive_thumb_shadow' ),
            'post_shadow'					=> be_themes_get_option( 'blog_archive_shadow' ),
            'read_more'						=> be_themes_get_option( 'blog_read_more_style' ),
            'featured_posts_height'			=> be_themes_get_option( 'featured_posts_height' ),
            'arrows'						=> '1'	//Used only for slider arrangement
        );

        // Merge any existing values.
        if ( isset( $GLOBALS['be_posts_loop'] ) ) {
            $default_args = array_merge( $default_args, $GLOBALS['be_posts_loop'] );
        }
        $GLOBALS['be_posts_loop'] = shortcode_atts( $default_args, $args );
    }
}

/**
 * Reset posts loop
 */
if( !function_exists( 'exponent_reset_post_loop' ) ) {
    function exponent_reset_post_loop() {
        if ( isset( $GLOBALS['be_posts_loop'] ) ) {
            unset( $GLOBALS[ 'be_posts_loop' ] );
        }
    }
}

/**
 * Get post loop props
 */
if( !function_exists( 'exponent_get_post_loop_prop' ) ) {
    function exponent_get_post_loop_prop( $prop, $default = '' ) {
        if ( ! isset( $GLOBALS['be_posts_loop'] ) ) {
            exponent_setup_post_loop(); // Ensure be posts loop is setup.
        }
        return isset( $GLOBALS['be_posts_loop'], $GLOBALS['be_posts_loop'][ $prop ] ) ? $GLOBALS['be_posts_loop'][ $prop ] : $default;
    }
}

/**
 * Copy theme mods from parent theme to child theme and vice versa
 * @ref https://core.trac.wordpress.org/ticket/27177
 */
if( !function_exists( 'exponent_copy_mods_on_theme_switch' ) ) {
	function exponent_copy_mods_on_theme_switch( $old_theme_name, $old_theme_obj ) {
		$cur_theme_obj = wp_get_theme();
        $cur_theme_name = $cur_theme_obj->get( 'Name' );
		if( 'exponent' === $cur_theme_obj->get( 'Template' ) && 'Exponent' === $old_theme_name ) {
			$main_theme_mods = get_option( 'theme_mods_exponent' );
			update_option( 'theme_mods_exponent_child', $main_theme_mods );
		}else if( 'Exponent' === $cur_theme_name && 'exponent' === $old_theme_obj->get( 'Template' ) ) {
			$child_theme_mods = get_option( 'theme_mods_exponent_child' );
			update_option( 'theme_mods_exponent', $child_theme_mods );
		}
	}
	add_action( 'after_switch_theme', 'exponent_copy_mods_on_theme_switch', 10, 2 );
}

/**
 * Posts Entry Header
 */
if( !function_exists( 'exponent_post_entry_header' ) ) {
	function exponent_post_entry_header() {
        if( is_search() ) {
            set_query_var( 'be_entry_header_wrap', true );
			get_template_part( 'template-parts/partials/entry', 'header' ); 
            return;
        }
		$post_types_with_entry_header = be_themes_get_option( 'posts_with_entry_header' );
		if( is_array( $post_types_with_entry_header ) && in_array( 'post', $post_types_with_entry_header ) ) {
			$full_width = be_themes_get_option( 'blog_grid_full_width' );
			$grid_styles = array( 'style2', 'style3', 'style5', 'style6', 'style7' );
			$blog_style = be_themes_get_option( 'blog_archive_style' );   
            $gutter  = be_themes_get_option( 'blog_gutter' ); 
            $has_tatsu_content = false;
            if( is_home() ) {
                $page_id = get_queried_object_id();
                $has_tatsu_content =  ( function_exists( 'edited_once_with_tatsu' ) && edited_once_with_tatsu( $page_id ) ) || isset( $_GET['tatsu-frame'] );
            }
			if( is_category() ) {
				$cur_cat = get_queried_object();
				$custom_header = get_term_meta( $cur_cat->term_id, be_themes_get_meta_prefix() . 'cat_custom_header', true );
				if( !empty( $custom_header ) ) {
					return;
				}
			}
			if( is_author() ) {
				$author_custom_header = be_themes_get_option( 'author_custom_header' );
				if( !empty( $author_custom_header ) ) {
					return;
				}
			}
			if( in_array( $blog_style, $grid_styles ) && !empty( $full_width ) ) {
				set_query_var( 'be_entry_header_wrap', false );
				set_query_var( 'be_entry_header_horizontal_pad', $gutter );
			}else {
				set_query_var( 'be_entry_header_wrap', true );
            }

            $header_loaded = get_query_var( 'be_entry_header_loaded' );
            if ( ! $has_tatsu_content && ! $header_loaded ) {
                get_template_part( 'template-parts/partials/entry', 'header' );
                set_query_var( 'be_entry_header_loaded', true );
            }
		}
	}
	add_action( 'be_themes_before_post_archive', 'exponent_post_entry_header' );
}

/**
 * Page Entry Header
 */
if( !function_exists( 'exponent_page_entry_header' ) ) {
	function exponent_page_entry_header() {		
        if( is_404() ) {
            return;
        }
		$post_types_with_entry_header = be_themes_get_option( 'posts_with_entry_header' );
		if( be_themes_is_woocommerce_activated() && ( is_cart() || is_checkout() || is_account_page() ) ) {
			return;
		}
		$single_page_override = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'entry_header_override', true );
		if( !empty( $single_page_override ) ) {
			$entry_header_meta = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'entry_header', true );
			if( !empty( $entry_header_meta ) ) {
				set_query_var( 'be_entry_header_wrap', true );
				get_template_part( 'template-parts/partials/entry', 'header' ); 
			}
		}else if( is_array( $post_types_with_entry_header ) && in_array( 'page', $post_types_with_entry_header ) ) {
			set_query_var( 'be_entry_header_wrap', true );
			get_template_part( 'template-parts/partials/entry', 'header' ); 
		}
	}
	add_action( 'be_themes_before_single_page', 'exponent_page_entry_header' );
}

/**
 * Password Forms
 */
if ( ! function_exists( 'exponent_password_protected_form' ) ) {
	function exponent_password_protected_form( $output ) {
			$post = get_post();
			$form_style = be_themes_get_option( 'form_style' );
            $label = 'pwbox-' . ( empty($post->ID ) ? rand() : $post->ID );
            $wrapper_class = be_themes_get_class( 'post-password-form-wrap' );
            if( is_singular( 'post' ) ) {
                $wrapper_class .=  ' ' . be_themes_get_class( 'smart-read' );
            }else if( is_singular( 'page' ) ) {
                $wrapper_class .=  ' ' . be_themes_get_class( 'wrap' );
                $wrapper_class .= ' be-themes-content-padding';
            }
		?>
			<div class="<?php echo be_themes_get_class( 'post-password-form-wrap', $wrapper_class ); ?>">
				<form method = "post" action = "<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) );?>" 
					class="post-password-form <?php echo be_themes_get_class( 'form', 'form-' . $form_style ); ?>"
				>
					<div class="<?php echo be_themes_get_class( 'protect-post-info' ); ?>">
						<?php echo  esc_html__( 'This content is password protected. To view it please enter your password below:', 'exponent' );  ?>
					</div>
					<div class="<?php echo be_themes_get_class( 'form-field' ); ?>">
						<?php if( 'underlined' === $form_style || 'bordered' === $form_style ) : ?>
							<input name = "post_password" id="<?php echo esc_attr( $label ); ?>" type="password" size="20" />
							<label class="<?php echo be_themes_get_class( 'form-field-label' ); ?>" for = "<?php echo esc_attr( $label ); ?>">
								<?php echo esc_html__( 'Password:', 'exponent' ) ?>
							</label>
							<span class="<?php echo be_themes_get_class( 'form-border' ); ?>"></span>
						<?php else: ?>
							<input name="post_password" id="<?php echo esc_attr( $label ); ?>" placeholder = "<?php echo esc_attr__( 'Password:', 'exponent' ) ?>" type="password" size="20" />
						<?php endif; ?>
					</div>
					<input type="submit" name="Submit" value = "<?php echo esc_attr_x( 'Enter', 'post password form', 'exponent' ); ?>"/>
				</form>
			</div>
		<?php
	}
	add_filter( 'the_password_form', 'exponent_password_protected_form' );
}

/**
 * Hook cdn address into exponent modules plugins
 */
if( !function_exists( 'exponent_modules_cdn_address' ) ) {
	function exponent_modules_cdn_address( $cdn_address ) {
		$cdn_address_from_theme = be_themes_get_option( 'cdn_address' );
		if( !empty( $cdn_address_from_theme ) ) {
			return $cdn_address_from_theme;
		}
		return $cdn_address;
	}
	add_action( 'exponent_modules_cdn_address', 'exponent_modules_cdn_address' );
}

/** 
 * Sticky Sections
 */
if( !function_exists( 'exponent_sticky_sections_add_body_class' ) ) {
    function exponent_sticky_sections_add_body_class( $classes ) {
        $sticky_sections = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'sticky_sections', true );
        if( !empty( $sticky_sections ) ) {
            $classes[] = 'be-sticky-sections';
        }
        return $classes;
    }
    add_filter( 'body_class', 'exponent_sticky_sections_add_body_class' );
}
if( !function_exists( 'exponent_sticky_sections_wrapper_start' ) ) {
    function exponent_sticky_sections_wrapper_start() {
        $sticky_sections = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'sticky_sections', true );
        if( !empty( $sticky_sections ) ) :
            $sticky_scroll_type = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'sticky_scroll_type', true );
	        $sticky_overlay = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'sticky_overlay', true );
        ?>
            <div class = "be-sections-wrap" data-sticky-scroll = "<?php echo $sticky_scroll_type; ?>" data-sticky-overlay = "<?php echo $sticky_overlay; ?>" >
        <?php 
        endif;
    }
    add_action( 'be_themes_before_single_page_content', 'exponent_sticky_sections_wrapper_start' );
}
if( !function_exists( 'exponent_sticky_sections_wrapper_end' ) ) {
    function exponent_sticky_sections_wrapper_end() {
        $sticky_sections = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'sticky_sections', true );
        if( !empty( $sticky_sections ) ) :
        ?>
            </div>
        <?php
        endif;
    }
    add_action( 'be_themes_after_single_page_content', 'exponent_sticky_sections_wrapper_end' );
} 
if( !function_exists( 'exponent_sticky_sections_fixed_wrapper_start' ) ) {
    function exponent_sticky_sections_fixed_wrapper_start() {
        $sticky_sections = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'sticky_sections', true );
        if( !empty( $sticky_sections ) ) :
        ?>  
            <div id = "be-sticky-section-fixed-wrap">
        <?php
        endif;
    }
    add_action( 'be_themes_before_body', 'exponent_sticky_sections_fixed_wrapper_start' );
}
if( !function_exists( 'exponent_sticky_sections_fixed_wrapper_end' ) ) {
    function exponent_sticky_sections_fixed_wrapper_end() {
        $sticky_sections = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'sticky_sections', true );
        if( !empty( $sticky_sections ) ) :
        ?>
            </div>
        <?php
        endif;
    }
    add_action( 'be_themes_after_footer', 'exponent_sticky_sections_fixed_wrapper_end' );
}
if( !function_exists( 'exponent_sticky_sections_disable_sticky_header' ) ) {
    function exponent_sticky_sections_disable_sticky_header( $header_settings ) {
        $sticky_sections = get_post_meta( get_the_ID(), be_themes_get_meta_prefix() . 'sticky_sections', true );
        if( !empty( $sticky_sections ) && is_array( $header_settings ) ) {
            if( !empty( $header_settings['sticky'] ) ) {
                $header_settings['sticky'] = false;
            }
        }
        return $header_settings;
    }
    add_filter( 'tatsu_active_header_global_settings', 'exponent_sticky_sections_disable_sticky_header' );
}
?>