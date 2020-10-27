<?php

namespace Controllers;
use Models\Users;
/**
 *
 */
class AdminController {

	public function __construct(){

	}

	public function admin(){
		view()->render( 'home' );
	}

	public function login(){
		do_action( 'wcic-render-login' );
		view()->render( 'pages/login' );
	}

	public function landpage(){
		do_action( 'wcic-render-landpage' );
		view()->render( 'pages/landingpage' );
	}
}