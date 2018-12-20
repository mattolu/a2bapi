<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Bus;
use App\Models\Driver;

class BusController extends Controller
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
    public function createNewBus(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bus_product_name' => 'required',
            'bus_plate_no' => 'required',
            //'driver_id' => 'required'
        ]);

        if($validator->fails()){
            $response = array(  
                                'response'=>$validator->messages(), 
                                'success'=>false
                            );
            return $response;
        }else
        
        $bus = new Bus();
        $bus->bus_product_name = $request->bus_product_name;
        $bus->bus_plate_no= $request->bus_plate_no;
        $bus->driver_id= Driver::find($id)->id;
        $bus->save();
        
        if($bus->save()){
            $response = response()->json(
                [
                    'response' => [
                        'posted' => true,
                        'message'=> 'Bus has been assigned successfully',
                        'status' => 200

                        ]
                ], 201);
        }else{
            $response = response()->json(
                [
                    'response' => [
                        'posted' => false,
                        'error'=> 'Bus not assigned',
                        'status' => 401
                        ]
                ], 401);
        }
        return $response;
    }   
}