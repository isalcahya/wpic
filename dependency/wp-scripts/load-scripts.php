<?php
require untrailingslashit( WCIC()->get_path( 'wp-scripts' ) ).'/functions/functions.wp-scripts.php';
require untrailingslashit( WCIC()->get_path( 'wp-scripts' ) ).'/functions/functions.wp-styles.php';
require untrailingslashit( WCIC()->get_path( 'wp-scripts' ) ).'/functions/functions.wp-script-loader.php';
require 'script-loader.php';

global $wp_scripts, $wp_styles;
$wp_scripts = new WP_Scripts();
wp_set_default_scripts( $wp_scripts );

$wp_styles = new WP_Styles();
wp_set_default_styles( $wp_styles );

// wcic head default init
add_action( 'wcic_head', 'wp_enqueue_scripts', 1 );
add_action( 'wcic_head', 'wp_print_styles', 8 );
add_action( 'wcic_head', 'wp_print_head_scripts', 9 );

// wcic footer default init
add_action( 'wcic_footer', 'wp_print_footer_scripts', 20 );
add_action( 'wp_print_footer_scripts', '_wp_footer_scripts' );