<?php
$cat_hide = (isset($cat_hide) && !empty($cat_hide) && intval($cat_hide) != 0) ? $cat_hide : 0;
$terms = be_get_taxonomies_by_id(get_the_ID(), 'portfolio_categories');
$length = 1;
$title_cats_alignment = !empty( $title_cats_alignment ) ? $title_cats_alignment : 'left';

$single_overlay_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_color', true );
$single_title_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_title_color', true );
$single_cat_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_cat_color', true );

$title_color = '';
$cat_color = '';
$overlay_color = '';
if(isset($single_title_color) && !empty($single_title_color)) {
   $title_color = $single_title_color;
}
if(isset($single_cat_color) && !empty($single_cat_color)) {
   $cat_color = $single_cat_color;
}
if( isset( $single_overlay_color ) && !empty( $single_overlay_color ) ){
   $overlay_color = $single_overlay_color;
}


?>

<div class="thumb-bg thumb-alignment-<?php echo $title_cats_alignment; ?>" <?php echo ( !empty($overlay_color) ? 'style="background:'. $overlay_color .';"' : '' ); ?>  >
<div class="thumb-title-wrap">
    <?php if( !empty( $terms )&& ( isset( $cat_hide ) && !($cat_hide) ) ) : ?>
    <div class="portfolio-item-cats" <?php echo ( !empty($cat_color) ? 'style="color:'. $cat_color .';"' : '' ); ?> >
       <div class = "portfolio-item-cats-inner-wrap">
           <?php
               foreach ($terms as $term) {
                   if( is_object($term) ) {
                       echo '<span>'.$term->name.'</span>';
                       if(count($terms) != $length) {
                           echo '<span> &middot; </span>';
                       }
                   }
                   $length++;
               }
           ?>
       </div>
   </div>
    <?php endif; ?>
   <div class="thumb-title" <?php echo ( !empty($title_color) ? 'style="color:'. $title_color .';"' : '' ); ?> >
       <div class = "thumb-title-inner-wrap">
       <?php echo get_the_title(); ?>
       </div>
   </div>
   <div class="thumb-animated-link">
        <div class = "thumb-animated-link-text">
        <?php echo __( 'Learn More', 'be-grid' ); ?>
        </div>
        <div class = "thumb-animated-link-arrow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px" height="15px" viewBox="0 0 30 18" enable-background="new 0 0 30 18" xml:space="preserve">
            <path class="tatsu-svg-arrow-head" d="M20.305,16.212c-0.407,0.409-0.407,1.071,0,1.479s1.068,0.408,1.476,0l7.914-7.952c0.408-0.409,0.408-1.071,0-1.481
                l-7.914-7.952c-0.407-0.409-1.068-0.409-1.476,0s-0.407,1.071,0,1.48l7.185,7.221L20.305,16.212z"></path>
            <path class="tatsu-svg-arrow-bar" fill-rule="evenodd" clip-rule="evenodd" d="M1,8h28.001c0.551,0,1,0.448,1,1c0,0.553-0.449,1-1,1H1c-0.553,0-1-0.447-1-1
                C0,8.448,0.447,8,1,8z"></path>
            </svg>
        </div>
   </div>
</div>
</div>