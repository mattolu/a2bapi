<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_subscription;
use Firebase\JWT\JWT;
use Intervention\Image\Facades\Image;
use Validator;

class UserController extends  Controller{
  
    //     public function __construct()
    // {
    
    // }
 
    public function fetchUserDetails(){
        $user = app('request')->get('authUser');
        return json_encode([
            'result'=>[
                    'status'=>200,
                    'user_data'=>$user
                ]]);
        }
        
    public function updatePix(Request $request){
        $user_id = app('request')->get('authUser')->id;
        $user = User::find($user_id);
        $validator = Validator::make($request->all(),[
           
			'profile_pix' => 'required',
            'profile_pix.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          
        ]);

        if($validator->fails()){
            return response()->json([
                'error'=>[
                    'success' => false,
                    'status' =>400,
                    'message' => $validator->errors()->all()
                        ]]);
        }else{
            if(($request->hasFile('profile_pix'))){
                $profile_pix = $request->file('profile_pix');
                $filename = time().uniqid(). '.' . $profile_pix->getClientOriginalExtension();
                $filepath = storage_path('public/uploads/profiles/users/' . $filename);
                Image::make($profile_pix)->resize(300, 300)->save( $filepath );

                $user->profile_pix = $filename;
                $user->save();
                return json_encode([
                    'result'=>[
                            'status'=>200,
                            'uploaded'=>true,
                            'message'=>'Profile image uploaded successfully',
                            'file_url'=>$filepath,
                        // 'bus_data' =>$bus
                             ]]);     
            } else 
                {
                return json_encode([
                   'error' => [
                            'status'=>400,
                            'uploaded'=>false,
                            'message'=>'Cannot upload, Try again'
                            ]]);  
                }
        }
    }
}

       //Alternative way of getting User ig i decide notot use the middleware pasing the variable
        // public function getUser(Request $request)
        // {
        //     if (!$request->hasHeader('Authorization')){
        //         return response()->json([
        //             'data'=>'Authorization Header not found', 
        //             'status'=>401], 401);
        //     }
        //     $token = $request->bearerToken();
        //     $token = $request->get('token');
        //     $token = $request->header('Authorization');
        //     $token = substr($token, 7);
        //     if ($request->header('Authorization') == null || $token == null){
        //         return  reponse()->json([
        //             'data'=>'No token provided', 
        //             'status'=>401], 401);
        //     }

        //     if (!$token) {
        //     return response()->json([
        //         'error' => 'Token not provided.'
        //         ], 401);
        //     }
            
        //     try {
        //         $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS512']);
        //         }catch (ExpiredException $e) {
        //             return response()->json([
        //             'error' => 'Provided token is expired.'
        //             ], 400);
        //         } catch (\Exception $e) {
        //             return response()->json([
        //             'error' => 'Error while decoding'
        //             ], 400);
        //         }
            
        //         $user =User::find($credentials->sub);
        //         return $user;
        //         // return json_encode([
        //         //     'status'=>200,
        //         //     'user_data'=>$user
        //         // ], 200);
        // }
    

