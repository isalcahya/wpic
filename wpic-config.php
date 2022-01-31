<?php

define( 'WP_SITE_URL', 'http://' . $_SERVER['SERVER_NAME'] ); // full url - WP_CONTENT_DIR is defined further up
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) ); // no trailing slash, full paths only - WP_SITE_URL is defined further down
define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/dependency' ); // full path, no trailing slash
define( 'WP_PLUGIN_URL', WP_SITE_URL . '/dependency' ); // full url, no trailing slash

/** Sets up Apps vars and included files. */
require_once( ABSPATH . 'wpic-database.php' );

define( 'MIDTRANS_SERVER_KEY', 'Mid-server-0msLXl9EauC2k_8TRNPYbInF' );
define( 'MIDTRANS_CLIENT_KEY', 'Mid-client-qb10Ayowu5FtsINe' );

/** Sets up Apps vars and included files. */
require_once( ABSPATH . 'wpic-settings.php' );