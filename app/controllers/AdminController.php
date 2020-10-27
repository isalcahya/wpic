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
}