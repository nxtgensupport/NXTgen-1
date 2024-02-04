<?php
	$post_id = be_themes_get_page_id();
	$footer_enabled = be_themes_get_option( 'enable_footer' );
	$footer_content = be_themes_get_option( 'footer_content' );
	$footer_widget_enabled = be_themes_get_option( 'enable_footer_widgets' )  ;
	$col_class = "one-fourth";
	$i = 4;
	$active_sidebar = false;

	for($j = 1; $j <= $i; $j++) {
		if ( is_active_sidebar( 'footer-widget-'.$j ) ) {
			$active_sidebar = true;
			break;
		}
	}

	do_action( 'tatsu_footer' );

    do_action( 'be_themes_before_footer_widgets' );
	// Footer Widget Area
	if( $active_sidebar ) {
		if( !isset( $footer_widget_enabled ) || ( isset( $footer_widget_enabled ) && $footer_widget_enabled ) ) { ?>
		<footer id="bottom-widgets">
			<div id="bottom-widgets-wrap" class="be-wrap be-row clearfix">
				<?php for($j = 1; $j <= $i; $j++) : ?>
					<div class="exponent-footer-column">
						<?php 
							if ( is_active_sidebar( 'footer-widget-'.$j ) ) {
								dynamic_sidebar( 'footer-widget-'.$j );
							}
						?>
					</div>
				<?php endfor; ?>	
			</div>
		</footer>
	<?php } 
	}
	
	// Footer
	do_action( 'tatsu_print_footer' );

    do_action('be_themes_before_footer'); 
	if( !isset( $footer_enabled ) || ( isset( $footer_enabled ) && $footer_enabled ) ) { ?>
		<footer id="footer" class = "<?php echo be_themes_get_class('wrap'); ?>">		
				<?php echo !empty( $footer_content ) ? $footer_content : ''; ?>
		</footer> 
	<?php
	}
    do_action('be_themes_after_footer'); 
    
    /** Back to top btn */
    $back_to_top_btn = '';
    $back_to_top = be_themes_get_option( 'back_to_top_btn' );
    if( !empty( $back_to_top ) ) {
        $back_to_top_icon = '<svg width="14" height="9" viewBox="0 0 14 9" xmlns="http://www.w3.org/2000/svg"><path d="M13 7.37329L7 2.00004L1 7.37329" stroke-width="2" stroke-linecap="round"/></svg>';
        echo apply_filters( 'be_themes_back_to_top_btn', sprintf( '<a href="#" id="be-themes-back-to-top">%s</a>', $back_to_top_icon ) );
    }
?>

<input type="hidden" id="ajax_url" value="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" />

<?php wp_footer(); ?>
<!-- Option Panel Custom JavaScript -->
</body>
</html>