<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOriginLocation;
use App\Models\UserDestinationLocation;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class UserLocationController extends Controller{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function createOrigin(Request $request)
    {
        $response = $this->validate($request, [
                'origin' => 'required',
        ]
        );
            try{
                $origin = new UserOriginLocation();
                $origin->origin = $request->origin;
                $origin->user_id= app('request')->get('authUser')->id;
                $origin->save();
                
                if($origin->save()){
                    return $response = response()->json(
                        [
                                'success' => true,
                                'status' => 200,
                                'message' => 'Location saved',
                                'origin' => $origin
                                
                        ]);
                }
            } catch(\Illuminate\Database\QueryException $ex){
                return json_encode([
                    'status'=>500,
                    'success' => false,
                    
                    'message'=>$ex->getMessage()
                    ]);
                }
            
    }

    public function getOrigin(){
       
        $user_id = app('request')->get('authUser')->id;
        try {

             $user = User::find($user_id);
             
            $user_origin_loc = $user->UserOriginLocations()->orderBy('id', 'desc')->get();
            if ( count($user_origin_loc) !=0  ){
            return json_encode([
            'user_origin'=>[
                    'status'=>200,
                    'location'=>$user_origin_loc
                ]]);
            } else{
                return json_encode([
                    'error'=>[
                        'status'=> 401,
                        'message'=> 'No origin history'
                    ]]);
            }
        } catch(\Illuminate\Database\QueryException $ex){
            return json_encode([
                'status'=>500,
                'success' => false,
                
                'message'=>$ex->getMessage()
                ]);
            }
    
    }

    public function createDestination(Request $request)
    {
        $response = $this->validate($request, [
                'destination' => 'required',
        ]
        );
            try{
                $destination = new UserDestinationLocation();
                $destination->destination = $request->destination;
                $destination->user_id= app('request')->get('authUser')->id;
                $destination->save();
                
                if($destination->save()){
                    return $response = response()->json(
                        [
                                'success' => true,
                                'status' => 200,
                                'message' => 'Location saved',
                                'destination' => $destination
                                
                        ]);
                }
             } catch(\Illuminate\Database\QueryException $ex){
                return json_encode([
                    'status'=>500,
                    'success' => false,
                    'message' => 'Location not saved',
                    'message'=>$ex->getMessage()
                    ]);
                }
    }

    public function getDestination(){
       
        $user_id = app('request')->get('authUser')->id;
        try {

             $user = User::find($user_id);
             
            $user_destination_loc = $user->UserDestinationLocations()->orderBy('id', 'desc')->get();
            if ( count($user_destination_loc) !=0  ){
                return json_encode([
                    'user_location'=>[
                            'status'=>200,
                            'location'=>$user_destination_loc
                        ]]);
            } else{
                return json_encode([
                    'error'=>[
                        'status'=> 401,
                        'message'=> 'No Destination history'
                    ]]);
            }
        } catch ( Exception $e){
                return json_encode([
                    'error'=>[
                        'status'=> 401,
                        'message'=> 'User does not exist'
                    ]]);
            }
    
    }

}