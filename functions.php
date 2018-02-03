<?php
/**
 * SH Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package SH_Theme
 */
if ( ! function_exists( 'shtheme_setup' ) ) :
	function shtheme_setup() {
		load_theme_textdomain( 'shtheme', get_template_directory() . '/languages' );
		// Load Theme Options
		require get_template_directory() . '/inc/options.php';
		Redux::init('sh_option');
		// Add theme support
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'shtheme' ),
		) );
		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array('search-form','comment-form','comment-list','gallery','caption',) );
		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'shtheme_custom_background_args', array('default-color' => 'ffffff','default-image' => '',) ) );
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'shtheme_setup' );
function sh_constants() {
	define( 'PARENT_DIR', get_template_directory() );
	define( 'SH_DIR',  get_template_directory_uri() );
	define( 'SH_FUNCTIONS_DIR', PARENT_DIR . '/inc/functions' );
}
add_action( 'init', 'sh_constants' );
function sh_load_framework() {
	// Load Functions.
	require_once( PARENT_DIR . '/inc/options-function.php' );
	require_once( SH_FUNCTIONS_DIR . '/init.php' );
	require_once( SH_FUNCTIONS_DIR . '/sidebar.php' );
	require_once( SH_FUNCTIONS_DIR . '/formatting.php' );
	require_once( SH_FUNCTIONS_DIR . '/breadcrumbs.php' );
	require_once( SH_FUNCTIONS_DIR . '/dashboard.php' );
	require_once( SH_FUNCTIONS_DIR . '/mobilemenu.php' );
}
add_action( 'init','sh_load_framework' );
/**
 * Custom Login Page
 */
function sh_login_logo() {
	wp_enqueue_style( 'login-custom-style', SH_DIR .'/lib/css/login.css' );
}
add_action( 'login_enqueue_scripts', 'sh_login_logo' );
/**
 * Register Widget Area
 *
 */
function shtheme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'shtheme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'shtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Secondary Sidebar', 'shtheme' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'shtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'shtheme_widgets_init' );
/**
 * Add Widget Top Header
 */
