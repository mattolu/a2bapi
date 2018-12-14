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
//Register
$router->post('/driver/register', 'DriverController@createNewDriver');
//Login
//$router->post('/driver/login', 'LoginController@driverLogin');
$router->post('/driver/login', 'DriverLogin@driverLogin');
//Attach bus to a driver
$router->post('/driver/bus/{driver_id}', 'BusController@createNewBus');
//Get reports
//$router->get('/driverreport/{driver_id}', 'ReportCOntroller@getDriverReports');

/** 
     * User's unprotected routes
*/ 
//Register
$router->post('/user/register', 'UserController@createNewUser');
//Login
$router->post('/user/login', 'UserLogin@userLogin');
//Get reports
//$router->get('/userreports/{user_id}', 'ReportCOntroller@getUserReports');


$router->group(['middleware' => 'jwt.auth'], function($router){

    /** 
     * Driver's protected routes
    */ 
    // Driver Profile
    $router->get('/driverprofile/{driver_id}', 'DriverController@getProfile');
    //Driver Report
    $router->post('/driver/report/{driver_id}', 'ReportController@createNewDriverReport');
    // Driver Upload pix
    $router->post('/uploadpix/{driver_id}', 'DriverController@updatePix');
    // Get the driver profile
    $router->get('/driverprofile/{driver_id}', 'DriverController@getProfile');

    /** 
     *   Users' Protected routes
    */ 
    // User create accident report
    $router->post('/user/report/{user_id}', 'ReportController@createNewUserReport');
    // Upload profile pix
//    $router->post('/user/uploadpix/{user_id}', 'UserController@updatePix');
    // Getting the user's profile
    $router->get('/userprofile/{user_id}', 'UserController@getProfile');
    //Subscription Protected routes
    $router->post('/subscribe/{user_id}', 'User_subscriptionController@createSubscription');
    //Create user's cards
    $router->post('/user/card/{user_id}', 'CardController@createCard');
    //Get user's cards
    $router->get('/usercards/{user_id}', 'CardController@getCards');
    
});
//Temporary route for image upload
$router->post('/user/uploadpix/{user_id}', 'UserController@updatePix');


/**
 * USING A NEW MIDDLEWARE TO PROTECT THE ROUTE... CHECK BOOTSTRAP/APP
 */
// $router->group(['middleware' => ['jwt.verify']], function($router){

//     /** 
//      * Driver's protected verification routes
//     */ 
//     // Driver Profile
//     $router->get('/driverprofile/{driver_id}', 'DriverController@getProfile');
//     //Driver Report
//     $router->post('/driver/report', 'ReportController@createNewDriverReport');
//     // Driver Upload pix
//     $router->post('/uploadpix/{driver_id}', 'DriverController@updatePix');
//     // Get the driver profile
//     $router->get('/driverprofile/{driver_id}', 'DriverController@getProfile');

//     /** 
//      *   Users' Protected routes
//     */ 
//     // User create accident report
//     $router->post('/user/report', 'ReportController@createNewUserReport');
//     // Upload profile pix
//    $router->post('/user/uploadpix/{user_id}', 'UserController@updatePix');
//     // Getting the user's profile
//     $router->get('/userprofile/{user_id}', 'UserController@getProfile');
//     //Subscription Protected routes
//     $router->post('/subscribe/{user_id}', 'User_subscriptionController@createSubscription');
//     //Create user's cards
//     $router->post('/user/card/{user_id}', 'CardController@createCard');
//     //Get user's cards
//     $router->get('/usercards/{user_id}', 'CardController@getCards');
    
// });

  

//$router->get('/driver', ['middleware'=>'auth', 'uses'=>'DriverController@getDriver']);
// $router->group(['middleware' => 'jwt.auth'], function($router){
  
//     // $router->post('/uploadpix/{driver_id}', 'DriverController@updatePix');
//   });

//$router->post('/resetpassword', 'LoginController@recoverPassword');
//$router->post('/upload', 'ReportController@uploadimages');
//$router->get('/profile/{driver_id}', 'DriverController@getProfile');
//$router->get('/profile/{driver_id}', ['middleware'=>'jwt.auth', 'uses'=>'DriverController@getProfile']);