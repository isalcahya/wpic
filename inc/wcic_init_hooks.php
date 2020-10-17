<?php

namespace App;
use App\lib\wcic_load_class;
/**
 *
 */
class wcic_init_hooks {

	protected static $_instance = null;

	/**
	 * Main Plugin Name Instance
	 *
	 * Ensures only one instance of Plugin Name is loaded or can be loaded.
	 *
	 * @since 1.0
	 * @static
	 * @return Plugin Name - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		// register class scripts dependency
 		add_action( 'registered_dependency', array( $this, 'register_scripts_dependency' ) );

		// bootstrap class
		add_action( 'before_plugins_loaded', array( new wcic_load_class(), 'on_init' ), 9, 1 );
 		add_action( 'handle_routes_registered', array( new wcic_load_class(), 'register_simply_request' ), 10, 1 );
 		add_action( 'before_routes_registered', array( new wcic_load_class(), 'before_routes_registered' ), 10, 1 );
	}

	public function register_scripts_dependency( ){
		include_once( untrailingslashit( WPIC_BASE ).'/dependency/wp-scripts/class-wp-dependency.php' );
		include_once( untrailingslashit( WPIC_BASE ).'/dependency/wp-scripts/wp.dependency.php' );
		include_once( untrailingslashit( WPIC_BASE ).'/dependency/wp-scripts/wp.scripts.php' );
		include_once( untrailingslashit( WPIC_BASE ).'/dependency/wp-scripts/wp.styles.php' );
		include_once( untrailingslashit( WPIC_BASE ).'/dependency/wp-scripts/load-scripts.php' );
	}
}
