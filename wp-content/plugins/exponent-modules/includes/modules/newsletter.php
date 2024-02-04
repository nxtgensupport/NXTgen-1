<?php 
if (!function_exists('exp_newsletter')) {
	function exp_newsletter( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
            'api_key' => '',
            'id' => '',
            'style' => 'rounded',
            'width' => '50',
            'alignment' => 'left',			
            'button_text'=>'Submit',
            'input_text_color' => '',
            'input_bg_color'    => '',
            'bg_color'=> '',
            'hover_bg_color'=> '',
            'color'=> '',
            'accent_color'  => '',
            'hover_color'=> '',
            'border_width' => 0,			
            'border_color'=> '',
            'border'    => '',
            'outer_border_color'  => '',
            'border_style'  => '',
            'border_radius'         => '',
            'hover_border_color'=> '',
			'success_text' => '',
            'success_text_color'=>'',
            'success_text_bgcolor'=>'',
            'key' => be_uniqid_base36(true),
        ), $atts, $tag);
        
        extract($atts);
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];


        //global $be_themes_data;
        $api_key = ( isset( $api_key ) && !empty( $api_key ) ) ? $api_key : '' ;
        $width  = (isset($width ) && !empty( $width ) ) ? $width : '100';
        $alignment  = (isset($alignment ) && !empty( $alignment ) ) ? $alignment : 'left';	
        
        $form_class = array( 'exp-mc-form', 'exp-form' );
        $classes = array( 'exp-module', 'exp-mc-wrap', $custom_class_name );
        if( !empty( $atts['css_classes'] ) ) {
            $classes[] = $atts['css_classes'];
        }
        $classes[] = be_get_visibility_classes_from_atts( $atts );

        $css_id = be_get_id_from_atts( $atts );

        if( !empty( $style ) ) {
            $classes[] = 'exp-mc-' . $style;
            $form_class[] = 'exp-form-' . $style;
            $form_class[] = 'exp-button-' . $style;
        }
        if( !empty( $alignment ) ) {
            $classes[] = 'exp-mc-align-' . $alignment; 
        }            

        if( isset( $animate ) && 1 == $animate && 'none' !== $animation_type ) {
            $classes[] = 'tatsu-animate';
        }
        $data_attrs = be_get_animation_data_atts( $atts );
    
        $id = ( isset( $id ) && !empty( $id ) ) ? $id : '' ;
        $privacy_policy_link = ( function_exists( 'get_privacy_policy_url' ) ) ? get_privacy_policy_url() : '#';
        $classes = implode( ' ', $classes );
        $form_class = implode( ' ', $form_class );
        $output = '';
        $success_style ="";
        if(!empty($success_text_color)||!empty($success_text_bgcolor)){
            $success_style = "<style>.subscribe_status.tatsu-success{";
            $success_style .=empty($success_text_color)?'':"color:$success_text_color;";
            $success_style .=empty($success_text_bgcolor)?'':"background-color:$success_text_bgcolor;";
            $success_style .="</style>";
        }
        ob_start();
?>
            <div <?php echo $css_id; ?> class = "<?php echo $classes; ?>" <?php echo $data_attrs; ?> >
                <?php echo $custom_style_tag; ?>
                <form method = "POST" class = "<?php echo $form_class; ?>">
                    <input type="hidden" name="api_key" value="<?php echo $api_key; ?>" />
                    <input type="hidden" name="list_id" value="<?php echo $id; ?>" />
                    <input type="hidden" name="success_text" value="<?php echo esc_html($success_text); ?>">
                    <div class = "exp-mc">
                        <input type="text" name="email" class = "exp-mc-email" placeholder="<?php echo __('Email','exponent-modules'); ?>" />
                        <div class = "exp-mc-submit-wrap">
                            <input type="submit" name="submit" value="<?php echo $button_text; ?>" class="exp-mc-submit tatsu-button"/>
                            <div class="exp-subscribe-loader">
                                <div class = "exp-subscribe-loader-inner">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo $success_style; ?>
                    <div class="subscribe_status tatsu-notification" >
                    </div>
                </form>
            </div>
<?php
        return ob_get_clean();
    }      
	add_shortcode( 'newsletter', 'exp_newsletter' );
}

