<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

/**
 * Define static handle for admin routes.
 *.
 * @since 0.0.1
*/
$staticHandle = function(){
	/**
	* Get current active route
	* @var Routes
	*/
	$route = request()->getLoadedRoute();

	/**
	* Do something before the dashboard is rendered
	* @param string $routerName [ the router name ]
	*/
	do_action( 'wpic_setup_dashboard', $route->getName() );

	/**
	* Dashboard is rendered
	*/
	view()->render( 'pages/dashboard' );
};

$routes = function ( $regsitered_pages ) use ($staticHandle) {
	if ( empty( $regsitered_pages ) || ! is_array( $regsitered_pages ) ) {
		return;
	}
	/**
	 * Extract all admin routes registered.
	 *
	 * @since 0.0.1
	*/
	foreach ( $regsitered_pages as $key => $page ) {
		Router::match( [ 'get', 'post' ], $page['menu_slug'], $staticHandle )->name( $page['page_id'] );
		if ( isset( $page['child'] ) && ! empty( $childrens = $page['child'] ) ) {
			foreach ( $childrens as $key => $child ) {
				$childRoute = "{$page['menu_slug']}/{$child['menu_slug']}";
				Router::match( [ 'get', 'post' ], $childRoute, $staticHandle )->name( "child.{$child['page_id']}" );
			}
		}
	}
};

Router::group( ['prefix' => '/wp-admin', 'middleware' => \App\middleware\AdminDashboard::class], function () use ($routes){
	if ( ! is_admin() ) {
		return;
	}
	$routes( wpic_get_menus_dashboard() );
});

Router::group( ['prefix' => '/wp-user', 'middleware' => \App\middleware\UserDashboard::class], function () use ($routes){
	if ( ! is_user_page() ) {
		return;
	}
	$routes( wpic_get_menus_dashboard() );
});