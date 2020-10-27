<?php
namespace Controllers;
/**
 *
 */
class DashboardController{

	protected $name;

	public function __construct( ){
		$this->name = request()->getLoadedRoute()->getName();
	}

	public function dashboard(){
		do_action( 'wcic-render-dashboard', $this->name );
		view()->render( 'pages/dashboard' );
	}
}