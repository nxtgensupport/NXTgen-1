<?php
    if( !function_exists( 'exp_blog' ) ) {
        function exp_blog( $atts, $content, $tag ) {
            $atts = shortcode_atts( array (
                'posts_count'           => '3',
                'categories'            => '',
                'pagination'            => '',
                'pagination_alignment' => 'left',
                'grid_with_margin'      => '',
                'hide_content'          => '0',
                'style'                 => 'style1',
                'alignment'             => '',
                'border'    => '',
                'border_color'  => '',
                'border_style'  => '',
                'border_radius'         => '',
                'grid_aspect_ratio'     => '0.75',
                'post_details_padding'  => '40px 40px',
                'post_details_color'    => '',
                'columns'               => '3',
                'primary_meta'          => '',
                'secondary_meta'        => '',
                'tertiary_meta'         => '',
                'meta_date_icon'        => '',
                'meta_author_image'     => '',
                'labeled_cat'           => '',
                'posts_gutter'          => '20',
                'thumb_shadow'          => '',
                'post_shadow'           => '',
                'read_more'             => 'dots',
                'key'                   => be_uniqid_base36(true),
            ), $atts, $tag );

            extract( $atts );

            $style_tag = be_generate_css_from_atts( $atts, $tag, $key );
            $custom_class = 'tatsu-' . $key;
            $classes = array( 'exp-module', 'exp-blog', $custom_class );

            if( !empty( $atts['css_classes'] ) ) {
                $classes[] = $atts['css_classes'];
            }
            $classes[] = be_get_visibility_classes_from_atts( $atts );

            if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
                $classes[] = 'tatsu-animate';
            }
            $data_attrs = be_get_animation_data_atts( $atts );

            $css_id = be_get_id_from_atts( $atts );

            if( !empty( $primary_meta ) ) {
                $meta_array = explode( ',', $primary_meta );
                $primary_meta = $meta_array;
            }else {
                $primary_meta = array();
            }
            $atts[ 'primary_meta' ] = $primary_meta;

            if( !empty( $secondary_meta ) ) {
                $meta_array = explode( ',', $secondary_meta );
                $secondary_meta = $meta_array;
            }else {
                $secondary_meta = array();
            }
            $atts[ 'secondary_meta' ] = $secondary_meta;

            if( !empty( $tertiary_meta ) ) {
                $meta_array = explode( ',', $tertiary_meta );
                $tertiary_meta = $meta_array;
            }else {
                $tertiary_meta = array();
            }
            $atts[ 'tertiary_meta' ]  = $tertiary_meta;

            $list_styles = array( 'style1', 'style4' );
            $loop_args = $atts;
            if( in_array( $style, $list_styles ) ) {
                $loop_args[ 'arrangement' ] = 'list';
            }else {
                $loop_args[ 'arrangement' ]  = 'grid';
            }
            $loop_args['custom_post_details_padding'] = 1;
            if( empty( $posts_count ) ) {
                $posts_per_page = 3;
            }else {
                $posts_per_page = (int)$posts_count;
            }

            $categories = !empty( $categories ) ? explode( ',', $categories ) : '';

            $tax_query = array();
            if( !empty( $categories ) ) {
                $tax_query[] = array (
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => $categories,
                    'operator' => 'IN',
                );
            }
            $args = array (
                'post_type'             => 'post',
                'post_status'           => 'publish',
                'posts_per_page'        => $posts_per_page,
                'orderby'               => 'date',
                'ignore_sticky_posts'   => 1,
                'tax_query'             => $tax_query
            );
            //pagination
            if( !empty( $pagination ) ) {
                /**
                 * Pagination in static front page.
                 * @source https://codex.wordpress.org/Creating_a_Static_Front_Page#Pagination
                 */
                if( is_front_page() ) {
                    $current_page_num = get_query_var( 'page' ) ? absint( get_query_var( 'page' ) ) : 1;
                }else {
                    $current_page_num = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
                }
                $args[ 'paged' ]  = $current_page_num;
            }
            $args = apply_filters( 'exp_blog_query_args', $args );
            $my_query = new WP_Query( $args );

            $classes = implode( ' ', $classes );
            ob_start();
            if( $my_query->have_posts() && function_exists( 'exponent_setup_post_loop' ) && function_exists( 'exponent_reset_post_loop' ) ) {
                $pagination_args = array(
                    'total' => $my_query->max_num_pages,
                );
                if( !in_array( $style, $list_styles ) && !empty( $grid_with_margin ) ) {
                    $pagination_args[ 'padding' ] = $posts_gutter;
                }
                if( !empty( $pagination_alignment ) ) {
                    $pagination_args[ 'class' ] = 'exp-pagination-' . $pagination_alignment;
                }
                // var_dump( $pagination_args );
                // wp_die();
                exponent_setup_post_loop( $loop_args );
                ?>
                    <div <?php echo $css_id; ?> class = "<?php echo $classes; ?>" <?php echo $data_attrs; ?>>
                        <?php echo $style_tag; ?>
                        <div class = "exp-blog-inner">
                            <?php get_template_part( 'template-parts/posts/before', 'loop' ); ?>
                            <?php
                                while ( $my_query->have_posts() ) : 
                                    $my_query->the_post(); 
                                    get_template_part( 'template-parts/posts/archive', $style );
                                endwhile;   
                            ?>
                            <?php get_template_part( 'template-parts/posts/after', 'loop' ); ?>
                        </div>
                        <?php if( !empty( $pagination ) ) : ?>
                            <?php 
                                echo be_get_pagination( $pagination_args );
                            ?>
                        <?php endif; ?>
                    </div>
                <?php
                exponent_reset_post_loop();
            }
            wp_reset_query();
            return ob_get_clean(); 
        }
        add_shortcode( 'blog', 'exp_blog' );
    }

    if( !function_exists( 'exp_blog_prevent_autop' ) ) {
        function exp_blog_prevent_autop( $content_filter, $tag ) {
            if( 'blog' === $tag ) {
                $content_filter = false;
            }
            return $content_filter;
        }
        add_filter( 'tatsu_shortcode_output_content_filter', 'exp_blog_prevent_autop', 10, 2 );
    }

    if( !function_exists( 'exp_register_blog' ) ) {
        add_action( 'tatsu_register_modules', 'exp_register_blog' );
        function exp_register_blog() {
            $controls = array (
                'icon' => EXPONENT_MODULES_PLUGIN_URL . '/img/modules.svg#blog',
                'title' => __( 'Exp Blog', 'exponent-modules' ),
                'is_js_dependant' => true,
                'type' => 'single',
                'is_built_in' => false,
                'group_atts' => array (
                    array (
                        'type' => 'tabs',
                        'group' => array (
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Content', 'exponent-modules' ),
                                'group' => array (
                                    'categories',
                                    'posts_count',
                                    'hide_content',
                                    'pagination',
                                    array (
                                        'type'  => 'accordion',
                                        'active' => 'none',
                                        'group' => array (
                                            array (
                                                'type' => 'panel',
                                                'title' => __( 'Meta Settings', 'exponent-modules' ),
                                                'group' => array (
                                                    'primary_meta',
                                                    'secondary_meta',
                                                    'tertiary_meta',
                                                    'meta_date_icon',
                                                    'meta_author_image',
                                                    'labeled_cat'
                                                )
                                            ),
                                        )
                                    ),
                                )
                            ),
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Style', 'exponent-modules' ),
                                'group' => array (
                                    'style',
                                    'columns',
                                    'posts_gutter',
                                    'grid_with_margin',
                                    'alignment',
                                    'pagination_alignment',
                                    'grid_aspect_ratio',
                                    'post_details_padding',
                                    'post_details_color',
                                    'read_more',
                                    'thumb_shadow',
                                    'post_shadow',
                                )
                            ),
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Advanced', 'exponent-modules' ),
                                'group' => array (
                                    array (
                                        'type'  => 'accordion',
                                        'active' => 'none',
                                        'group' => array (
                                            array (
												'type' => 'panel',
												'title' => __( 'Border', 'tatsu' ),
												'group' => array (
                                                    'border_style',
                                                    'border',
                                                    'border_color',
                                                    'border_radius',
                                                ),
                                            ),
                                        )
                                    )
                                )
                            ),
                        )
                    )
                ),
                'atts' => array (
                    array (
                        'att_name' => 'posts_count',
                        'type' => 'slider',
                        'label' => __( 'Number of Items', 'exponent-modules' ),
                        'options' => array (
                            'min'	=> '3',
                            'max'	=> '20',
                            'step'	=> '1'
                        ),
                        'default' => '6',
                        'tooltip' => ''
                    ),
                    array (
                        'att_name'		=> 'pagination',
                        'type'			=> 'switch',
                        'label'			=> __( 'Pagination', 'exponent-modules' ),
                        'default'		=> '1',
                        'tooltip'		=> '',
                    ),
                    array (
                        'att_name'	=> 'pagination_alignment',
                        'type'	=> 'button_group',
                        'is_inline'     => true,
                        'label'	 => __( 'Pagination Alignment', 'exponent-modules' ),
                        'default' => 'left',
                        'options' => array (
                            'left'	=> 'Left',
                            'center' => 'Center',
                            'right'	=> 'Right',
                        ),
                        'visible' => array ( 'pagination', '=', '1' ),
                    ),
                    array (
                        'att_name'		=> 'style',
                        'type'			=> 'select',
                        'is_inline'     => true,
                        'label'			=> __( 'Style', 'exponent-modules' ),
                        'options'		=> array (
                            'style1'	=> 'Style 1',
                            'style2'	=> 'Style 2',
                            'style3'	=> 'Style 3',
                            'style4'	=> 'Style 4',
                            'style5'	=> 'Style 5',
                            'style6'	=> 'Style 6',
                            'style7'	=> 'Style 7',		
                        ),
                        'default'		=> 'style2',
                        'tooltip'		=> ''
                    ),
                    array (
                        'att_name'		=> 'grid_with_margin',
                        'type'			=> 'switch',
                        'label'			=> __( 'Grid Margin', 'exponent' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'visible'		=> array(
                            'condition'	=> array (
                                array('style', '!=', 'style1'),
                                array( 'style', '!=', 'style4')
                            ),
                            'relation'	=> 'and'
                        )
                    ),
                    array (
                        'att_name' => 'categories',
                        'type' => 'grouped_checkbox',
                        'label' => __( 'Categories', 'exponent-modules' ),
                        'options' => exp_get_categories_as_module_option(),
                        'tooltip' => '',
                    ),
                    array (
                        'att_name'		=> 'alignment',
                        'type'			=> 'button_group',
                        'is_inline'     => true,
                        'label'			=> __( 'Align', 'exponent-modules' ),
                        'options'		=> array (
                            'left'		=> 'Left',
                            'center'	=> 'Center',
                            'right'		=> 'Right'
                        ),
                        'default'		=> 'center',
                        'tooltip'		=> '',	
                    ),
                    array (
                        'att_name' 	=> 'hide_content',
                        'type' 		=> 'switch',
                        'label' 		=> __( 'Hide Content', 'exponent-modules' ),
                        'default' 	=> '0',
                        'tooltip' 	=> '',
                    ),
                    array (
                        'att_name'		=> 'grid_aspect_ratio',
                        'type'			=> 'slider',
                        'label'			=> __( 'Grid Aspect Ratio', 'exponent-modules' ),
                        'default'		=> 1.25,
                        'options'		=> array (
                            'min'  => 0,
                            'max'  => 3,
                            'step' => 0.01,
                            'unit' => '',
                        ),
                        'tooltip'		=> ''
                    ),
                    array (
                        'att_name'		=> 'post_details_padding',
                        'type'			=> 'input_group',
                        'options'	=> array(
                            'unit'	=> array('px', '%', 'em'),
                            'labels' => array('Top & Bottom', 'Left & Right' ),
                        ),
                        'label'			=> __( 'Content Padding', 'exponent-modules' ),
                        'default' 		=> '',
                        'tooltip'		=> '',
                    ),
                    array (
                        'att_name'		=> 'post_details_color',
                        'type'			=> 'color',
                        'label'			=> __( 'Content Background Color', 'exponent-modules' ),
                        'options'		=> array (
                            'gradient'	=> true	
                        ),
                        'default'		=> '',
                        'tooltip'		=> ''
                    ),
                    array (
                        'att_name'		=> 'columns',
                        'type'			=> 'slider',
                        'label'			=> __( 'Columns', 'exponent-modules' ),
                        'default'		=> '3',
                        'options'		=> array (
                            'min'		=> '2',
                            'max'		=> '6',
                            'step'		=> '1'
                        ),
                        'default'		=> '3',
                        'tooltip'		=> ''
                    ),
                    array (
                        'att_name'		=> 'posts_gutter',
                        'is_inline'     => true,
                        'type'			=> 'number',
                        'label'			=> __( 'Gutter', 'exponent-modules' ),
                        'default'		=> '40',
                        'options'		=> array (
                            'unit'		=> 'px'
                        ),
                        'tooltip'		=> ''
                    ),
                    array (
                        'att_name' => 'border_style',
                        'type' => 'select',
                        'is_inline' => true,
                        'label' => __( 'Border Style', 'tatsu' ),
                        'options' => array(
                            'none' => 'None',
                            'solid' => 'Solid',
                            'dashed' => 'Dashed',
                            'double' => 'Double',
                            'dotted' => 'Dotted',
                        ),
                        'default' => 'solid',
                        'tooltip' => '',
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID} .exp-post-inner' => array(
                                'property' => 'border-style',
                                'when' => array(
                                    array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                    array( 'border_style', '!=', 'none' ),
                                ),
                                'relation' => 'and',            
                            ),
                        ),
                    ),
                    array (
                        'att_name' => 'border',
                        'type' => 'input_group',
                        'label' => __( 'Border Width', 'tatsu' ),
                        'default' => '0px 0px 0px 0px',
                        'tooltip' => '',
                        'responsive' => true,
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID} .exp-post-inner' => array(
                                'property' => 'border-width',
                            ),
                        ),
                    ),
                    array (
                        'att_name' => 'border_color',
                        'type' => 'color',
                        'label' => __( 'Border Color', 'tatsu' ),
                        'default' => '',
                        'tooltip' => '',
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID} .exp-post-inner' => array(
                                'property' => 'border-color',
                                'when' => array('border', '!=', '0px 0px 0px 0px'),
                            ),
                        ),
                    ),
                    array (
                        'att_name'		=> 'border_radius',
                        'type'			=> 'number',
                        'is_inline'     => true,
                        'label'			=> __( 'Border Radius', 'exponent-modules' ),
                        'default'		=> '0',
                        'options'		=> array (
                            'unit'		=> 'px'
                        ),
                        'tooltip'		=> ''
                    ),
                    array (
                        'att_name' => 'thumb_shadow',
                        'type'     => 'button_group',
                        'label'    => __( 'Thumb Shadow', 'exponent-modules' ),
                        'default'  => 'none',
                        'tooltip'  => '',
                        'options'  => array (
                            'none'      => __( 'None', 'exponent-modules' ),
                            'light'     => __( 'Light', 'exponent-modules' ),
                            'medium'    => __( 'Medium', 'exponent-modules' ),
                            'dark'      => __( 'Dark', 'exponent-modules' ),
                        )	
                    ),
                    array (
                        'att_name' => 'post_shadow',
                        'type'     => 'button_group',
                        'label'    => __( 'Content Shadow', 'exponent-modules' ),
                        'default'  => 'none',
                        'tooltip'  => '',
                        'options'  => array (
                            'none'      => __( 'None', 'exponent-modules' ),
                            'light'     => __( 'Light', 'exponent-modules' ),
                            'medium'    => __( 'Medium', 'exponent-modules' ),
                            'dark'      => __( 'Dark', 'exponent-modules' ),
                        )	
                    ),
                    array (
                        'att_name'			=> 'primary_meta',
                        'type'				=> 'grouped_checkbox',
                        'label' 			=> __( 'Primary Meta', 'exponent-modules' ),
                        'options'			=> array (
                            'categories'	=> 'Category',
                            'author'		=> 'Author',
                            'date'			=> 'Date'
                        ),
                        'default'			=> 'categories',
                        'tooltip'			=> '',
                    ),
                    array (
                        'att_name'			=> 'secondary_meta',
                        'type'				=> 'grouped_checkbox',
                        'label' 			=> __( 'Secondary Meta', 'exponent-modules' ),
                        'options'			=> array (
                            'categories'	=> 'Category',
                            'author'		=> 'Author',
                            'date'			=> 'Date'
                        ),
                        'default'			=> 'date',
                        'tooltip'			=> '',
                    ),
                    array (
                        'att_name'			=> 'tertiary_meta',
                        'type'				=> 'grouped_checkbox',
                        'label' 			=> __( 'Tertiary Meta', 'exponent-modules' ),
                        'options'			=> array (
                            'categories'	=> 'Category',
                            'author'		=> 'Author',
                            'date'			=> 'Date'
                        ),
                        'default'			=> '',
                        'tooltip'			=> '',
                    ),
                    array (
                        'att_name'			=> 'meta_date_icon',
                        'type'				=> 'switch',
                        'label'				=> __( 'Date Meta Icon', 'exponent-modules' ),
                        'default'			=> '0',
                        'tooltip'			=> '',
                    ),
                    array (
                        'att_name'			=> 'meta_author_image',
                        'type'				=> 'switch',
                        'label'				=> __( 'Author Meta Image', 'exponent-modules' ),
                        'default'			=> '0',
                        'tooltip'			=> '',
                    ),
                    array (
                        'att_name'			=> 'labeled_cat',
                        'type'				=> 'switch',
                        'label'				=> __( 'Labeled Style for Categories Meta', 'exponent-modules' ),
                        'default'			=> '0',
                        'tooltip'			=> '',
                    ),
                    array (
                        'att_name'			=> 'read_more',
                        'type'				=> 'button_group',
                        'is_inline'     => true,
                        'label'				=> __( 'Read More Style', 'exponent-modules' ),
                        'options'			=> array (
                            'underlined'	=> 'Underlined',
                            'dots'			=> 'Dots'
                        ),
                        'default'			=> 'underlined',
                        'tooltip'			=> '',	
                    ),
                ),
            );
            tatsu_register_module( 'blog', $controls );
        }
    }

    if( !function_exists( 'exp_blog_modify_atts' ) ) {
        function exp_blog_modify_atts( $out, $pairs, $atts ) {
            if( array_key_exists( 'custom_post_details_padding', $atts ) && empty( $atts['custom_post_details_padding'] ) ) {
                $out['post_details_padding'] = '';
            }
            return $out;
        }
        add_filter( 'shortcode_atts_blog', 'exp_blog_modify_atts', 10, 3 );
    }

    if( !function_exists( 'exp_blog_parse_atts' ) ) {
        function exp_blog_parse_atts( $atts ) {
            if( array_key_exists( 'custom_post_details_padding', $atts ) && empty( $atts['custom_post_details_padding'] ) ) {
                $atts['post_details_padding'] = '';
                unset($atts['custom_post_details_padding']);
            }
            return $atts;
        }
        add_filter( 'tatsu_parse_atts_blog', 'exp_blog_parse_atts' );
    }