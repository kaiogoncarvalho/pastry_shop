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
/**
 * @var \Laravel\Lumen\Routing\Router $router
 */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'v1/clients'], function () use ($router){
    $router->get('/', 'ClientsController@getAll');
    $router->post('/', 'ClientsController@create');
    $router->patch('/{id}', 'ClientsController@update');
    $router->get('/{id}', 'ClientsController@get');
    $router->delete('/{id}', 'ClientsController@delete');
});

$router->group(['prefix' => 'v1/pastries'], function () use ($router){
    $router->get('/', 'PastriesController@getAll');
    $router->post('/{id}', 'PastriesController@update');
    $router->post('/', 'PastriesController@create');
    $router->get('/{id}/photo', 'PastriesController@getPhoto');
    $router->get('/{id}', 'PastriesController@get');
    $router->delete('/{id}', 'PastriesController@delete');

});

$router->group(['prefix' => 'v1/orders'], function () use ($router){
    $router->get('/', 'OrdersController@getAll');
    $router->post('/{id}/email', 'OrdersController@sendEmail');
    $router->post('/', 'OrdersController@create');
    $router->patch('/{id}', 'OrdersController@update');
    $router->get('/{id}', 'OrdersController@get');
    $router->delete('/{id}', 'OrdersController@delete');
});

