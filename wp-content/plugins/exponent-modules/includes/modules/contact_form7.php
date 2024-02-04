<?php
if( !function_exists( 'exp_contact_form7' ) ) {
    function exp_contact_form7($atts,$content, $tag) {
        $atts = shortcode_atts( array (
            'form_id'           => '',
            'bg_color'          => '',
            'color'             => '',
            'label_color'       => '',
            'form_type'         => '',
            'accent_color'      => '',
            'button_type'       => '',
            'button_color'      => '',
            'button_bg_color'   => '',
            'border_color'      => '',
            'border'    => '',
            'outer_border_color'  => '',
            'border_style'  => '',
            'border_radius'         => '',
            'key' => be_uniqid_base36(true),
        ), $atts, $tag );

        extract($atts);
        
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
        $unique_class_name = ' tatsu-'.$atts['key'];

        $classes = array ( 'exp-contact-form-cf7', 'exp-module', $unique_class_name );
        if( !empty( $atts['css_classes'] ) ) {
            $classes[] = $atts['css_classes'];
        }
        $classes[] = be_get_visibility_classes_from_atts( $atts );

        $css_id = be_get_id_from_atts( $atts );

        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        $data_attrs = be_get_animation_data_atts( $atts );

        $form_types = array( 'rounded', 'border-with-underline', 'rounded-with-underline', 'pill' );
        $button_types = array ('rounded', 'pill', 'rounded-block', 'pill-block' );
        $html_class = array();
        $form_type = !empty( $form_type ) && in_array( $form_type, $form_types ) ? $form_type : '';
        $button_type = !empty($button_type) && in_array( $button_type, $button_types ) ? $button_type : '';
        if( !empty( $form_type ) ) {
            $html_class[] = 'exp-form-' . $form_type;
        }
        if( !empty( $button_type ) ) {
            $html_class[] = 'exp-button-' . $button_type;
        }

        $form_shortcode = '';
        if( !empty( $form_id ) ) {
            $form_shortcode =  sprintf( '[contact-form-7 html_class = "%s" id="%s"]', implode( ' ', $html_class ), $form_id );
        }

        ob_start();
?>
        <div <?php echo $css_id; ?> class = "<?php echo implode( ' ', $classes ); ?>" <?php echo $data_attrs; ?>>
            <?php echo $custom_style_tag; ?>
            <div class = "exp-contact-cf7-inner">
                <?php echo do_shortcode( $form_shortcode ); ?>
            </div>
        </div>
<?php
        return ob_get_clean();
    };
    add_shortcode( 'exp_contact_form7', 'exp_contact_form7' );
}

if( !function_exists( 'exp_contact_form7_prevent_autop' ) ) {
    function exp_contact_form7_prevent_autop( $content_filter, $tag ) {
        if( 'exp_contact_form7' === $tag ) {
            $content_filter = false;
        }
        return $content_filter;
    }
    add_filter( 'tatsu_shortcode_output_content_filter', 'exp_contact_form7_prevent_autop', 10, 2 );
}

