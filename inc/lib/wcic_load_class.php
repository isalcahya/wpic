<?php

 namespace App\lib;

 use App\Plugin;
 use Symfony\Component\Finder;
 use Symfony\Component\Finder\Exception as FinderExc;
 use hanneskod\classtools;
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

 	public function __construct() {
 		// parent::__construct();
 		$this->features = [];
 	}

 	private function include(){

 		try {
 			$finder = new Finder\Finder();

 			$path = $finder->in( PLUGIN_PATH.'inc/hooks/' );

			$iter = new classtools\Iterator\ClassIterator( $path );

			$iter->enableAutoloading();

			foreach ($iter as $class) {

			    $this->collectFitur($class->getName());

			}

			// already register all fitur
			$this->plugin = new Plugin();
			$this->on_instance_classes();
 		} catch ( FinderExc\DirectoryNotFoundException $e ) {
 			echo '<pre>';
 			print_r( $e->getMessage() );
 			echo '</pre>';
 			exit();
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

			default:
				$path = $base;
				break;

		}//end switch

		return $path;
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
		// handle the error routes
		$this->HandleErrorRoute();

		// Start the routing
		SimpleRouter::start();
	}

	public function before_routes_registered(){
		/**
		 * The default namespace for route-callbacks, so we don't have to specify it each time.
		 * Can be overwritten by using the namespace config option on your specific routes.
		 */
		SimpleRouter::setDefaultNamespace('Controllers');
	}

	public function HandleErrorRoute(){

		if ( file_exists( $routes = WPIC_BASE.'routes/errRoute.php' ) ) {
			require_once $routes;
		}

	}

 }