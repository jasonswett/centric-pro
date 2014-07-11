<?php
/**
 * This file adds the Home Page to the Centric Theme.
 *
 * @author StudioPress
 * @package Centric
 * @subpackage Customizations
 */
 
add_action( 'wp_enqueue_scripts', 'centric_enqueue_home_scripts' );
/**
 * Enqueue Scripts
 */
function centric_enqueue_home_scripts() {

	wp_enqueue_script( 'centric-home', get_bloginfo( 'stylesheet_directory' ) . '/js/home.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
	wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
 	
}

add_action( 'genesis_meta', 'centric_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function centric_home_genesis_meta() {

	if ( is_active_sidebar( 'home-widgets-1' ) || is_active_sidebar( 'home-widgets-2' ) || is_active_sidebar( 'home-widgets-3' ) || is_active_sidebar( 'home-widgets-4' ) || is_active_sidebar( 'home-widgets-5' ) || is_active_sidebar( 'home-widgets-6' ) ) {

		//* Force full width content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		//* Add centric-pro-home body class
		add_filter( 'body_class', 'centric_body_class' );
		
		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		
		//* Add home featured widget
		add_action( 'genesis_after_header', 'centric_home_featured_widget', 1 );
		
		//* Add home widgets
		add_action( 'genesis_before_footer', 'centric_home_widgets', 5 );
		
	}
}

function centric_body_class( $classes ) {

	$classes[] = 'centric-pro-home';
	return $classes;
	
}

function centric_home_featured_widget() {

	genesis_widget_area( 'home-widgets-1', array(
		'before' => '<div class="home-featured"><div class="wrap"><div class="home-widgets-1 color-section widget-area">',
		'after'  => '</div></div></div>',
	) );
	
}

function centric_home_widgets() {

	echo '<div id="home-widgets" class="home-widgets">';
	
	genesis_widget_area( 'home-widgets-2', array(
		'before' => '<div class="home-widgets-2 widget-area">',
		'after'  => '</div>',
	) );
	
	genesis_widget_area( 'home-widgets-3', array(
		'before' => '<div class="home-widgets-3 color-section widget-area">',
		'after'  => '</div>',
	) );
	
	genesis_widget_area( 'home-widgets-4', array(
		'before' => '<div class="home-widgets-4 dark-section widget-area">',
		'after'  => '</div>',
	) );
	
	genesis_widget_area( 'home-widgets-5', array(
		'before' => '<div class="home-widgets-5 widget-area">',
		'after'  => '</div>',
	) );
	
	genesis_widget_area( 'home-widgets-6', array(
		'before' => '<div class="home-widgets-6 color-section widget-area">',
		'after'  => '</div>',
	) );
	
	echo '</div>';

}

genesis();
