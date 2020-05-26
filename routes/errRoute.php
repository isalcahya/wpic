<?php
use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\Http\Request;

Router::get('/not-found', function(){
	return 'damn, you goes wrong';
});

Router::error(function(Request $request, \Exception $exception) {

    if( $exception instanceof NotFoundHttpException && $exception->getCode() === 404 ) {
        response()->redirect('/not-found');
    }

});