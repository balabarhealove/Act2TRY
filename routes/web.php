<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/* |---------------------------------------------------------------------
| Application Routes
|---------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Define API routes
    $router->get('/users',['uses' => 'UserController@getUsers']);
    $router->post('/users',['uses' => 'UserController@add']); // Create new user

   // $router->get('/users/{id}', 'UserController@show'); // Get user by id
   // $router->put('/users/{id}', 'UserController@update'); // Update user record
    //$router->patch('/users/{id}', 'UserController@update'); // Update user record
    //$router->delete('/users/{id}', 'UserController@delete'); // Delete record