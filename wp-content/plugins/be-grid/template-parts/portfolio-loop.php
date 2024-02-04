<?php
$target = ("1" == get_post_meta( get_the_ID(), 'be_themes_portfolio_open_new_tab', true )) ? 'target="_blank"' : '';

$is_double_width = get_post_meta(get_the_ID(), 'be_themes_double_width', true);
$is_double_height = get_post_meta(get_the_ID(), 'be_themes_double_height', true);
$lazy_load = (isset($lazy_load) && !empty($lazy_load) && intval($lazy_load) != 0) ? $lazy_load : 0;
$masonry_enable = ((!isset($masonry)) || empty($masonry)) ? '0' : '1';
$filter_to_use = ((!isset($filter)) || empty($filter)) ? 'categories' : $filter;

if( $prebuilt_hover_style === 'style5' ){
    $masonry_enable = '1';
}

$aspect_ratio = '1.6';
$aspect_ratio = apply_filters('portfolio_aspect_ratio', $aspect_ratio);

$placeholder_padding = ( 1/$aspect_ratio ) * 100;

$double_prop_class = (   "1" === $is_double_width && "1" === $is_double_height ? 'be-double-width-height-cell' :  ("1" === $is_double_width ? 'be-double-width-cell' : ("1" === $is_double_height ? "be-double-height-cell" : '') ) );
$is_not_ajax = !( wp_doing_ajax() || ( defined('REST_REQUEST') && REST_REQUEST ) || isset($_GET['tatsu']) ) ? 1 : 0;

$attachment_id = get_post_thumbnail_id(get_the_ID());
$image_atts = be_get_portfolio_image(get_the_ID(), $col, $masonry_enable);
$attachment_thumb = wp_get_attachment_image_src( $attachment_id, $image_atts['size']);
$attachment_full = wp_get_attachment_image_src( $attachment_id, 'full');
$attachment_thumb_url = $attachment_thumb[0];
$attachment_full_url = $attachment_full[0];
$attachment_info = be_wp_get_attachment($attachment_id);
$link_to = get_post_meta( get_the_ID(), 'be_themes_portfolio_link_to', true );

$portfolio_page_style = get_post_meta( get_the_ID(), 'be_themes_portfolio_single_page_style', true );

$video_url = get_post_meta( $attachment_id, 'be_themes_featured_video_url', true );
if(!empty( $video_url ) ) {
    $attachment_full_url = $video_url;
}
$permalink = '';
$filter_classes = array();
$visit_site_url = get_post_meta( get_the_ID(), 'be_themes_portfolio_external_url', true );
if(!isset($visit_site_url) || empty($visit_site_url)) {
    $visit_site_url = '#';
}
$permalink = ( $link_to == 'external_url' ) ? $visit_site_url : get_permalink();
$post_terms = get_the_terms( get_the_ID(), $filter_to_use );
if( $show_filters == '1' && is_array( $post_terms ) ) {
    foreach ( $post_terms as  $term ) {
        //$filter_classes .=$term->slug." ";
        array_push( $filter_classes, $term->slug );
    }
} else{
    $filter_classes=array();
}
$masonry_aspect_ratio = '';
if( '0' !== $masonry_enable ) {			
    $masonry_aspect_ratio = round( $attachment_full[ 1 ]/$attachment_full[ 2 ], 2 );
    $placeholder_padding = ( $attachment_full[ 2 ]/$attachment_full[ 1 ] ) * 100;
}
$terms = be_get_taxonomies_by_id(get_the_ID(), 'portfolio_categories');

