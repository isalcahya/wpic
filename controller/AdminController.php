<?php

namespace Controllers;

/**
 *
 */
class AdminController {

	public function __construct(){

	}

	public function admin(){
		view()->render( 'home',
			// pass some varible to template
			array( 'someVar' => "hello i'm coder" ) );
	}

	public function login(){

	}

}