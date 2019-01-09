<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Validator;
use App\Repositories\UserRepository;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Driver;
use App\Mail\RegisterConfirmation;
use Laravel\Lumen\Routing\Controller as BaseController;


class DriverAuthController extends BaseController
{
    /**
    * The request instance.
    *
    * @var \Illuminate\Http\Request
    */
    public $attributes;
    private $request;
    /**
    * Create a new controller instance.
    *
    * @param \Illuminate\Http\Request $request
    * @return void
    */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
    * Create a new token.
    *
    * @param \App\Driver $driver
    * @return string
    */
    protected function jwt(Driver $driver){
        $payload = [
                    'iss' => 'lumen-jwt', // Issuer of the token
                    'sub' => $driver->id, // Subject of the token
                    'iat' => time(), // Time when JWT was issued.
                    'exp' => time() + 3600*3600 // Expiration time
                ];
        return JWT::encode($payload, env('JWT_SECRET'), 'HS512');
    }

    /**
    * Registration method
    *
    * @param Request $request registration request
    *
    * @return array
    * @throws \Illuminate\Validation\ValidationException
    */
    public function register(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'first_name' => 'required',
        'last_name' => 'required',
        'phone_no' => 'required',
        'address' => 'required',
        'email' => 'required|email|unique:drivers'
    ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>[
                    'success' => false,
                    'status' =>400,
                    'message' => $validator->errors()->all()
                        ]]);
        
            } else{
                function unique_link($length=10, $characters) {
                    $string = '';
                    for ($p = 0; $p < $length; $p++) {
                        $string .= $characters[mt_rand(0, strlen($characters)-1)];
                    }
                
                    return $string;
                }

                $characters = "23456789ABCDEFHJKLMNPRTVWXYZ";
                $ref = unique_link(6, $characters);
                $driver_id = "A2B-".$ref; // driver's id generated
                $characters_10 = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";
                // Defining characters for the driver's password.
                $password = unique_link(10, $characters_10); // driver's password generated
                $request->attributes->add(['password' => $password]);
               
              
                var_dump($password);

                
                    }
                    try{

                        $hasher = app()->make('hash');

                        $driver = new Driver();
                        $driver->first_name = $request->first_name;
                        $driver->last_name = $request->last_name;
                        $driver->phone_no = $request->phone_no;
                        $driver->address = $request->address;
                        $driver->email = $request->email;
                        $driver->driver_id = $driver_id;
                    
                        $driver->flag_changed_password = false;
                        $driver->password = $hasher->make($password);
                    
                        $filename = '';

                        if($request->hasFile('profile_pix')){
                            $profile_pix = $request->file('profile_pix');
                            $filename = time().uniqid(). '.' . $profile_pix->getClientOriginalExtension();
                           Image::make($profile_pix)->resize(300, 300)->save( storage_path('app/public/profiles/drivers/' . $filename ) );
                            //Image::make($profile_pix)->resize(300, 300)->save( public_path('/profiles/drivers/' . $filename ) );
                        }
                        $request->attributes->add(['email' => $request->email]);
                       // $request->attributes->add(['lastname' => $request->last_name]);
                        $driver->profile_pix = $filename;
                        $driver->save();

                        $data = ['email'=> $request->email,'password' => $password, 'lastname' =>$request->last_name, 'firstname'=>$request->first_name];

                        Mail::send('RegisterConfirmationEmail', $data, function($message){
                            $message->from ( 'donotreply@a2b.com', 'a2bTest' );
                            $message->to(app('request')->get('email'));
                            $message->subject('Registration Confirmation');
                        });
                        return json_encode([
                            'driver_details'=>[
                                            'status'=>200,
                                            'registered'=>true,
                                            'message'=> 'Registration Successsful! Check your mail to complete your registration',
                                            'driver_data'=>$driver,

                                            ]]);     
                    }catch(\Illuminate\Database\QueryException $ex){
                        return json_encode([
                           'error'=> [
                                            'status'=>500,
                                            'registered'=>false,
                                            'message'=>$ex->getMessage()
                                            ]]);  
                    } 
                    //Send email to the driver with the login details
                    //Mail::to($request->email)->send(new RegisterConfirmation());
            }

            /**
    * Authenticate a driver and return the token if the provided credentials are correct.
    *
    * @param \App\Driver $driver
    * @return mixed
    */
    public function authenticate(Driver $driver)
    {
        
        $validator = Validator::make($this->request->all(), 
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>[
                    'success' => false,
                    'status' =>400,
                    'message' => $validator->errors()->all()
                        ]]);
                }
            $driver = Driver::where('email', $this->request->input('email'))->first();
            if (!$driver) {
                return response()->json([
                'error' =>[
                    'message' => 'Email does not exist.',
                    'status' => 400
                    ]]);
            }
            if (Hash::check($this->request->input('password'), $driver->password)) {
                return response()->json([
                   'result'=> [
                       'success'=> true,
                       'message'=>'Successfully logged in',
                        'token' => $this->jwt($driver),
                        'status' => 200
                ]]);
                }
                return response()->json([
                    'error'=>[
                        'message' => 'Email or password is wrong.',
                        'status' => 400
                ]]);
    }
}
   

