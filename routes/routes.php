<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::get( '/', 'AdminController@admin' );
Router::get( '/login', 'AdminController@login' );
Router::get( '/landpage', 'AdminController@landpage' );

Router::group( ['prefix' => '/admin'], function () {
	$staticCallback = 'DashboardController@dashboard';
	$menu = array( 'dashboard', 'example', 'profile' );
	foreach ( $menu as $key => $page ) {
		Router::match( [ 'get', 'post' ], $page, $staticCallback )->name( "dash.{$page}" );
	}
});