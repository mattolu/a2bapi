<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserLogin extends LoginController{
/**
 * Sets the guard to be used during authentication.
 *
 * @var string|null
 */
protected $guard = 'user';

public function userLogin(Request $request){
$this->validate($request, [
    'email'    => 'required',
    'password' => 'required',
]);

try {
   
    $token = $this->guard()->attempt($request->only('email', 'password'));
    if (!$token) {
        return json_encode([
            'status'=>false,
            'message'=>'Driver not found',
            
          ], 404); 
       
    }

} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
    return json_encode([
        'status'=>false,
        'message'=>'Token Expired',
        
      ], 500); 

} catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    return json_encode([
        'status'=>false,
        'message'=>'Token Invaid',
        
      ], 500); 
} catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
    return json_encode([
        'status'=>'Token not present',
        'message'=>$e->getMessage(),
        
      ], 500); 
 
}
      
        return json_encode([
                                'status'=>true,
                                'message'=>'Successfully logged in',
                                'token'=> $token
                              ], 200); 

}

}