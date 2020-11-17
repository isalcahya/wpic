<?php
namespace App\lib;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;

class WpicEloquent {
    protected static $_instance = null;

    const _DBHOST = DBHOST;
    const _DBNAME = DBNAME;
    const _DBUSER = DBUSER;
    const _DBPASS = DBPASS;
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
            'driver'    => 'mysql',
            'host'      => self::_DBHOST,
            'database'  => self::_DBNAME,
            'username'  => self::_DBUSER,
            'password'  => self::_DBPASS,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        // Set the event dispatcher used by Eloquent models... (optional)
        $capsule->setEventDispatcher(new Dispatcher(new Container));

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();

        $this->instance_auth_php();
    }

    public function instance_auth_php(){
        $dbname = self::_DBNAME;
        $dbhost = self::_DBHOST;
        $dsn    = "mysql:dbname={$dbname};host=$dbhost";
        $pdo    = new \PDO($dsn, self::_DBUSER, self::_DBPASS);

        if ( ! defined( 'PHPMIG_MIGRATE' ) ) {
            global $wpauth;
            try {
                $wpauth = new \Delight\Auth\Auth( $pdo );
            } catch (Exception $e) {
                $wpauth = null;
            }
        }
    }
}