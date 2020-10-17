<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::get( '/', 'AdminController@admin' );
Router::get( '/login', 'AdminController@login' );