<?php
    $be_pb_class = '';
	$single_portfolio_style = get_post_meta(get_the_ID(), 'be_themes_portfolio_single_page_style', true);
	if( 'fixed-left' == $single_portfolio_style ) {
		$single_portfolio_class = 'left';
		$fix_sidebar_to = 'right';
	}else{
		$single_portfolio_class = 'right';
		$fix_sidebar_to = 'left';
	}
	if( !function_exists( 'is_edited_with_tatsu' ) || !is_edited_with_tatsu( get_the_ID() ) ) {
		$be_pb_class = 'no-page-builder';
		get_template_part( 'page-breadcrumb' );
	}
    if ( post_password_required() ) :
        $content  = get_the_password_form();
        echo '<div class="be-wrap clearfix be-password-protect-wrap">'.$content.'</div>';
	else :
?>
<div id="content" class="be-content-overflow fixed-sidebar-page <?php echo esc_attr( $single_portfolio_class);?>-fixed-page">	
	<div id="content-wrap" class="tatsu-wrap <?php echo esc_attr($be_pb_class); ?> clearfix">
		<div class="be-content-overflow-inner-wrap">
	        <div id="be-overflow-image-content" class="content-single-sidebar" >
	            <div id="be-overflow-image-content-inner">
	                <?php
	                    $attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
						if(!empty($attachments)) {
							$count = 1;
							foreach ( $attachments as $attachment_id ) {
								$attach_img = wp_get_attachment_image_src($attachment_id, 'full');
								$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
								$attachment_info = be_wp_get_attachment( $attachment_id );
								if($video_url) {
									$data_source = 'video';
								} else {
									$data_source = $attach_img[0];
								}
								if($count == count($attachments)) {
									$class = 'margin-bottom-0';
									$image_padding = '0';
								} else {
									$class = '';
								}
								echo '<p class="be-animate">';
								if($video_url) {

									$video_details = be_get_video_details( $video_url );
									$output = '';
									if( !function_exists( 'be_gdpr_privacy_ok' ) ){
										$output .= '<div class=" tatsu-video tatsu-youtube-wrap" data-gdpr-concern="'. esc_attr( $video_details['source'] ) .'" >';
										if( $video_details['source'] === 'youtube' ){
											$output .= tatsu_youtube( $video_url );
										} elseif( $video_details['source'] === 'vimeo' ){
											$output .= tatsu_vimeo( $video_url );
										}
										$output .= '</div>';
									}else{
										if ( !empty( $_COOKIE ) ) {
											if( !( be_gdpr_privacy_ok( $video_details['source'] ) )  ){
												$output .= '<div class=" tatsu-video tatsu-youtube-wrap" data-gdpr-concern="'. esc_attr( $video_details['source'] ).'" >';
												$output .= '<div class="gdpr-alt-image"><img src="'.esc_url( $video_details['thumb_url'] ).'"/><div class="gdpr-video-alternate-image-content" >'. shortcode_exists( 'be_gdpr_api_name' ) ? do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="'.esc_attr( $video_details['source'] ).'" ]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ) ) ) : '' .'</div></div>';
												$output .= '</div>';
											} else {
												$output .= '<div class=" tatsu-video tatsu-youtube-wrap be-gdpr-consent-required" data-gdpr-concern="'. esc_attr( $video_details['source'] ).'" >';
												if( $video_details['source'] === 'youtube' ){
													$output .= tatsu_youtube( $video_url );
												} elseif( $video_details['source'] === 'vimeo' ){
													$output .= tatsu_vimeo( $video_url );
												}
												$output .= '</div>';
											}
									
										}else{
											$output .= '<div class=" tatsu-video tatsu-youtube-wrap be-gdpr-consent-required '.$unique_class_name.'" data-gdpr-concern="'. esc_attr( $video_details['source'] ).'" >';
											if( $video_details['source'] === 'youtube' ){
												$output .= tatsu_youtube( $video_url );
											} elseif( $video_details['source'] === 'vimeo' ){
												$output .= tatsu_vimeo( $video_url );
											}
											$output .= '</div>';
											
											$output .= '<div class=" tatsu-video tatsu-youtube-wrap be-gdpr-consent-message">';
											$output .= '<div class="gdpr-alt-image"><img src="'.esc_url( $video_details['thumb_url'] ).'"/><div class="gdpr-video-alternate-image-content" >'. shortcode_exists( 'be_gdpr_api_name' ) ? do_shortcode( str_replace('[be_gdpr_api_name]','[be_gdpr_api_name api="'.esc_attr( $video_details['source'] ).'" ]', get_option( 'be_gdpr_text_on_overlay', 'Your consent is required to display this content from [be_gdpr_api_name] - [be_gdpr_privacy_popup]' ) ) ) : '' .'</div></div>';
											$output .= '</div>';
										}
									}


									echo wp_kses_post( $output );
								} else {
									echo '<img class="exp-lazy-load" data-src="'.esc_url( $data_source ).'" style="display: block;" alt="'.esc_attr( $attachment_info['alt'] ).'"/>';
								}
								echo '</p>';
								$count++;
							}
						}
	                ?>
	            </div>
			</div>
			<div id="<?php echo esc_attr( $fix_sidebar_to );?>-sidebar-wrapper" >
				<div id="<?php echo esc_attr( $fix_sidebar_to );?>-sidebar" class="clearfix fixed-sidebar be-sticky-column">
					<div class="fixed-sidebar-content">
						<div class="fixed-sidebar-content-inner simplebar">
							<div class="simplebar-content">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<?php
    endif;
	if( get_theme_mod('portfolio_navigation_in_all_items', false) && shortcode_exists( 'be_portfolio_navigation' ) ){
		echo '<div class="be-single-portfolio-navigation-wrap" ><div class="exp-wrap" >';
		echo do_shortcode( '[be_portfolio_navigation title_align= "center" nav_links_color= "" animate= "0" animation_type= "fadeIn"][/be_portfolio_navigation]' );
		echo '</div></div>';
	} 
	
	if ( !function_exists('tatsu_youtube') ) {
		function tatsu_youtube( $url ) {
			$video_id = '';
			if( ! empty( $url ) ) {
				$video_id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match ) ) ? $match[1] : '' ;		
				return '<div class="be-youtube-embed" data-video-id="' . esc_attr( $video_id ). '"></div>';		
			} else {
				return '';
			}
	
		}
	}
	
	/**************************************
				VIDEO - VIMEO
	**************************************/
	if ( !function_exists( 'tatsu_vimeo' ) ) {
		function tatsu_vimeo( $url ) {
			$video_id = '';
			if( ! empty( $url ) ) {
				sscanf(parse_url($url, PHP_URL_PATH), '/%d', $video_id);
				return '<div class="be-vimeo-embed" data-video-id="' . esc_attr( $video_id ). '"></div>';
			} else {
				return '';
			}
		}
	}
?>