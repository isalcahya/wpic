<?php

namespace App;
use App\lib\WpicEloquent;
use App\lib\WpicCsrfVerifier;
use Pecee\SimpleRouter\SimpleRouter;
use Pecee\SimpleRouter\Router;
use Pecee\Http\Middleware\Exceptions\TokenMismatchException;

/**
 *
 */
class wcic_init_hooks {

	protected static $_instance = null;

	public $path;

	protected $router;

	protected static $wpcsrf;
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

		$this->path = untrailingslashit( WPIC_BASE );

		$this->setup_wp_dependency();

		$this->try_connect_to_database();

		$this->set_main_hooks();
	}

	public function setup_wp_dependency(){
		require( $this->path . '/dependency/wp-custom-dependency.php' );
	}

	public function set_main_hooks(){
		// register class scripts dependency
 		add_action( 'wpic_on_bootup', array( $this, 'register_scripts_dependency' ), 9 );
		// bootstrap class
		add_action( 'wpic_on_started', array( WCIC(), 'on_init' ), 9, 1 );
 		add_action( 'setup_routes_handler', array( WCIC(), 'register_simply_request' ), 10, 1 );
 		add_action( 'before_routes_registered', array( WCIC(), 'before_routes_registered' ), 10, 1 );

 		// wpic token verifier
 		add_action( 'wpic_on_bootup', array( $this, 'set_csrf_token_verifier' ) );
 		add_action( 'wpic_on_started', array( $this, 'handle_ajax_token_verifier' ) );
 		add_action( 'setup_routes_handler', array( $this, 'handle_ajax_token_verifier' ) );
	}

	public function handle_ajax_token_verifier(){
		if ( WCIC()->is_request( 'ajax' ) ) {
			if ( null !== $this->router && null !== $this->request ) {
				try {
					$this->router->getCsrfVerifier()->handle($this->request);
				} catch (TokenMismatchException $e) {
					response()->httpCode(401)->json( array(
						'message' => $e->getMessage()
					) );
				}
			}
		}
	}

	public function set_csrf_token_verifier(){
		SimpleRouter::csrfVerifier( static::wpcsrf() );
		$this->router 	= SimpleRouter::router();
		$this->request 	= SimpleRouter::request();
	}

	public function register_scripts_dependency( ){
		include_once( $this->path.'/dependency/wp-scripts/class-wp-dependency.php' );
		include_once( $this->path.'/dependency/wp-scripts/wp.dependency.php' );
		include_once( $this->path.'/dependency/wp-scripts/wp.scripts.php' );
		include_once( $this->path.'/dependency/wp-scripts/wp.styles.php' );
		include_once( $this->path.'/dependency/wp-scripts/load-scripts.php' );
		include_once( $this->path.'/dependency/wp-class/class-wp-user.php' );
	}

	public function try_connect_to_database(){
		/* setup and try to connect database */
		WpicEloquent::instance();
	}

	 /**
     * Returns the WpicCsrfVerifier instance
     *
     * @return Router
     */
    public static function wpcsrf(): WpicCsrfVerifier
    {
        if (static::$wpcsrf === null) {
            static::$wpcsrf = new WpicCsrfVerifier();
        }

        return static::$wpcsrf;
    }
}
