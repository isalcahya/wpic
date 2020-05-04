<?php

 namespace App\lib;

 use App\Plugin;
 use Symfony\Component\Finder;
 use hanneskod\classtools;
 /**
  *
  */
 class Wcic_Load_Class
 {

 	private $plugin;
 	private $features;
 	private $class = [];
 	public function __construct()

 	{
 		# code...
 		// parent::__construct();
 		$this->features = [];
 		$this->include();

 		$this->init();
 	}

 	private function include(){

 		$finder = new Finder\Finder();

		$iter = new classtools\Iterator\ClassIterator( $finder->in( PLUGIN_PATH.'inc/classes/' ) );

		$iter->enableAutoloading();

		foreach ($iter as $class) {

		    $this->collectFitur($class->getName());

		}

		// already register all fitur
		$this->plugin = new Plugin();
		$this->on_instance_classes();
 	}

 	private function init(){

 		add_action( 'plugins_loaded', array( $this , 'on_init' ), 10, 1 );

 	}

 	public function on_init(){

 		$this->wcic_inits_class();

 	}

 	private function wcic_inits_class(){
 		if( count($this->features) ){

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

 	public function __call($method, $arguments){
 	 	if( count($this->features) ){
 			foreach ( $this->features as $fitur ) {
 				$className = $this->get_class_name($fitur);
 				if ( method_exists( $this->class[$className], $method ) && is_callable( array( $this->class[$className], $method ) ) ){
		            return call_user_func_array( array( $this->class[$className], $method ), $arguments );
		        }
 			}
 		}
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

 	public function get_class_name($fitur){
 		return (new \ReflectionClass($fitur))->getShortName();
 	}

 	public function collectFitur($obj){

 		array_push( $this->features, $obj );

 	}

 	Public function define($name='',$value){

		if ( !defined($name) ) {
			 define($name, $value);
		}

	}

 }