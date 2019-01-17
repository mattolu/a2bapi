<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Driver;
use DB;
use Validator;

class ForgotDriverPasswordController extends BaseController
{   
    // use ResetsPasswords;
    // use SendsPasswordResetEmails;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $hasher;
    public function __construct(HasherContract $hasher)
    {
        $this->hasher = $hasher;
    }

    
    public function generateResetToken(Request $request)
    {
        //validate the email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
            ]);

       if($validator->fails()){
           return response()->json([
               'error'=>[
                   'success' => false,
                   'status' =>400,
                   'message' => $validator->errors()->all()
                       ]
                    ],400);
       } else{
           //if validation is successful, check the User DB 
           $email = $request->email;
           $driver = Driver::where ('email', $request->input('email'))->first();
           
           if (!$driver){

            return response()->json([
                'error' =>[
                    'message' => 'Email does not exist.',
                    'status' => 400
                    ]
                ],400);

           }
           //Token generation and send to the mail
            $token = $this->broker()->createToken($driver);
            $response = $this->broker()->sendResetLink($request->only('email'));

            return $response == Password::RESET_LINK_SENT
            ? response()->json([
                'result'=>[
                    'message' => 'Reset link sent to your email.', 
                    'status' =>201,
                    'success' => true
                    ]
                ], 201)
                
            : response()->json([
                'error'=>[
                    'message' => 'Unable to send reset link', 
                    'status' => 401], 
                ], 401);
        }
        
    }

    //  Reset Password
    public function resetPassword(Request $request)
    {
        //validate the input of the user
        $validator = Validator::make($request->all(), 
                [
                    'email' => 'required|email',
                    'password' => 'required|confirmed|min:6'
                ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>[
                    'success' => false,
                    'status' =>400,
                    'message' => $validator->errors()->all()
                        ]]);
                }
        //check for the token, hash it and compare with the DB before updating user password
        if ($request->token != null){
            $reset_query =  DB::table("password_resets")->where('email', $request->email);
            $reset = DB::table("password_resets")->where('email', $request->email)->first();
            if($reset){
                    if($this->hasher->check($request->token, $reset->token)){
                        $driver = Driver::where('email', '=', $request->email)->first();
                        $driver->password = app('hash')->make($request->password);
                        $driver->flag_changed_password = true;
                        $driver->save();
                        $reset_query->delete();
                        return response()->json([
                            'result' => [
                                'success' => true,
                                'message' => 'Password reset successfully',
                                'status' => 201
                                ]
                            ], 201);
                    }
                    return   response()->json([
                        'error'=>[
                            'message' => 'Token not existing - mismatched', 
                            'status' => 401,
                            'success' => false
                        ]
                    ], 401);
            }
            return response()->json([
                'error' => [
                    'message' => 'Email not found', 
                    'status' => 401,
                    'success' => false
                    ]
                ], 401);
        }
        return   response()->json([
            'error'=>[
                'message' => 'Token is null', 
                'status' => 401,
                'success' => false
            ]
        ], 401);
    }
    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
   
    protected function broker()
    {
        return Password::broker('drivers');
    }
}
