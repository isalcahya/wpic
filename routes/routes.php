<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::get( '/', 'AdminController@admin' );