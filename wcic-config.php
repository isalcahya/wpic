<?php

define( 'WP_SITE_URL', 'http://' . $_SERVER['SERVER_NAME'] ); // full url - WP_CONTENT_DIR is defined further up
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) ); // no trailing slash, full paths only - WP_SITE_URL is defined further down
define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/dependency' ); // full path, no trailing slash
define( 'WP_PLUGIN_URL', WP_SITE_URL . '/dependency' ); // full url, no trailing slash

// ** MySQL settings - You can get this info from your web host ** //
define( 'DBDRIVER', 'mysql' );

/** MySQL hostname */
define( 'DBHOST', 'localhost' );

/** The name of the database for Apps */
define( 'DBNAME', 'pkl__fiani' );

/** MySQL database username */
define( 'DBUSER' , 'root' );

/** MySQL database password */
define( 'DBPASS', '' );

// define environment
define( 'ENV', 'prod' );

/** Sets up Apps vars and included files. */
require_once( ABSPATH . 'wcic-settings.php' );