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
$router->get('/health-check', function () {
    return 'OK';
});

$router->group(
    [
        'prefix' => env('PREFIX') . '/api/v1',
    ], function () use ($router) {
        // User
        $router->get('/user', 'Api\v1\User\UserController@index');
        $router->post('/user', 'Api\v1\User\UserController@store');
        $router->get('/user/{product}', 'Api\v1\User\UserController@show');
        $router->put('/user/{product}', 'Api\v1\User\UserController@update');
        $router->patch('/user/{product}', 'Api\v1\User\UserController@update');
        $router->delete('/user/{product}', 'Api\v1\User\UserController@destroy');

        // Hotel
        $router->get('/hotel', 'Api\v1\Hotel\HotelController@index');
        $router->post('/hotel', 'Api\v1\Hotel\HotelController@store');
        $router->get('/hotel/{id}', 'Api\v1\Hotel\HotelController@show');
        $router->put('/hotel/{id}', 'Api\v1\Hotel\HotelController@update');
        $router->patch('/hotel/{id}', 'Api\v1\Hotel\HotelController@update');
        $router->delete('/hotel/{id}', 'Api\v1\Hotel\HotelController@destroy');

        // Room
        $router->get('/room', 'Api\v1\Room\RoomController@index');
        $router->post('/room', 'Api\v1\Room\RoomController@store');
        $router->get('/room/{id}', 'Api\v1\Room\RoomController@show');
        $router->put('/room/{id}', 'Api\v1\Room\RoomController@update');
        $router->patch('/room/{id}', 'Api\v1\Room\RoomController@update');
        $router->delete('/room/{id}', 'Api\v1\Room\RoomController@destroy');

    }
);