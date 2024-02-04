<?php 

if( !function_exists( 'be_gdpr_popup_for_exponent' ) ) {
    function be_gdpr_popup_for_exponent(){
        $privacy_popup_with_mobx = '<a href="#gdpr-popup" class="mobx privacy-settings" data-type="HTML" >'. get_option( 'be_gdpr_popup_title_text','Privacy Settings' ) .'</a>';
        return $privacy_popup_with_mobx;
    }
    add_filter('be_gdpr_privacy_settings_popup', 'be_gdpr_popup_for_exponent');
}

if ( ! function_exists( 'exponent_be_gdpr_options' ) ) {
    function exponent_be_gdpr_options(){
        $options = array(
            'youtube' => array(
                'label' => "Youtube",
                'description' => esc_html__( "Consent to display content from YouTube.", 'exponent' ),
                'required' => false
            ),
            'vimeo' => array(
                'label' => "Vimeo",
                'description' => esc_html__( "Consent to display content from Vimeo.", 'exponent' ),
                'required' => false
            ), 
            'gmaps' => array(
                'label' => "Google Maps",
                'description' => esc_html__( "Consent to display content from Google Maps.", 'exponent' ),
                'required' => false
			),
			'spotify' => array(
                'label' => "Spotify",
                'description' => esc_html__( "Consent to display content from Spotify.", 'exponent' ),
                'required' => false
			),
			'soundcloud' => array(
                'label' => "Sound Cloud",
                'description' => esc_html__( "Consent to display content from Sound Cloud.", 'exponent' ),
                'required' => false
            ),
        );
        foreach( $options as $option => $value ){
            be_gdpr_register_option($option,$value);
        }
    }
}
add_action('be_gdpr_register_options','exponent_be_gdpr_options');