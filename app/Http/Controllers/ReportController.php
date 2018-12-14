<?php
namespace App\Http\Controllers;
use App\Driver;
use Illuminate\Http\Request;
use App\Report;
use App\ReportsImage;
use Intervention\Image\Facades\Image;
use Validator;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function createNewDriverReport(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
                'accident_address' => 'required',
                'accident_report' => 'required',
                //'driver_id' => 'required',
                 'image_path' => 'array',
                'image_path.*'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8192'
        ]);

        if($validator->fails()){
            $response = array(  
                                'response'=>$validator->messages(), 
                                'success'=>false
                            );
            return $response;
        }else{
                $data= array ();
                $report = new Report();
                $report->accident_address = $request->accident_address;
                $report->accident_report= $request->accident_report;
                $report->driver_id= Driver::find($id)->id;
                

                if ($request-> hasFile('image_path')){
                $images = $request -> file('image_path');
                    foreach($images as $image){
                        $filename = time().uniqid(). '.' . $image->getClientOriginalExtension();
                        $filepath = storage_path('public/uploads/reports/drivers' . $filename);
                        Image::make($image)->resize(500, 500)->save( $filepath );
                    array_push($data, $filename);
                    }
                $path = implode (',', $data);
                $report->image_path = $path;
                $report->save();
               
            }
            

        
        if($report->save()){
            $response = response()->json(
                [
                    'response' => [
                        'posted' => true,
                       
                        'customized_message' => 'The rescue team is on their way',
                        'status' => 200

                        ]
                ], 201);
        }else{
            $response = response()->json(
                [
                    'response' => [
                        'posted' => false,
                       //'reportId' => $report->id,
                        'customized_message' => 'Report not posted',
                        'status' => 401
                        ]
                ], 401);
        }
        return $response;
    }
    }

/**
 * Getting the report of the driver
 */
    // public function getDriverReports($id)
    // {
    //     $driverReport = Driver::find($id)->reports()->get();
    //     return ($driverReport);   
    // }

    public function createNewUserReport(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
                'accident_address' => 'required',
                'accident_report' => 'required',
                //'user_id' => 'required',
                 'image_path' => 'array',
                'image_path.*'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8192'
        ]);

        if($validator->fails()){
            $response = array(  
                                'response'=>$validator->messages(), 
                                'success'=>false
                            );
            return $response;
        }else{
                $data= array ();
                $report = new Report();
                $report->accident_address = $request->accident_address;
                $report->accident_report= $request->accident_report;
                $report->driver_id= User::find($id)->id;
                
                if ($request-> hasFile('image_path')){
                $images = $request -> file('image_path');
                    foreach($images as $image){
                        $filename = time().uniqid(). '.' . $image->getClientOriginalExtension();
                        $filepath = storage_path('public/uploads/reports/users' . $filename);
                        Image::make($image)->resize(500, 500)->save( $filepath );
                    array_push($data, $filename);
                    }
                $path = implode (',', $data);
                $report->image_path = $path;
                $report->save();
               
            }
            

        
        if($report->save()){
            $response = response()->json(
                [
                    'response' => [
                        'posted' => true,
                        'customized_message' => 'The rescue team is on their way',
                        'status' => 200

                        ]
                ], 201);
        }else{
            $response = response()->json(
                [
                    'response' => [
                        'posted' => false,
                        'customized_message' => 'Report not posted',
                        'status' => 401
                        ]
                ], 401);
        }
        return $response;
    }
    }
/**
 * Getting the report of the user
 */
    // public function getUserReports($id)
    // {
    //     $userReport = User::find($id)->reports()->get();
    //     return ($userReport);   
    // }









    //Backup for the image Uploads
    // public function uploadimages(Request $request){

    //     if ($request->hasFile('cnicFrontUrl')) {
    //         $picName = $request->file('cnicFrontUrl')->getClientOriginalName();
    //         $picName = base_path() . uniqid() . $picName;
    //         $destinationPath = "driveReport/";
    //         $request->file('cnicFrontUrl')->move($destinationPath, $picName);
    //         $userDetails->cnicFrontUrl = asset($destinationPath. "/" . uniqid() . 
    //         $request->file('cnicFrontUrl')
    //                 ->getClientOriginalName());
    //     }
        

        // $files = $request->allFiles('image');   
        // $files->store('public/uploads');    
    //     $count = 0;       
    //     foreach ($files as $file) {
    //         $file->store('public/uploads');
    //         $count++;
    //    }
       //$count return only 1(it only upload one file)
    //    return response()->json(['uploaded'=> true],201);
    
    // }
}