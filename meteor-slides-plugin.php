<?php
/*
	Plugin Name: Meteor Slides
	Description: Easily create responsive slideshows with WordPress that are mobile friendly and simple to customize.
	Plugin URI: http://jleuze.com/plugins/meteor-slides
	Author: Josh Leuze
	Author URI: http://jleuze.com/
	License: GPL2
	Version: 1.5.6.1
*/

/*  Copyright 2016 Josh Leuze (email : mail@jleuze.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	// Adds custom post type for Slides
	
	add_action( 'init', 'meteorslides_register_slides' );

	function meteorslides_register_slides() {
	
		$meteor_labels = array(

			'name'               => __( 'Slides', 'meteor-slides' ),
			'singular_name'      => __( 'Slide', 'meteor-slides' ),
			'add_new'            => __( 'Add New', 'meteor-slides' ),
			'add_new_item'       => __( 'Add New Slide', 'meteor-slides' ),
			'edit_item'          => __( 'Edit Slide', 'meteor-slides' ),
			'new_item'           => __( 'New Slide', 'meteor-slides' ),
			'view_item'          => __( 'View Slide', 'meteor-slides' ),
			'search_items'       => __( 'Search Slides', 'meteor-slides' ),
			'not_found'          => __( 'No slides found', 'meteor-slides' ),
			'not_found_in_trash' => __( 'No slides found in Trash', 'meteor-slides' ), 
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Slides', 'meteor-slides' )

		);
				
		if ( function_exists( 'members_get_capabilities' ) ) {
	
			$meteor_capabilities = array(
		
				'edit_post'          => 'meteorslides_edit_slide',
				'edit_posts'         => 'meteorslides_edit_slides',
				'edit_others_posts'  => 'meteorslides_edit_others_slides',
				'publish_posts'      => 'meteorslides_publish_slides',
				'read_post'          => 'meteorslides_read_slide',
				'read_private_posts' => 'meteorslides_read_private_slides',
				'delete_post'        => 'meteorslides_delete_slide',
				'delete_posts'       => 'meteorslides_delete_slides'

			);
			
			$meteor_capabilitytype = 'slide';
			
			$meteor_mapmetacap = false;
		
		} else {
		
			$meteor_capabilities = array(
		
				'edit_post'          => 'edit_post',
				'edit_posts'         => 'edit_posts',
				'edit_others_posts'  => 'edit_others_posts',
				'publish_posts'      => 'publish_posts',
				'read_post'          => 'read_post',
				'read_private_posts' => 'read_private_posts',
				'delete_post'        => 'delete_post',
				'delete_posts'       => 'delete_posts'

			);
			
			$meteor_capabilitytype = 'post';
			
			$meteor_mapmetacap = true;
		
		}
		
		$meteor_args = array(
	
			'labels'              => $meteor_labels,
			'public'              => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-images-alt2',
			'capability_type'     => $meteor_capabilitytype,
			'capabilities'        => $meteor_capabilities,
			'map_meta_cap'        => $meteor_mapmetacap,
			'hierarchical'        => false,
			'supports'            => array( 'title', 'thumbnail' ),
			'taxonomies'          => array( 'slideshow' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => true,
			'can_export'          => true,
			'show_in_nav_menus'   => false
		
		);
  
		register_post_type( 'slide', $meteor_args );
		
	}

	// Adds custom taxonomy for Slideshows
	
	add_action( 'init', 'meteorslides_register_taxonomy' );
	
	function meteorslides_register_taxonomy() {
	
		$meteor_tax_labels = array(
				
			'name'              => __( 'Slideshows', 'meteor-slides' ),
			'singular_name'     => __( 'Slideshow', 'meteor-slides' ),
			'search_items'      => __( 'Search Slideshows', 'meteor-slides' ),
			'popular_items'     => __( 'Popular Slideshows', 'meteor-slides' ),
			'all_items'         => __( 'All Slideshows', 'meteor-slides' ),
			'parent_item'       => __( 'Parent Slideshow', 'meteor-slides' ),
			'parent_item_colon' => __( 'Parent Slideshow:', 'meteor-slides' ),
			'edit_item'         => __( 'Edit Slideshow', 'meteor-slides' ),
			'update_item'       => __( 'Update Slideshow', 'meteor-slides' ),
			'add_new_item'      => __( 'Add New Slideshow', 'meteor-slides' ),
			'new_item_name'     => __( 'New Slideshow Name', 'meteor-slides' ),
			'menu_name'         => __( 'Slideshows', 'meteor-slides' )
				
		);
		
		if ( function_exists( 'members_get_capabilities' ) ) {
	
			$meteor_tax_capabilities = array(
		
				'manage_terms' => 'meteorslides_manage_slideshows',
				'edit_terms'   => 'meteorslides_manage_slideshows',
				'delete_terms' => 'meteorslides_manage_slideshows',
				'assign_terms' => 'meteorslides_edit_slides'

			);
		
		} else {
		
			$meteor_tax_capabilities = array(
		
				'manage_terms' => 'manage_categories',
				'edit_terms'   => 'manage_categories',
				'delete_terms' => 'manage_categories',
				'assign_terms' => 'edit_posts'

			);
		
		}
		
		$meteor_tax_args = array(
	
			'labels'            => $meteor_tax_labels,
			'public'            => true,
			'show_in_nav_menus' => false,
			'show_ui'           => true,
			'show_tagcloud'     => false,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'slideshow' ),
			'capabilities'      => $meteor_tax_capabilities
		
		);
	
		register_taxonomy( 'slideshow', 'slide', $meteor_tax_args );
		
	}
	
	// Adds featured image functionality for Slides
	
	add_action( 'after_setup_theme', 'meteorslides_featured_image_array', '9999' );

	function meteorslides_featured_image_array() {
	
		global $_wp_theme_features;

		if ( !isset( $_wp_theme_features['post-thumbnails'] ) ) {
		
			$_wp_theme_features['post-thumbnails'] = array( array( 'slide' ) );
			
		}

		elseif ( is_array( $_wp_theme_features['post-thumbnails'] ) ) {
        
			$_wp_theme_features['post-thumbnails'][0][] = 'slide';
			
		}
		
	}
	
	// Adds featured image size for Slides
	
	add_action( 'plugins_loaded', 'meteorslides_featured_image' );
	
	function meteorslides_featured_image() {
		
		$meteor_options = get_option( 'meteorslides_options' );
		
		$slide_width  = isset( $meteor_options['slide_width'] ) ? intval( $meteor_options['slide_width'] ) : 960;
		$slide_height = isset( $meteor_options['slide_height'] ) ? intval( $meteor_options['slide_height'] ) : 640;
				
		add_image_size( 'featured-slide', $slide_width, $slide_height, true );
		
		add_image_size( 'featured-slide-thumb', 250, 9999 );
	
	}

	// Updates max srcset size for Slide images larger than 1600px

	add_filter( 'max_srcset_image_width', 'meteorslides_filter_max_srcset', 10, 2 );

	function meteorslides_filter_max_srcset( $max_width, $size_array ) {
		$meteor_options     = get_option( 'meteorslides_options' );
		$meteor_slide_width = isset( $meteor_options['slide_width'] ) ? intval( $meteor_options['slide_width'] ) : 960;
		if ( $meteor_slide_width > 1600 ) {
			$max_width = $meteor_slide_width;
		}
		return $max_width;
	}
		
	// Adds CSS for the slideshow
	
	add_action( 'wp_enqueue_scripts', 'meteorslides_css' );

	function meteorslides_css() {
	
		if ( file_exists( get_stylesheet_directory()."/meteor-slides.css" ) ) {
					
			wp_enqueue_style( 'meteor-slides', get_stylesheet_directory_uri() . '/meteor-slides.css', array(), '1.0' );
					
		}
		
		elseif ( file_exists( get_template_directory()."/meteor-slides.css" ) ) {
								
			wp_enqueue_style( 'meteor-slides', get_template_directory_uri() . '/meteor-slides.css', array(), '1.0' );
		
		}
	
		else {
			
			wp_enqueue_style( 'meteor-slides', plugins_url('/css/meteor-slides.css', __FILE__), array(), '1.0' );
		
		}
		
	}
	
	// Adds JavaScript for the slideshow
	
	add_action( 'wp_enqueue_scripts', 'meteorslides_javascript' );
		
	function meteorslides_javascript() {
 		
		$meteor_options = get_option( 'meteorslides_options' );

		if( !is_admin() ) {
	  
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-cycle', plugins_url( '/js/jquery.cycle.all.js', __FILE__ ), array( 'jquery' ), '2.9999.5', true );
			wp_enqueue_script( 'jquery-metadata', plugins_url( '/js/jquery.metadata.v2.js', __FILE__ ), array( 'jquery' ), '2.0', true );
			wp_enqueue_script( 'jquery-touchswipe', plugins_url( '/js/jquery.touchSwipe.1.6.18.js', __FILE__ ), array( 'jquery' ), '1.6.18', true );
			
			if ( file_exists( get_stylesheet_directory()."/slideshow.js" ) ) {
                
				wp_enqueue_script( 'meteorslides-script', get_stylesheet_directory_uri() . '/slideshow.js', array('jquery', 'jquery-cycle', 'jquery-touchswipe'), '1.0', true );
                        
			}
            
			elseif ( file_exists( get_template_directory()."/slideshow.js" ) ) {
                
				wp_enqueue_script( 'meteorslides-script', get_template_directory_uri() . '/slideshow.js', array('jquery', 'jquery-cycle', 'jquery-touchswipe'), '1.0', true );
            
			}
        
			else {
                
				wp_enqueue_script( 'meteorslides-script', plugins_url( '/js/slideshow.js', __FILE__ ), array( 'jquery', 'jquery-cycle', 'jquery-touchswipe' ), '1.0', true );
            
			}
			
			$transition_speed = isset( $meteor_options['transition_speed'] ) ? intval( $meteor_options['transition_speed'] ) : 2000;
			$slide_duration = isset( $meteor_options['slide_duration'] ) ? intval( $meteor_options['slide_duration'] ) : 5000;
			$slide_height = isset( $meteor_options['slide_height'] ) ? intval( $meteor_options['slide_height'] ) : 640;
			$slide_width = isset( $meteor_options['slide_width'] ) ? intval( $meteor_options['slide_width'] ) : 940;
			$transition_style = isset( $meteor_options['transition_style'] ) ? $meteor_options['transition_style'] : 'fade';
			
			wp_localize_script( 'meteorslides-script', 'meteorslidessettings',
			
				array(
				
					'meteorslideshowspeed'      => $transition_speed,
					'meteorslideshowduration'   => $slide_duration,
					'meteorslideshowheight'     => $slide_height,
					'meteorslideshowwidth'      => $slide_width,
					'meteorslideshowtransition' => $transition_style
					
				)
				
			);
			
		}
	
	}
	
	// Load admin functions if in the backend
	
	if ( is_admin() ) {
	
		require_once( 'includes/meteor-slides-admin.php' );
	
	}
	
	// Adds default values for options on settings page
	
	register_activation_hook( __FILE__, 'meteorslides_default_options' );
	
	function meteorslides_default_options() {
	
		$meteor_temp = get_option( 'meteorslides_options' );
		
		if ( ( !is_array( $meteor_temp ) ) || ( empty( $meteor_temp['slideshow_quantity'] ) ) ) {

			$meteor_defaults_args = array(
			
				'slideshow_quantity'   => '5',
				'slide_height'         => '640',
				'slide_width'          => '960',
				'transition_style'     => 'fade',
				'transition_speed'     => '2000',
				'slide_duration'       => '5000',
				'slideshow_navigation' => 'navnone'
				
			);	
			
			update_option( 'meteorslides_options', $meteor_defaults_args );
	
		}

	}
	
	// Adds function to load slideshow in theme
		
	function meteor_slideshow( $slideshow='', $metadata='' ) {
		
		if ( file_exists( get_stylesheet_directory()."/meteor-slideshow.php" ) ) {
					
			include( get_stylesheet_directory() . '/meteor-slideshow.php' );
			
		}
		
		elseif ( file_exists( get_template_directory()."/meteor-slideshow.php" ) ) {
								
			include( get_template_directory() . '/meteor-slideshow.php' );
		
		}
	
		else {
			
			include( 'includes/meteor-slideshow.php' );
		
		}
	
	}
		
		/* To load the slideshow, add this line to your theme:
	
			<?php if(function_exists('meteor_slideshow')) { meteor_slideshow(); } ?>
	
		*/
		
	// Adds shortcode to load slideshow in content
	
	function meteor_slideshow_shortcode( $meteor_atts ) {
	
		$meteor_atts = shortcode_atts( array (
		
			'slideshow' => '',
			'metadata'  => '',
			
		), $meteor_atts );
		
		$slideshow_att = sanitize_key( $meteor_atts['slideshow'] );
		
		$metadata_att = wp_kses( $meteor_atts['metadata'], array() );
	
		ob_start();
		
		meteor_slideshow( $slideshow=$slideshow_att, $metadata=$metadata_att );
		
		$meteor_slideshow_content = ob_get_clean();
		
		return $meteor_slideshow_content;
	
	}
	
	add_shortcode( 'meteor_slideshow', 'meteor_slideshow_shortcode' );
	
		/* To load the slideshow, add this line to your page or post:
	
			[meteor_slideshow]
	
		*/
		
// Adds widget to load slideshow in sidebar
include( 'includes/meteor-slides-widget.php' );