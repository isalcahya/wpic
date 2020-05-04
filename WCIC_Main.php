<?php

/**
 * Plugin Name: 	  Gis Donorejo
 * Description:       custom plugin for GIS Donorejo
 * Version:           0.0.1
 * Requires at least: 5.2
 * Author:            isal-xyz
 * License:           GPL v2 or later
 * Text Domain:       gis custom plugins
 * Domain Path:       /languages
 */


 if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
 }

 define('PLUGIN_PATH', plugin_dir_path( __FILE__ ));

 if ( ! class_exists( 'WCIC_Main' ) ) :

 final class WCIC_Main
 {

 	public function __construct()
 	{
 		// create an init or an include to construct this plugin
 		$this->includes();
 		$this->init_hook();
 	}

 	private function init_hook(){

 		register_activation_hook(__FILE__, array($this,'activate'));

 		register_deactivation_hook(__FILE__, array($this,'deactivate'));

 	}

 	private function includes(){

 		if( file_exists(plugin_dir_path(__DIR__.'/vendor/autoload')) ){

	 		define( 'WPIC_BASE', plugin_dir_path(__FILE__) );

			require WPIC_BASE.'vendor/autoload.php';

			// jika program berhasil mengeksekusi sampai baris sini berarti plugin berhasil di 	  jalankan

 		}

 		new App\lib\Wcic_Load_Class();

 	}
 		// activated this plugin
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

 new WCIC_Main();

 endif;
