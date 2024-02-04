<?php 

    $unique_class_name = 'tatsu-'.$key;
    $delay_load_class = ( !empty( $delay_load ) ) ? 'portfolio-delay-load ' : '';
    $lazy_load_class = ( !empty( $lazy_load ) ) ? 'portfolio-lazy-load ' : '';
    $hover_style = (!isset($hover_style) || empty($hover_style)) ?  'style1' : $hover_style;
    $masonry_enable = ((!isset($masonry)) || empty($masonry)) ? '0' : '1';
	$gutter_width = ( isset( $gutter_width ) ) ? intval( $gutter_width ) : intval(40);
    $col = ((!isset($col)) || empty($col)) ? '3' : $col;
    $show_filters = ( !empty( $show_filters ) ) ? '1' : '0';
    $filter_to_use = ((!isset($filter)) || empty($filter)) ? 'categories' : $filter;
    $delay_load = ( (!isset( $delay_load )) || empty( $delay_load ) ) ? 0 : 1;
    $aspect_ratio = '1.6';
    $aspect_ratio = apply_filters('portfolio_aspect_ratio', $aspect_ratio);
    $shadow_class = '';
    $mobile_cols = !empty($two_col_mobile) ? 'data-mobile-cols="2"' : '';

    $wrapper_classes = array( $unique_class_name );
    $css_id = be_get_id_from_atts( $values );
    $visibility_classes = be_get_visibility_classes_from_atts( $values );
    $data_animations = be_get_animation_data_atts( $values );
    if( !empty( $css_classes ) ) {
        $wrapper_classes[] = $css_classes;
    }
    if( !empty( $visibility_classes ) ) {
        $wrapper_classes[] = $visibility_classes;
    }
    if( ( !empty($animate) && 'none' !== $animation_type ) ) {
        $wrapper_classes[] = 'tatsu-animate';
    }

    if( $prebuilt_hover_style === 'style5' ){
        $masonry_enable = '1';
        if( !empty( $enable_shadow ) ) {
            $shadow_class = ' be-portfolio-with-shadow';
        }
    }

    $metro_layout = '1';

    if( $masonry_enable === '1' ){
        $metro_layout = '0';
    }

    if( '' != $delay_load_class && 'none' == $initial_load_style ) {
        $initial_load_style = 'fadeIn';
    }
?>
<div <?php echo $css_id; ?> class="be-portfolio-wrap tatsu-module be-portfolio-module <?php echo implode( ' ', $wrapper_classes ); ?>"  <?php echo $data_animations; ?>>
    <div class="<?php echo "be-portfolio {$delay_load_class} be-portfolio-prebuilt-hover-{$prebuilt_hover_style} {$lazy_load_class}{$shadow_class}"; ?>"  >
<?php
        $stack = array();
		if($filter_to_use == 'portfolio_tags' ) {
            $terms = get_terms( $filter_to_use );
            $tags = explode( ',', $tag );
            if( !empty( $tags[0] ) ) {
                foreach( $terms as $term ) {
                    if( in_array( $term->slug, $tags ) ) {
                        array_push( $stack, $term->term_id );
                    }
                }
                $terms = get_terms($filter_to_use, array( 'include' => $stack ));
            }
		} else {
            $category = explode(',', $category);
	 	 	$args_cat = array( 'taxonomy' => 'portfolio_categories' ) ;
			foreach(get_categories( $args_cat ) as $single_category ) {
				if ( in_array( $single_category->slug, $category ) ) {
					array_push( $stack, $single_category->cat_ID );
				}
			}
			$terms = get_terms($filter_to_use, array( 'include' => $stack) );
		}

	    if(!empty( $terms ) && $show_filters == '1') {
            $filter_alignment = ( isset( $filter_alignment ) && !empty( $filter_alignment ) ) ? $filter_alignment : 'center';
?>
		    <div class="portfolio-filters clearfix  align-<?php echo $filter_alignment; ?>">
                <div class="portfolio-filter_item"><span class="sort-items current_choice" data-id="all"><?php echo __( 'All', 'be-grid' ); ?></span></div>
        <?php	foreach ($terms as $term) {
                    if( is_object( $term ) ) {
                        ?>
                        <div class="portfolio-filter_item">    		
                            <span class="sort-items" data-id="<?php echo $term->slug; ?>"><?php echo $term->name; ?></span>	
                        </div>
                        <?php
                    }
                }?>
            </div>
    <?php } ?>
        
        <div class="be-portfolio-container be-grid be-cols-<?php echo $col; ?> clickable clearfix portfolio-shortcode" data-aspect-ratio="<?php echo $aspect_ratio; ?>" data-metro-layout="<?php echo $metro_layout; ?>" data-animation-target = ".portfolio-thumb-img-wrap" data-cols="<?php echo $col; ?>" data-scroll-reveal = "<?php echo $delay_load; ?>" data-filter-items = "<?php echo $show_filters; ?>" data-animation="<?php echo $initial_load_style; ?>" data-gutter="<?php echo $gutter_width;?>" data-layout = "<?php echo !empty($masonry_enable) ? 'masonry' : 'metro'; ?>" <?php echo $mobile_cols; ?> >
