<?php

define( 'WP_SITE_URL', 'http://' . $_SERVER['SERVER_NAME'] ); // full url - WP_CONTENT_DIR is defined further up
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) ); // no trailing slash, full paths only - WP_SITE_URL is defined further down
define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/dependency' ); // full path, no trailing slash
define( 'WP_PLUGIN_URL', WP_SITE_URL . '/dependency' ); // full url, no trailing slash

/** Sets up Apps vars and included files. */
require_once( ABSPATH . 'wpic-database.php' );
$server_key = 'SB-Mid-server-ArcPDtmVoycpgLTFEqSqH8YW';
$client_key = 'SB-Mid-client-Q0uA9usoKz4Pe01w';
if ( 'production' === ENV  ) {
	$server_key = 'Mid-server-2h2_aeTUenrRd77V9At_Nzrj';
	$client_key = 'Mid-client-whhaZBs4Qj1b3n8X';
}
define( 'MIDTRANS_SERVER_KEY', $server_key );
define( 'MIDTRANS_CLIENT_KEY', $client_key );

/** Sets up Apps vars and included files. */
require_once( ABSPATH . 'wpic-settings.php' );