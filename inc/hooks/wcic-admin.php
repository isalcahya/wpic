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
		add_action( 'wcic-render-login', array( $this, 'remove_front_dependency' ) );
		add_action( 'wcic-render-landpage', array( $this, 'prepare_landpage' ) );
		add_action( 'wcic-render-dashboard', array( $this, 'remove_front_dependency' ) );
		add_action( 'wcic_navbar_template', array( $this, 'navbar_default_template' ) );
 	}

 	public function navbar_default_template(){
 		view()->render( 'parts/navbar-home' );
 	}

 	public function navbar_landpage_template(){
 		view()->render( 'parts/navbar-landpage' );
 	}

 	public function prepare_landpage(){
 		remove_action( 'wcic_navbar_template', array( $this, 'navbar_default_template' ) );
 		add_action( 'wcic_navbar_template', array( $this, 'navbar_landpage_template' ) );
 	}

 	public function remove_front_dependency( ){
 		wp_dequeue_style('front');
 		wp_enqueue_style('dashboard');
 	}

 	public function register_script(){
 		// scripts
 		wp_register_script( 'exampleJs', $this->pathDist . '/js/test.js', array( 'jquery', 'bootstrap' ), false, true );
 		wp_register_script( 'headroom', $this->pathDist . '/assets/vendor/headroom.js/dist/headroom.min.js', array( 'jquery', 'bootstrap' ), false, true );
 		// styles
 		wp_register_style( 'front', $this->pathDist . '/css/front.css', false, false, 'all' );
 		wp_register_style( 'fontawesome-free', $this->pathDist . '/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css', false, false, 'all' );
 		wp_register_style( 'prism', $this->pathDist . '/assets/vendor/prismjs/themes/prism.css', false, false, 'all' );
		wp_register_style( 'nucleo', $this->pathDist . '/assets/vendor/nucleo/css/nucleo.css', false, false, 'all' );
 	}

 	public function enqueue(){
 		wp_enqueue_script('exampleJs');
 		wp_enqueue_script('headroom');
 		wp_enqueue_style('front');
 		wp_enqueue_style('fontawesome-free');
 		wp_enqueue_style('nucleo');
 		wp_enqueue_style('prism');
 	}

}