if( !function_exists( 'exp_register_newsletter' ) ) {
    add_action( 'tatsu_register_modules', 'exp_register_newsletter', 11);
    function exp_register_newsletter() {
        $controls = array (
            'icon' => EXPONENT_MODULES_PLUGIN_URL . '/img/modules.svg#newsletter',
            'title' => __( 'Newsletter', 'exponent-modules' ),
            'is_js_dependant' => true,
            'child_module' => '',
            'type' => 'single',
            'is_built_in' => false,
            // 'group_atts'	=> array (
            //     array (
            //         'type'		=> 'accordion',
            //         'active'	=> 'all',
            //         'group'		=> array (
            //             array (
            //                 'type'		=> 'panel',
            //                 'title'		=> __( 'Api Key', 'exponent-modules' ),
            //                 'group'		=> array (
            //                     'api_key',
            //                     'id'
            //                 )
            //             ),
            //             array (
            //                 'type'		=> 'panel',
            //                 'title'		=> __( 'Style and Alignment', 'exponent-modules' ),
            //                 'group'		=> array (
            //                     'style',
            //                     'alignment'
            //                 )
            //             ),
            //             array (
            //                 'type'		=> 'panel',
            //                 'title'		=> __( 'Email Box Styles', 'exponent-modules' ),
            //                 'group'		=> array (
            //                     'width',
            //                     'input_text_color',
            //                     'input_bg_color',
            //                     'accent_color',
            //                 )
            //             ),
            //             array (
            //                 'type'		=> 'panel',
            //                 'title'		=> __( 'Submit Button Text and Styles', 'exponent-modules' ),
            //                 'group'		=> array (
            //                     'button_text',
            //                     'bg_color',
            //                     'hover_bg_color',
            //                     'color',
            //                     'hover_color',
            //                     'border_width',
            //                     'border_color',
            //                     'hover_border_color'
            //                 )
            //             ),
            //             array (
            //                 'type'		=> 'panel',
            //                 'title'		=> __( 'Margin and Animation', 'exponent-modules' ),
            //                 'group'		=> array (
            //                     'margin',
            //                     'animate',
            //                     'animation_type',
            //                     'animation_delay',
            //                 )
            //             ),
            //         )	
            //     ),
            // ),
            'group_atts' => array (
                array (
                    'type'  => 'tabs',
                    'group' => array (
                        array (
                            'type'  => 'tab',
                            'title' => __( 'Content', 'exponent-modules' ),
                            'group' => array (
                                'api_key',
                                'id',
                                'button_text',
                                'success_text',
                                'success_text_color',
                                'success_text_bgcolor',
                            )
                        ),
                        array (
                            'type'  => 'tab',
                            'title' => __( 'Style', 'exponent-modules' ),
                            'group' => array (
                                'style',
                                'width',
                                'alignment',
                                'border_width',
                                array (
                                    'type'  => 'accordion',
                                    'group' => array (
                                        array (
                                            'type' => 'panel',
                                            'title' => __( 'Colors', 'exponent-modules' ),
                                            'group' => array (
                                                array (
                                                    'type'  => 'tabs',
                                                    'group' => array (
                                                        array (
                                                            'type'  => 'tab',
                                                            'title' => __( 'Normal', 'exponent-modules' ),
                                                            'group' => array (
                                                                'input_text_color',
                                                                'accent_color',
                                                                'input_bg_color',
                                                                'color',
                                                                'bg_color',
                                                                'border_color',
                                                            )
                                                        ),
                                                        array (
                                                            'type'  => 'tab',
                                                            'title' => __( 'Normal', 'exponent-modules' ),
                                                            'group' => array (
                                                                'hover_color',
                                                                'hover_bg_color',
                                                                'hover_border_color',
                                                            )
                                                        ),
                                                    )
                                                )
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
                    'att_name' => 'api_key',
                    'type' => 'text',
                    'label' => __( 'Mailchimp.com Api key', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => ''
                ),
                array (
                    'att_name' => 'id',
                    'type' => 'text',
                    'label' => __( 'Mailchimp.com List ID', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => ''
                ),
                array (
                    'att_name'		=> 'style',
                    'is_inline'     => true,
                    'type'			=> 'button_group',
                    'options'		=> array (
                        'pill'		=> 'Pill',
                        'rounded'	=> 'Rounded',
                    ),
                    'default'		=> 'rounded',
                    'label'			=> __( 'Style', 'exponent-modules' ),
                    'tooltip'		=> '',
                ),
                array (
                    'att_name' => 'width',
                    'type' => 'slider',
                    'label' => __( 'Width', 'exponent-modules' ),
                    'options' => array(
                        'min' => '0',
                        'max' => '100',
                        'step' => '1',
                        'unit' => '%',
                    ),	
                    'responsive'	=> true,
                    'css'		=> true,
                    'selectors'	=> array (
                        '.tatsu-{UUID} .exp-mc-email'	=> array (
                            'property'		=> 'width',
                            'append'		=> '%',
                        ),
                    ),
                    'default' => array('d' => '50', 'm' => '100'),
                    'tooltip' => ''
                ),
                array (
                    'att_name' => 'alignment',
                    'type' => 'button_group',
                    'is_inline' => true,
                    'label' => __( 'Align', 'exponent-modules' ),
                    'options' => array(
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right'
                    ),
                    'default' => 'center',
                    'tooltip' => ''
                ),
                array (
                    'att_name' => 'button_text',
                    'type' => 'text',
                    'label' => __( 'Button Text', 'exponent-modules' ),
                    'default' => __( 'Subscribe', 'exponent-modules' ),
                    'tooltip' => ''
                ),
                array(
                    'att_name' => 'success_text',
                    'type' => 'text',
                    'label' => __( 'Message After Success', 'exponent-modules' ),
                    'default' => __('Thank you, you have been added to our mailing list.','exponent-modules'),
                    'tooltip' => '',
                ),
                array (
                    'att_name' => 'success_text_color',
                    'type' => 'color',
                    'label' => __( 'Success Message color', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => '',
                ),
                array (
                    'att_name' => 'success_text_bgcolor',
                    'type' => 'color',
                    'label' => __( 'Success Message background color', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => '',
                ),
                array (
                    'att_name' => 'input_text_color',
                    'type' => 'color',
                    'label' => __( 'Email Text', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .exp-mc .exp-mc-email' =>  array(
                            'property' => 'color'
                        ),
                        '.tatsu-{UUID} .exp-mc .exp-mc-email::placeholder' =>  array(
                            'property' => 'color'
                        ),
                    ),
                ),
                array (
                    'att_name' => 'input_bg_color',
                    'type' => 'color',
                    'label' => __( 'Email Background', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .exp-mc .exp-mc-email' =>  array(
                            'property' => 'background'
                        ),
                    ),
                ),
                array (
                    'att_name' => 'bg_color',
                    'type' => 'color',
                    'label' => __( 'Button Background', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .exp-mc-submit' =>  array(
                            'property' => 'background'
                        ),
                        '.tatsu-{UUID} .exp-subscribe-loader'	=> array (
                            'property'	=> 'border-color',
                        ),
                    ),
                ),
                array (
                    'att_name' => 'hover_bg_color',
                    'type' => 'color',
                    'label' => __( 'Button Background', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .exp-mc-submit:hover' =>  array(
                            'property' => 'background'
                        ),
                    ),
                ),
                array (
                    'att_name' => 'color',
                    'type' => 'color',
                    'label' => __( 'Button Text', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .exp-mc-submit' =>  array(
                            'property' => 'color'
                        ),
                    ),
                ),
                array (
                    'att_name' => 'hover_color',
                    'type' => 'color',
                    'label' => __( 'Button Text', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .exp-mc-submit:hover' =>  array(
                            'property' => 'color'
                        ),
                    ),
                ),
                array (
                    'att_name' => 'border_width',
                    'type' => 'number',
                    'is_inline'     => true,
                    'label' => __( 'Button Border Width', 'exponent-modules' ),
                    'options' => array(
                        'unit' => 'px',
                    ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .exp-mc-submit' =>  array(
                            'property' => 'border',
                            'append' => 'px solid transparent',
                        ),
                    ),
                ),
                array (
                    'att_name' => 'border_color',
                    'type' => 'color',
                    'label' => __( 'Button Border', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => '',
                    'visible' => array( 'border_width', '!=', '0' ),
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .exp-mc-submit' =>  array(
                            'property' => 'border-color'
                        ),
                    ),
                ),
                array (
                    'att_name' => 'hover_border_color',
                    'type' => 'color',
                    'label' => __( 'Button Border', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => '',
                    'visible' => array( 'border_width', '!=', '0' ),
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} .exp-mc-submit:hover' =>  array(
                            'property' => 'border-color'
                        ),
                    ),
                ),
                array (
                    'att_name' => 'accent_color',
                    'type' => 'color',
                    'label' => __( 'Email Focus State', 'exponent-modules' ),
                    'default' => '',
                    'tooltip' => '',
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID} input.exp-mc-email:focus' =>  array(
                            'property' => 'border-color',
                        ),
                    ),
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
                    'responsive' => true,
                    'selectors' => array(
                        '.tatsu-{UUID}' => array(
                            'property' => 'border-style',
                            'when' => array(
                                array( 'border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                array( 'border', 'notempty' ),
                                array( 'border_style', '!=', array( 'd' => 'none' ) ),
                            ),
                            'relation' => 'and',            
                        ),
                    ),
                ),
                array (
                    'att_name' => 'border',
                    'type' => 'input_group',
                    'label' => __( 'Border Width', 'tatsu' ),
                    'default' => '',
                    'tooltip' => '',
                    'responsive' => true,
                    'css' => true,
                    'selectors' => array(
                        '.tatsu-{UUID}' => array(
                            'property' => 'border-width',
                            'when' => array(
                                array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                array( 'border_style', '!=', 'none' ),
                            ),
                            'relation' => 'and',
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
                            'when' => array(
                                array('border', '!=', array( 'd' => '0px 0px 0px 0px' ) ),
                                array( 'border_style', '!=', 'none' ),
                            ),
                            'relation' => 'and',
                        ),
                    ),
                ),
                array (
                    'att_name'	=> 'border_radius',
                    'type'		=> 'number',
                    'is_inline' => true,
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
            ),
            'presets' => array(
                'default' => array(
                    'title' => '',
                    'image' => '',
                    'preset' => array(
                        'color' => array( 'id' => 'palette:1', 'color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ),
                    ),
                )
            ),
        );
        tatsu_register_module( 'newsletter', $controls, 'exp_newsletter' );
    }
}

?>