<?php


namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;


class ProductRating{

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
        'ratingstyle'       => array(
            'type'    => 'string',
            'default' => 'stars',
        ),
		'innerPage' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'ratingLabel' => array(
			'type'    => 'string',
			'default' => 'customer review',
		),
		'ratingsLabel' => array(
			'type'    => 'string',
			'default' => 'customer reviews',
		),
	);

	public function render_block($settings = array(), $inner_content=''){
		extract($settings);

		if($sourceType == 'latest_item'){
			global $post;
			if(is_object($post)){
				if($post->post_type == 'product'){
					$postId = $post->ID;
				}else{
					$postId = 0;
				}
			}else{
				$postId = 0;
			}
		}else{
			$postId = (isset($postId) && $postId > 0) ? (int)$postId : 0;
		}

        $postfix = isset($postfix) ? esc_attr($postfix) : '';
        $label = isset($label) ? esc_attr($label) : '';
        $_product = gspbwoo_get_product_object_by_id($postId);

        if(!$_product) return __('Product not found.', 'greenshiftwoo');

        if($ratingstyle == 'number'){
            $rating = '<svg height="16" viewBox="0 0 512 512" width="16" xmlns="http://www.w3.org/2000/svg"><g><g><g><circle cx="256" cy="256" fill="orange" r="256"/></g></g><g><g><path d="m412.924 205.012c-1.765-5.43-6.458-9.388-12.108-10.209l-90.771-13.19-40.594-82.252c-2.527-5.12-7.742-8.361-13.451-8.361s-10.924 3.241-13.451 8.362l-40.594 82.252-90.771 13.19c-5.65.821-10.345 4.779-12.109 10.209s-.292 11.391 3.796 15.376l65.683 64.024-15.506 90.404c-.965 5.627 1.348 11.315 5.967 14.671 4.62 3.356 10.743 3.799 15.797 1.142l81.188-42.683 81.188 42.683c5.092 2.676 11.212 2.189 15.797-1.142 4.619-3.356 6.933-9.043 5.968-14.671l-15.506-90.404 65.682-64.024c4.088-3.986 5.559-9.947 3.795-15.377z" fill="white"/></g></g></g></svg><span>' . $_product->get_average_rating() . '</span>';
        }else{
            $rating = '<div class="star-rating" role="img">' . wc_get_star_rating_html( $_product->get_average_rating(), $_product->get_rating_count() ) . '</div>';
        }

		$blockId = 'gspb_id-'.$id;
		$commentcount = '';
		$blockClassName = 'gspb-ratingbox woocommerce '.$blockId.' '.(!empty($className) ? $className : '').'';
		if($innerPage && comments_open()){
			$review_count = $_product->get_review_count();
			$labelreview = $review_count > 1 ? $ratingsLabel : $ratingLabel;
			$commentcount = '<a href="#reviews" class="woocommerce-review-link">(<span class="count">' . esc_html( $review_count ) . '</span> '.$labelreview.')</a>';
		}

		$out = '<div class="'.$blockClassName.'"'.gspb_AnimationRenderProps($animation).'>';
            $out .= '<div class="gspb_rating_value">' . $rating . $commentcount .'</div>';
		$out .='</div>';
		return $out;
	}
}

new ProductRating;