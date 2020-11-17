<?php
namespace App\middleware;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class AdminDashboard implements IMiddleware {

	public function handle(Request $request): void
	{
		global $wpauth;
		$redirect = url( 'login.page' );
		if ( ! $wpauth instanceof \Delight\Auth\Auth ) {
			response()->redirect($redirect);
		}
		if ( ! $wpauth->isLoggedIn() ) {
			response()->redirect($redirect);
		}
	}
}