<?php
namespace App\hooks;
/**
 *
 */
class AdminHooks {

	protected $pathDist;

	// if you want to activated this class just set from unregister to register
	public function register(){
		$this->pathDist = untrailingslashit( WCIC()->get_path( 'dist', true ) );
	}

	public function init(){
		add_action( 'after_plugins_loaded', array( $this, 'enqueue' ) );
		add_action( 'init', array( $this, 'register_script' ) );
 	}

 	public function register_script(){
 		// scripts
 		wp_register_script( 'exampleJs', $this->pathDist . '/js/test.js', array( 'jquery', 'bootstrap' ), false, true );
 	}

 	public function enqueue(){
 		wp_enqueue_script('exampleJs');
 	}

}