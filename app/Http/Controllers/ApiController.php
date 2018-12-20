<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Config;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Driver;

class ApiController extends Controller
{

    public function __construct()
    {
        $this->driver = new Driver;
        $this->user = new User;
    }
 
    public function userLogin(Request $request){
    
		app('config')->set('jwt.user', 'App\User'); 
		app('config')->set('auth.providers.users.model', \App\User::class);
		$credentials = $request->only('email', 'password');
		$token = null;
		try {
		    if (!$token = JWTAuth::attempt($credentials)) {
		        return response()->json([
		            'response' => 'error',
		            'message' => 'invalid_email_or_password',
		        ]);
		    }
		} catch (JWTAuthException $e) {
		    return response()->json([
		        'response' => 'error',
		        'message' => 'failed_to_create_token',
		    ]);
		}
		return response()->json([
		    'response' => 'success',
		    'result' => [
		        'token' => $token,
		        'message' => 'I am front user',
		    ],
		]);
    }

    public function driverLogin(Request $request){
		config('auth.defaults.guard', 'admin');
		config('auth.defaults.passwords', 'admins');
		$user_provider = new EloquentUserProvider(app('hash'), Driver::class);
		app()->auth->setProvider($user_provider);
		// app('config')->set('jwt.user', 'App\Driver'); 
        // app('config')->set('auth.providers.users.model', \App\Driver::class);
		$credentials = $request->only('email', 'password');
		$token = null;
		try {
		    if (!$token = JWTAuth::attempt($credentials)) {
		        return response()->json([
		            'response' => 'error',
		            'message' => 'invalid_email_or_password',
		        ]);
		    }
		} catch (JWTAuthException $e) {
		    return response()->json([
		        'response' => 'error',
		        'message' => 'failed_to_create_token',
		    ]);
		}
		return response()->json([
		    'response' => 'success',
		    'result' => [
		        'token' => $token,
		        'message' => 'I am Admin user',
		    ],
		]);
    }
}