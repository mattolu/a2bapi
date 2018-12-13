<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Card;
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


    public function createCard(Request $request, $id)
    {
        
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
              
                $card = new Card();
                $card->card_number = $request->card_number;
                $card->card_holder_name= $request->card_holder_name;
                $card->expiry_month= $request->expiry_month;
                $card->expiry_year= $request->expiry_year;
                $card->cvv= $request->cvv;
                $card->user_id= User::find($id)->id;
            
                $card->save();
               
            }
         
        
        if($card->save()){
           return $reponse = response()->json(
                [
                    'card_status' => [
                        'posted' => true,
                        'status' => 200,
                        'message' => 'Saved successfully',
                        
                        ]
                ], 201);
                
        }else{
          return  $response = response()->json(
                [
                    'response' => [
                        'posted' => false,
                        'message' => 'UNSUCCESSFUL',
                        'status' => 401
                        ]
                ], 401);
          
        }
        
    }

    public function getCards($id){
        $user_cards = User::find($id)->cards()->get();
        return $user_cards;

    }
}

   
