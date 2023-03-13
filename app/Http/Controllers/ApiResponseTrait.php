<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiResponseTrait extends Controller
{
    public function apiResponse($data= null,$message = null,$status = null){

        $array = [
            'data'=>$data,
            'message'=>$message,
            'status'=>$status,
        ];
 
        return response($array,$status);
 
    }
}
