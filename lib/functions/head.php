<?php
/**
 * Functions for outputting common site data in the `<head>` area of a site.
 *
 * @package    Cherry_Framework
 * @subpackage Functions
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

// Adds common theme items to <head>.
add_action( 'wp_head', 'cherry_meta_charset',  0 );
add_action( 'wp_head', 'cherry_meta_viewport', 1 );
add_action( 'wp_head', 'wp_generator',         1 ); // Move the WordPress generator to a better priority.
add_action( 'wp_head', 'cherry_link_pingback', 3 );

/**
 * Removes unnecessary code that WordPress puts to <head>.
 *
 * @link http://wpengineer.com/1438/wordpress-header/
 */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

// Removes injected CSS from recent comments widget.
add_filter( 'wp_head', 'cherry_remove_recent_comments_style', 1 );

/**
 * Adds the meta charset to the header.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 */
function cherry_meta_charset() {
	printf( '<meta charset="%s" />' . "\n", get_bloginfo( 'charset' ) );
}

/**
 * Adds the meta viewport to the header.
 *
 * @since 4.0.0
 */
function cherry_meta_viewport() {
	$is_responsive = cherry_get_option( 'grid-responsive' );

	if ( 'true' == $is_responsive ) {
		echo '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";
	}
}

/**
 * Adds the pingback meta tag to the head so that other sites can know how to send a pingback to our site.
 *
 * @author Justin Tadlock <justin@justintadlock.com>
 * @author Cherry Team <support@cherryframework.com>
 * @since  4.0.0
 */
function cherry_link_pingback() {
	if ( 'open' === get_option( 'default_ping_status' ) ) {
		printf( '<link rel="pingback" href="%s" />' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}

/**
 * Remove inline CSS used by Recent Comments widget.
 *
 * @since 4.0.0
 */
function cherry_remove_recent_comments_style() {
	global $wp_widget_factory;

	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
}