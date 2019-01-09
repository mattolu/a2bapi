<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Laravel\Lumen\Routing\Controller;
use Validator;

class ForgotPasswordController extends Controller
{   
    use ResetsPasswords, SendsPasswordResetEmails;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // public function __invoke(Request $request)
	// {
	// 	$this->validateEmail($request);
	// 	// We will send the password reset link to this user. Once we have attempted
	// 	// to send the link, we will examine the response then see the message we
	// 	// need to show to the user. Finally, we'll send out a proper response.
	// 	$response = $this->broker()->sendResetLink(
	// 		$request->only('email')
	// 	);
	// 	return $response == Password::RESET_LINK_SENT
	// 		? response()->json(['message' => 'Reset link sent to your email.', 'status' => true], 201)
	// 		: response()->json(['message' => 'Unable to send reset link', 'status' => false], 401);
    // }
    
    
    public function generateResetToken(Request $request)
    {
        // Check email address is valid
        $this->validate($request, []);
        $validator = Validator::make($request,['email' => 'required|email']);

       if($validator->fails()){
           return response()->json([
               'error'=>[
                   'success' => false,
                   'status' =>400,
                   'message' => $validator->errors()->all()
                       ]]);
       }else{
           $user = User::where ('email', $request->input('email'))->first();
           if (!$user){

            return response()->json([
                'error' =>[
                    'message' => 'Email does not exist.',
                    'status' => 400
                    ]]);

           }
           $token = $this->broker()->createToken($user);
            // Send password reset to the user with this email address
            $response = $this->broker()->sendResetLink($request->only('email'));

            return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email.', 'status' => true], 201)
            : response()->json(['message' => 'Unable to send reset link', 'status' => false], 401);
                }
        
    }

    //  Reset Password
    public function resetPassword(Request $request)
    {
        // Check input is valid
        $rules = [
            'token'    => 'required',
            'email' => 'required|string',
            'password' => 'required|confirmed|min:6',
        ];
        $this->validate($request, $rules);

        // Reset the password
        $response = $this->broker()->reset(
        $this->credentials($request),
            function ($user, $password) {
                $user->password = app('hash')->make($password);
                $user->save();
            }
        );

        return $response == Password::PASSWORD_RESET
        ? response()->json(['response_message'=> $this->sendResetResponse($response), 'message' => 'Password Reset successful.', 'status' => true], 201)
        : response()->json(['response_message'=> $this->sendResetFailedResponse($response),'message' => 'Unable to reset password', 'status' => false], 401);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password', 'password_confirmation', 'token');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        $passwordBrokerManager = new PasswordBrokerManager(app());
        return $passwordBrokerManager->broker();
    } 
}

