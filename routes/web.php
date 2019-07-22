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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/classes', 'ClassesController@list');
    $router->get('/classes/{id}', 'ClassesController@get');
    $router->post('/classes', 'ClassesController@insert');
    $router->put('/classes/{id}', 'ClassesController@update');
    $router->delete('/classes/{id}', 'ClassesController@delete');
    $router->get('/classes/{id}/bookings', 'ClassesController@getClassBookings');

    $router->get('/bookings', 'BookingController@list');
    $router->get('/bookings/{id}', 'BookingController@get');
    $router->post('/bookings', 'BookingController@insert');
    $router->put('/bookings/{id}', 'BookingController@update');
    $router->delete('/bookings/{id}', 'BookingController@delete');
    $router->get('/bookings/{id}/classes', 'BookingController@getBookingClasses');
});

$router->get('{route}', function ($route) use ($router) {
    return response()->json(['error' => 'Route: '.$route.' not found'], 404);
});
