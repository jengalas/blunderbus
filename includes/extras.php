<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Blunderbus
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function blunderbus_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'blunderbus_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function blunderbus_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'blunderbus_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function blunderbus_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'blunderbus_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function blunderbus_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'blunderbus' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'blunderbus_wp_title', 10, 2 );

/**
 * Enqueue fonts
 */

function wpse_google_webfonts() {
    $protocol = is_ssl() ? 'https' : 'http';
    $query_args = array(
        'family' => 'Open+Sans:400italic,700italic,400,700|Open+Sans+Condensed:300|Raleway:400|Amaranth:400|Lato:700italic',
        'subset' => $subsets,
    );

    wp_enqueue_style('google-webfonts',
        add_query_arg($query_args, "$protocol://fonts.googleapis.com/css" ),
        array(), null);
}

add_action( 'wp_enqueue_scripts', 'wpse_google_webfonts' );

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

/**
 * Deregister Heartbeat in attempt to investigate server load
 */

add_action( 'init', 'my_deregister_heartbeat', 1 );
function my_deregister_heartbeat() {
	global $pagenow;

	if ( 'post.php' != $pagenow && 'post-new.php' != $pagenow )
		wp_deregister_script('heartbeat'); 
} 
