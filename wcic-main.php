<?php

/**
 * Plugin Name: 	  Unique Name
 * Description:       custom project
 * Version:           0.0.1
 * Requires at least: 5.2
 * Author:            isal-xyz
 * License:           GPL v2 or later
 * Domain Path:       /languages
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

if ( ! class_exists( 'Wcic_Main' ) ) :
final class Wcic_Main {

 	public function __construct()
 	{
 		// create an init or an include to construct this plugin
 		$this->includes();
 		$this->init_hook();
 	}

 	private function init_hook(){

 		// register_activation_hook( __FILE__ , array( $this, 'activate' ) );

 	}

 	private function includes(){

 		$this->register_dependency();

 		// you can initilize action
 		if ( class_exists( 'App\lib\wcic_load_class' ) ) {
 			\App\wcic_init_hooks::instance();
 		}

 		if ( class_exists( 'App\lib\wcic_load_environment' ) ) {
 			\App\lib\wcic_load_environment::instance();
 		}
 	}

 	private function register_dependency(  ){

 		if( file_exists( plugin_dir_path( __DIR__ . '/vendor/autoload' ) ) ){

	 		define( 'WPIC_BASE', plugin_dir_path(__FILE__) );

			require untrailingslashit( WPIC_BASE ).'/vendor/autoload.php';

			require untrailingslashit( WPIC_BASE ).'/dependency/wp-custom-dependency.php';
			// jika program berhasil mengeksekusi sampai baris sini berarti plugin berhasil di 	  jalankan
 		}
 	}

 	private function activate(){
 		// flush rewrite rules;
 		flush_rewrite_rules();
 	}

 		// daectivated plugin
 	private function deactivate(){
 		// flush rewrite rules;
 		flush_rewrite_rules();
 	}

 }

 new Wcic_Main();

 endif;
