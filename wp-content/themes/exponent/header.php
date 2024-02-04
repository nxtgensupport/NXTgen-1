<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
	<?php 
    	if ( is_singular() ) { 
    		wp_enqueue_script( 'comment-reply' );
    	}
    	wp_head(); 
    ?>
</head>
<body <?php body_class(); ?> data-be-page-template = '<?php echo basename(get_page_template(),".php"); ?>' >	
	<?php
		do_action( 'be_themes_before_body' );
		do_action( 'tatsu_print_header' );
		$header_enabled = be_themes_get_option( 'enable_header' );
		//Get Site Logo
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if( $custom_logo_id ) {
			$exp_logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		}
		//Print Header
		if( 'page-templates/page_blank.php' !== get_page_template_slug() && ( !isset( $header_enabled ) || ( isset( $header_enabled ) && $header_enabled ) ) ) {?>
			<div id="exponent-header-container" >
				<div id="exponent-header-wrap" > 
					<div class="exponent-header">
						<div class="exponent-header-row exponent-wrap">
							<div class="exponent-header-column left" >
								<div class="exponent-header-logo ">
									<a href=" <?php echo esc_url( home_url() ); ?> ">
										<?php if( !empty( $exp_logo[0] ) ) : ?>
											<img src = "<?php echo esc_url( $exp_logo[0] ); ?>" />
										<?php else: 
											echo '<span>'.get_bloginfo( 'name' ).'</span>';	
											endif;
										?>
									</a>
								</div>
							</div>
							<div class="exponent-header-column right" >
								<?php exponent_print_main_nav() ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}?>