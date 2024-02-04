<?php
    $blog_style = exponent_get_post_loop_prop( 'style' );
    $list_styles = array( 'style1', 'style4' );

    if( !in_array( $blog_style, $list_styles ) ) :
?>
    </div> <!-- End Row -->
    </div> <!-- End Row Wrap -->
<?php
    endif;
?>
    </div> <!-- End posts loop -->