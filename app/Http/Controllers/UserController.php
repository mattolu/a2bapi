<?php
namespace App\Http\Controllers;
use App\User;
use App\User_subscription;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //
    }

    public function createNewUser(Request $request){

        $validator = Validator::make($request->all(),[
            'full_name' => 'required',
            'user_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            $response = array(  
                                'response'=>$validator->messages(), 
                                'success'=>false
                            );
            return $response;
        }else{

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
                    $token = JWTAuth::fromUser($user);
                    $user->save();

                 

                    //return response()->json(compact('user','token'),201);
                    return json_encode([
                                        'status'=>200,
                                        'registered'=>true,
                                        'user_data'=>$user,
                                        'token' => $token
                                       
                                        ]);     
                }catch(\Illuminate\Database\QueryException $ex){
                    return json_encode([
                        'status'=>500,
                        'registered'=>false,
                        'message'=>$ex->getMessage()
                        ]);  
                }
            }
        }
    //GEtting user that has been authenticated
        // public function getAuthenticatedUser()
        // {
        //         try {

        //                 if (! $user = JWTAuth::parseToken()->authenticate()) {
        //                         return response()->json(['user_not_found'], 404);
        //                 }

        //         } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

        //                 return response()->json(['token_expired'], $e->getStatusCode());

        //         } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

        //                 return response()->json(['token_invalid'], $e->getStatusCode());

        //         } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

        //                 return response()->json(['token_absent'], $e->getStatusCode());

        //         }

        //         return response()->json(compact('user'));
        // }
    public function updatePix(Request $request, $id){
        $user = User::find($id);
      
        $validator = Validator::make($request->all(),[
           
			'profile_pix' => 'required',
            'profile_pix.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          
        ]);

        if($validator->fails()){
            $response = array(  
                                'response'=>$validator->messages(), 
                                'success'=>false
                            );
            return $response;
        }else{
            if(($request->hasFile('profile_pix')&&($user))){
                $profile_pix = $request->file('profile_pix');
                $filename = time().uniqid(). '.' . $profile_pix->getClientOriginalExtension();
                $filepath = storage_path('public/uploads/profiles/users/' . $filename);
                Image::make($profile_pix)->resize(300, 300)->save( $filepath );

                $user->profile_pix = $filename;
                $user->save();
                return json_encode([
                    'status'=>200,
                    'uploaded'=>true,
                    'file_url'=>$filepath,
                   // 'bus_data' =>$bus
                    ]);     
            }else{
                return json_encode([
                    'status'=>false,
                    'uploaded'=>'Cannot upload, Try again with the correct user'
                    ]);  
            }
        }
    }


        //getting a single driver
        public function getProfile($id){

            $user = User::find($id);
            if ($user){
                return json_encode([
                    'status'=>true,
                    'user_detail'=>$user,
                    //'bus_detail' =>$driver->bus()->get()
                    ]);  
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'Cannot find driver and the bus'
                    ]);  
            }
        }

    //     public function createSubscription(Request $request, $id){
    //     $user = User::find($id);
    //     $validator = Validator::make($request->all(), [
    //             'tariff_plan' => 'required',
    //             //'start_date' => 'required',
    //             // 'end_date' => 'required',
    //             'amount' => 'required',
    //     ]);

    //     if($validator->fails()){
    //         $response = array(  
    //                             'response'=>$validator->messages(), 
    //                             'success'=>false
    //                         );
    //         return $response;
    //     }else{
              
    //             $user_subscription = new User_subscription();
    //             $user_subscription->tariff_plan = $request->tariff_plan;
    //             $user_subscription->start_date= Carbon::now();
    //             $user_subscription->end_date= Carbon::now()->addDays(30);
    //             $user_subscription->amount= $request->amount;
    //             $user_subscription->user_id= $request->user_id;
            
    //             $user_subscription->save();
               
    //         }
            

        
    //     if($user_subscription->save()){
    //         $user_subscription = response()->json(
    //             [
    //                 'response' => [
    //                     'posted' => true,
    //                     'message' => 'Subscription successful',
    //                     'status' => 200
    //                     ]
    //             ], 201);
    //     }else{
    //         $response = response()->json(
    //             [
    //                 'response' => [
    //                     'posted' => false,
    //                    //'reportId' => $report->id,
    //                     'customized_message' => 'Report not posted',
    //                     'status' => 401
    //                     ]
    //             ], 401);
    //     }
    //     return $response;
    // }
    
}
