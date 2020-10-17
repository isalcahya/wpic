<?php

namespace App\lib;
use App\lib\wcic_load_request;
/**
 *
 */
class wcic_load_environment {

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
		$this->registered_dependency();
		// plugin initialize all class registered
		$this->start();
	}

	private function registered_dependency(){
		do_action( 'registered_dependency' );
	}

	private function start(){
		$this->before_start();

		// plugin initialize all class registered
		do_action( 'init' );

		// end of environment initialize
		$this->end();

		// bootsrap request
		wcic_load_request::instance();
	}

	private function before_start(){
		// before plugin initialize all class registered
		do_action( 'before_plugins_loaded' );
	}

	private function end(){
		// after plugin initialize all class registered
		do_action( 'after_plugins_loaded' );
	}
}