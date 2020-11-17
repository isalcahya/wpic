<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::get( '/', 'FrontController@admin' );
Router::get( '/login', 'FrontController@login' )->name( 'login.page' );
Router::form('register', 'FrontController@register' )->name( 'register.page' );