<?php 
	$post = get_post();
	$post_id = !empty($post) ? $post->ID : null;
	$title_type = '';
	$title = ''; 
	ob_start();
	if( is_category() ) {
		$title_type = esc_html__( 'Category', 'exponent' );
		$title = single_cat_title( '', false );
	} elseif( is_tag() ) {
		$title_type = esc_html__( 'Articles Tagged with', 'exponent' );
		$title = single_tag_title( '', false );
	} elseif ( is_search() ) {
		$title_type = esc_html__( 'Search Results', 'exponent' );
		$title = get_search_query();
	} elseif( ( is_tax( 'portfolio_categories' ) || is_tax( 'portfolio_tags' ) ) ) {
		$term =	$wp_query->queried_object;
		if(is_tax( 'portfolio_categories' )) {
			$title_type = esc_html__( 'Portfolio Category', 'exponent' );
			$title = $term->name;
		} else if( is_tax( 'portfolio_tags' ) ) { 
			$title_type = esc_html__( 'Portfolios Tagged with', 'exponent' );
			$title = $term->name;
		}else {
			$title_type = esc_html__( 'Portfolio Archives', 'exponent' );
		}
	}else if ( be_themes_is_woocommerce_activated() && ( is_woocommerce() || is_cart() || is_checkout() ) ) {
		$shop_title = be_themes_get_option( 'wc_enable_archive_title' );
		if( !empty( $shop_title ) ) {
			$title = woocommerce_page_title( false );
		}
	}else if( is_author() ) {
		$title_type = esc_html__( 'Posts by', 'exponent' );
		$title = get_the_author_meta( 'display_name' );
	}elseif( is_archive() ) {
		if ( is_day() ) {
			$title_type = esc_html__( 'Daily Archives', 'exponent' );
			$title = get_the_date();
		} elseif ( is_month() ) {
			$title_type = esc_html__( 'Monthly Archives', 'exponent' );
			$title = get_the_date( esc_html__( 'F Y', 'exponent' ) );
		} elseif ( is_year() ) {
			$title_type = esc_html__( 'Yearly Archives', 'exponent' );
			$title = get_the_date( esc_html__( 'F', 'exponent' ) );
		}else { 
			$title_type = esc_html__( 'Blog Archives', 'exponent' );
		}
	} else if( is_singular('portfolio') ) {
		$title_type = esc_html__( 'Portfolio', 'exponent' );
		if( !empty( $post_id ) ) {
			$title = get_the_title( $post_id );
		}
	}elseif( is_singular('post') ) {
		$title_type = esc_html__( 'Post', 'exponent' );
		if( !empty( $post_id ) ) {
			$title = get_the_title( $post_id );
		}
	} elseif( is_home() ) {
		$title = esc_html__( 'Blog', 'exponent' );
	} else if( !empty( $post_id ) ) {
		$title = get_the_title( $post_id );
	}
?>
	<?php if( !empty( $title ) ) : ?>
		<div class="<?php echo be_themes_get_class( 'post-entry-title-wrap' ); ?>">
			<?php if( !empty( $title_type ) ) : ?>
				<div class="<?php echo be_themes_get_class( 'post-entry-title-type' ); ?>">
					<?php echo esc_html( $title_type ); ?>
				</div>
			<?php endif; ?>
			<h1 class="<?php echo be_themes_get_class( 'post-entry-title' ); ?>">
				<?php echo esc_html( $title ); ?>
			</h1>
		</div>
	<?php endif; ?>
<?php
	$title_html = ob_get_clean();
	echo apply_filters( 'be_post_title', $title_html, $post_id );
?>