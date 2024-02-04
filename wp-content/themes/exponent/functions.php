<?php
load_theme_textdomain( 'exponent', get_template_directory() . '/languages' );
add_filter( 'auto_update_theme', '__return_true' );
if ( ! isset( $content_width ) ) {
	$content_width = 1160;
}
add_editor_style('css/custom-editor-style.css'); 

/* -------------------------------------------
			Theme Setup
---------------------------------------------  */
if ( ! function_exists( 'exponent_theme_setup' ) ) {
	function exponent_theme_setup() {
		register_nav_menu( 'main_nav', 'Main Menu' );
		register_nav_menu( 'footer_nav', 'Footer Menu' );	
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'gallery', 'image', 'quote', 'video', 'audio','link' ) );
		add_theme_support( 'tatsu-global-sections' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'tatsu-header-builder' );
		add_theme_support( 'tatsu-footer-builder' );
		add_theme_support( 'custom-logo', array(
			'height'      => 100,
			'width'       => 400,
			'flex-width' => true,
		) );
	}
	add_action( 'after_setup_theme', 'exponent_theme_setup' );
}

/* ---------------------------------------------  */
// Welcome Screen
/* ---------------------------------------------  */

require_once( get_template_directory() . '/lib/start-page/ExponentRegister.php' );
require_once( get_template_directory() . '/lib/start-page/ExponentAdminMenu.php' );
require_once( get_template_directory() . '/lib/start-page/ExponentInstallPlugins.php' );
require_once( get_template_directory() . '/lib/start-page/ExponentRedirect.php' );
require_once( get_template_directory() . '/lib/admin-tpl/extra.php' );

if ( ! function_exists( 'exponent_config' ) ) {
	function exponent_config( $ExponentCore ) {
		$ExponentCore->offsetSet( 'themeName', 'Exponent' );
		$ExponentCore->offsetSet( 'documentation', 'https://exponentwptheme.com/documentation' );
		$ExponentCore->offsetSet( 'themePath', get_stylesheet_directory() );
		$ExponentCore->offsetSet( 'themeUri', get_stylesheet_directory_uri() );
		$ExponentCore['exponent_admin_menu'] = new ExponentAdminMenu( $ExponentCore );
		$ExponentCore['exponent_register'] = new ExponentRegister( $ExponentCore );
		$ExponentCore['exponent_plugins'] = new ExponentInstallPlugins( $ExponentCore );
		$ExponentCore['exponent_redirect'] = new ExponentRedirect( $ExponentCore );
	}
	add_filter( 'exponent_demos_config', 'exponent_config', 10, 1 );
}

if ( ! function_exists( 'exponent_core' ) ) {
	function exponent_core() {
		if ( ! class_exists( 'ExponentDemosCore' ) ) {
			$ExponentCore = array();
			global $ExponentCore;
			$ExponentCore['themeName'] = 'Exponent';
			$ExponentCore['themePath'] = get_stylesheet_directory();
			$ExponentCore['documentation'] = 'https://exponentwptheme.com/documentation';
			$start_menu = new ExponentAdminMenu( $ExponentCore );
			$updater = new ExponentRegister( $ExponentCore );
			$default_plugins = new ExponentInstallPlugins( $ExponentCore );
			$redirect = new ExponentRedirect( $ExponentCore );
			$start_menu->run();
			$updater->run();
			$default_plugins->run();
			$redirect->run();
		}
	}
	add_action( 'init', 'exponent_core', 10, 1 );
}


/* ---------------------------------------------  */
// Includes
/* ---------------------------------------------  */

//Core Helpers
require_once trailingslashit( get_template_directory() ) . 'inc/helpers/theme-helpers.php';
require_once trailingslashit( get_template_directory() ) . 'inc/helpers/be-helpers.php';
require_once trailingslashit( get_template_directory() ) . 'inc/helpers/helpers.php';

//Admin Options
require_once trailingslashit( get_template_directory() ) . 'inc/admin/init.php';

