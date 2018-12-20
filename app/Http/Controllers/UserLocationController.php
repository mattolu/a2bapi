<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Firebase\JWT\JWT;


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
    public function createLocation(Request $request, $id)
    {
        $response = $this->validate($request, [
                'from' => 'required',
                'to' => 'required',
             
        ]
        );
        
        $location = new UserLocation();
        $location->from = $request->from;
        $location->to= $request->to;
        $location->user_id= app('request')->get('authUser')->id;
        $location->save();
        
        if($report->save()){
            $response = response()->json(
                [
                    'result' => [
                        'success' => true,
                        'message' => 'Location saved',
                        'status' => 200
                        ]
                ]);
        }else{
            $response = response()->json(
                [
                    'error' => [
                        'success' => false,
                        'message' => 'Location not saved',
                        'status' => 401
                        ]
                ]);
        }
        return $response;
    }
}