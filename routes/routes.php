<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::get( '/', 'FrontController@admin' );
Router::get('logout', 'FrontController@logout')->name('logout');
Router::form('login', 'FrontController@login')->name('login.page');
Router::form('register', 'FrontController@register')->name('register.page');