//Widgets
require_once trailingslashit( get_template_directory() ) . 'inc/widgets/init.php';

//Integrations
include_once trailingslashit( get_template_directory() ) . 'inc/integrations/init.php';

//WooCommerce
if ( be_themes_is_woocommerce_activated() ) {
	require_once trailingslashit( get_template_directory() ) . 'woocommerce/exponent-woo-functions.php';
}

/* ---------------------------------------------  */
// Specifying the various image sizes for theme
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_image_sizes' ) ) {
	function be_themes_image_sizes( $sizes ) {
		global $_wp_additional_image_sizes;
		if ( empty( $_wp_additional_image_sizes ) )
			return $sizes;
		foreach ( $_wp_additional_image_sizes as $id => $data ) {
			if ( !isset($sizes[$id]) )
				$sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
		}
		return $sizes;
	}
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'exponent-blog-image', 1160, 700, true);
	add_image_size( 'exponent-blog-image-with-aspect-ratio', 1160, 0, true);
	add_image_size( 'exponent-carousel-thumb', 0, 50, true );

	add_filter( 'image_size_names_choose', 'be_themes_image_sizes' );
}

/* ---------------------------------------------  */
// Enqueue Stylesheets
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_add_styles' ) ) {
	function be_themes_add_styles() {		
		$theme_version = be_themes_get_theme_info( 'Version' );
		$theme_name = be_themes_get_theme_info( 'name' );
		$theme_name = lcfirst( $theme_name );
		$suffix =  be_themes_should_minify_assets() ? '.min' : '';
		$cdn_address = be_themes_get_option( 'cdn_address' );
		$template_directory_url = get_template_directory_uri();
		$stylesheet_url = get_stylesheet_uri();
		if( !empty( $cdn_address ) ) {
			$site_url = get_site_url();
			if( false !== strpos( $template_directory_url, $site_url ) ) {
				$template_directory_url = str_replace( $site_url, $cdn_address, $template_directory_url );
			}
			if( false !== strpos( $stylesheet_url, $site_url ) ) {
				$stylesheet_url = str_replace( $site_url, $cdn_address, $stylesheet_url );
			}
		}

		wp_enqueue_style( 'exponent-core-icons', trailingslashit( $template_directory_url ) . 'fonts/icons.css', array(), $theme_version );
		wp_enqueue_style( 'exponent-vendor', trailingslashit( $template_directory_url ) . 'css/vendor/vendor' . $suffix . '.css', array(), $theme_version );
		wp_enqueue_style( 'exponent-main-css', trailingslashit( $template_directory_url ) . 'css/main' . $suffix . '.css', array( 'exponent-vendor' ), $theme_version );		
		wp_register_style( 'exponent-style-css', $stylesheet_url, array( 'exponent-main-css' ), $theme_version );
		wp_enqueue_style( 'exponent-style-css' );
	}
	add_action( 'wp_enqueue_scripts', 'be_themes_add_styles');
}

