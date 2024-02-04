<?php

    $bundle_class = new GREENSHIFT_WOO_BUNDLE_WC_Custom_Bundles();

    // If product variable but not have any variation price not show
    if ( $product->is_type( 'variable' ) && ! $product->has_child() ) {
        return;
    }
    // Ensure visibility + if not in stock
    if ( empty( $product ) || ! $product->is_visible() ) {
        return;
    }

?>
<div class="gspbwoo-product-outer-main product-<?php echo (int)$product->get_id();?>">
    <div class="product-outer ">
        <div class="product-inner">
            <div class="product-content">
                <?php
                    if ( isset( $settings['show_category'] ) && $settings['show_category'] ) {
                            $bundle_class->custom_template_loop_categories();
                        }
                    ?>
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="blackcolor">
                    <div class="woocommerce-loop-product__title fontbold lineheight20 mb10">
                        <?php echo wp_kses_post( $product->get_title() ); ?></div>
                </a>
            </div>
            <div class="product-thumbnail mb10">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                    <?php echo wp_kses_post( $product->get_image( 'shop_catalog' ) ); ?>
                </a>
            </div>
            <?php $bundle_class->custom_bundles_price( $main_product_id=$product_id, $id = $product->get_id() );?>
        </div>
    </div>
</div>