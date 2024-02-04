<?php

$posts = array(
    'Blog'  => array (
        'loop_title_list'  =>   array (
            'label'        => __( 'Post Archive - Title (List Styles)', 'exponent' ),
            'selector'     => sprintf( '.%s .%s', be_themes_get_class( 'posts-loop' ), be_themes_get_class( 'post-title' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/loop_title_list.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '35px',
                'font-variant'      => '600',
                'line-height'       => '46px',
                'color'             => '#343638',
                'letter-spacing'    => '-0.01em',
                'text-transform'    => 'none',
            )
        ),
        'loop_title_grid'  =>   array (
            'label'        => __( 'Post Archive - Title (Grid Styles)', 'exponent' ),
            'selector'     => sprintf( '.be-grid .%s', be_themes_get_class( 'post-title' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/loop_title_grid.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '22px',
                'font-variant'      => '600',
                'line-height'       => '34px',
                'color'             => '#343638',
                'letter-spacing'    => '-0.01em',
                'text-transform'    => 'none',
            )
        ),
        'loop_content'              => array (
            'label'                 => __( 'Post Archive - Content', 'exponent' ),
            'selector'              => sprintf( '.%s .%s', be_themes_get_class( 'posts-loop' ), be_themes_get_class( 'post-content' ) ),
            'img'                   => get_template_directory_uri().'/img/typehub/loop_content.jpg',
            'responsive'   => true,
            'options'               => array (
                'font-family'       => 'schemes:secondary',
                'font-size'         => '16px',
                'line-height'       => '28px',
                'color'             => '#848991',
                'letter-spacing'    => '0px',
                'font-variant'      => '400',
                'text-transform'    => 'none',
            )
        ),
        'loop_meta_categories'   =>   array (
            'label'        => __( 'Post Archive - Category Meta', 'exponent' ),
            'selector'     => sprintf( '.%1$s .%2$s, .%1$s.%4$s .%3$s, .%1$s.%5$s .%3$s', be_themes_get_class( 'posts-loop' ), be_themes_get_class( 'post-categories' ), be_themes_get_class( 'post-categories-labeled' ), be_themes_get_class( 'posts-loop-style3' ), be_themes_get_class( 'posts-loop-style7' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/loop_meta_categories.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '11px',
                'font-variant'      => '500',
                'line-height'       => '1',
                'text-transform'    => 'uppercase',
                'color'             => 'rgba(0,0,0,0.45)',    
                'letter-spacing'    => '1px',
            )
        ),
        'loop_meta_author'   =>   array (
            'label'        => __( 'Post Archive - Author Meta', 'exponent' ),
            'selector'     => sprintf( '.%s .%s', be_themes_get_class( 'posts-loop' ), be_themes_get_class( 'post-author' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/loop_meta_author.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '13px',
                'line-height'       => '1',
                'font-variant'      => '500',
                'color'             => 'rgba(0,0,0,0.45)',    
                'letter-spacing'    => '0px',
                'text-transform'    => 'capitalize',
            )
        ),
        'loop_meta_date'   =>   array (
            'label'        => __( 'Post Archive - Date Meta', 'exponent' ),
            'selector'     => sprintf( '.%1$s .%2$s, .%1$s .%3$s', be_themes_get_class( 'posts-loop' ), be_themes_get_class( 'post-date' ), be_themes_get_class( 'post-date-with-icon' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/loop_meta_date.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '13px',
                'line-height'       => '1',
                'font-variant'      => '500',
                'color'             => 'rgba(0,0,0,0.45)',    
                'letter-spacing'    => '0px',
                'text-transform'    => 'none',
            )
        ),

        'loop_title_slider'  =>   array (
            'label'        => __( 'Post Archive - Title (Recent Posts)', 'exponent' ),
            'selector'     => sprintf( '.%s .%s', be_themes_get_class( 'recent-posts' ), be_themes_get_class( 'post-title' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/loop_title_slider.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '22px',
                'font-variant'      => '600',
                'line-height'       => '34px',
                'color'             => '#343638',
                'letter-spacing'    => '-0.01em',
                'text-transform'    => 'none',
            )
        ),
        'loop_title_featured'  =>   array (
            'label'        => __( 'Post Archive - Title (Featured Posts)', 'exponent' ),
            'selector'     => sprintf( '.%s .%s', be_themes_get_class( 'featured-posts' ), be_themes_get_class( 'post-title' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/loop_title_featured.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '35px',
                'font-variant'      => '600',
                'line-height'       => '48px',
                'color'             => '#343638',
                'letter-spacing'    => '-0.01em',
                'text-transform'    => 'none',
            )
        ),
        'loop_title_related'  =>   array (
            'label'        => __( 'Post Archive - Title (Related Posts)', 'exponent' ),
            'selector'     => sprintf( '.%s .%s', be_themes_get_class( 'related-posts' ), be_themes_get_class( 'post-title' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/loop_title_related.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '22px',
                'font-variant'      => '600',
                'line-height'       => '34px',
                'color'             => '#343638',
                'letter-spacing'    => '-0.01em',
                'text-transform'    => 'none',
            )
        ),
        'single_title'  =>   array (
            'label'        => __( 'Individual Post Title', 'exponent' ),
            'selector'     => sprintf( '.%s .%s, .%s', be_themes_get_class( 'post-single-header' ), be_themes_get_class( 'post-title' ), be_themes_get_class( 'category-header-title' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/single_title.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '46px',
                'font-variant'      => '600',
                'line-height'       => '58px',
                'color'             => '#343638',
                'letter-spacing'    => '0px',
                'text-transform'    => 'none',
            )
        ),
        'single_content'            => array (
            'label'                 => __( 'Individual Post Content', 'exponent' ),
            'selector'              => sprintf( '.%s', be_themes_get_class( 'post-single-content' ) ),
            'img'                   => get_template_directory_uri().'/img/typehub/single_content.jpg',
            'responsive'            => true,
            'options'               => array (
                'font-family'       => 'schemes:secondary',
                'font-size'         => '17px',
                'line-height'       => '30px',
                'color'             => '#848991',  
                'letter-spacing'    => '0px',
                'font-variant'      => '400',
                'text-transform'    => 'none',
            )
        ),
        'single_meta_categories'   =>   array (
            'label'        => __( 'Individual Post - Category Meta', 'exponent' ),
            'selector'     => sprintf( '.%s .%s', be_themes_get_class( 'post-single-header' ), be_themes_get_class( 'post-categories' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/single_meta_categories.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '12px',
                'line-height'       => '1',
                'color'             => 'rgba(0,0,0,0.45)',    
                'font-variant'      => '500',
                'text-transform'    => 'uppercase',
                'letter-spacing'    => '1px',
            )
        ),
        'single_meta_author'   =>   array (
            'label'        => __( 'Individual Post - Author Meta', 'exponent' ),
            'selector'     => sprintf( '.%s .%s', be_themes_get_class( 'post-single-header' ), be_themes_get_class( 'post-author' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/single_meta_author.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '14px',
                'line-height'       => '1',
                'font-variant'      => '500',
                'color'             => 'rgba(0,0,0,0.45)',    
                'letter-spacing'    => '0px',
                'text-transform'    => 'capitalize',
            )
        ),
        'single_meta_date'   =>   array (
            'label'        => __( 'Individual Post - Date Meta', 'exponent' ),
            'selector'     => sprintf( '.%1$s .%2$s, .%1$s .%3$s', be_themes_get_class( 'post-single-header' ), be_themes_get_class( 'post-date' ), be_themes_get_class( 'post-date-with-icon' ) ),
            'img'          => get_template_directory_uri().'/img/typehub/single_meta_date.jpg',
            'responsive'   => true,
            'options'      => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '14px',
                'line-height'       => '1',
                'font-variant'      => '500',
                'color'             => 'rgba(0,0,0,0.45)',    
                'letter-spacing'    => '0px',
                'text-transform'    => 'none',
            )
        ),
        'single_post_author_title'       => array (
            'label'                 => __( 'Individual Post - Author Title', 'exponent' ),
            'selector'              => sprintf( '.%s', be_themes_get_class( 'post-single-footer-author-name' ) ),
            'img'                   => get_template_directory_uri().'/img/typehub/single_post_author_title.jpg',
            'responsive'            => true,
            'options'               => array (
                'font-family'       => 'schemes:primary',
                'font-size'         => '17px',
                'line-height'       => '30px',
                'color'             => '#343638',  
                'letter-spacing'    => '0px',
                'font-variant'      => '600',
                'text-transform'    => 'none',
            )
        ),
        'single_post_author_info'       => array (
            'label'                 => __( 'Individual Post - Author Description', 'exponent' ),
            'selector'              => sprintf( '.%s', be_themes_get_class( 'post-single-footer-author-description' ) ),
            'img'                   => get_template_directory_uri().'/img/typehub/single_post_author_info.jpg',
            'responsive'            => true,
            'options'               => array (
                'font-family'       => 'schemes:secondary',
                'font-size'         => '16px',
                'line-height'       => '28px',
                'color'             => '#888C92',  
                'letter-spacing'    => '0px',
                'font-variant'      => '400',
                'text-transform'    => 'none',
            )
        ),
    )        
);

return $posts;