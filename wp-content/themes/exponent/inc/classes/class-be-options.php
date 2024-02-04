<?php
    class Be_Options {

        private static $theme_name;
        private $theme_version; 
        /**
         * The class constructor
         */
        public function __construct( $name, $version ) {
            self::$theme_name = $name;
            $this->theme_version = $version;
            $this->load_dependencies();
            $this->define_hooks();
        }

        private function load_dependencies() {
            require_once trailingslashit( get_template_directory() ) . 'inc/admin/customizer/custom-controls.php';
            require_once trailingslashit( get_template_directory() ) . 'inc/admin/options/helper.php';
        }

        public function enqueue_styles() {
            wp_enqueue_style( 'be_custom_controls_css', trailingslashit( get_template_directory_uri() ) . 'css/admin/customizer/controls.css', null, $this->theme_version, 'all'  );
        }

        public function register_custom_controls() {
            /**
             *  Custom Controls.
             *  Note that the classes defining these custom controls are required as dependency in load_dependencies(). 
             */
            add_filter( 'kirki_control_types', function( $controls ) {
                $controls[ 'be_responsive_number' ] = 'Be_Responsive_Number';
                $controls['be_color'] = 'Be_Color_Picker';
                $controls[ 'be_title' ] = 'Be_Title';
                $controls[ 'be_sub_title' ] = 'Be_Sub_Title';
                $controls[ 'be_separator' ] = 'Be_Separator';
                return $controls;
            } );  
        }

        private function define_hooks() {
            /**
             *  Register custom control. 
             */
            add_action( 'customize_register', array( $this, 'register_custom_controls' ) );

            /**
             *  Enqueue styles and scripts needed for custom controls.
             */
            add_action( 'customize_controls_print_styles', array( $this, 'enqueue_styles' ) );
        }

        public function load_options() {
            foreach( glob( trailingslashit( get_template_directory() ) . 'inc/admin/options/config/*.php' ) as $dependency ) {
                require_once $dependency;
            }
        }

        /**
         * Create a new panel
         *
         * @param   string      the ID for this panel
         * @param   array       the panel arguments
         */
        public static function add_panel( $id = '', $args = array() ) {
            Kirki::add_panel( $id, $args );
        }

        /**
         * Create a new section
         *
         * @param   string      the ID for this section
         * @param   array       the section arguments
         */
        public static function add_section( $id, $args ) {
            Kirki::add_section( $id, $args );
        }


        /**
         * Sets the configuration options.
         *
         * @param    array     $args         The configuration arguments
         */
        public function add_config( $args = array() ) {
            Kirki::add_config( self::$theme_name, $args );
        }

        /**
         * Create a new field
         *
         * @param    array     $args         The field's arguments
         */
        public static function add_field( $args ) {
            //fix for kirki issue https://github.com/kirki-framework/kirki/issues/2452
            if(!class_exists('Kirki_Control_Base') && !empty($args['type'])){
                static $be_count = 10;
                $args['priority']=$be_count++;//Order priority to load the control
            }
            Kirki::add_field( self::$theme_name, $args );
        }

    }

    $theme_data = be_themes_get_theme_info();
    $theme_options = new Be_Options( $theme_data[ 'name' ] , $theme_data[ 'version' ] );
    add_action('init', array( $theme_options, 'load_options' ));