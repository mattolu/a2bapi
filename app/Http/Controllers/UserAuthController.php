<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Validator;
//use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Driver;
use Laravel\Lumen\Routing\Controller as BaseController;


class UserAuthController extends BaseController
{
        /**
    * The request instance.
    *
    * @var \Illuminate\Http\Request
    */
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
    * @param \App\User $user
    * @return string
    */
    protected function jwt(User $user){
        $payload = [
                    'iss' => 'lumen-jwt', // Issuer of the token
                    'sub' => $user->id, // Subject of the token
                    'iat' => time(), // Time when JWT was issued.
                    'exp' => time() + 3600*3600 // Expiration time
                ];
        return JWT::encode($payload, env('JWT_SECRET'), 'HS512');
    }
    /**
    * Authenticate a user and return the token if the provided credentials are correct.
    *
    * @param \App\User $user
    * @return mixed
    */

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
        'full_name' => 'required',
        'user_name' => 'required',
        'email' => 'required|email|unique:users',
        'phone_number' => 'required',
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
            try{

                $hasher = app()->make('hash');

                $user = new User();
                $user->full_name = $request->full_name;
                $user->user_name = $request->user_name;
                $user->email = $request->email;
                $user->phone_number = $request->phone_number;
                $user->password = $hasher->make($request->password);
                $filename = '';

                if($request->hasFile('profile_pix')){
                    $profile_pix = $request->file('profile_pix');
                    $filename = time().uniqid(). '.' . $profile_pix->getClientOriginalExtension();
                    Image::make($profile_pix)->resize(300, 300)->save(  storage_path('public/uploads/profiles/users/' . $filename ) );
                }
                    
                $user->profile_pix = $filename;
                $user->save();
                //unset($user->password);
                return json_encode([
                            'result'=> [
                                    'success'=> true,
                                    'status'=>200,
                                    'message'=> 'Registration successful',
                                    'user_data'=>$user,
                                    'token' => $this->jwt($user)
                                ]]);    
        
                
                }catch(\Illuminate\Database\QueryException $ex){
                return json_encode([
                    'status'=>500,
                    'registered'=>false,
                    'message'=>$ex->getMessage()
                    ]);  
            }
        }
    
    public function authenticate(User $user)
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
            $user = User::where('email', $this->request->input('email'))->first();
            if (!$user) {
                return response()->json([
                    'error' =>[
                        'message' => 'Email does not exist.',
                        'status' => 400
                        ]]);
            }
            if (Hash::check($this->request->input('password'), $user->password)) {
                return response()->json([
                    'result'=> [
                        'success'=> true,
                        'message'=>'Successfully logged in',
                         'token' => $this->jwt($user),
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
