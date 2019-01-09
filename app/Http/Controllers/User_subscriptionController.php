<?php
namespace App\Http\Controllers;

use App\Models\User_subscription;
use App\Models\Card;
use Illuminate\Http\Request;
use App\Models\User;
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
    // public function createSubscription(Request $request)
    // {
    //    // $user = new User();
    //     $validator = Validator::make($request->all(), [
    //             'tariff_plan' => 'required',
    //             'amount' => 'required',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json([
    //             'error'=>[
    //                 'success' => false,
    //                 'status' =>400,
    //                 'message' => $validator->errors()->all()
    //                     ]]);
    //     }else{
              
    //             $user_subscription = new User_subscription();
    //             $user_subscription->tariff_plan = $request->tariff_plan;
    //             $user_subscription->start_date= Carbon::now();
    //             $user_subscription->end_date= Carbon::now()->addMonths($request->tariff_plan);
    //             $user_subscription->amount= $request->amount;
    //             $user_subscription->user_id= app('request')->get('authUser')->id;
            
    //             $user_subscription->save();
               
    //         }
         
        
    //     if($user_subscription->save()){
    //         return $response = response()->json(
    //             [
    //                 'subscription' => [
    //                     'success' => true,
    //                     'status' => 200,
    //                     'message' => 'Subscription successful',
    //                     'tariff_plan_in_month'=> $user_subscription->tariff_plan,
    //                     'subscription_details' => $user_subscription
                 
    //                     ]
    //             ]);
             
    //     }else{
    //       return  $response = response()->json(
    //             [
    //                 'errors' => [
    //                     'sucess' => false,
    //                     'message' => 'Subscription UNSUCCESSFUL',
    //                     'status' => 401
    //                     ]
    //             ]);
                
    //     }
        
    // }


    public function createSubscription(Request $request)
    {
        $user_id = app('request')->get('authUser')->id;

        $validator = Validator::make($request->all(), [
           
            'tariff_plan' => 'required',
            'amount' => 'required',
            'card_number'=> 'required'
    ]);

    if($validator->fails()){
        $response = array(  
                            'response'=>$validator->messages(), 
                            'success'=>false
                        );
        return $response;
    }else{  
        try{
          
                $user_subscription = new User_subscription();
                $user_subscription->tariff_plan = $request->tariff_plan;
                $user_subscription->start_date= Carbon::now();
                $user_subscription->end_date= Carbon::now()->addMonths($request->tariff_plan);
                $user_subscription->amount= $request->amount;
                $user_subscription->user_id= app('request')->get('authUser')->id;
                $user_subscription->card_id = Card::where('card_number', $request->card_number)->first()->id;
               
            
                $user_subscription->save();

                if($user_subscription->save()){
                    return $reponse = response()->json([
                             'sub_status' => [
                                 'posted' => true,
                                 'status' => 200,
                                 'message' => 'Subscription details saved successfully'    
                                             ]
                                                     ]);
                             }
                        
            
            }  catch(\Illuminate\Database\QueryException $ex){
                    return json_encode([
                        'status'=>500,
                        'posted'=>false,
                        'message'=>$ex->getMessage()
                        ]);  
                }
        }
    }

    public function getSubscription()
    {
        $user_id = app('request')->get('authUser')->id;
            try {

                $user = User::find($user_id);
                     
                $user_sub = $user->user_subscriptions()->orderBy('id', 'desc')->first();
                $card_id = $user_sub->card_id;
             
               return json_encode([
               'user_sub'=>[
                       'status'=>200,
                       'sub'=>$user_sub,
                       'card' =>  Card::where('id', $card_id)->get()
                   ]]);
          
           } catch ( Exception $e){
                   return json_encode([
                       'error'=>[
                           'status'=> 401,
                           'message'=> 'User does not exist'
                       ]]);
               }
    }

    public function getSubscriptionAll(){
       
        $user_id = app('request')->get('authUser')->id;
        try {

            $user = User::find($user_id);
            
           $user_sub = $user->user_subscriptions()->get();
           if ( count($user_sub) !=0  ){
           return json_encode([
           'user_sub'=>[
                   'status'=>200,
                   'sub'=>$user_sub
               ]]);
           } else{
               return json_encode([
                   'error'=>[
                       'status'=> 401,
                       'message'=> 'No Subscription history'
                   ]]);
           }
       } catch ( Exception $e){
               return json_encode([
                   'error'=>[
                       'status'=> 401,
                       'message'=> 'User does not exist'
                   ]]);
           }
    }
}

   
