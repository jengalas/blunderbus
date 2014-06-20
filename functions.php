<?php
/**
 * Surveymarks functions and definitions
 *
 * @package Surveymarks
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 750; /* pixels */

if ( ! function_exists( 'surveymarks_setup' ) ) :
/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function surveymarks_setup() {
	global $cap, $content_width;

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	if ( function_exists( 'add_theme_support' ) ) {

		/**
		 * Add default posts and comments RSS feed links to head
		*/
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/
		add_theme_support( 'post-thumbnails' );

		/**
		 * Enable support for Post Formats
		*/
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

		/**
		 * Setup the WordPress core custom background feature.
		*/
		add_theme_support( 'custom-background', apply_filters( 'surveymarks_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

	}

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Surveymarks, use a find and replace
	 * to change 'surveymarks' to the name of your theme in all the template files
	*/
	load_theme_textdomain( 'surveymarks', get_template_directory() . '/languages' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	*/
	register_nav_menus( array(
		'primary'  => __( 'Header bottom menu', 'surveymarks' ),
	) );

}
endif; // surveymarks_setup
add_action( 'after_setup_theme', 'surveymarks_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function surveymarks_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'surveymarks' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'surveymarks_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function surveymarks_scripts() {

	// load bootstrap css
	wp_enqueue_style( 'surveymarks-bootstrap', get_template_directory_uri() . '/includes/resources/bootstrap/css/bootstrap.css' );

	// load Surveymarks styles
	wp_enqueue_style( 'surveymarks-style', get_stylesheet_uri() );

	// load bootstrap js
	wp_enqueue_script('surveymarks-bootstrapjs', get_template_directory_uri().'/includes/resources/bootstrap/js/bootstrap.js', array('jquery') );

	// load bootstrap wp js
	wp_enqueue_script( 'surveymarks-bootstrapwp', get_template_directory_uri() . '/includes/js/bootstrap-wp.js', array('jquery') );

	wp_enqueue_script( 'surveymarks-skip-link-focus-fix', get_template_directory_uri() . '/includes/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'surveymarks-keyboard-image-navigation', get_template_directory_uri() . '/includes/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

}
add_action( 'wp_enqueue_scripts', 'surveymarks_scripts' );

/**
 * Enqueue fonts
 */

function wpse_google_webfonts() {
    $protocol = is_ssl() ? 'https' : 'http';
    $query_args = array(
        'family' => 'Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:300',
        'subset' => $subsets,
    );

    wp_enqueue_style('google-webfonts',
        add_query_arg($query_args, "$protocol://fonts.googleapis.com/css" ),
        array(), null);
}

add_action( 'wp_enqueue_scripts', 'wpse_google_webfonts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/includes/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/includes/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/includes/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/includes/bootstrap-wp-navwalker.php';

/**
 * Deregister Heartbeat in attempt to investigate server load
 */

add_action( 'init', 'my_deregister_heartbeat', 1 );
function my_deregister_heartbeat() {
	global $pagenow;

	if ( 'post.php' != $pagenow && 'post-new.php' != $pagenow )
		wp_deregister_script('heartbeat'); 
} 

/**
 * Puts location taxonomy terms in order State, County, Quad
 */

function order_location_terms() {    
   	 
	 $taxonomy_slug = "location";			 
	 $terms = get_the_terms( $post->ID, $taxonomy_slug);
	 
    // if $terms is not array or it's empty don't proceed
    if ( ! is_array( $terms ) || empty( $terms ) ) {
        return false;
    }

    foreach ( $terms as $term ) {
        // if the term has a parent, set the child term as attribute in parent term
        if ( $term->parent != 0 )  {
            $terms[$term->parent]->child = $term;   
        } else {
            // record the parent term
            $parent = $term;
        }
    }

		$state_link = '/'.$taxonomy_slug.'/'.$parent->slug;
		$county_link = $state_link .'/' . $parent->child->slug;
		$quad_link = $county_link . '/' . $parent->child->child->slug; 
		
		return "<a href=$state_link>$parent->name</a> - <a href=$county_link>".$parent->child->name."</a> - <a href=$quad_link>".$parent->child->child->name."</a>";
		
}

add_shortcode( 'location_tax_inorder', 'order_location_terms' );

function order_location_terms_nolink() {    /*  Puts location taxonomy terms in order State, County, Quad */
   	 
	 $taxonomy_slug = "location";			 
	 $terms = get_the_terms( $post->ID, $taxonomy_slug);
	 
    // if $terms is not array or it's empty don't proceed
    if ( ! is_array( $terms ) || empty( $terms ) ) {
        return false;
    }

    foreach ( $terms as $term ) {
        // if the term has a parent, set the child term as attribute in parent term
        if ( $term->parent != 0 )  {
            $terms[$term->parent]->child = $term;   
        } else {
            // record the parent term
            $parent = $term;
        }
    }

		$state_link = '/'.$taxonomy_slug.'/'.$parent->slug;
		$county_link = $state_link .'/' . $parent->child->slug;
		$quad_link = $county_link . '/' . $parent->child->child->slug; 
		
		return $parent->name .' - '. $parent->child->name .' - '. $parent->child->child->name;
		
}

add_shortcode( 'location_tax_inorder_nolink', 'order_location_terms_nolink' );
