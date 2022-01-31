<?php
namespace Controllers;
use Models\Users;
/**
 *
 */
class FrontController {

	public function __construct(){
		if ( in_array( $method = request()->getMethod(), array( 'post', 'put', 'patch' ) ) ) {
			switch ( strtolower($method) ) {
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
			$page = request()->getLoadedRoute()->getName();
			do_action( 'front_post_handler', $page, $postdata );
		}
	}

	public function admin(){
		view()->render( 'spp-home' );
	}

	public function login(){
		do_action( 'wcic-render-login' );
		view()->render( 'pages/login' );
	}

	public function loginBaru(){
		do_action( 'wcic-render-login' );
		view()->render( 'pages/login' );
	}

	public function register(){
		do_action( 'wcic-setup-register-page' );
		view()->render( 'pages/register' );
	}

	public function logout(){
		try {
			if ( ! ( $auth = get_wpauth() ) ){
				throw new \Exception("Error Processing Request", 1);
			}
			$token = input()->get( 'wp_csrf_token' );
			if ( empty($token) || !is_object($token) ) {
				throw new \Exception("Error Processing Request", 1);
			}
			$token = $token->value;
			// manualy verifier for get request
			wp_token_verifier( $token );

			// already logout
    		$auth->logOutEverywhere();

    		// finnaly redirect to login page
    		redirect(url('login.page'));

		} catch (\Exception $e) {
			die($e->getMessage());
		} catch (\Delight\Auth\NotLoggedInException $e) {
		    die('Not logged in');
		}
	}

	public function landpage(){
		do_action( 'wcic-render-landpage' );
		view()->render( 'pages/landingpage' );
	}
}