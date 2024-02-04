<?php

namespace greenshiftwoo\Blocks;
defined('ABSPATH') OR exit;

class ProductComparison{

	public function __construct(){
		add_action('init', array( $this, 'init_handler' ));
	}

	public function init_handler(){
		register_block_type(__DIR__, array(
			'attributes' => $this->attributes,
			'render_callback' => array( $this, 'render_block' ),
		));
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
		'selectedPostId' => array(
			'type'    => 'string',
			'default' =>''
		),
		'postId'      => array(
			'type'    => 'number',
		),
		'type' => array(
            'type' => 'string',
            'default'=> 'button'
        ),
        'icontype' => array(
            'type'=>'string',
            'default'=> 'balance'
        ),
        'comparisonadd' => array(
            'type'=>'string',
			'default'=>'Add to compare'
        ),
        'comparisonadded' => array(
            'type'=>'string',
			'default'=>'Added to compare'
        ),
        'loginpage' => array(
            'type'=>'string',
			'default'=>''
        ),
        'comparisonpage' => array(
            'type'=>'string',
			'default'=>''
        ),
        'noitemstext' => array(
            'type'=>'string',
			'default'=>'There is nothing in your comparison'
        ),
        'table_type' => array(
            'type'=>'string',
            'default'=>'dynamically_created'
        ),
        'predefined_by' => array(
            'type'=>'string',
            'default'=>'product_ids'
        ),
        'productsIds' => array(
            'type'=>'array',
            'default'=>[]
        ),
        'categoryId' => array(
            'type'=>'string',
            'default'=>''
        ),
        'tagId' => array(
            'type'=>'string',
            'default'=>''
        ),
        'disable_fields' => array(
            'type' => 'object',
            'default' => [
                'description' => false,
                'brand' => false,
                'stock' => false,
                'userrate' => false,
            ],
        ),
        'additional_shortcode' => array(
            'type'=>'string',
            'default'=>''
        ),
        'additional_shortcode_label' => array(
            'type'=>'string',
            'default'=>''
        ),
        'search_button' => array(
            'type'=>'boolean',
            'default'=>false
        ),
        'align' => array(
			'type' => 'string',
		),
	);

	public function render_block($settings = array(), $inner_content = ''){
		extract($settings);
		$out = $postId = '';
		if($selectedPostId){
			$postId = (int)$selectedPostId;
		}else{
			if(empty($postId)){
				global $post;
                if(is_object($post)){
                    $postId = $post->ID;
                }
			}
		}
		$blockId = 'gspb_id-'.$id;
        $alignClass = '';
        if (isset($align)) {
			if ($align == 'full') {
				$alignClass = ' alignfull';
			} elseif ($align == 'wide') {
				$alignClass = ' alignwide';
			} elseif ($align == '') {
				$alignClass = '';
			}
		}

		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'class' => $blockId . $alignClass . ' gspb_comparecounter',
			)
		);

		$out .= '<div '.$wrapper_attributes.gspb_AnimationRenderProps($animation).'>
		'.gspb_query_comparison(array('type'=>$type,'icon'=>$inner_content, 'post_id'=>$postId, 
		'comparisonadd'=>$comparisonadd, 'comparisonadded'=>$comparisonadded, 'comparisonpage'=>$comparisonpage,'loginpage'=>$loginpage,'noitemstext'=>$noitemstext, 'table_type' => $table_type, 'predefined_by' => $predefined_by, 'productsIds' => $productsIds, 'categoryId' => $categoryId, 'tagId' => $tagId, 'disable_fields' => $disable_fields, 'additional_shortcode' => $additional_shortcode, 'additional_shortcode_label' => $additional_shortcode_label, 'searchbtn' => $search_button)).'
		</div>';

		return $out;
	}

}

new ProductComparison;