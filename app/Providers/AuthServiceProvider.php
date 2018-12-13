<?php

namespace App\Providers;

use App\Driver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        // $this->app['auth']->viaRequest('api', function ($request) {
        //     if ($request->input('api_token')) {
        //         return Driver::where('api_token', $request->input('api_token'))->first();
        //     }
        // });
        
        $this->app['auth']->viaRequest('api', function ($request){
            return \App\Driver::where('email', $request->input('email'))->first();
        });

        // $this->app['auth']->viaRequest('token', function ($request) {
        //     $access_token = HelperClass::getTokenFromHeader($request->headers->get('Authorization'));
    
        //     if ($access_token) {
        //         $tokendata = JWT::decode($access_token, getenv('TOKEN_SECRET'), array('HS256'));
    
        //         if ($tokendata->user_id) {
        //             return User::find($tokendata->user_id);
        //         }
    
        //         return Client::find($tokendata->client_id);
        //     }
        // });
    }
}