/* ---------------------------------------------  */
// Enqueue scripts
/* ---------------------------------------------  */
if ( ! function_exists( 'be_themes_add_scripts' ) ) {
	function be_themes_add_scripts() {
		$theme_info = be_themes_get_theme_info();
		$theme_name = lcfirst( $theme_info[ 'name' ] );
		$main_script_name = $theme_name . '-main-js';
		$theme_version = $theme_info[ 'version' ];
		$query_string = '?ver=' . $theme_version; 
		$suffix =  be_themes_should_minify_assets() ? '.min' : '';
		$cdn_address = be_themes_get_option( 'cdn_address' );
		$template_directory_url = get_template_directory_uri();
		$vendor_scripts_url = trailingslashit( $template_directory_url ) . 'js/vendor/';
		if ( ! empty( $cdn_address ) ) {
			$site_url = get_site_url();
			if ( false !== strpos( $template_directory_url, $site_url ) ) {
				$template_directory_url = str_replace( $site_url, $cdn_address, $template_directory_url );
				$vendor_scripts_url 	= trailingslashit( $template_directory_url ) . 'js/vendor/';
			}
		}

		wp_enqueue_script( 'asyncloader', trailingslashit( $template_directory_url ) . 'js/vendor/asyncloader' . $suffix . '.js', array( 'jquery' ), $theme_version , true );
		wp_enqueue_script( 'be-script-helpers', trailingslashit( $template_directory_url ) . 'js/helpers' . $suffix . '.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'debouncedresize', trailingslashit( $template_directory_url ) . 'js/vendor/debouncedresize' . $suffix . '.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'modernizr', trailingslashit( $template_directory_url ) . 'js/vendor/modernizr' . $suffix . '.js', $theme_version, false );
		wp_enqueue_script( $main_script_name, trailingslashit( $template_directory_url ) . 'js/main' . $suffix . '.js', array( 'jquery', 'be-script-helpers', 'asyncloader', 'debouncedresize' ), $theme_version, true );

		$script_dependencies = array();
		foreach( glob( get_template_directory() . '/js/vendor/*' . $suffix . '.js' ) as $dependency ) {
			if ( '.min' === $suffix || false === strpos( $dependency, '.min.js' ) ) { 
				$current_index = basename( $dependency, $suffix.'.js' );
				$cur_dep = add_query_arg( 'ver',  $theme_version, $vendor_scripts_url . basename( $dependency ) );
				$script_dependencies[ $current_index ] = esc_url( $cur_dep );
			}
		}
		
		wp_localize_script(
			$main_script_name, 
			$theme_name . 'ThemeConfig', 
			array(
				'vendorScriptsUrl' => $vendor_scripts_url,
				'dependencies' => $script_dependencies,
				'ajaxurl'	=> esc_url( admin_url( 'admin-ajax.php' ) ),
				'version'	=> $theme_version
			) 
		);
		
	}
	add_action( 'wp_enqueue_scripts', 'be_themes_add_scripts' );
}

/* ---------------------------------------------  */
// Register Custom Font - Metropolis
/* ---------------------------------------------  */
if ( ! function_exists( 'exponent_register_custom_font' ) ) {
	function exponent_register_custom_font() {
		$metropolis = array(
			'name' => 'Metropolis',
			'src' => get_template_directory_uri().'/fonts/metropolis.css',
			'variants' => array(
				'300' 		=> 'Book 300',
				'400' 		=> 'Normal 400',
				'500' 		=> 'Medium 500',
				'600' 		=> 'Semi Bold 600',
				'700' 		=> 'Bold 700',
			)
		);
		typehub_register_font( $metropolis );
	}
	add_action( 'typehub_register_font', 'exponent_register_custom_font' );
}

/* ---------------------------------------------  */
// Default Typography when Typehub isn't active
/* ---------------------------------------------  */
if ( ! function_exists( 'exponent_default_typography' ) ) {
    function exponent_default_typography() {
		$typehub_store = get_option('typehub_data');
        if( !class_exists( 'Typehub' ) || empty( $typehub_store ) ) {
            $typehub_config = array();
            $css = '';
            foreach( glob( trailingslashit( get_template_directory() ) . 'inc/integrations/typehub/*.php' ) as $config_path ){
                $file_name = basename( $config_path, '.php' );
                if( 'typehub' === $file_name ) {
                    continue;
                }
                $new_config = include $config_path;
                $typehub_config = array_merge( $typehub_config, $new_config );
            }
            
            foreach( $typehub_config as $category => $fields ) {
                foreach( $fields as $key => $field ) {
					$selector = $field['selector'].', .'.$key;
                    $css .= $selector.' {';
                    foreach( $field['options'] as $property => $value ) {
                        if( 'font-family' === $property ) {
                            $value = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
						} 
						if( 'letter-spacing' === $property  ) {
							continue;
						}
						if( 'font-variant' === $property ) {
							$css .= 'font-weight:'.be_extract_font_weight( $value ).';';
							$css .= 'font-style:'.be_extract_font_style( $value ).';';
						} else {
							$css .= $property.':'.$value.';';
						}
                    }
                    $css .= '}';
                }
            }
			wp_add_inline_style( 'exponent-main-css', $css );
        }
    }
    add_action( 'wp_enqueue_scripts', 'exponent_default_typography' );
}

