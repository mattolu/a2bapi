<?php
namespace App\Http\Controllers;
use App\Driver;
use App\Bus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\Facades\Image;

class DriverController extends Controller{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //
    }

    // public function index(){
    //     $driver = driver::all();
    //     return response()->json($driver);
    //  }

    

     public function createNewDriver(Request $request){

        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_no' => 'required',
            'address' => 'required',
            //'email' => 'required|email|unique:Drivers',
            'email' => 'required|email|unique:drivers',
			//  'profile_pix' => 'required',
            // 'profile_pix.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           // 'bus_product_name'=> 'required', 
            //'driver_id'=> 'required',
           // 'bus_plate_no' => 'required'
        ]);



        if($validator->fails()){
            $response = array(  
                                'response'=>$validator->messages(), 
                                'success'=>false
                            );
            return $response;
        }else{

            function unique_link($length=10, $characters) {
                $string = '';
                for ($p = 0; $p < $length; $p++) {
                    $string .= $characters[mt_rand(0, strlen($characters)-1)];
                }
            
                return $string;
            }

            $characters = "23456789ABCDEFHJKLMNPRTVWXYZ";
            $ref = unique_link(6, $characters);
            $driver_id = "A2B-".$ref; // driver's id generated
            $characters_10 = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";
            // Defining characters for the driver's password.
            $password = unique_link(10, $characters_10); // driver's password generated
            var_dump($password);

               
                }
                try{

                    $hasher = app()->make('hash');

                    $register = new Driver();
                    $register->first_name = $request->first_name;
                    $register->last_name = $request->last_name;
                    $register->phone_no = $request->phone_no;
                    $register->address = $request->address;
                    $register->email = $request->email;
                    $register->driver_id = $driver_id;
                  
                    $register->flag_changed_password = false;
                    $register->password = $hasher->make($password);
                    // $post->user_id = auth()->user()->id;
                    // $img_path = '';
                    // if ($request->hasfile('profile_pix')) {

                    //     $image = $request->file('profile_pix');
    
                    //     $name = $image->getClientOriginalName();
                    //     $_name = time().uniqid().".".$image->getClientOriginalExtension();
                      
                    //     $image->move( storage_path('/public/driver_img/', $_name));
                    //     $img_path = '/driver_img/' . $_name;
                    // }

                    $filename = '';

                    if($request->hasFile('profile_pix')){
                        $profile_pix = $request->file('profile_pix');
                        $filename = time().uniqid(). '.' . $profile_pix->getClientOriginalExtension();
                        Image::make($profile_pix)->resize(300, 300)->save(  storage_path('public/uploads/profiles/drivers/' . $filename ) );
                    }
                        
                    $register->profile_pix = $filename;
                    $register->save();

                    // $bus = new Bus();
                    // $bus->bus_product_name = $request ->bus_product_name;
                    // $bus->bus_plate_no = $request->bus_plate_no;
                    // $bus->driver_id = $register->id;
                    // $bus->save();

                    //TODO- Adding mail feature after registration
                                //          $subject = "Please verify your email address.";
                                //         Mail::send('email.verify', ['driver_id' => $driver_id, 'password' => $password],
                                // function($mail) use ($email, $name, $subject){
                                //     $mail->from(getenv('FROM_EMAIL_ADDRESS'), "a2b by iVOThinking");
                                //     $mail->to($email, $first_name);
                                //     $mail->subject($subject);
                                // });

                    return json_encode([
                                        'status'=>200,
                                        'registered'=>true,
                                       // 'message'=> 'Thanks for signing up! Please check your email to complete your registration.',
                                        'driver_data'=>$register,
                                       // 'bus_data' =>$bus
                                        ]);     
                }catch(\Illuminate\Database\QueryException $ex){
                    return json_encode([
                        'status'=>500,
                        'registered'=>false,
                        'message'=>$ex->getMessage()
                        ]);  
                }
        }
    

    public function getDrivers(){
        $driver = Driver::all();
        if ($driver){
            return json_encode([
                'status'=>true,
                'message'=>$driver,
                'bus_detail' =>$driver->bus()->get()
                ]);  
        }else{
            return json_encode([
                'status'=>false,
                'message'=>'Cannot find driver'
                ]);  
        }
    }

    public function updatePix(Request $request, $id){
        $driver = Driver::find($id);
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
            if($request->hasFile('profile_pix')){
                $profile_pix = $request->file('profile_pix');
                $filename = time().uniqid(). '.' . $profile_pix->getClientOriginalExtension();
                $filepath = storage_path('public/uploads/profiles/drivers/' . $filename);
                Image::make($profile_pix)->resize(300, 300)->save( $filepath );

                $driver->profile_pix = $filename;
                $driver->save();
                return json_encode([
                    'status'=>200,
                    'uploaded'=>true,
                    'file_url'=>$filepath,
                   // 'bus_data' =>$bus
                    ]);     
            }else{
                return json_encode([
                    'status'=>false,
                    'uploaded'=>'Cannot upload, Try again'
                    ]);  
            }
        }
    }


        //getting a single driver
        public function getProfile($id){

            $driver = Driver::find($id);
            if ($driver){
                return json_encode([
                    'status'=>true,
                    'driver_detail'=>$driver,
                    //'bus_detail' =>$driver->bus()->get()
                    ]);  
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'Cannot find driver and the bus'
                    ]);  
            }
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
}
