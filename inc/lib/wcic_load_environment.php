<?php

namespace App\lib;
/**
 *
 */
class wcic_load_environment {

	public function __construct() {
		// plugin initialize all class registered
		$this->start();
	}

	private function start(){
		$this->before_start();

		// plugin initialize all class registered
		do_action( 'plugins_loaded' );

		$this->end();
	}

	private function before_start(){
		// before plugin initialize all class registered
		do_action( 'before_plugin_loaded' );
	}

	private function end(){
		// after plugin initialize all class registered
		do_action( 'after_plugins_loaded' );
	}
}