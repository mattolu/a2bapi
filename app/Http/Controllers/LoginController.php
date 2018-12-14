<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{


 /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    // protected $jwt;

    // public function __construct(JWTAuth $jwt)
    // {
    //     $this->jwt = $jwt;
    // }


    /**
 * Sets the guard to be used during authentication.
 *
 * @var string|null
 */
protected $guard = null;

// All your usually authentication methods using `$this->guard()`

/**
 * Gets the guard to be used during authentication.
 *
 * @return \Illuminate\Contracts\Auth\StatefulGuard
 */
protected function guard()
{
    return Auth::guard($this->guard);
}
    // public function driverLogin(Request $request)
    // {
    //     $this->validate($request, [
    //         'email'    => 'required',
    //         'password' => 'required',
    //     ]);

    //     try {
    //         //app('config')->set('jwt.user', 'App\Driver'); 
    //         app('config')->set('auth.providers.users.model', \App\Driver::class);
    //         $token = $this->jwt->attempt($request->only('email', 'password'));
    //         if (!$token) {
    //             return json_encode([
    //                 'status'=>false,
    //                 'message'=>'Driver not found',
                    
    //               ], 404); 
               
    //         }

    //     } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
    //         return json_encode([
    //             'status'=>false,
    //             'message'=>'Token Expired',
                
    //           ], 500); 

    //     } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    //         return json_encode([
    //             'status'=>false,
    //             'message'=>'Token Invaid',
                
    //           ], 500); 
    //     } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
    //         return json_encode([
    //             'status'=>'Token not present',
    //             'message'=>$e->getMessage(),
                
    //           ], 500); 
         
    //     }
              
    //             return json_encode([
    //                                     'status'=>true,
    //                                     'message'=>'Successfully logged in',
    //                                     'token'=> $token
    //                                   ], 200); 
 
    // }

    // public function userLogin(Request $request)
    // {
    //     $this->validate($request, [
    //         'email'    => 'required',
    //         'password' => 'required',
    //     ]);

    //     try {
    //         app('config')->set('jwt.user', 'App\User'); 
    //         app('config')->set('auth.providers.users.model', \App\User::class);
    //         $token = $this->jwt->attempt($request->only('email', 'password'));
    //         if (!$token) {
    //             return json_encode([
    //                 'status'=>false,
    //                 'message'=>'Driver not found',
                    
    //               ], 404); 
               
    //         }

    //     } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
    //         return json_encode([
    //             'status'=>false,
    //             'message'=>'Token Expired',
                
    //           ], 500); 

    //     } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
    //         return json_encode([
    //             'status'=>false,
    //             'message'=>'Token Invaid',
                
    //           ], 500); 
    //     } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
    //         return json_encode([
    //             'status'=>'Token not present',
    //             'message'=>$e->getMessage(),
                
    //           ], 500); 
         
    //     }
              
    //             return json_encode([
    //                                     'status'=>true,
    //                                     'message'=>'Successfully logged in',
    //                                     'token'=> $token
    //                                   ], 200); 
 
    // }
    
//PASSWORD RESET GOES HERE
    // public function recoverPassword(){
    //         {
        
    //             $rules = [
    //                 'email' => 'required',
                   
    //             ];
           
    //               $customMessages = [
    //                  'required' => ':attribute is required'
    //             ];
    //               $this->validate($request, $rules, $customMessages);
    //                $email    = $request->input('email');
    //             $driver = Driver::where('email', $request->email)->first();
    //             if (!$driver) {
    //                 $error_message = "Your email address was not found.";
    //                 return json_encode([
    //                     'success'=>false,
    //                     'error' => ['email'=> $error_message]
                        
    //                   ], 401); 
    //                // return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
    //             }
    //             try {
    //                 $driver = new Driver();
    //                 $verification_code = str_random(30); //Generate verification code
    //     // DB::table('password_reset')->insert(['driver_id'=>$driver->id,'token'=>$verification_code]);
    //     // DB::table('password_reset')->insert(['driver_id'=>$driver->id,'token'=>$verification_code]);
    //                 Password::sendResetLink($request->only('email'), function (Message $message) {
    //                     $message->subject('Your Password Reset Link');
    //                 });
    //             } catch (\Exception $e) {
    //                 //Return with error
    //                 $error_message = $e->getMessage();
    //                 return json_encode([
    //                     'success'=>false,
    //                     'error' => ['email'=> $error_message]
                        
    //                   ], 401); 
    //                 //return response()->json(['success' => false, 'error' => $error_message], 401);
    //             }
    //             // return response()->json([
                    
    //             //     'success' => true, 
    //             // ]);

    //             return json_encode([
    //                 'success'=>true,
    //                 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
    //               ], 401); 
    //         }
    //     }
   

    }







