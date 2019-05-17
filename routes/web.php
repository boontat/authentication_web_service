<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// not use
// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

// register endpoint
$router->post('api/register', 'UserController@register');

// login endpoint
$router->post('api/login', 'UserController@login');

// Other endpoiont that should be wrapped with access_token
$router->group(['prefix' => 'api', 'middleware' => 'client'], function() use (&$router){
    $router->post('details', 'UserController@usersDetails');
});
