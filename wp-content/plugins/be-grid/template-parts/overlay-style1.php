<?php 
$cat_hide = (isset($cat_hide) && !empty($cat_hide) && intval($cat_hide) != 0) ? $cat_hide : 0;
$terms = be_get_taxonomies_by_id(get_the_ID(), 'portfolio_categories');
$length = 1;

$single_overlay_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_color', true );
$single_title_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_title_color', true );
$single_cat_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_cat_color', true );

$title_color = '';
$cat_color = '';

$overlay_color = be_compute_color($overlay_color);
$overlay_color = $overlay_color[1];
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
<div class="thumb-overlay ">
<div class="thumb-bg " >
    <div class="thumb-title-wrap ">
        <div class="thumb-title" <?php echo ( !empty($title_color) ? 'style="color:'. $title_color .';"' : '' ); ?> >
            <?php echo get_the_title(); ?>
        </div>
        <div class="portfolio-item-cats" <?php echo ( !empty($cat_color) ? 'style="color:'. $cat_color .';"' : '' ); ?> >
            <?php 
            if( !empty( $terms )&& ( isset( $cat_hide ) && !($cat_hide) ) ){
                foreach ($terms as $term) {
                    if( is_object($term) ) {
                        echo '<span>'.$term->name.'</span>';
                        if(count($terms) != $length) {
                            echo '<span> &middot; </span>';
                        }
                    }
                    $length++;
                }
            }
            ?>
        </div>
    </div>
    <div class = "thumb-border-wrapper" style="border-color:<?php echo $overlay_color; ?>;"  ></div>
</div>
</div>