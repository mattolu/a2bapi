<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Driver;
use App\Models\User;
use App\Models\Report;
use App\Models\ReportsImage;
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
    public function createNewDriverReport(Request $request)
    {

        $validator = Validator::make($request->all(), [
                'accident_address' => 'required',
                'accident_report' => 'required',
                 'image_path' => 'array',
                'image_path.*'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8192'
        ]);

        if($validator->fails()){
            return response()->json([
                'error'=>[
                    'success' => false,
                    'status' =>400,
                    'message' => $validator->errors()->all()
                        ]]);
            }else{
                    $data= array ();
                    $report = new Report();
                    $report->accident_address = $request->accident_address;
                    $report->accident_report= $request->accident_report;
                    $report->driver_id=  app('request')->get('authDriver')->id;
                    

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
                        'result' => [
                            'success' => true,
                            'message' => 'The rescue team is on their way',
                            'status' => 200
                            ]
                    ]);
            }else{
                $response = response()->json(
                    [
                        'error' => [
                            'success' => false,
                            'message' => 'Report not posted',
                            'status' => 401
                            ]
                    ]);
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

    public function createNewUserReport(Request $request)
    {

        $validator = Validator::make($request->all(), [
                'accident_address' => 'required',
                'accident_report' => 'required',
                 'image_path' => 'array',
                'image_path.*'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8192'
        ]);

        if($validator->fails()){
            return response()->json([
                'error'=>[
                    'success' => false,
                    'status' =>400,
                    'message' => $validator->errors()->all()
                        ]]);
        }else{
                $data= array ();
                $report = new Report();
                $report->accident_address = $request->accident_address;
                $report->accident_report= $request->accident_report;
                $report->driver_id = app('request')->get('authUser')->id;
                
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
                        'result' => [
                            'success' => true,
                            'message' => 'The rescue team is on their way',
                            'status' => 200
                            ]
                    ]);
            }else{
                $response = response()->json(
                    [
                        'error' => [
                            'success' => false,
                            'message' => 'Report not posted',
                            'status' => 401
                            ]
                    ]);
            }
            return $response;
    }
    }










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