/* ---------------------------------------------  */
// Automatic Theme Updates
/* ---------------------------------------------  */
require_once( get_template_directory() . '/inc/classes/theme-update-checker.php' );
$exponent_update_checker = new ThemeUpdateChecker(
    'exponent',
    'https://brandexponents.com/wp-json/beepapi/v1/purchase-verifier'
);

if ( ! function_exists( 'exponent_pk_verify_vars' ) ) {
	function exponent_pk_verify_vars( $make_url = false) {
		$query_args = array(
			'theme' => 'exponent',
			'site_url' => site_url(),
			'user_email' => get_option( 'exponent_newsletter_email', '' )
		);
		return empty( $make_url ) ? $query_args : http_build_query( $query_args );
	}
}

add_filter( 'tuc_request_update_query_args-exponent',function( $query_args ) {
	$exponent_purchase_data = get_option( 'exponent_purchase_data', '' );
	if ( is_array( $exponent_purchase_data) && array_key_exists( 'theme_purchase_code', $exponent_purchase_data ) ) {
		$query_args['purchase_key'] = trim( $exponent_purchase_data['theme_purchase_code'] );
	} else {
		$query_args['purchase_key'] = '';
	}
	$vars = exponent_pk_verify_vars();
	$query_args = array_merge( $query_args, $vars );
	return $query_args;
} );

/***
 * Get Theme update data
 */
add_filter( 'tuc_request_update_result-exponent', function( $themeUpdate, $result ) {
	if ( is_wp_error( $result ) ) {
		return $themeUpdate;
	}

	$body = wp_remote_retrieve_body( $result );
	if ( ! empty( $body ) ) {
		$body = json_decode( $body );
		$theme_version = be_themes_get_theme_info( 'Version' );
		if ( ! empty( $body->version ) && version_compare( $body->version, $theme_version, '>' ) ) {
			update_option( 'exponent-latest-version', $body->version );
			if ( ! empty( $body->changelog_url ) ) {
				update_option('exponent-changelog_url', $body->changelog_url );
			}
			if ( ! empty( $body->theme_message ) ) {
				update_option( 'exponent-theme_message', $body->theme_message );
			} else {
				update_option( 'exponent-theme_message', '' );
			}
		} else {
			update_option( 'exponent-latest-version', '' );
			update_option('exponent-theme_message', '' );
		}
		if ( 200 == wp_remote_retrieve_response_code( $result ) ) {
			update_option( 'exponent-theme-invalid', '' );
		} else {
			update_option( 'exponent-theme-invalid', '1' );
		}
	}
	return $themeUpdate;
}, 10, 2 );

add_action( 'template_redirect', function() {
	$is_maintenance_mode_on = ! empty( be_themes_get_option( 'maintenance_mode_on' ) ) ? true : false;
    if ( $is_maintenance_mode_on && ( ! current_user_can( 'edit_themes' ) || ! is_user_logged_in() ) ) {
		include( TEMPLATEPATH . '/maintenance-mode.php' );
        die();
    }
} );

add_action( 'admin_notices', function() {
	$is_maintenance_mode_on = ! empty( be_themes_get_option( 'maintenance_mode_on' ) ) ? true : false;
	if ( $is_maintenance_mode_on ) {
		?>
		<div class="exponent-maintenance-mode notice notice-warning">
			<p><?php _e( 'Maintenance Mode is <strong>turned on</strong>. Please don\'t forget to <a href="' . admin_url( '/customize.php?autofocus[section]=global_theme_options' ) . '">turn it off</a> once you are done.', 'exponent' ); ?></p>
		</div>
		<?php
	}
} );

