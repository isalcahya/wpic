<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::get('/', function() {
    return 'home';
});