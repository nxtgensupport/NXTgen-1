<?php
/**************************************
			COUNTDOWN
**************************************/
if (!function_exists('exp_countdown')) {
	function exp_countdown( $atts, $content, $tag ) {
        $atts = shortcode_atts( array (
                'date_time' => '',
                'text_color' => '',
                'alignment' => 'center',
                'key' => be_uniqid_base36(true),
        ), $atts, $tag );
        
        extract( $atts );
        $custom_style_tag = be_generate_css_from_atts( $atts, $tag, $atts['key'] );
        $custom_class_name = ' tatsu-'.$atts['key'];


        $animate = isset( $animate ) && 1 == $animate && 'none' !== $animation_type ? 'tatsu-animate' : '';
        $data_attrs = be_get_animation_data_atts( $atts );
        ob_start();
?>
        <div class= "<?php echo "exp-countdown-wrap" .$custom_class_name . " exp-module " .$animate. " clearfix"; ?>" <?php echo $data_attrs; ?>>
        <div class="exp-countdown clearfix" data-time="<?php echo $date_time; ?>"></div>
        <?php echo $custom_style_tag; ?>
        </div>
<?php
        return ob_get_clean();
	}
}

if( !function_exists( 'exp_register_countdown' ) ) {
    add_action( 'tatsu_register_modules', 'exp_register_countdown');
    function exp_register_countdown() {
            $controls = array (
                'icon' => EXPONENT_MODULES_PLUGIN_URL.'/img/modules.svg#countdown',
                'title' => __( 'Countdown', 'exponent-modules' ),
                'is_js_dependant' => true,
                'type' => 'single',
                'is_built_in' => false,
                'group_atts' => array (
                    array (
                        'type'  => 'tabs',
                        'group' => array (
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Content', 'exponent-modules' ),
                                'group' => array (
                                    'date_time'
                                )
                            ),
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Style', 'exponent-modules' ),
                                'group' => array (
                                    'text_color',
                                    'alignment'
                                )
                            ),
                            array (
                                'type'  => 'tab',
                                'title' => __( 'Advanced', 'exponent-modules' ),
                                'group' => array (

                                )
                            ),
                        )
                    )
                ),
                'atts' => array (
                    array (
                        'att_name' => 'date_time',
                        'type' => 'text',
                        'label' => __( 'End Date & Time', 'exponent-modules' ),
                        'default' => '',
                        'tooltip' => ''
                    ),	        	
                    array (
                        'att_name' => 'text_color',
                        'type' => 'color',
                        'options' => array(
                            'gradient' => true,
                        ),
                        'label' => __( 'Text Color', 'exponent-modules' ),
                        'default' => '',
                        'tooltip' => '',
                        'css' => true,
                        'selectors' => array(
                            '.tatsu-{UUID} .countdown-section' => array(
                                'property' => 'color'
                            )
                        ),
                    ),
                    array (
                        'att_name' => 'alignment',
                        'type' => 'button_group',
                        'is_inline'     => true,
                        'label' => __( 'Align', 'exponent-modules' ),
                        'options' => array(
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right'
                        ),
                        'default' => 'center',
                        'css'	=> true,
                        'selectors'	=> array (
                            '.tatsu-{UUID} .countdown-section'	=> array (
                                'property'	=> 'text-align'
                            )
                        ),
                        'tooltip' => ''
                    ),
                ),
                        
                'presets' => array(
                    'default' => array(
                        'title' => '',
                        'image' => '',
                        'preset' => array(
                            'date_time' => '2018-01-01 00:00:00',
                        ),
                    )
                ),
            );
        tatsu_register_module( 'exp_countdown', $controls, 'exp_countdown' );
    }
}
?>