<?php

function WCIC(){
    return new App\lib\wcic_load_class();
}

function view(){
	return new App\lib\wcic_load_view();
}

function get_image_directory(){
	return untrailingslashit( WCIC()->get_path( 'resource', true ) . 'img/' );
}

function get_dist_directory(){
	return untrailingslashit( WCIC()->get_path( 'dist', true ) );
}