<?php
    $grid_styles = array( 'style2', 'style3', 'style5', 'style6', 'style7' );
    $blog_style = be_themes_get_option( 'blog_archive_style' );
    $full_width = be_themes_get_option( 'blog_grid_full_width' );
    if( !in_array( $blog_style, $grid_styles ) || empty( $full_width ) ) :
?>  
    <div class="<?php echo be_themes_get_class( 'wrap' ); ?>">
<?php endif; ?>