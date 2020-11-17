<?php
/**
 * Executing Ajax process.
 *
 * @since 0.0.1
 */
define( 'DOING_AJAX', true );
define( 'REMOVE_ROUTES' , true );
if ( ! defined( 'WP_ADMIN' ) ) {
	define( 'WP_ADMIN', true );
}
define( 'ABSPATH', dirname( dirname( __FILE__ ) ) . '/' );
/** Loads the Custom Framework Environment and Template */
require(  dirname( dirname( __FILE__ ) ) . '/wcic-config.php' );

/** Allow for cross-domain requests (from the front end). */
send_origin_headers();

// Require an action parameter
if ( empty( $_REQUEST['action'] ) ) {
	wp_die( '0', 400 );
}

@header( 'Content-Type: text/html; charset=ISO-8859-15' );
@header( 'X-Robots-Tag: noindex' );

send_nosniff_header();
nocache_headers();

$action = ( isset( $_REQUEST['action'] ) ) ? $_REQUEST['action'] : '';

if ( is_user_logged_in() ) {
	// If no action is registered, return a Bad Request response.
	if ( ! has_action( "wp_ajax_{$action}" ) ) {
		wp_die( '0', 400 );
	}

	/**
	 * Fires authenticated Ajax actions for logged-in users.
	 *
	 * The dynamic portion of the hook name, `$action`, refers
	 * to the name of the Ajax action callback being fired.
	 *
	 * @since 2.1.0
	 */
	do_action( "wp_ajax_{$action}" );
} else {
	// If no action is registered, return a Bad Request response.
	if ( ! has_action( "wp_ajax_nopriv_{$action}" ) ) {
		wp_die( '0', 400 );
	}

	/**
	 * Fires non-authenticated Ajax actions for logged-out users.
	 *
	 * The dynamic portion of the hook name, `$action`, refers
	 * to the name of the Ajax action callback being fired.
	 *
	 * @since 2.8.0
	 */
	do_action( "wp_ajax_nopriv_{$action}" );
}
// Default status
wp_die( '0' );
