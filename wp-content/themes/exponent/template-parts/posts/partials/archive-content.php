<?php  
    $read_more_style = exponent_get_post_loop_prop( 'read_more' );
    $arrangement = exponent_get_post_loop_prop( 'arrangement' );
    $hide_content = exponent_get_post_loop_prop( 'hide_content' );
    if( empty( $hide_content ) ) :
?>
    <div class="clearfix <?php echo be_themes_get_class( 'post-content', 'post-content-read-more-' . $read_more_style ); ?>">
        <?php 
            if ( 'slider' === $arrangement || ( function_exists( 'edited_once_with_tatsu' ) && edited_once_with_tatsu( get_the_ID() ) ) ) {
                the_excerpt();
            }else {
                the_content();
            }
        ?>
    </div>
<?php  
    endif;