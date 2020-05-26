<?php
namespace App\lib;
/**
 *
 */
class wcic_load_request {

	public function __construct( ){
		add_action( 'after_plugins_loaded', array( $this, 'load_routes' ), 9, 1 );
	}

	public function load_routes(){
		try {
			if ( file_exists( $routes = WPIC_BASE.'routes/routes.php' ) ) {
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
			echo $e->getMessage();
			die();
		}

		do_action( 'handle_routes_registered' );
	}

}