<?php

define( 'WP_SITE_URL', 'http://' . $_SERVER['SERVER_NAME'] ); // full url - WP_CONTENT_DIR is defined further up
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) ); // no trailing slash, full paths only - WP_SITE_URL is defined further down
define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/dependency' ); // full path, no trailing slash
define( 'WP_PLUGIN_URL', WP_SITE_URL . '/dependency' ); // full url, no trailing slash
/** Sets up Apps vars and included files. */
require_once( ABSPATH . 'wpic-database.php' );
/** Sets up Apps vars and included files. */
require_once( ABSPATH . 'wpic-settings.php' );