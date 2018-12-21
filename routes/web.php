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

/** 
     * Driver's unprotected routes
*/ 
//Driver Register
$router->post('/driver/register', 'DriverAuthController@register');
//Driver Login
$router->post('/driver/login', 'DriverAuthController@authenticate');

/** 
     * User's unprotected routes
*/
//User Register
$router->post('/user/register', 'UserAuthController@register');
//User login
$router->post('/user/login', 'UserAuthController@authenticate');

//Attach bus to a driver
$router->post('/driver/bus/{driver_id}', 'BusController@createNewBus');

/**
 * Protected user routes
 */
$router->group(
    ['middleware' => 'jwt.auth:user',], 
    function($router)  {
        //User profile
        $router->get('/userprofile', 'UserController@fetchUserDetails');
        //User profile update
        $router->post('/user/update', 'UserController@updateProfile');
        
        //Subscription Protected routes
        $router->post('/subscribe', 'User_subscriptionController@createSubscription');
        //Get User subscription
        $router->get('/usersubscriptions', 'User_subscriptionController@getSubscription');
        //Create user's cards
        $router->post('/user/card', 'CardController@createCard');
        //Get user's cards
        $router->get('/usercards', 'CardController@getCards');
        //User reports
        $router->post('/user/report', 'ReportController@createNewUserReport');
        //User update pix
        $router->post('/user/uploadpix', 'UserController@updatePix');
        //User location
        $router->post('/user/location', 'UserLocationController@createLocation');
         //Get User location
         $router->get('/userlocation', 'UserLocationController@getUserLocation');
    }
);
/**
 * Protected driver routes
 */
$router->group(
    ['middleware' => 'jwt.auth:driver',], 
    function($router)  {
        //Driver profile
        $router->get('/driverprofile', 'DriverController@fetchDriverDetails');
        //Report accident
        $router->post('/driver/report', 'ReportController@createNewDriverReport');
        // Driver Upload pix
        $router->post('/uploadpix', 'DriverController@updatePix');
    }
);

