<?php
namespace Controllers;
use Models\Users;
/**
 *
 */
class FrontController {

	public function __construct(){
		if ( in_array( $method = request()->getMethod(), array( 'post', 'put', 'patch' ) ) ) {
			switch ( $method ) {
				case 'post':
					$postdata = $_POST;
					unset( $_POST );
					break;
				case 'put':
					$postdata = $_PUT;
					unset( $_PUT );
					break;
				case 'patch':
					$postdata = $_PATCH;
					unset( $_PATCH );
					break;
			}
			do_action( 'front_post_handler', $postdata );
		}
	}

	public function admin(){
		view()->render( 'home' );
	}

	public function login(){
		do_action( 'wcic-render-login' );
		view()->render( 'pages/login' );
	}

	public function register(){
		do_action( 'wcic-setup-register-page' );
		view()->render( 'pages/register' );
	}

	public function landpage(){
		do_action( 'wcic-render-landpage' );
		view()->render( 'pages/landingpage' );
	}
}