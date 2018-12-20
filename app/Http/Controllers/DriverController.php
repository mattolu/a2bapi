<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Modles\Driver;
use App\Models\Bus;
use Firebase\JWT\JWT;
use Intervention\Image\Facades\Image;
use Validator;

class DriverController extends Controller{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct(){
       
    // }
    
    public function updatePix(Request $request)
    {
        $driver_id = app('request')->get('authDriver')->id;
        $driver = Driver::find($driver_id);
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
            if($request->hasFile('profile_pix')){
                $profile_pix = $request->file('profile_pix');
                $filename = time().uniqid(). '.' . $profile_pix->getClientOriginalExtension();
                $filepath = storage_path('public/uploads/profiles/drivers/' . $filename);
                Image::make($profile_pix)->resize(300, 300)->save( $filepath );

                $driver->profile_pix = $filename;
                $driver->save();
                return json_encode([
                    'result'=>[
                        'status'=>200,
                        'uploaded'=>true,
                        'message'=>'Profile image uploaded successfully',
                        'file_url'=>$filepath,
                    // 'bus_data' =>$bus
                         ]]);  
                       
            }else{
                return json_encode([
                    'error' => [
                        'status'=>400,
                        'uploaded'=>false,
                        'message'=>'Cannot upload, Try again'
                        ]]);  
            }
        }
    }


    public function fetchDriverDetails(){
        $driver = app('request')->get('authDriver');
        return json_encode([
                    'status'=>200,
                    'user_data'=>$driver
                ], 200);
        }
     public function edit($id){
        echo 'edit';
     }
     public function update(Request $request, $id){
        echo 'update';
     }
     public function destroy($id){
        echo 'destroy';
     }
    //  public function getDrivers(){
    //     $driver = Driver::all();
    //     if ($driver){
    //         return json_encode([
    //             'status'=>true,
    //             'message'=>$driver,
    //             'bus_detail' =>$driver->bus()->get()
    //             ]);  
    //     }else{
    //         return json_encode([
    //             'status'=>false,
    //             'message'=>'Cannot find driver'
    //             ]);  
    //     }
    // }
}
