<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductQuickView{

    public function __construct(){
        add_action('init', array( $this, 'init_handler' ));
    }

    public function init_handler(){
        register_block_type(__DIR__, array(
                'render_callback' => array( $this, 'render_block' ),
                'attributes'      => $this->attributes
            )
        );
    }

    public $attributes = array(
        'id' => array(
            'type'    => 'string',
            'default' => null,
        ),
        'inlineCssStyles' => array(
            'type'    => 'string',
            'default' => '',
        ),
        'animation' => array(
            'type' => 'object',
            'default' => array(),
        ),
        'sourceType'       => array(
            'type'    => 'string',
            'default' => 'latest_item',
        ),
        'label'       => array(
            'type'    => 'string',
            'default' => '',
        ),
        'postfix'       => array(
            'type'    => 'string',
            'default' => '',
        ),
        'postId'       => array(
            'type'    => 'number',
            'default' => 0,
        ),
    );

    public function render_block($settings = array(), $inner_content=''){
        extract($settings);

        global $product;

        if(!empty($product)) {
            $product_content = $this->get_product_quick_view_content();
        } else {

            if(!empty($postId)) {
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 1,
                    'post__in' => [$postId]
                );
            } else {
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 1,
                    'orderby' =>'date',
                    'order' => 'DESC'
                );
            }

            $loop = new \WP_Query( $args );
            if ( $loop->have_posts() ) {
                while ( $loop->have_posts() ) : $loop->the_post();
                    $product_content = $this->get_product_quick_view_content();
                endwhile;
            } else {
                return __('Product not found.', 'greenshiftwoo');
            }
            wp_reset_postdata();
        }

        $blockId = 'gspb-product-quick-view-box-id-'.$id;
        $blockClassName = 'gspb-product-quick-view-box-wrapper '.$blockId.' '.(!empty($className) ? $className : '').'';
        $out = '<div class="'.$blockClassName.'"'.gspb_AnimationRenderProps($animation).'>';
            $out .= '<div class="gspb-product-quick-view-popup">';
                $out .= '<div class="gspb-product-quick-view-popup-inner">';
                $out .= '<span class="gspb-product-quick-view-close">×</span>';
                $out .= $product_content;
                $out .= '</div>';
            $out .= '</div>';
            $out .= $inner_content;
        $out .='</div>';

        return $out;
    }

    public function get_product_quick_view_content() {

        global $product;

        if($product !== null) {
            wp_enqueue_script( 'wc-single-product' );
            wp_enqueue_script( 'wc-add-to-cart-variation' );

            ob_start();
            /**
             * Hook: woocommerce_before_single_product.
             *
             * @hooked woocommerce_output_all_notices - 10
             */
            do_action( 'woocommerce_before_single_product' );

            if ( post_password_required() ) {
                echo get_the_password_form(); // WPCS: XSS ok.
                return;
            }
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
            add_action('woocommerce_single_product_summary', [$this, 'quick_view_template_rating'], 9);
            ?>
            <div class="woocommerce">
                <div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
                    
                    <?php echo do_blocks('<!-- wp:greenshift-blocks/product-gallery {"id":"gsbp-edffd978-1c8b","inlineCssStyles":".gspb-product-image-gallery-wrap{width:100%}.gspb-gallery-full{width:100%}.gspb-gallery-thumb{box-sizing:border-box;width:100%}.gspb-gallery-thumb .swiper-slide{width:25%;height:100%;opacity:.4;}.gspb-gallery-thumb .swiper-slide-thumb-active{opacity:1}.gspb-product-image-gallery .swiper-slide img{width:100%;height:100%;object-fit:cover}.gspb_id-gsbp-edffd978-1c8b .gspb-product-image-gallery-wrap{max-width:400px;}.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-full img{object-fit:scale-down;}.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-thumb img{object-fit:scale-down;}.gspb_id-gsbp-edffd978-1c8b, .gspb_id-gsbp-edffd978-1c8b .gspb-product-image-gallery-wrap{display:flex;flex-wrap:wrap;justify-content:center;align-items:flex-start}.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-full{display:flex;align-items:center;flex-wrap:wrap;justify-content:center;}.gspb_id-gsbp-edffd978-1c8b .gspb-product-image-gallery-wrap{gap:1px;}@media (max-width: 991.98px){.gspb_id-gsbp-edffd978-1c8b .gspb-product-image-gallery-wrap{gap:1px;}}@media (max-width: 767.98px){.gspb_id-gsbp-edffd978-1c8b .gspb-product-image-gallery-wrap{gap:1px;}}@media (max-width: 575.98px){.gspb_id-gsbp-edffd978-1c8b .gspb-product-image-gallery-wrap{gap:1px;}}.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-thumb{height:100px;}@media (max-width: 991.98px){.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-thumb{height:100px;}}@media (max-width: 767.98px){.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-thumb{height:100px;}}@media (max-width: 575.98px){.gspb_id-gsbp-edffd978-1c8b .gspb-product-image-gallery-wrap{max-width:100%; overflow:hidden}.gspb_id-gsbp-edffd978-1c8b .swiper-wrapper, .gspb_id-gsbp-edffd978-1c8b .gspb-product-image-gallery-wrap, .gspb_id-gsbp-edffd978-1c8b .swiper{min-width:0px}.gspb_id-gsbp-edffd978-1c8b .swiper{display:grid !important}.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-thumb{height:100px;}}.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-full{height:400px;}@media (max-width: 991.98px){.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-full{height:400px;}}@media (max-width: 767.98px){.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-full{height:400px;}}@media (max-width: 575.98px){.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-full{height:300px;}}.gspb_id-gsbp-edffd978-1c8b .gspb-gallery-full.gspb-gallery-no-slider{width:100% !important;}.gspb_id-gsbp-edffd978-1c8b .swiper-button-prev, .gspb_id-gsbp-edffd978-1c8b .swiper-button-next{width:38px;height:38px;line-height:38px;}.gspb_id-gsbp-edffd978-1c8b .swiper-button-prev{background-color:#ffffff;top:40%;left:10px;box-shadow:20px 20px 60px #58667d5e;border-radius:99px;}.gspb_id-gsbp-edffd978-1c8b .swiper-button-next{background-color:#ffffff;top:40%;right:10px;box-shadow:20px 20px 60px #58667d5e;border-radius:99px;}.gspb_id-gsbp-edffd978-1c8b .swiper-button-prev:after, .gspb_id-gsbp-edffd978-1c8b .swiper-button-next:after{font-size:14px;}","align":"center","loading":false,"max_height_of_main_image":[400,400,400,300],"slidesPerView":[4,4,4,4],"spaceBetween":[15,10,10,10],"verticalSize":[20,20,20,15],"scale":"scale-down","scalethumbnail":"scale-down","navradius":99,"navigationarrows":true,"navSize":[14,null,null,null],"navSpaceSize":[12,null,null,null], "disableAttachments": "true"} /-->');?>

                   

                    <div class="summary entry-summary">
                        <?php
                        /**
                         * Hook: woocommerce_single_product_summary.
                         *
                         * @hooked woocommerce_template_single_title - 5
                         * @hooked woocommerce_template_single_rating - 10
                         * @hooked woocommerce_template_single_price - 10
                         * @hooked woocommerce_template_single_excerpt - 20
                         * @hooked woocommerce_template_single_add_to_cart - 30
                         * @hooked woocommerce_template_single_meta - 40
                         * @hooked woocommerce_template_single_sharing - 50
                         * @hooked WC_Structured_Data::generate_product_data() - 60
                         */
                        ob_start();
                        do_action( 'woocommerce_single_product_summary' );
                        $summary = ob_get_contents();
                        $summary = str_replace('<h1', '<h2', $summary); // Replace <h1 with <h2
                        $summary = str_replace('</h1>', '</h2>', $summary); // Replace </h1> with </h2>
                        ob_get_clean();
                        echo ''.$summary;
                        ?>

                        <a href="<?php echo get_permalink($product->get_id())?>" class="gspb-link-full-page"><?php echo __('Open full product page', 'greenshiftwoo')?></a>
                    </div>
                </div>
            </div>

            <?php
            $html = ob_get_contents();
            ob_get_clean();
        } else $html = __('Product not found.', 'greenshiftwoo');

        return $html;
    }

    public function quick_view_template_rating() {
        if ( post_type_supports( 'product', 'comments' ) ) {
            include GREENSHIFTWOO_DIR_PATH .'inc/templates/quick-view/rating.php';
        }
    }
}

new ProductQuickView;