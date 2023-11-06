<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller ;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
class ResponseController extends Controller
{
    public function responseError($messageError=[])
    {
      $response=[
          'ststes'=>false,
          'message'=>$messageError,
          'data'=>null,
      ];
      return response()->json($response, 401);
    }
    public function responseData($ruselt,$message)
    {
        $response=[
            'states'=>true,
            'message'=>$message,
            'data'=> $ruselt
        ];
        return response()->json($response, 200);

    }
}
