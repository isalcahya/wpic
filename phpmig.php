<?php
use Phpmig\Adapter;
use Pimple\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

$container = new Container();

# silence is gold
define( 'ABSPATH', dirname( __FILE__ ) . '/' );

require_once( ABSPATH . 'wpic-database.php' );

$container['config'] = [
    'driver'    => DBDRIVER,
    'host'      => DBHOST,
    'database'  => DBNAME,
    'username'  => DBUSER,
    'password'  => DBPASS,
];

$container['db'] = function ($c) {
    $capsule = new Capsule();
    $capsule->addConnection($c['config']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};

$container['phpmig.adapter'] = function($c) {
    return new Adapter\Illuminate\Database($c['db'], 'migrations');
};

$container['phpmig.migrations_path'] = ABSPATH . 'database/migrations';

$container['schema'] = function($c){
    return $c['db']::schema();
};

return $container;