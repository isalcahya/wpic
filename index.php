<?php

# silence is gold

define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Loads the Custom Framework Environment and Template */
require( dirname( __FILE__ ) . '/dependency/wp-custom-functions.php' );
require( dirname( __FILE__ ) . '/WCIC_Main.php' );