if( ( $link_to != 'external_url' ) && isset($portfolio_page_style) && $portfolio_page_style == 'lightbox-gallery') {
    $thumb_class = 'mobx';
} else if( ( $link_to != 'external_url' ) && isset($portfolio_page_style) && $portfolio_page_style == 'lightbox') {
    $thumb_class = 'mobx';
} else if( ( $link_to != 'external_url' ) && isset($portfolio_page_style) && $portfolio_page_style == 'none') {
    $thumb_class = 'no-link';
    $attachment_full_url = '#';
} else {
    $thumb_class = '';
    $attachment_full_url = $permalink;
}
?>
<div class="portfolio-item be-col <?php echo $double_prop_class; ?> " data-category-names = <?php echo json_encode( $filter_classes ); ?>   >
    <div class="portfolio-item-inner" >
 
            <a href="<?php echo $attachment_full_url; ?>" data-thumb="<?php echo $attachment_thumb_url; ?>"  <?php echo ('lightbox' !== $portfolio_page_style ? ( 'data-rel= "my-gallery'. get_the_ID() . '"' ) : ''); ?> class="portfolio-thumb-wrap portfolio-thumb-img-wrap <?php echo $thumb_class; ?>" title="<?php echo $attachment_info['title']; ?>" <?php echo $target; ?> >
            <div class="portfolio-thumb" >
                <div class=" be-grid-placeholder" style="padding-bottom:<?php echo $placeholder_padding.'%'; ?> ;" data-aspect-ratio="<?php echo $masonry_aspect_ratio; ?>" >
                    <img <?php echo ($lazy_load &&  $is_not_ajax ? "class='be-lazy-load'" : ""); ?> <?php echo  ( $lazy_load && $is_not_ajax ? 'data-src="'.$attachment_thumb_url : 'src="'.$attachment_thumb_url ); ?>" alt="<?php echo $attachment_info['alt'] ?>" />
                </div>
            </div>
                <?php be_grid_portfolio_get_template_part( 'overlay', $prebuilt_hover_style, $values ); ?>
</a>
    </div>
</div>
<?php
if(isset($portfolio_page_style) && $portfolio_page_style == 'lightbox-gallery') :
?>    
    <div class="popup-gallery">
<?php
    $attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
    if(!empty($attachments)) {
        foreach ( $attachments as $attachment_id ) {
            $attach_img = wp_get_attachment_image_src($attachment_id, 'full');
            $video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
            $attachment_info = be_wp_get_attachment($attachment_id);
            $url = $attach_img[0];

            if($video_url) {
                $gdpr_atts = '{}';
				$gdpr_concern_selector = '';
                $url = $video_url;
                $gdpr_key = be_uniqid_base36(true);
                $gdpr_data_atts = '';

                $video_details_large = be_get_video_details($url,'large');
                $video_details_small = be_get_video_details($url,'small');

                if( function_exists( 'be_gdpr_privacy_ok' ) ){
					
                    if( !empty($_COOKIE) ){
                        if( !be_gdpr_privacy_ok($video_details_large['source'])  ){
                            $url = '#gdpr-alt-lightbox-'.$gdpr_key ;
                            $gdpr_data_atts = 'data-type="HTML"';
                        }
                    }else{

                        $gdpr_atts = array(
                            'concern' => $video_details_large[ 'source' ],
                            'add' => array( 
                                'atts'	=> array( 'href' => '#gdpr-alt-lightbox-'.$gdpr_key,
                                                  'data-type' => 'HTML' ),
                            ),
                        );

                        $gdpr_concern_selector = 'be-gdpr-consent-required';
                        $gdpr_atts = json_encode( $gdpr_atts );

                    }
                    echo be_gdpr_lightbox_for_video($gdpr_key,$video_details_large["thumb_url"],$video_details_large['source']);
                }
            
                echo '<a href="'.$url.'" data-rel="my-gallery'.get_the_ID().'" class="mobx" data-poster="'.$video_details_large['thumb_url'].'" data-thumb="'.$video_details_small['thumb_url'].'" title="'.$attachment_info['title'].'" '. $gdpr_data_atts .'></a>';
            } else {
                echo '<a href="'.$url.'" data-rel="my-gallery'.get_the_ID().'" data-thumb="'. $url .'" class="mobx" title="'.$attachment_info['title'].'"></a>';
            }
        }
    }
    echo '</div>'; //End Gallery
endif;

?>