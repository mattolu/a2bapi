<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\User_subscription;
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
    public function createSubscription(Request $request, $id)
    {
        $user = new User();
        $validator = Validator::make($request->all(), [
                'tariff_plan' => 'required',
                //'start_date' => 'required',
                // 'end_date' => 'required',
                'amount' => 'required',
        ]);

        if($validator->fails()){
            $response = array(  
                                'response'=>$validator->messages(), 
                                'success'=>false
                            );
            return $response;
        }else{
              
                $user_subscription = new User_subscription();
                $user_subscription->tariff_plan = $request->tariff_plan;
                $user_subscription->start_date= Carbon::now();
                $user_subscription->end_date= Carbon::now()->addMonths($request->tariff_plan);
                $user_subscription->amount= $request->amount;
                $user_subscription->user_id= User::find($id)->id;
            
                $user_subscription->save();
               
            }
         
        
        if($user_subscription->save()){
            $response = response()->json(
                [
                    'subscription' => [
                        'posted' => true,
                        'status' => 200,
                        'message' => 'Subscription successful',
                        'tariff_plan_in_month'=> $user_subscription->tariff_plan,
                        'subscription_details' => $user_subscription
                        
                        ]
                ], 201);
                return $response;
        }else{
            $response = response()->json(
                [
                    'response' => [
                        'posted' => false,
                        'customized_message' => 'Subscription UNSUCCESSFUL',
                        'status' => 401
                        ]
                ], 401);
                return $response;
        }
        
    }
}

   