if( !function_exists( 'exp_register_contact_form7' ) ) {
    add_action( 'tatsu_register_modules', 'exp_register_contact_form7' );
    function exp_register_contact_form7() {
        if ( class_exists( 'WPCF7' ) ) {
            $args = array(
                'post_type' => 'wpcf7_contact_form', 
                'posts_per_page' => -1
            );
            extract( be_get_color_hub() );
            $form_style_default = function_exists( 'be_themes_get_option' ) ? be_themes_get_option( 'form_style' ) : '';
            $button_style_default = function_exists( 'be_themes_get_option' ) ? be_themes_get_option( 'button_style' ) : '';
            $cf7_forms = get_posts( $args );
            $forms = array();
            $default_form_id = '';
            if( !empty( $cf7_forms ) ) {
                foreach( $cf7_forms as $index => $cf7_form ) {
                    $id = $cf7_form->ID;
                    $title = $cf7_form->post_title;
                    $forms[ $id ] = $title;
                    if( 0 === $index ) {
                        $default_form_id = $id;
                    }
                }
            }
            $controls = array (
                'icon' => EXPONENT_MODULES_PLUGIN_URL . '/img/modules.svg#wpcf7',
                'title' => __( 'Exp Contact Form 7', 'exponent-modules' ),
                'is_js_dependant' => true,
                'type' => 'single',
                'is_built_in' => false,
                // 'group_atts'	=> array (
                //     'form_id',
                //     'form_type',
                //     'button_type',
                //     array (
                //         'type' => 'accordion' ,
                //         'active' => 'none',
                //         'group' => array (
                //             array (
                //                 'type' => 'panel',
                //                 'title' => __( 'Spacing and Styling', 'exponent-modules' ),
                //                 'group' => array (
                //                     'border_color',
                //                     'bg_color',
                //                     'color',
                //                     'label_color',
                //                     'accent_color',
                //                     'button_bg_color',
                //                     'button_color',
                //                     'margin',
                //                 ),
                //             ),		
                //             array (
                //                 'type' => 'panel',
                //                 'title' => __( 'Animation', 'exponent-modules' ),
                //                 'group' => array (
                //                     'animate',
                //                     'animation_type',
                //                     'animation_delay'
                //                 )
                //             ),
                //         ) 
                //     )
                // ),
                'group_atts'  => array (
                    array (
                        'type' => 'tabs',
                        'group' => array (
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Content', 'exponent-modules' ),
                                'group' => array (
                                    'form_id'
                                )
                            ),
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Style', 'exponent-modules' ),
                                'group' => array (
                                    'form_type',
                                    'button_type',
                                    array (
                                        'type'  => 'accordion',
                                        'active' => 'all',
                                        'group' => array (
                                            array (
                                                'type'  => 'panel',
                                                'title' => __( 'Colors', 'exponent-modules' ),
                                                'group' => array (
                                                    'bg_color',
                                                    'color',
                                                    'label_color',
                                                    'accent_color',
                                                    'button_color',
                                                    'button_bg_color',
                                                    'border_color',
                                                )
                                            )
                                        )
                                    )
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
                                                    'outer_border_color',
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
                        'att_name'		=> 'form_id',
                        'type'			=> 'select',
                        'label'			=> __( 'Forms', 'exponent-modules' ),
                        'options'		=> $forms,
                        'default'		=> $default_form_id,
                        'tooltip'		=> '',	
                    ),
                    array (
                        'att_name'		=> 'bg_color',
                        'type'			=> 'color',
                        'label'			=> __( 'Background', 'exponent-modules' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'visible'		=> array ( 'form_type', '!=', 'border-with-underline' ),
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID} input:not([type="submit"]), .tatsu-{UUID} textarea, .tatsu-{UUID} select' => array (
                                'property'		=> 'background',
                                'when'			=> array ( 'form_type', '!=', 'border-with-underline' ),
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'color',
                        'type'			=> 'color',
                        'label'			=> __( 'Text', 'exponent-modules' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID} input:not([type="submit"]), .tatsu-{UUID} textarea' => array (
                                'property'		=> 'color'
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'label_color',
                        'type'			=> 'color',
                        'label'			=> __( 'Label', 'exponent-modules' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID} label, .tatsu-{UUID} ::-webkit-input-placeholder' => array (
                                'property'		=> 'color',
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'form_type',
                        'type'			=> 'select',
                        'label'			=> __( 'Form Style', 'exponent-modules' ),
                        'default'		=> $form_style_default,
                        'tooltip'		=> '',
                        'options'		=> array (
                            'rounded'					=> __( 'Solid', 'exponent-modules' ),
                            'border-with-underline'	=> __( 'Line', 'exponent-modules' ),
                            'rounded-with-underline'	=> __( 'Rounded - Inner Shadow ', 'exponent-modules' ),
                            'pill'					=> __( 'Pill', 'exponent-modules' ),
                        )
                    ),
                    array (
                        'att_name'		=> 'accent_color',
                        'type'			=> 'color',
                        'label'			=> __( 'Accent', 'exponent-modules' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID} input:not([type = "submit"]):focus, .tatsu-{UUID} textarea:focus, .tatsu-{UUID} select:focus' => array (
                                'property'		=> 'border-color',
                                'when'			=> array (
                                    array ('form_type', '=', 'pill' ),
                                    array( 'form_type', '=', 'rounded' ),
                                ),
                                'relation'		=> 'or',
                            ),
                            '.tatsu-{UUID} .exp-form-border' => array (
                                'property'		=> 'background-color',
                                'when'			=> array (
                                    array ( 'form_type', '=', 'border-with-underline' ),
                                    array ( 'form_type', '=', 'rounded-with-underline' ),
                                ),
                                'relation'		=> 'or',
                            ),
                            '.tatsu-{UUID} .exp-form-border-with-underline .exp-form-field-active .exp-form-field-label'	=> array (
                                'property'		=> 'color',
                                'when'			=> array ( 'form_type', '=', 'border-with-underline' ),
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'button_type',
                        'type'			=> 'select',
                        'label'			=> __( 'Button Style', 'exponent-modules' ),
                        'default'		=> $button_style_default,
                        'tooltip'		=> '',
                        'options'		=> array (
                            'rounded'			=> __( 'Rounded', 'exponent-modules' ),
                            'pill'		=>  __( 'Pill', 'exponent-modules' ),
                            'rounded-block' => __( 'Rounded Block', 'exponent-modules' ),
                            'pill-block'	=> __( 'Pill - Block', 'exponent-modules' ),
                        )
                    ),
                    array (
                        'att_name'		=> 'button_color',
                        'type'			=> 'color',
                        'label'			=> __( 'Button', 'exponent-modules' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID} input[type = "submit"]' => array (
                                'property'		=> 'color'
                            )
                        )
                    ),
                    array (
                        'att_name'		=> 'button_bg_color',
                        'type'			=> 'color',
                        'label'			=> __( 'Button Background', 'exponent-modules' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'selectors'		=> array (
                            '.tatsu-{UUID} input[type = "submit"]' => array (
                                'property'		=> 'background-color',
                            ),
                        ),
                    ),
                    array (
                        'att_name'		=> 'border_color',
                        'type'			=> 'color',
                        'label'			=> __( 'Border', 'exponent-modules' ),
                        'default'		=> '',
                        'tooltip'		=> '',
                        'css'			=> true,
                        'visible'		=> array ( 'form_type', '=', 'border-with-underline' ),
                        'selectors'		=> array (
                            '.tatsu-{UUID} textarea, .tatsu-{UUID} input:not([type = "submit"]), .tatsu-{UUID} select' => array (
                                'property'		=> 'border-color',
                                'when'				=> array ( 'form_type', '=', 'border-with-underline' )
                            ),
                        )
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
                        'tooltip' => '',
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}' => array(
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
                            '.tatsu-{UUID}' => array(
                                'property' => 'border-width',
                            ),
                        ),
                    ),
                    array (
                        'att_name' => 'outer_border_color',
                        'type' => 'color',
                        'label' => __( 'Border Color', 'tatsu' ),
                        'default' => '',
                        'tooltip' => '',
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID}' => array(
                                'property' => 'border-color',
                                'when' => array('border', '!=', '0px 0px 0px 0px'),
                            ),
                        ),
                    ),
                    array (
                        'att_name'	=> 'border_radius',
                        'type'		=> 'number',
                        'is_inline' => true,
                        'exclude' => array('tatsu_empty_space'),
                        'is_inline' => true,
                        'label'		=> __( 'Border Radius', 'tatsu' ),
                        'options' 	=> array (
                            'unit'	=> array( 'px', '%' ),
                        ),
                        'default'	=> '',
                        'css'		=> true,
                        'selectors'	=> array (
                            '.tatsu-{UUID}'	=>  array (
                                'property' => 'border-radius',
                                'append' => 'px'
                            )
                        )
                    ),
                )
            );
            tatsu_register_module( 'exp_contact_form7', $controls );
        }
    }
}