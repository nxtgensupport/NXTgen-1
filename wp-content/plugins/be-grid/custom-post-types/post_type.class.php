<?php

/**
 * Post Type class used to register post types
 * Can call add_taxonomy and add_meta_box to call the associated classes
 * Method chaining is possible
 *
 * @author 	Gijs Jorissen
 * @since 	0.1
 *
 */
if( !class_exists( 'Be_Grid_Cuztom_Post_Type' ) ){
	class Be_Grid_Cuztom_Post_Type {
		var $name;
		var $title;
		var $plural;
		var $args;
		var $labels;
		var $add_features;
		var $remove_features;
		
		
		
		/**
		 * Construct a new Cuztom Post Type
		 *
		 * @param 	string|array 	$name
		 * @param 	array 			$args
		 * @param 	array 			$labels
		 *
		 * @author 	Gijs Jorissen
		 * @since 	0.1
		 *
		 */
		function __construct( $name, $args = array(), $labels = array() ) {
			if( ! empty( $name ) ) {
				// If $name is an array, the first element is the normal name, the second is the plural name
				if( is_array( $name ) ) {
					$this->name		= Be_Grid_Cuztom::uglify( $name[0] );
					$this->title	= Be_Grid_Cuztom::beautify( $name[0] );
					$this->plural 	= Be_Grid_Cuztom::beautify( $name[1] );
				}
				else {
					$this->name		= Be_Grid_Cuztom::uglify( $name );
					$this->title	= Be_Grid_Cuztom::beautify( $name );
					$this->plural 	= Be_Grid_Cuztom::pluralize( Be_Grid_Cuztom::beautify( $name ) );
				}

				$this->args 		= $args;
				$this->labels 		= $labels;
				$this->add_features	= $this->remove_features	= array();
				

				// Add action to register the post type, if the post type doesnt exist
				if( ! post_type_exists( $this->name ) ) {
					add_action( 'init', array( &$this, 'register_post_type' ) );
				}
			}
		}
		
		
		/**
		 * Register the Post Type
		 * 
		 * @author 	Gijs Jorissen
		 * @since 	0.1
		 *
		 */
		function register_post_type() {

			//$this->slug = 'portfolio';
			// Set labels
			$labels = array_merge(

				// Default
				array(
					'name' 					=> _x( $this->plural, 'post type general name', BE_GRID_CUZTOM_TEXTDOMAIN ),
					'singular_name' 		=> _x( $this->title, 'post type singular title', BE_GRID_CUZTOM_TEXTDOMAIN ),
					'add_new' 				=> _x( 'Add New', $this->title, BE_GRID_CUZTOM_TEXTDOMAIN ),
					'add_new_item' 			=> sprintf( __( 'Add New %s', BE_GRID_CUZTOM_TEXTDOMAIN ), $this->title ),
					'edit_item' 			=> sprintf( __( 'Edit %s', BE_GRID_CUZTOM_TEXTDOMAIN ), $this->title ),
					'new_item' 				=> sprintf( __( 'New %s', BE_GRID_CUZTOM_TEXTDOMAIN ), $this->title ),
					'all_items' 			=> sprintf( __( 'All %s', BE_GRID_CUZTOM_TEXTDOMAIN ), $this->plural ),
					'view_item' 			=> sprintf( __( 'View %s', BE_GRID_CUZTOM_TEXTDOMAIN ), $this->title ),
					'search_items' 			=> sprintf( __( 'Search %s', BE_GRID_CUZTOM_TEXTDOMAIN ), $this->plural ),
					'not_found' 			=> sprintf( __( 'No %s found', BE_GRID_CUZTOM_TEXTDOMAIN ), $this->plural ),
					'not_found_in_trash' 	=> sprintf( __( 'No %s found in trash', BE_GRID_CUZTOM_TEXTDOMAIN ), $this->plural ),
					'menu_name' 			=> $this->plural,
				),

				// Given labels
				$this->labels

			);

			// Post type arguments
			$args = array_merge( 
				// Default
				array(
					'label' 				=> $this->plural,
					'labels' 				=> $labels,
					'public' 				=> true,
					'supports' 				=> array( 'title', 'editor','thumbnail','excerpt' ),
					'has_archive'           => sanitize_title( $this->plural ),
					'rewrite' 				=> array( 
						'slug' 			=> apply_filters('be_grid_post_type_slug',$this->name),
					),
				),

				// Given args
				$this->args

			);

			// Register the post type
			register_post_type( $this->name, $args );
		}
		
		
		/**
		 * Add a taxonomy to the Post Type
		 *
		 * @param 	string|array 	$name
		 * @param 	array 			$args
		 * @param 	array 			$labels
		 * @return  object 			Be_Grid_Cuztom_Post_Type
		 *
		 * @author 	Gijs Jorissen
		 * @since 	0.1
		 *
		 */
		function Add_Categories_Style_Taxonomy( $name, $args = array(), $labels = array() ) {
			// Call Cuztom_Taxonomy with this post type name as second parameter
			$taxonomy = new Be_Grid_Cuztom_Taxonomy( $name, $this->name, $args, $labels, $hierarchical=true );
			
			// For method chaining
			return $this;
		}
		
		/**
		 * Add a taxonomy to the Post Type
		 *
		 * @param 	string|array 	$name
		 * @param 	array 			$args
		 * @param 	array 			$labels
		 * @return  object 			Be_Grid_Cuztom_Post_Type
		 *
		 * @author 	Gijs Jorissen
		 * @since 	0.1
		 *
		 */
		function Add_Tags_Style_Taxonomy( $name, $args = array(), $labels = array() ) {
			// Call Cuztom_Taxonomy with this post type name as second parameter
			$taxonomy = new Be_Grid_Cuztom_Taxonomy( $name, $this->name, $args, $labels, $hierarchical=false );
			
			// For method chaining
			return $this;
		}
	}
}
/**
 * Registers a Post Type
 *
 * @param 	string|array 	$name
 * @param 	array 			$args
 * @param 	array 			$labels
 * @return 	object 			Be_Grid_Cuztom_Post_Type
 *
 * @author 	Gijs Jorissen
 * @since 	0.8
 *
 */
if( !function_exists( 'Be_Grid_Create_Custom_Post_Type' ) ){
	function Be_Grid_Create_Custom_Post_Type( $name, $args = array(), $labels = array() ) {
		$post_type = new Be_Grid_Cuztom_Post_Type( $name, $args, $labels );
		return $post_type;
	}
}