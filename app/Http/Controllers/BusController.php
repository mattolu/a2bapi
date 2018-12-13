<?php
namespace App\Http\Controllers;
use App\Driver;
use Illuminate\Http\Request;
use App\Bus;

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
    public function createNewBus(Request $request, $id)
    {
        $response = $this->validate($request, [
                'bus_product_name' => 'required',
                'bus_plate_no' => 'required',
               // 'driver_id' => 'required'
        ]
        );
        
        $bus = new Bus();
        $bus->bus_product_name = $request->bus_product_name;
        $bus->bus_plate_no= $request->bus_plate_no;
        $bus->driver_id= Driver::find($id)->id;
        $bus->save();
        
        if($report->save()){
            $response = response()->json(
                [
                    'response' => [
                        'posted' => true,
                     
                        'status' => 200

                        ]
                ], 201);
        }else{
            $response = response()->json(
                [
                    'response' => [
                        'posted' => false,
                       
                        'status' => 401
                        ]
                ], 401);
        }
        return $response;
    }

   
}