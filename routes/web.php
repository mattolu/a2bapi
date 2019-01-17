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
//Send token to mail
$router->post('/senddrivertoken',  'ForgotDriverPasswordController@generateResetToken');
//Reset user password
$router->post('/driverreset/{token}', 'ForgotDriverPasswordController@resetPassword');
/** 
     * User's unprotected routes
*/
//User Register
$router->post('/user/register', 'UserAuthController@register');
$router->post('/update', 'UserAuthController@update');
//User login
$router->post('/user/login', 'UserAuthController@authenticate');
//Send token to mail
$router->post('/sendtoken',  'ForgotPasswordController@generateResetToken');
//Reset user password
$router->post('/reset/{token}', 'ForgotPasswordController@resetPassword');
//Attach bus to a driver
$router->post('/driver/bus/{driver_id}', 'BusController@createNewBus');

//User origin
$router->post('/user/origin1', 'UserLocationController@createOrigin');
//Get User origin
$router->get('/userorigin1', 'UserLocationController@getOrigin');
//User destination
$router->post('/user/destination1', 'UserLocationController@createDestination');
//Get User desination
$router->get('/userdestination1', 'UserLocationController@getDestination');

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
        $router->get('/usersubscription', 'User_subscriptionController@getSubscription');
        //Get all user's subscription
        $router->get('/allusersubscriptions', 'User_subscriptionController@getSubscriptionAll');
        
        //Create user's cards
        $router->post('/user/card', 'CardController@createCard');
        //Get user's cards
        $router->get('/usercards', 'CardController@getCards');
        //User reports
        $router->post('/user/report', 'ReportController@createNewUserReport');
        //User update pix
        $router->post('/user/uploadpix', 'UserController@updatePix');
        //User location
        $router->post('/user/origin', 'UserLocationController@createOrigin');
         //Get User location
        $router->get('/userorigin', 'UserLocationController@getOrigin');
         //User location
        $router->post('/user/destination', 'UserLocationController@createDestination');
        //Get User location
        $router->get('/userdestination', 'UserLocationController@getDestination');
         // Contact us page
        $router->post('/contactus', 'ContactController@contactUs');
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

