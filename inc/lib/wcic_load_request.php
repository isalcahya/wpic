<?php
namespace App\lib;
/**
 *
 */
final class wcic_load_request {

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

	public function __construct( ){
		$this->load_routes();
	}

	public function load_routes(){
		try {
			if ( file_exists( $routes = untrailingslashit( WPIC_BASE ) .'/routes/routes.php' ) ) {
				// action to handle before routes
				do_action( 'before_routes_registered' );

				/* Load external routes file */
				require_once $routes;
			} else {
				$error[] = 'File routes.php not found,';
				$error[] = 'We instead found';
				$error[] = sprintf( '%s', $routes );
				throw new \Exception( implode( PHP_EOL, $error ) , 1);
			}
		} catch ( \Exception $e ) {
			dd($e->getMessage());
		}

		do_action( 'handle_routes_registered' );
	}

}