//     public function login(Request $request)
//     {
 
//       $rules = [
//           'driver_id' => 'required',
//           'password' => 'required'
//       ];
 
//         $customMessages = [
//            'required' => ':attribute is required'
//       ];
//         $this->validate($request, $rules, $customMessages);
//          $driver_id    = $request->input('driver_id');
//         try {
//             $login = Driver::where('driver_id', $driver_id)->first();
//             if ($login) {
//                 if ($login->count() > 0) {
//                     if (Hash::check($request->input('password'), $login->password)) {
//                         try {
//                             $api_token = sha1($login->id.time());
 
//                               $create_token = Driver::where('id', $login->id)->update(['api_token' => $api_token]);
                              
//                               return json_encode([
//                                 'status'=>true,
//                                 'message'=>'Successfully logged in',
//                                 'data'=>$login,
//                                 'api_token'=> $api_token,
//                               ], 200); 
//                             //   $res['status'] = true;
//                             //   $res['message'] = 'Success login';
//                             //   $res['data'] =  $login;
//                             //   $res['api_token'] =  $api_token;
 
//                             //   return response($res, 200);
 
 
//                         } catch (\Illuminate\Database\QueryException $ex) {
//                             return json_encode([
//                                 'status'=> false,
//                                 'message'=> $ex->getMessage(),

//                               ], 200);
                            
//                             // $res['status'] = false;
//                             // $res['message'] = $ex->getMessage();
//                             // return response($res, 500);
//                         }
//                     } else {

//                         return json_encode([
//                             'success'=> false,
//                             'message'=> 'email/password not found',
//                           ], 401);


//                         // $res['success'] = false;
//                         // $res['message'] = 'Username / email / password not found';
//                         // return response($res, 401);
                        
//                     }
//                 } else {
//                     return json_encode([
//                         'success'=> false,
//                         'message'=> 'email/password not found',
//                       ], 401);
                    
//                 //     $res['success'] = false;
//                 //     $res['message'] = 'Username / email / password  not found';
//                 //     return response($res, 401);
//                  }
//             } else {
//                 return json_encode([
//                     'success'=> false,
//                     'message'=> 'email/password not found',
//                   ], 401);
//                 // $res['success'] = false;
//                 // $res['message'] = 'Username / email / password not found';
//                 // return response($res, 401);
//             }
//         } catch (\Illuminate\Database\QueryException $ex) {

//             return json_encode([
//                 'success'=> false,
//                 'message'=> $ex->getMessage(),
//               ], 500);
//             // $res['success'] = false;
//             // $res['message'] = $ex->getMessage();
//             // return response($res, 500);
//         }
//     }

// // @TO-DO

//     public function logout(Request $request) {
//         $this->validate($request, ['token' => 'required']);
//         try {
//             // JWTAuth::invalidate($request->input('token'));
//             return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
//         } catch (JWTException $e) {
//             // something went wrong whilst attempting to encode the token
//             return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
//         }
//     }
// public function recoverPassword(){
//     {

//         $rules = [
//             'email' => 'required',
           
//         ];
   
//           $customMessages = [
//              'required' => ':attribute is required'
//         ];
//           $this->validate($request, $rules, $customMessages);
//            $email    = $request->input('email');
//         $driver = Driver::where('email', $request->email)->first();
//         if (!$driver) {
//             $error_message = "Your email address was not found.";
//             return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
//         }
//         try {
//             Password::sendResetLink($request->only('email'), function (Message $message) {
//                 $message->subject('Your Password Reset Link');
//             });
//         } catch (\Exception $e) {
//             //Return with error
//             $error_message = $e->getMessage();
//             return response()->json(['success' => false, 'error' => $error_message], 401);
//         }
//         return response()->json([
//             'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
//         ]);
//     }
// }