if ( ! function_exists( 'exponent_theme_update_notice' ) ) {
	function exponent_theme_update_notice( $return = false ) {
		$theme_notice = '';
		$exponent_version = get_option( 'exponent-latest-version', false );
		if ( ! $exponent_version ) {
			return;
		}

		$theme_version = be_themes_get_theme_info( 'Version' );
		if ( version_compare( $exponent_version, $theme_version, '>' ) ) {
			$exponent_purchase_data = get_option( 'exponent_purchase_data', '' );
			
			$changelog_url = get_option( 'exponent-changelog_url', false );
			$changelog_url = empty( $changelog_url ) ? admin_url( 'themes.php' ) : $changelog_url;

			$theme_message = get_option( 'exponent-theme_message',false );
			$theme_message = empty( $theme_message ) ? '' : $theme_message;

			if ( is_array( $exponent_purchase_data ) && array_key_exists( 'theme_purchase_code', $exponent_purchase_data ) ) {
				$msg = sprintf( '<a href="' . admin_url( 'themes.php?be_check_theme_update=1' ) . '">%1$s</a>', 
					esc_html( __( 'Please update now', 'exponent' ) )
				);
			} else {
				$msg = sprintf( '%1$s <a href="' . admin_url( 'themes.php?page=be_register#be-welcome' ) . '">%2$s</a>', 
					esc_html( __( 'Please provide valid Exponent theme purchase code to', 'exponent' ) ),
					esc_html( __( 'allow automatic updates', 'exponent' ) )
				);
			}

			$theme_notice = sprintf( '<div class="notice notice-info is-dismissible"><p><strong><a href="' . $changelog_url . '" target="_blank">Exponent %1$s</a> %2$s. %3$s ' . $theme_version . '. '. $msg . '. ' . $theme_message . '</strong></p></div>', 
				$exponent_version,
				esc_html( __( 'is available', 'exponent' ) ),
				esc_html( __( 'Current version is', 'exponent' ) )
			);
		} 

		if ( $return === true ) {
			return $theme_notice;
		} else {
			echo $theme_notice;
		}
	}
	add_action( 'admin_notices', 'exponent_theme_update_notice' );
}

add_action( 'admin_print_styles', function() {
	echo '<style>';
	echo '#meta-box-conditional-logic-update,#meta-box-show-hide-update,#meta-box-tabs-update,#meta-box-notification,.rwmb-activate-license{
		display:none;
	}';
	echo '</style>';
} );

add_action( 'admin_print_footer_scripts', function() {
	$current_screen = get_current_screen()->base;
	if ( $current_screen == 'plugins' ) {
		echo '<script>';
			echo "jQuery('.wp-list-table.plugins #the-list').find('tr[data-slug = meta-box-show-hide] td span a:contains(Activate License)').css('display','none');";
			echo "jQuery('.wp-list-table.plugins #the-list').find('tr[data-slug = meta-box-conditional-logic] td span a:contains(Activate License)').css('display','none');";
			echo "jQuery('.wp-list-table.plugins #the-list').find('tr[data-slug = meta-box-tabs] td span a:contains(Activate License)').css('display','none');";
			echo "jQuery('.wp-list-table.plugins #the-list').find('tr[data-slug = meta-box] td span a:contains(Go Pro)').css('display','none');";
		echo '</script>';
	}
} );

/*Remove protected title from protected page*/
add_filter( 'protected_title_format', function( $content ) {
	return '%s';
} );

