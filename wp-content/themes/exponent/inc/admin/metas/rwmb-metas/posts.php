<?php
    $posts_meta = array();
	$meta_prefix = be_themes_get_meta_prefix();
	extract( be_get_color_hub() );
	
    $posts_meta[] = array (
		'title' => 'Metro Style Post Thumbnail Options',
		'pages' => array( 'post' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array (
			array (
				'name'		=> __('Enable Double Width', 'exponent'),
				'id'   => "{$meta_prefix}blog_double_width",
				'type' => 'checkbox',
				'std'  => ''
			),
			array (
				'name'		=> __('Enable Double Height', 'exponent'),
				'id'   => "{$meta_prefix}blog_double_height",
				'type' => 'checkbox',
				'std'  => ''
			)
		)
	);
	
	$posts_meta[] = array (
		'title' => 'Archive Style 5',
		'pages' => array( 'post' ),
		'fields' => array (
			array (
				'name'		=> __('Box shadow color', 'exponent'),
				'id'   => "{$meta_prefix}blog_shadow_color",
				'type' => 'color',
				'alpha_channel'	=> true,
				'std'  => ''
			)
		)
	);
	
	$posts_meta[] = array (
		'title' => 'Featured Posts',
		'pages' => array( 'post' ),
		'fields' => array (
			array (
				'name'		=> __('Featured Post?', 'exponent'),
				'id'   => "{$meta_prefix}featured_post",
				'type' => 'checkbox',
				'std'  => ''
			)
		)
	);
	
	$posts_meta[] = array (
		'title'		=> 'Single Post Overrides',
		'pages'		=> array( 'post' ),
		'desc'		=> __( 'Overrides the single post options from customizer', 'exponent' ),
		'fields'	=> array (
			array (
				'name'		=> __( 'Enable Single Post Override', 'exponent' ),
				'id'		=> "{$meta_prefix}single_post_override",
				'type'		=> 'checkbox',
				'std'		=> '',
			),
			array (
				'name'		=> __( 'Add Metas on Featured Image', 'exponent' ),
				'id'		=> "{$meta_prefix}single_title_style",
				'type'		=> 'select',
				'options'	=> array (
					'wrap'	=> 'Wrapped',
					'wide'	=> 'Wide',
				),
				'visible'	=> array( "{$meta_prefix}single_post_override", '=', '1' ),
				'std'		=> 'wide',
			),
			array (
				'name'		=> __( 'Thumb Height', 'exponent' ),
				'id'		=> "{$meta_prefix}thumb_height",
				'type'		=> 'number',
				'std'		=> '60',	
				'visible'	=> array( "{$meta_prefix}single_post_override", '=', '1' ),
				'desc'		=> __( 'Value entered are in vh units', 'exponent' ),
			),
			array (
				'name'		=> __( 'Enable Related Posts', 'exponent' ),
				'id'		=> "{$meta_prefix}related_posts",
				'visible'	=> array( "{$meta_prefix}single_post_override", '=', '1' ),
				'type'		=> 'checkbox',
				'std'		=> '',
			),
			array (
				'name'		=> __( 'Related Posts Cols', 'exponent' ),
				'id'		=> "{meta_prefix}related_posts_cos",
				'type'		=> 'number',
				'visible'	=> array( "{$meta_prefix}single_post_override", '=', '1' ),
				'std'		=> '',
			)
		)
	);

	$posts_meta[] = array (
		'title'		=> __( 'Video Post Format Options', 'exponent' ),
		'visible'	=> array( 'post_format', 'video' ),
		'fields'	=> array (
			array (
				'name'		=> __( 'Add Your Video Embed Url', 'exponent' ),
				'id'		=> "{$meta_prefix}video_embed",
				'type'		=> 'oembed',
				'std'		=> '',
			),
		),
	);

	$posts_meta[] = array (
		'title'		=> __( 'Gallery Post Format Options', 'exponent' ),
		'visible'	=> array( 'post_format', 'gallery' ),
		'fields'	=> array (
			array (
				'name'		=> __( 'Gallery Post Format Images', 'exponent' ),
				'id'		=> "{$meta_prefix}gallery_images",
				'std'		=> '',
				'type'		=> 'image_advanced',
			)
		),
	);

	$posts_meta[] = array (
		'title'		=> __( 'Audio Post Format Options', 'exponent' ),
		'visible'	=> array( 'post_format', 'audio' ),
		'fields'	=> array (
			array (
				'name'		=> __( 'Audio Link', 'exponent' ),
				'id'		=> "{$meta_prefix}audio_embed",
				'std'		=> '',
				'type'		=> 'oembed',
			)
		),
	);

	$posts_meta[] = array (
		'title'		=> __( 'Quote Post Format Options', 'exponent' ),
		'visible'	=> array( 'post_format', 'quote' ),
		'fields'	=> array (
			array (
				'name'		=> __( 'Quote', 'exponent' ),
				'id'		=> "{$meta_prefix}quote",
				'std'		=> '',
				'type'		=> 'text',
			),
			array (
				'name'		=> __( 'Quote Author', 'exponent' ),
				'id'		=> "{$meta_prefix}quote_author",
				'std'		=> '',
				'type'		=> 'text',
			),
			array (
				'name'		=> __( 'Post Color', 'exponent' ),
				'id'		=> "{$meta_prefix}quote_color",
				'std'		=> $alt_bg_text_color,
				'type'		=> 'color'
			),
			array (
				'name'		=> __( 'Post Bg Color', 'exponent' ),
				'id'		=> "{$meta_prefix}quote_bg_color",
				'std'		=> $color_scheme,
				'type'		=> 'color'
			),
		),
	);

	$posts_meta[] = array (
		'title'		=> __( 'Link Post Format Options', 'exponent' ),
		'visible'	=> array( 'post_format', 'link' ),
		'fields'	=> array (
			array (
				'name'		=> __( 'Link', 'exponent' ),
				'id'		=> "{$meta_prefix}link",
				'std'		=> '',
				'type'		=> 'text',
			),
			array (
				'name'		=> __( 'Post Color', 'exponent' ),
				'id'		=> "{$meta_prefix}link_color",
				'std'		=> $alt_bg_text_color,
				'type'		=> 'color'
			),
			array (
				'name'		=> __( 'Post Bg Color', 'exponent' ),
				'id'		=> "{$meta_prefix}link_bg_color",
				'std'		=> $color_scheme,
				'type'		=> 'color'
			),
		),
	);

    return $posts_meta;