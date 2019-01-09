<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    //
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        return response(["success"=> false , "message" => $errors],401);
    }

}