function sh_register_top_header_widget_areas() {
	global $sh_option;
	if( $sh_option['display-topheader-widget'] == '1' ) {
		register_sidebar( array(
			'name'          => __( 'Top Header', 'shtheme' ),
			'id'            => 'top-header',
			'description'   => __( 'Top Header widget area', 'shtheme' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
}
add_action( 'widgets_init','sh_register_top_header_widget_areas', 1 );
/**
 * Add Widget Footer
 */
function sh_register_footer_widget_areas() {
	global $sh_option;
	$footer_widgets = $sh_option['opt-number-footer'];
	$footer_widgets_number = intval($footer_widgets);
	$counter = 1;
	while ( $counter <= $footer_widgets_number ) {
		register_sidebar( array(
			'name'          => sprintf( __( 'Footer %d', 'shtheme' ), $counter ),
			'id'            => sprintf( 'footer-%d', $counter ),
			'description'   => sprintf( __( 'Footer %d widget area', 'shtheme' ), $counter ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
		$counter++;
	}
}
add_action( 'widgets_init','sh_register_footer_widget_areas' );
/**
 * Load File
 *
 */
// Load Plugin Activation File.
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';
// Load Shortcode
require get_template_directory() . '/inc/shortcode/shortcode-blog.php';
// Load Widget
require get_template_directory() . '/inc/widgets/wg-post-list.php';
require get_template_directory() . '/inc/widgets/wg-support.php';
require get_template_directory() . '/inc/widgets/wg-fblikebox.php';
require get_template_directory() . '/inc/widgets/wg-page.php';
require get_template_directory() . '/inc/widgets/wg-view-post-list.php';
require get_template_directory() . '/inc/widgets/wg-information.php';
require get_template_directory() . '/inc/widgets/wg-social.php';
function shtheme_lib_scripts(){
	// Bootstrap
	wp_enqueue_script( 'bootstrap-js', SH_DIR . '/lib/js/bootstrap.min.js', array('jquery'), '1.0', true );
	wp_enqueue_style( 'bootstrap-style', SH_DIR .'/lib/css/bootstrap.min.css' );
	// Main js
	wp_enqueue_script( 'main-js', SH_DIR . '/lib/js/main.js', array(), '1.0', true );
	wp_localize_script( 'main-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	// Owl carousel
	wp_register_script( 'owlcarousel-js', SH_DIR . '/lib/js/owl.carousel.min.js', array('jquery'), '1.0', true );
	wp_register_style( 'owlcarousel-style', SH_DIR .'/lib/css/owl.carousel.min.css' );
	wp_register_style( 'owlcarousel-theme-style', SH_DIR .'/lib/css/owl.theme.default.min.css' );
	// Font Awesome
	wp_enqueue_style( 'fontawesome-style', SH_DIR .'/lib/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'shtheme_lib_scripts' , 1 );
/**
 * Add Thumb Size
**/
add_image_size( 'sh_thumb410x270', 410, 270, array( 'center', 'center' ) );
add_image_size( 'sh_thumb200x120', 200, 120, array( 'center', 'center' ) );

// Register Custom Post Type
function create_post_type_question() {

	$labels = array(
		'name'                  => _x( 'Question', 'Question General Name', 'shtheme' ),
		'singular_name'         => _x( 'Question', 'Question Singular Name', 'shtheme' ),
		'menu_name'             => __( 'Question', 'shtheme' ),
		'name_admin_bar'        => __( 'Question', 'shtheme' ),
		'archives'              => __( 'Item Archives', 'shtheme' ),
		'attributes'            => __( 'Item Attributes', 'shtheme' ),
		'parent_item_colon'     => __( 'Parent Item:', 'shtheme' ),
		'all_items'             => __( 'All Items', 'shtheme' ),
		'add_new_item'          => __( 'Add New Item', 'shtheme' ),
		'add_new'               => __( 'Add New', 'shtheme' ),
		'new_item'              => __( 'New Item', 'shtheme' ),
		'edit_item'             => __( 'Edit Item', 'shtheme' ),
		'update_item'           => __( 'Update Item', 'shtheme' ),
		'view_item'             => __( 'View Item', 'shtheme' ),
		'view_items'            => __( 'View Items', 'shtheme' ),
		'search_items'          => __( 'Search Item', 'shtheme' ),
		'not_found'             => __( 'Not found', 'shtheme' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'shtheme' ),
		'featured_image'        => __( 'Featured Image', 'shtheme' ),
		'set_featured_image'    => __( 'Set featured image', 'shtheme' ),
		'remove_featured_image' => __( 'Remove featured image', 'shtheme' ),
		'use_featured_image'    => __( 'Use as featured image', 'shtheme' ),
		'insert_into_item'      => __( 'Insert into item', 'shtheme' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'shtheme' ),
		'items_list'            => __( 'Items list', 'shtheme' ),
		'items_list_navigation' => __( 'Items list navigation', 'shtheme' ),
		'filter_items_list'     => __( 'Filter items list', 'shtheme' ),
	);
	$rewrite = array(
		'slug'                  => 'cau-hoi',
		'with_front'            => true,
	);
	$args = array(
		'label'                 => __( 'Question', 'shtheme' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail','excerpt' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'map_meta_cap' 			=> true,
		'rewrite'               => $rewrite,
		'query_var' 			=> true,
	);
	register_post_type( 'question', $args );

}
add_action( 'init', 'create_post_type_question', 0 );

// Register Custom Taxonomy
function create_taxonomy_topic_question() {

	$labels = array(
		'name'                       => _x( 'Topic', 'Topic General Name', 'shtheme' ),
		'singular_name'              => _x( 'Topic', 'Topic Singular Name', 'shtheme' ),
		'menu_name'                  => __( 'Topic', 'shtheme' ),
		'all_items'                  => __( 'All Items', 'shtheme' ),
		'parent_item'                => __( 'Parent Item', 'shtheme' ),
		'parent_item_colon'          => __( 'Parent Item:', 'shtheme' ),
		'new_item_name'              => __( 'New Item Name', 'shtheme' ),
		'add_new_item'               => __( 'Add New Item', 'shtheme' ),
		'edit_item'                  => __( 'Edit Item', 'shtheme' ),
		'update_item'                => __( 'Update Item', 'shtheme' ),
		'view_item'                  => __( 'View Item', 'shtheme' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'shtheme' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'shtheme' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'shtheme' ),
		'popular_items'              => __( 'Popular Items', 'shtheme' ),
		'search_items'               => __( 'Search Items', 'shtheme' ),
		'not_found'                  => __( 'Not Found', 'shtheme' ),
		'no_terms'                   => __( 'No items', 'shtheme' ),
		'items_list'                 => __( 'Items list', 'shtheme' ),
		'items_list_navigation'      => __( 'Items list navigation', 'shtheme' ),
	);
	$rewrite = array(
		'slug'                       => 'chu-de',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'topic', array( 'question' ), $args );

}
add_action( 'init', 'create_taxonomy_topic_question', 0 );