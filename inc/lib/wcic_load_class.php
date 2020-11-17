<?php

 namespace App\lib;

 use App\Plugin;
 use Symfony\Component\Finder\Finder;
 use Symfony\Component\Finder\Exception;
 use hanneskod\classtools\Iterator;
 use Pecee\SimpleRouter\SimpleRouter;
 /**
  *
  */
final class wcic_load_class {

 	private $plugin;

 	private $features;

 	private $class = [];

 	private static $on_init;

 	public $version = '0.0.1';

	public $capability = 'manage_options';

	public $plugin_domain = 'plugin_domain';

	public $name = 'plugin_name';

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
	public static function init() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

 	public function __construct() {
 		// parent::__construct();
 		$this->features = [];
 	}

 	private function include(){

 		try {
 			foreach ( array( PLUGIN_PATH.'inc/hooks/', PLUGIN_PATH.'app/hooks/') as $key => $dir ) {
 				if ( is_dir( $dir ) ) {
 					$dirs[] = $dir;
 				}
 			}
 			if ( !isset( $dirs ) && empty( $dirs ) ) {
 				throw new Exception\DirectoryNotFoundException("Error Processing Request", 1);
 			}
 			$finder = new Finder;
			$iter = new Iterator\ClassIterator($finder->in($dirs));
			$iter->enableAutoloading();
			// Print the file names of classes, interfaces and traits in 'src'
			foreach ($iter->getClassMap() as $classname => $splFileInfo) {
			    $this->collectFitur($classname);
			}
			// already register all fitur
			$this->plugin = new Plugin();
			$this->on_instance_classes();
 		} catch ( Exception\DirectoryNotFoundException $e ) {
 			dd( $e->getMessage() );
 		}
 	}

 	public function on_init(){
 		$this->include();

 		if ( self::$on_init === true ) {
 			return 'error confused';
 		}

 		$this->wcic_inits_hooks();

 		do_action( $this->name . '_loadeds' );
 	}

 	private function wcic_inits_hooks(){
 		if( count($this->features) && true !== self::$on_init ){
 			self::$on_init = true;
 			foreach ( $this->features as $fitur ) {
	 			# code...
	 			// $this->class[$fitur] = self::instance($fitur);
 				$className = $this->get_class_name($fitur);
	 			if( method_exists($this->class[$className], 'register') ){
	 				// feature has been added into plugin
	 				$this->plugin->add($this->class[$className]);
	 				// feature already registered
	 				$this->class[$className]->register();
	 			}
 			}
 		}
		// initialise the plugin
		$this->plugin->inits();
 	}

 	public function on_instance_classes(){
 		if( count($this->features) ){
 			foreach ( $this->features as $fitur ) {
 				$className = $this->get_class_name($fitur);
 				$this->class[$className] = self::instance($fitur);
 			}
 		}
 	}

 	private function get_dir_classes( $dir ){
 		// store already declared classes:
		$predeclaredClasses = get_declared_classes();

		// Load classes inside the given folder:
		foreach ( (array) $dir as $key => $value ) {
			$i = new \FileSystemIterator($value, \FileSystemIterator::SKIP_DOTS);
		    foreach ($i as $f) {
		        require_once $f->getPathname();
		    }
		}
		// Enjoy
		return array_diff(get_declared_classes(), $predeclaredClasses);
 	}

 	public static function instance($class){

 		if ( !class_exists( $class ) ) {
 			return false;
 		}

 		$classes = new $class;

 		return $classes;
 	}

 	private function get_class_name($fitur){
 		return (new \ReflectionClass($fitur))->getShortName();
 	}

 	public function collectFitur($obj){

 		array_push( $this->features, $obj );

 	}

 	Public function define( $name='', $value ){

		if ( ! defined( $name ) ) {
			 define( $name, $value );
		}

	}

	/**
	 * Returns various plugin paths or urls
	 * @param  string  $type          type of path
	 * @param  boolean $use_url       return as url or as absolute path
	 * @return string                 path / url to the desired type
	 */
	public function get_path( $type = '', $use_url = false ) {

		$base = $use_url ? trailingslashit( WP_SITE_URL )  : trailingslashit( WP_CONTENT_DIR );

		switch ( $type ) {
			case 'dist':
				$path = $base . 'dist/';
				break;

			case 'templates':
				$path = $base . 'resource/templates/';
				break;

			case 'libraries':
				$path = $base . 'inc/lib/';
				break;

			case 'dep':
				$path = $base . 'dependency/';
				break;

			case 'wp-scripts':
				$path = $base . 'dependency/wp-scripts/';
				break;

			case 'assets':
				$path = $base . 'inc/assets/';
				break;

			case 'admin-ajax':
				$path = $base . 'wpic-admin/';
				break;

			case 'resource':
				$path = $base . 'resource/';
			break;

			case 'admin-route':
				$path = $base . 'inc/route/';
				break;

			default:
				$path = $base;
				break;

		}//end switch

		return $path;
	}

	/**
	 * What type of request is this?
	 * string $type ajax, frontend or admin
	 * @return bool
	 */
	public function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Get the plugin path.
	 * @return string
	 */
	public function plugin_path(){
		return WPIC_BASE;
		// return untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/mba-project';
	}

	/**
	 * Get the template path.
	 * @return string
	 */
	public function template_path(){
		return apply_filters( 'wcic_template_path', '/' );
	}

	public function register_simply_request(){
		// Start the routing
		SimpleRouter::start();
	}

	public function before_routes_registered(){
		/**
		 * The default namespace for route-callbacks, so we don't have to specify it each time.
		 * Can be overwritten by using the namespace config option on your specific routes.
		 */
		SimpleRouter::setDefaultNamespace('Controllers');

		if ( file_exists( $route_source = $this->get_path('admin-route') . 'wpic-dashboard-routes.php' ) ) {
			include( $route_source );
		}
	}
 }