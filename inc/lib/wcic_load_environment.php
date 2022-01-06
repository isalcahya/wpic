<?php

namespace App\lib;
use Pecee\SimpleRouter\Handlers\EventHandler;
use Pecee\SimpleRouter\Event\EventArgument;
use Pecee\SimpleRouter\SimpleRouter as Router;
/**
 *
 */
class wcic_load_environment {

	protected static $_instance = null;

	/**
	 * Main Plugin Name Instance
	 *
	 * Ensures only one instance of Plugin Name is loaded or can be loaded.
	 *
	 * @since 1.0
	 * @static
	 * @return Plugin Name - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		/* startup of environment initialize */
		$this->wpic_startup();

		/* end of environment initialize */
		$this->end();
	}

	private function wpic_startup(){

		$this->route_event_handler();

		if ( ! defined( 'REMOVE_ROUTES' ) || ! REMOVE_ROUTES ) {
			/* bootsrap request */
			wcic_load_request::instance();
		} elseif( defined( 'DOING_AJAX' ) || DOING_AJAX ){
			// boots framework
			do_action( 'wpic_on_bootup' );
			// started hooks
			do_action( 'wpic_on_started' );
		}
	}

	private function end(){
		if ( ! defined( 'REMOVE_ROUTES' ) || ! REMOVE_ROUTES ) {
			/* fire after plugin has done setup */
			do_action( 'shutdown' );
		}
	}

	public function route_event_handler(  ){

		// --- your routes goes here ---
		$eventHandler = new EventHandler();

		// Add event that fires when a route is rendered
		$eventHandler
		->register(EventHandler::EVENT_MATCH_ROUTE, function(EventArgument $argument) {
			# KETIGA
			do_action( 'init' );
		})
		->register(EventHandler::EVENT_BOOT, function(EventArgument $argument) {
			try {
				$request = $argument->getRequest();
				if ( $request instanceof \Pecee\Http\Request ) {
					global $wp_current_page;
					$originUrl 		= $request->getUrl()->getOriginalUrl();
					$explodeUrl		= explode('/', $originUrl);
					if ( isset( $explodeUrl[1] ) && str_contains( $explodeUrl[1], 'wp-' ) ) {
						$vars = $explodeUrl[1];
						switch ( strtolower($vars) ) {
							case 'wp-admin':
								$request->admin_page = true;
								break;
							case 'wp-user':
								$request->user_page = true;
								break;
						}
					}

					/**
					* Set global $wp_current_page from current request
					*/
					$wp_current_page = $request;

					# KEDUA
					do_action( 'wpic_on_started' );

					if ( isset( $request->admin_page ) && true === $request->admin_page ) {

						/**
						* Fires as an admin screen or script is being initialized.
						*
						* This is roughly analogous to the more general {@see 'init'} hook, which fires earlier.
						*
						* @since 0.0.1
						*/
						do_action( 'admin_init' );

						if ( count( array_filter($explodeUrl) ) === 1 ) {
							$request->setRewriteUrl( rtrim($originUrl, '/') . '/dashboard' );
						}

					} else if( isset( $request->user_page ) && true === $request->user_page ){

						/**
						* Fires as an user screen or script is being initialized.
						*
						* This is roughly analogous to the more general {@see 'init'} hook, which fires earlier.
						*
						* @since 0.0.1
						*/
						do_action( 'user_init' );

						if ( count( array_filter($explodeUrl) ) === 1 ) {
							$request->setRewriteUrl( rtrim($originUrl, '/') . '/dashboard' );
						}

					}

					/**
					* Action for parse request
					*/
					do_action( 'parse_request', $request );

				} else{
					throw new \Exception("Error Processing Request", 1);
				}
			} catch (\Exception $e) {
				dd( $e->getMessage() );
			}
		})
		->register( EventHandler::EVENT_INIT, function(EventArgument $argument){
			# PERTAMA
			do_action( 'wpic_on_bootup' );
		})
		->register( EventHandler::EVENT_RENDER_ROUTE, function(EventArgument $argument){
			# KEEMPAT
			do_action( 'wpic_on_render' );
		});

		Router::addEventHandler($eventHandler);
	}
}