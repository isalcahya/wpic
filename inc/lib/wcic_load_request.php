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
			$folderroutes  = untrailingslashit( WPIC_BASE ) .'/routes/';
			$path = realpath($folderroutes);
			 if( $path !== false AND is_dir($path) ) {
			 		$files = glob($path . '/*.php');
			 		if ( !empty( $files ) ) {
				 		/* Do something before all route registered */
						do_action( 'before_routes_registered' );
				 	}
				 	foreach ( $files as $key => $file ) {
				 		/* Load external routes file */
						require_once $file;
				 	}
			} else {
				$error[] = 'Folder routes not found,';
				$error[] = 'Please make sure you has created that folder';
				throw new \Exception( implode( PHP_EOL, $error ) , 1);
			}
		} catch ( \Exception $e ) {
			dd($e->getMessage());
		}

		do_action( 'setup_routes_handler' );
	}

}