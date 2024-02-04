<?php
/**
 * The template for displaying quick view.
 */

defined( 'ABSPATH' ) || exit;
global $product, $post;
do_action( 'exponent_wc_before_quickview', $product );
?>
<div class="<?php echo be_themes_get_class( 'wc-quickview-wrap' ); ?>">
    <div class="<?php echo be_themes_get_class( 'wc-quickview-overlay' ); ?>">
    </div>
    <div class="<?php echo be_themes_get_class( 'wc-quickview' ); ?>">
        <div class="<?php echo be_themes_get_class( 'wc-quickview-gallery' ); ?>">
            <?php 
                do_action( 'exponent_wc_quickview_product_slider', $product );
            ?>
        </div>
        <div class="<?php echo be_themes_get_class( 'wc-product-info' ); ?>">
            <?php
                do_action( 'exponent_wc_quickview_product_summary', $product );
            ?>
        </div>
        <?php
            do_action( 'exponent_wc_after_quickview_product_summary', $product );
        ?>
        <div class="<?php echo be_themes_get_class( 'wc-close-quickview' ); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"/></svg>
        </div>
    </div>
</div>
<?php 
    do_action( 'exponent_wc_after_quickview' );
?>