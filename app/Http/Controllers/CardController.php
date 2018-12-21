<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Card;
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
        $user = User::find($user_id);
        return $user_cards = $user->cards()->get();
        // $user_cards;

    }
}

   
