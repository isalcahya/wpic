<?php

# silence is gold

define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Loads the Custom Framework Environment and Template */
require( dirname( __FILE__ ) . '/wcic_config.php' );
require( dirname( __FILE__ ) . '/dependency/wp-custom-functions.php' );
require( dirname( __FILE__ ) . '/wcic_main.php' );