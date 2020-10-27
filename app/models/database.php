<?php
namespace Models;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database {
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
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => DBDRIVER,
            'host'      => DBHOST,
            'database'  => DBNAME,
            'username'  => DBUSER,
            'password'  => DBPASS,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        // Setup the Eloquent ORM…
        $capsule->bootEloquent();

        do_action_ref_array( 'wcic_after_boot_database', array( &$capsule ) );
    }
}