if ( ! function_exists( 'be_get_theme_tgm_data' ) ) {
	function be_get_theme_tgm_data( $plugin_slugs ) {
		$theme_version = be_themes_get_theme_info( 'Version' );

		//check if tgm data is already available
		$tgmData = get_option( 'exponent-themetgmdata', false );
		if ( ! empty( $tgmData ) && ! empty( $tgmData['version'] ) && version_compare( $tgmData['version'], $theme_version, '==' ) ) {
			return $tgmData;
		}
		
		//get purchase key
		$purchase_key = '';
		$exponent_purchase_data = get_option( 'exponent_purchase_data' );
		if ( $exponent_purchase_data && is_array( $exponent_purchase_data ) && array_key_exists( 'theme_purchase_code', $exponent_purchase_data ) ) {
			$purchase_key = trim( $exponent_purchase_data['theme_purchase_code'] );
		}
		if ( empty( $purchase_key ) ) {
			return $plugin_slugs;
		}

		$vars = exponent_pk_verify_vars( true );
		$vars = "https://brandexponents.com/wp-json/beepapi/v1/purchase-verifier?get_tgm=1&purchase_key=" . $purchase_key . "&" . $vars;
		
		$response = wp_remote_get( $vars, array(
			'timeout'   => 120,
			'sslverify' => false,
			'httpversion' => '1.1',
		) );
		if ( is_wp_error( $response ) ) {
			return $plugin_slugs;
		}

		$body = wp_remote_retrieve_body( $response );
		$body = json_decode( $body, true );
		if ( 200 == wp_remote_retrieve_response_code( $response ) && ! empty( $body )  && ! empty( $body['tgm'] ) ) {
			$tgm = array();
			$tgm['version'] = $theme_version;
			foreach ( $plugin_slugs as $slug => $plugin ) {
				$tgm[ $slug ] = empty( $body['tgm'][ $slug ] ) ? $plugin : $body['tgm'][ $slug ];
			}
			update_option( 'exponent-themetgmdata', $tgm );
			return $tgm;
		}

		return $plugin_slugs;
	}
}

if ( ! function_exists( 'be_themecheck_for_updates' ) ) {
	function be_themecheck_for_updates() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$theme_version = be_themes_get_theme_info( 'Version' );
		$exponent_version = get_option( 'exponent-latest-version' );
		if ( ! empty( $exponent_version ) && version_compare( $exponent_version, $theme_version, '>=' ) ) {
			return $exponent_version;
		}

		if ( class_exists( 'ThemeUpdateChecker' ) ) {
			$exponent_update_checker = new ThemeUpdateChecker(
				'exponent',
				'https://brandexponents.com/wp-json/beepapi/v1/purchase-verifier'
			);
			$exponent_update_checker->checkForUpdates();
			$exponent_version = get_option( 'exponent-latest-version', '' );
			return empty( $exponent_version ) ? $theme_version : $exponent_version;
		}
		return $exponent_version;
	}
}

add_action( 'current_screen', function() {
	if ( is_admin() && current_user_can( 'manage_options' ) && class_exists( 'ThemeUpdateChecker' ) ) {
		$current_screen = get_current_screen();
		if ( isset( $current_screen->base ) && ( 'themes' === $current_screen->base ) && ! empty( $_GET['be_check_theme_update'] ) ) {
			$exponent_update_checker = new ThemeUpdateChecker(
				'exponent',
				'https://brandexponents.com/wp-json/beepapi/v1/purchase-verifier'
			);
			$exponent_update_checker->checkForUpdates();
		}
	}
} );

// Display back to top button if tatsu footer is active.
add_action( 'tatsu_after_footer_builder_content', function() {
    $back_to_top = be_themes_get_option( 'back_to_top_btn' );
	if( ! empty( $back_to_top ) ) {
        $back_to_top_icon = '<svg width="14" height="9" viewBox="0 0 14 9" xmlns="http://www.w3.org/2000/svg"><path d="M13 7.37329L7 2.00004L1 7.37329" stroke-width="2" stroke-linecap="round"/></svg>';
        echo apply_filters( 'be_themes_back_to_top_btn', sprintf( '<a href="#" id="be-themes-back-to-top">%s</a>', $back_to_top_icon ) );
    }
} );

// Fix WooCommerce Cart Fragments JS in WC >= 7.8.0
add_action( 'wp_enqueue_scripts', function() {
	if ( wp_script_is( 'wc-cart-fragments', 'registered' ) && ! wp_script_is( 'wc-cart-fragments' ) ) {
		wp_enqueue_script( 'wc-cart-fragments' );
 	}
}, 99 );
?>