<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'centric', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'centric' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Centric Theme', 'centric' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/centric/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'centric_load_scripts' );
function centric_load_scripts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,700|Spinnaker', array(), CHILD_THEME_VERSION );
	
	wp_enqueue_style( 'dashicons' );
	
	wp_enqueue_script( 'centric-global', get_bloginfo( 'stylesheet_directory' ) . '/js/global.js', array( 'jquery' ), '1.0.0', true );
	
}

//* Add new image sizes
add_image_size( 'featured-page', 960, 700, TRUE );
add_image_size( 'featured-post', 400, 300, TRUE );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 80,
	'width'           => 360,
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer',
) );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'centric-pro-charcoal' => __( 'Centric Charcoal', 'centric' ),
	'centric-pro-green'    => __( 'Centric Green', 'centric' ),
	'centric-pro-orange'   => __( 'Centric Orange', 'centric' ),
	'centric-pro-purple'   => __( 'Centric Purple', 'centric' ),
	'centric-pro-red'      => __( 'Centric Red', 'centric' ),
	'centric-pro-yellow'   => __( 'Centric Yellow', 'centric' ),
) );

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'centric' ) ) );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Reposition Page Title
add_action( 'genesis_before', 'centric_post_title' );
function centric_post_title() {

	if ( is_page() and !is_page_template() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		add_action( 'genesis_after_header', 'centric_open_post_title', 1 );
		add_action( 'genesis_after_header', 'genesis_do_post_title', 2 );
		add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
	} elseif ( is_category() ) {
		remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
		add_action( 'genesis_after_header', 'centric_open_post_title', 1 ) ;
		add_action( 'genesis_after_header', 'genesis_do_taxonomy_title_description', 2 );
		add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
	} elseif ( is_search() ) {
        remove_action( 'genesis_before_loop', 'genesis_do_search_title' );
        add_action( 'genesis_after_header', 'centric_open_post_title', 1 ) ;
        add_action( 'genesis_after_header', 'genesis_do_search_title', 2 );
        add_action( 'genesis_after_header', 'centric_close_post_title', 3 );
    }

}

function centric_open_post_title() {
	echo '<div class="page-title"><div class="wrap">';
}

function centric_close_post_title() {
	echo '</div></div>';
}

//* Prevent Page Scroll When Clicking the More Link
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );
function remove_more_link_scroll( $link ) {

	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
	
}

//* Hook after entry widget area after the entry content
add_action( 'genesis_after_entry', 'centric_after_entry', 5 );
function centric_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
		) );

}

//* Modify the size of the Gravatar in author box
add_filter( 'genesis_author_box_gravatar_size', 'centric_author_box_gravatar_size' );
function centric_author_box_gravatar_size( $size ) {

	return 96;
	
}

//* Modify the size of the Gravatar in comments
add_filter( 'genesis_comment_list_args', 'centric_comment_list_args' );
function centric_comment_list_args( $args ) {

    $args['avatar_size'] = 60;
	return $args;
	
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'centric_remove_comment_form_allowed_tags' );
function centric_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-widgets-1',
	'name'        => __( 'Home 1', 'centric' ),
	'description' => __( 'This is the first section of the home page.', 'centric' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-2',
	'name'        => __( 'Home 2', 'centric' ),
	'description' => __( 'This is the second section of the home page.', 'centric' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-3',
	'name'        => __( 'Home 3', 'centric' ),
	'description' => __( 'This is the third section of the home page.', 'centric' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-4',
	'name'        => __( 'Home 4', 'centric' ),
	'description' => __( 'This is the fourth section of the home page.', 'centric' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-5',
	'name'        => __( 'Home 5', 'centric' ),
	'description' => __( 'This is the fifth section of the home page.', 'centric' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-widgets-6',
	'name'        => __( 'Home 6', 'centric' ),
	'description' => __( 'This is the sixth section of the home page.', 'centric' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'centric' ),
	'description' => __( 'This is the after entry widget area.', 'centric' ),
) );
