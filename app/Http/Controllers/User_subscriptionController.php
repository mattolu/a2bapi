<?php
namespace App\Http\Controllers;

use App\Models\User_subscription;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Driver;
use Validator;
use Carbon\Carbon;

class User_subscriptionController extends Controller
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
    public function createSubscription(Request $request)
    {
        $user = new User();
        $validator = Validator::make($request->all(), [
                'tariff_plan' => 'required',
                'amount' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'error'=>[
                    'success' => false,
                    'status' =>400,
                    'message' => $validator->errors()->all()
                        ]]);
        }else{
              
                $user_subscription = new User_subscription();
                $user_subscription->tariff_plan = $request->tariff_plan;
                $user_subscription->start_date= Carbon::now();
                $user_subscription->end_date= Carbon::now()->addMonths($request->tariff_plan);
                $user_subscription->amount= $request->amount;
                $user_subscription->user_id= app('request')->get('authUser')->id;
            
                $user_subscription->save();
               
            }
         
        
        if($user_subscription->save()){
            return $response = response()->json(
                [
                    'subscription' => [
                        'success' => true,
                        'status' => 200,
                        'message' => 'Subscription successful',
                        'tariff_plan_in_month'=> $user_subscription->tariff_plan,
                        'subscription_details' => $user_subscription
                 
                        ]
                ]);
             
        }else{
          return  $response = response()->json(
                [
                    'errors' => [
                        'sucess' => false,
                        'message' => 'Subscription UNSUCCESSFUL',
                        'status' => 401
                        ]
                ]);
                
        }
        
    }
}

   
