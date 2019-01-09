<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Models\Contact;
use Validator;

class ContactController extends Controller
{
    public function contactUs(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'full_name' => 'required',
        'email' => 'required',
        'phone_number' => 'required',
        'message' => 'required'
    ]);
        if ($validator->fails()) {
            return response()->json([
                'error'=>[
                    'success' => false,
                    'status' =>400,
                    'message' => $validator->errors()->all()
                        ]]);
            }
            try{
                
                $contact = new Contact();
                $contact->full_name = $request->full_name;
                $contact->email = $request->email;
                $contact->phone_number = $request->phone_number;
                $contact->message = $request->message;
                $contact->user_id= app('request')->get('authUser')->id;
                $contact->save();
                return json_encode([
                            'result'=> [
                                    'success'=> true,
                                    'status'=>200,
                                    'message'=> 'Message sent successfully',
                                      ]]);    
        
                
                }catch(\Illuminate\Database\QueryException $ex){
                return json_encode([
                    'status'=>500,
                    'registered'=>false,
                    'message'=>$ex->getMessage()
                    ]);  
            }
        }
}