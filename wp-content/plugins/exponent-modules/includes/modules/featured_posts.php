<?php
    if( !function_exists( 'exp_featured_posts' ) ) {
        function exp_featured_posts( $atts, $content, $tag ) {
            $atts = shortcode_atts( array (
                'arrangement'           => 'slider',
                'columns'               => '3',
                'posts_gutter'          => '20',
                'grid_with_margin'      => '0',
                'alignment'             => '',
                'featured_posts_height' => '700',
                'border'    => '',
                'border_color'  => '',
                'border_style'  => '',
                'border_radius'         => '',
                'primary_meta'          => '',
                'secondary_meta'        => '',
                'tertiary_meta'         => '',
                'meta_date_icon'        => '',
                'meta_author_image'     => '',
                'labeled_cat'           => '',
                'post_shadow'           => 'none',
                'slide_width'           => '90',
                'key'                   => be_uniqid_base36(true),
            ), $atts, $tag );
            
            if( 'slider' === $atts['arrangement'] ) {
                $atts['columns'] = false;
                $atts['grid_with_margin'] = false;
            }
            extract( $atts );

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

            $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
            $custom_class_name = ' tatsu-'.$atts['key'];

            $classes = array( 'exp-featured-posts', 'exp-module', $custom_class_name );

            if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
                $classes[] = 'tatsu-animate';
            }
            $data_attrs = be_get_animation_data_atts( $atts );

            if( !empty( $atts['css_classes'] ) ) {
                $classes[] = $atts['css_classes'];
            }
            $classes[] = be_get_visibility_classes_from_atts( $atts );

            $css_id = be_get_id_from_atts( $atts );

            if( function_exists( 'be_themes_get_meta_prefix' ) ) {
                //loop args
                $loop_style = apply_filters( 'be_themes_featured_posts_style', 'style3' );
                $loop_args = $atts;
                $loop_args[ 'style' ] = $loop_style;
                $loop_args[ 'type' ] = 'featured';

                $featured_meta_key = be_themes_get_meta_prefix() . 'featured_post';
                $args = array (
                    'post_type'         => 'post',
                    'posts_per_page'    => -1,
                    'orderby'           => 'date',
                    'meta_key'          => $featured_meta_key,
                    'meta_value'        => '1'    
                );
                $args = apply_filters( 'be_themes_featured_posts_query_args', $args );
                $my_query = new WP_Query( $args );

                $classes = implode( ' ', $classes );
                ob_start();
                if( $my_query->have_posts() && function_exists( 'exponent_setup_post_loop' ) && function_exists( 'exponent_reset_post_loop' ) ) {
                    exponent_setup_post_loop( $loop_args );
                    ?>
                        <div <?php echo $css_id; ?> class = "<?php echo $classes; ?>" <?php echo $data_attrs; ?>>
                            <?php echo $custom_style_tag; ?>
                            <div class = "exp-featured-posts-inner">
                                <?php get_template_part( 'template-parts/posts/before', 'loop' ); ?>
                                <?php
                                    while ( $my_query->have_posts() ) : 
                                        $my_query->the_post(); 
                                        get_template_part( 'template-parts/posts/archive', $loop_style );
                                    endwhile;   
                                ?>
                                <?php get_template_part( 'template-parts/posts/after', 'loop' ); ?>
                            </div>
                        </div>
                    <?php
                    exponent_reset_post_loop();
                }
                wp_reset_query();
                return ob_get_clean(); 

            }
            return '';
        }
        add_shortcode( 'exp_featured_posts', 'exp_featured_posts' );
    }

    if( !function_exists( 'exp_featured_posts_prevent_autop' ) ) {
        function exp_featured_posts_prevent_autop( $content_filter, $tag ) {
            if( 'exp_featured_posts' === $tag ) {
                $content_filter = false;
            }
            return $content_filter;
        }
        add_filter( 'tatsu_shortcode_output_content_filter', 'exp_featured_posts_prevent_autop', 10, 2 );
    }
            

    if( !function_exists( 'exp_register_featured_posts' ) ) {
        add_action( 'tatsu_register_modules', 'exp_register_featured_posts' );
        function exp_register_featured_posts() {
            $controls = array (
                'icon' => EXPONENT_MODULES_PLUGIN_URL . '/img/modules.svg#featured_posts',
                'title' => __( 'Exp Featured Posts Slider', 'exponent-modules' ),
                'is_js_dependant' => true,
                'type' => 'single',
                'is_built_in' => false,
                'group_atts' => array (
                    array (
                        'type'  => 'tabs',
                        'group' => array (
                            array( 
                                'type'  => 'tab',
                                'title' => __( 'Content', 'exponent-modules' ),
                                'group' => array (
                                    'primary_meta',
                                    'secondary_meta',
                                    'tertiary_meta',
                                    'meta_date_icon',
                                    'meta_author_image',
                                    'labeled_cat'
                                )
                            ),
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Style', 'exponent-modules' ),
                                'group' => array (
                                    'arrangement',
                                    'alignment',
                                    'slide_width',
                                    'columns',
                                    'featured_posts_height',
                                    'grid_with_margin',
                                    'posts_gutter',
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
                            )
                        )
                    )
                ),
                'atts' => array (
                    array (
                        'att_name'		=> 'arrangement',
                        'type'			=> 'button_group',
                        'is_inline'     => true,
                        'label'			=> __( 'Featured Posts Type', 'exponent-modules' ),
                        'options'		=> array (
                            'slider'		=> 'Slider',
                            'grid'		=> 'Grid',
                        ),
                        'default'		=> 'slider',
                        'tooltip'		=> '',	
                    ),
                    array (
                        'att_name'		=> 'slide_width',
                        'type'			=> 'slider',
                        'label'			=> __( 'Slide Width', 'exponent-modules' ),
                        'default'		=> '90',
                        'options'		=> array (
                            'unit'		=> '%',
                            'min'		=> 0,
                            'max'		=> 100,
                            'step'		=> 1,
                        ),
                        'visible'		=> array ('arrangement', '==', 'slider'  ),
                        'css'			=> true,
                        'responsive'	=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID} .be-slide'	=> array (
                                'property'		=> 'width',
                                'append'		=> '%',
                            ),
                        ),
                        'tooltip'		=> '',
                    ),
                    array (
                        'att_name'		=> 'columns',
                        'type'			=> 'slider',
                        'label'			=> __( 'Grid Columns', 'exponent-modules' ),
                        'default'		=> '3',
                        'options'		=> array (
                            'unit'		=> '',
                            'min'		=> 2,
                            'max'		=> 5,
                            'step'		=> 1,
                        ),
                        'visible'		=> array ('arrangement', '==', 'grid'  ),
                        'tooltip'		=> '',
                    ),
                    array (
                        'att_name'		=> 'grid_with_margin',
                        'type'			=> 'switch',
                        'label'			=> __( 'Grid With Margin', 'exponent-modules' ),
                        'default'		=> '0',
                        'visible'		=> array ('arrangement', '==', 'grid'  ),
                        'tooltip'		=> '',
                    ),
                    array (
                        'att_name'		=> 'posts_gutter',
                        'is_inline'     => true,
                        'type'			=> 'number',
                        'label'			=> __( 'Gutter', 'exponent-modules' ),
                        'default'		=> '20',
                        'options'		=> array (
                            'unit'		=> 'px'
                        ),
                        'tooltip'		=> ''
                    ),
                    array (
                        'att_name' => 'border_style',
                        'type' => 'select',
                        'label' => __( 'Border Style', 'tatsu' ),
                        'options' => array(
                            'none' => 'None',
                            'solid' => 'Solid',
                            'dashed' => 'Dashed',
                            'double' => 'Double',
                            'dotted' => 'Dotted',
                        ),
                        'default' => 'solid',
                        'exclude' => array( 'tatsu_image' ),
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
                        'is_inline'     => true,
                        'type'			=> 'number',
                        'label'			=> __( 'Border Radius', 'exponent-modules' ),
                        'default'		=> '0',
                        'options'		=> array (
                            'unit'		=> 'px'
                        ),
                        'tooltip'		=> ''
                    ),
                    array (
                        'att_name'		=> 'alignment',
                        'is_inline'     => true,
                        'type'			=> 'button_group',
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
                        'att_name'		=> 'featured_posts_height',
                        'type'			=> 'number',
                        'is_inline'     => true,
                        'label'			=> __( 'Height', 'exponent-modules' ),
                        'default'		=> '700',
                        'visible'		=> array ('arrangement', '==', 'slider'  ),
                        'options'		=> array (
                            'unit'		=> 'px'
                        ),
                        'tooltip'		=> ''
                    ),
                    array (
                        'att_name' => 'post_shadow',
                        'type'     => 'button_group',
                        'is_inline'     => true,
                        'label'    => __( 'Shadow', 'exponent-modules' ),
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
                ),
            );
            tatsu_register_module( 'exp_featured_posts', $controls );
        }
    }