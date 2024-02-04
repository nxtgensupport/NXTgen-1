<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/classes/class-tgm-plugin-activation.php';

if( !function_exists( 'be_themes_register_required_plugins' ) ) {
	add_action( 'tgmpa_register', 'be_themes_register_required_plugins' );
	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register two plugins - one included with the TGMPA library
	 * and one from the .org repo.
	 *
	 * The variable passed to tgmpa_register_plugins() should be an array of plugin
	 * arrays.
	 *
	 * This function is hooked into tgmpa_init, which is fired within the
	 * TGM_Plugin_Activation class constructor.
	 */
	function be_themes_register_required_plugins() {
		$tgmData = be_get_theme_tgm_data(array(
			'tatsu'=>array(
				'download_url'=>'https://brandexponents.com/be-plugins/tatsu.zip',
				'version'=>'3.3.5',
			),
			'exponent-demos'=>array(
				'download_url'=>'https://brandexponents.com/exponent-plugins/exponent-demos.zip',
				'version'=>'1.3.0',
			),
			'exponent-modules'=>array(
				'download_url'=>'https://brandexponents.com/be-plugins/exponent-modules.zip',
				'version'=>'2.1.3',
			),
			'typehub'=>array(
				'download_url'=>'https://brandexponents.com/oshin-plugins/typehub.zip',
				'version'=>'2.0.5',
			),
			'colorhub'=>array(
				'download_url'=>'https://brandexponents.com/oshin-plugins/colorhub.zip',
				'version'=>'1.0.6',
			),
			'be-grid'=>array(
				'download_url'=>'https://brandexponents.com/be-plugins/be-grid.zip',
				'version'=>'1.2.8',
			),
			'revslider'=>array(
				'download_url'=>'https://brandexponents.com/thirdparty-plugins/revslider.zip',
				'version'=>'6.5.5',
			),
			'meta-box-conditional-logic'=>array(
				'download_url'=>'https://brandexponents.com/thirdparty-plugins/meta-box-conditional-logic.zip',
				'version'=>'1.6.13',
			),
			'meta-box-show-hide'=>array(
				'download_url'=>'https://brandexponents.com/thirdparty-plugins/meta-box-show-hide.zip',
				'version'=>'1.3.0',
			),
			'be-gdpr'=>array(
				'download_url'=>'https://brandexponents.com/oshin-plugins/be-gdpr.zip',
				'version'=>'1.1.3',
			)
		));
		
		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// array(
			// 	'name' 		=> 'Contact Form 7',
			// 	'slug' 		=> 'contact-form-7',				
			// ),
			array(
				'name' 		=> 'WPForms Lite',
				'slug' 		=> 'wpforms-lite',				
			),
			array(
				'name' 		=> 'Meta Box Framework',
				'slug' 		=> 'meta-box',				
			),
			array(
				'name' 		=> 'Kirki Cutomizer Toolkit',
				'slug' 		=> 'kirki',				
			),
			array (
				'name'		=> 'Safe SVG',
				'slug'		=> 'safe-svg',
			),
			array(
				'name'     				=> 'Tatsu', // The plugin name
				'slug'     				=> 'tatsu', // The plugin slug (typically the folder name)
				'source'   				=> empty($tgmData['tatsu'])?'https://brandexponents.com/be-plugins/tatsu.zip':$tgmData['tatsu']['download_url'], // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> empty($tgmData['tatsu'])?'3.3.5':$tgmData['tatsu']['version'], // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'     				=> 'Exponent Demos', // The plugin name
				'slug'     				=> 'exponent-demos', // The plugin slug (typically the folder name)
				'source'   				=> empty($tgmData['exponent-demos'])?'https://brandexponents.com/exponent-plugins/exponent-demos.zip':$tgmData['exponent-demos']['download_url'], // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> empty($tgmData['exponent-demos'])?'1.3.0':$tgmData['exponent-demos']['version'], // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),	
				
			array(
				'name'     				=> 'Exponent Modules', // The plugin name
				'slug'     				=> 'exponent-modules', // The plugin slug (typically the folder name)
				'source'   				=> empty($tgmData['exponent-modules'])?'https://brandexponents.com/be-plugins/exponent-modules.zip':$tgmData['exponent-modules']['download_url'], // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> empty($tgmData['exponent-modules'])?'2.1.3':$tgmData['exponent-modules']['version'], // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

			// array(
			// 	'name'     				=> 'Typehub', // The plugin name
			// 	'slug'     				=> 'typehub', // The plugin slug (typically the folder name)
			// 	'source'   				=> empty($tgmData['typehub'])?'https://brandexponents.com/oshin-plugins/typehub.zip':$tgmData['typehub']['download_url'], // The plugin source
			// 	'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			// 	'version' 				=> empty($tgmData['typehub'])?'2.0.5':$tgmData['typehub']['version'], // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			// 	'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			// 	'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			// 	'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			// ),

			// array(
			// 	'name'     				=> 'Colorhub', // The plugin name
			// 	'slug'     				=> 'colorhub', // The plugin slug (typically the folder name)
			// 	'source'   				=> empty($tgmData['colorhub'])?'https://brandexponents.com/oshin-plugins/colorhub.zip':$tgmData['colorhub']['download_url'], // The plugin source
			// 	'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			// 	'version' 				=> empty($tgmData['colorhub'])?'1.0.6':$tgmData['colorhub']['version'], // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			// 	'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			// 	'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			// 	'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			// ),

			array(
				'name'     				=> 'BE Grid', // The plugin name
				'slug'     				=> 'be-grid', // The plugin slug (typically the folder name)
				'source'   				=> empty($tgmData['be-grid'])?'https://brandexponents.com/be-plugins/be-grid.zip':$tgmData['be-grid']['download_url'], // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> empty($tgmData['be-grid'])?'1.2.8':$tgmData['be-grid']['version'], // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),	

			array(
				'name'     				=> 'Slider Revolution', // The plugin name
				'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
				'source'   				=> empty($tgmData['revslider'])?'https://brandexponents.com/thirdparty-plugins/revslider.zip':$tgmData['revslider']['download_url'], // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> empty($tgmData['revslider'])?'6.5.3':$tgmData['revslider']['version'], // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
	
			array(
				'name'     				=> 'Meta Box Conditional Logic', // The plugin name
				'slug'     				=> 'meta-box-conditional-logic', // The plugin slug (typically the folder name)
				'source'   				=> empty($tgmData['meta-box-conditional-logic'])?'https://brandexponents.com/thirdparty-plugins/meta-box-conditional-logic.zip':$tgmData['meta-box-conditional-logic']['download_url'], // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> empty($tgmData['meta-box-conditional-logic'])?'1.6.13':$tgmData['meta-box-conditional-logic']['version'], // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),	

			array(
				'name'     				=> 'Meta Box Show Hide', // The plugin name
				'slug'     				=> 'meta-box-show-hide', // The plugin slug (typically the folder name)
				'source'   				=> empty($tgmData['meta-box-show-hide'])?'https://brandexponents.com/thirdparty-plugins/meta-box-show-hide.zip':$tgmData['meta-box-show-hide']['download_url'], // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> empty($tgmData['meta-box-show-hide'])?'1.3.0':$tgmData['meta-box-show-hide']['version'], // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),				
			array(
				'name'     				=> 'BE GDPR Compliance', // The plugin name
				'slug'     				=> 'be-gdpr', // The plugin slug (typically the folder name)
				'source'   				=> empty($tgmData['be-gdpr'])?'https://brandexponents.com/oshin-plugins/be-gdpr.zip':$tgmData['be-gdpr']['download_url'], // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> empty($tgmData['be-gdpr'])?'1.1.3':$tgmData['be-gdpr']['version'], // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
		);

		// Change this to your theme text domain, used for internationalising strings
		$theme_text_domain = 'exponent';

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'       		=> 'exponent',         	// Text domain - likely want to be the same as your theme.
			'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
			'parent_slug' 	=> 'themes.php', 				// Default parent menu slug
			'menu'         		=> 'install-required-plugins', 	// Menu slug
			'has_notices'      	=> true,                       	// Show admin notices or not
			'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
			'message' 			=> '',							// Message to output right before the plugins table
			'strings'      		=> array(
				'page_title'                       			=> __( 'Install Required Plugins', 'exponent' ),
				'menu_title'                       			=> __( 'Install Plugins', 'exponent' ),
				'installing'                       			=> __( 'Installing Plugin: %s', 'exponent' ), // %1$s = plugin name
				'oops'                             			=> __( 'Something went wrong with the plugin API.', 'exponent' ),
				'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'exponent' ), // %1$s = plugin name(s)
				'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'exponent' ), // %1$s = plugin name(s)
				'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'exponent' ), // %1$s = plugin name(s)
				'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'exponent' ), // %1$s = plugin name(s)
				'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'exponent' ), // %1$s = plugin name(s)
				'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'exponent' ), // %1$s = plugin name(s)
				'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'exponent' ), // %1$s = plugin name(s)
				'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'exponent' ), // %1$s = plugin name(s)
				'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'exponent' ),
				'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'exponent' ),
				'return'                           			=> __( 'Return to Required Plugins Installer', 'exponent' ),
				'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'exponent' ),
				'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'exponent'), // %1$s = dashboard link
				'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
			)
		);

		tgmpa( $plugins, $config );

	}
}