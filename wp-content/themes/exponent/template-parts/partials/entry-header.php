<?php
    $wrap = get_query_var( 'be_entry_header_wrap', false );
    $entry_header_horizontal_pad = esc_attr( get_query_var( 'be_entry_header_horizontal_pad', false ) );

    $breadcrumbs = be_themes_get_breadcrumbs();
    
    //entry header styles
    $entry_header_style = '';
    //entry header pad
    if( !empty( $entry_header_horizontal_pad ) ) {
        $entry_header_horizontal_pad = "padding-left : {$entry_header_horizontal_pad}px;padding-right : {$entry_header_horizontal_pad}px";
    }else {
        $entry_header_horizontal_pad = "";
    }
    if( !empty( $entry_header_horizontal_pad ) ) {
        $entry_header_style = sprintf( 'style = "%s"', esc_attr( $entry_header_horizontal_pad ) );
    }
    $entry_header_row_class = 'be-row ' . be_themes_get_class( $wrap ? 'wrap' : '', !empty( $breadcrumbs ) ? 'has-breadcrumbs' : '' );
?>
<section class="<?php echo be_themes_get_class( 'entry-header' ); ?>" <?php echo !empty( $entry_header_style ) ? $entry_header_style : ''; ?>>
    <div class="<?php echo apply_filters( 'be_themes_breadcrumb_row_class', $entry_header_row_class ); ?>" >
        <?php do_action( 'be_before_entry_header' ); ?>
        <div class="<?php echo be_themes_get_class( 'title-breadcrumb-wrap' ); ?>">
            <?php get_template_part( 'template-parts/partials/title' ); ?>
            <?php
                /*Yoast and Rankmath breadcrumb with default theme breadcrumb*/
                if ( function_exists('yoast_breadcrumb') ) {
                    yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                }else if (function_exists('rank_math_the_breadcrumbs')) {
                    rank_math_the_breadcrumbs();
                }else{ 
                    echo wp_kses_post( $breadcrumbs ); 
                }
            ?>
        </div>
        <?php do_action( 'be_after_entry_header' ); ?>
    </div>
</section>