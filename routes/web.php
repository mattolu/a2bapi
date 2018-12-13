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
$router->get('/key', function() {
    return str_random(32);
});

//Driver's routes
$router->post('/driver/report', 'ReportController@createNewReport');
$router->post('/driver/register', 'DriverController@createNewDriver');
$router->post('/driver/login', 'LoginController@driverLogin');
$router->get('/driverprofile/{driver_id}', 'DriverController@getProfile');//to be moved to the middleware
$router->post('/uploadpix/{driver_id}', 'DriverController@updatePix');
$router->group(['middleware' => 'jwt.auth'], function($router){
   $router->get('/driver/profile/{driver_id}', 'DriverController@getProfile');
  // $router->post('/uploadpix/{driver_id}', 'DriverController@updatePix');
});

//User's routes
//$router->post('/report', 'ReportController@createNewReport');
$router->post('/user/register', 'UserController@createNewUser');
$router->post('/user/login', 'LoginController@userLogin');
//$router->post('/user/uploadpix/{user_id}', 'UserController@updatePix');
$router->group(['middleware' => 'jwt.auth'], function($router){
   $router->get('/userprofile/{user_id}', 'UserController@getProfile');
   $router->post('user/uploadpix/{user_id}', 'UserController@updatePix');
});

//Subscription
$router->post('/subscribe/{user_id}', 'User_subscriptionController@createSubscription');

//$router->get('/driver', ['middleware'=>'auth', 'uses'=>'DriverController@getDriver']);

//$router->post('/resetpassword', 'LoginController@recoverPassword');
//$router->post('/upload', 'ReportController@uploadimages');
//$router->get('/profile/{driver_id}', 'DriverController@getProfile');
//$router->get('/profile/{driver_id}', ['middleware'=>'jwt.auth', 'uses'=>'DriverController@getProfile']);