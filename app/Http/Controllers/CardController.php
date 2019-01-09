<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Card;
use App\Models\User_subscription;
use Validator;

class CardController extends Controller
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


    public function createCard(Request $request)
    {
        $user_id = app('request')->get('authUser')->id;
        //$user = User::find($user_id);
        $validator = Validator::make($request->all(), [
                'card_number' => 'required|unique:cards',
                'card_holder_name' => 'required',
                'expiry_month' => 'required',
                'expiry_year' => 'required',
                'cvv' => 'required',
               
        ]);

        if($validator->fails()){
            $response = array(  
                                'response'=>$validator->messages(), 
                                'success'=>false
                            );
            return $response;
        }else{  
            
              try{
                $card = new Card();
                $card->card_number = $request->card_number;
                $card->card_holder_name= $request->card_holder_name;
                $card->expiry_month= $request->expiry_month;
                $card->expiry_year= $request->expiry_year;
                $card->cvv= $request->cvv;
                $card->user_id= $user_id;
            
                $card->save();
        
                if($card->save()){
                return $reponse = response()->json([
                            'card_status' => [
                                'posted' => true,
                                'status' => 200,
                                'message' => 'Card details saved successfully'    
                                            ]
                                                    ]);
                            }
                 }catch(\Illuminate\Database\QueryException $ex){
                    return json_encode([
                        'status'=>500,
                        'registered'=>false,
                        'message'=>$ex->getMessage()
                        ]);  
                }
            }   
        // }else{
        //   return  $response = response()->json([
        //             'response' => [
        //                 'posted' => false,
        //                 'error' => 'Card not saved',
        //                 'status' => 401
        //                         ]
        //                                      ]);
          
        // }
        
    }

    public function getCards(){
        $user_id = app('request')->get('authUser')->id;
        // $user_cards;
        try {

            $user = User::find($user_id);
            $user_cards = $user->cards()->get();
           if ( count($user_cards) !=0  ){
           return json_encode([
           'user_card'=>[
                   'status'=>200,
                   'card'=>$user_cards
               ]]);
           } else{
               return json_encode([
                   'error'=>[
                       'status'=> 401,
                       'message'=> 'No card history'
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

    public function subscription_card(){
        $user_id = app('request')->get('authUser')->id;

        $validator = Validator::make($request->all(), [
           
            'tariff_plan' => 'required',
            'amount' => 'required',
            'card_no'=> 'required'
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

                $card_details = Card::find($request->card_no);
                $user_subscription->card_id = $card_details->id;
            
                $user_subscription->save();
            
            }  catch(\Illuminate\Database\QueryException $ex){
                    return json_encode([
                        'status'=>500,
                        'registered'=>false,
                        'message'=>$ex->getMessage()
                        ]);  
                }
        }
    }
}

   
