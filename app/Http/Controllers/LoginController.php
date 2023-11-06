<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends ResponseController
{
  public function __construct()
  {
    $this->middleware('check_token:api')->except('login');
  }
    public function login(Request $request)
    {
       $validate=Validator::make($request->all(),
                   [
                   'email'=>'required|string|email|max:255',
                   'password'=>'required|min:8|'
                   ]);

       if($validate->fails()){
                               return $this->responseError($validate->errors());
                             }

       $credate=$request->only('email','password');
                 if (!auth()->validate($credate) )
                      {
                        return $this->responseError('email or password invalid');
                      }
                     $user =User::where('email',$request->email)->first();
                   $token = JWTAuth::fromUser($user);
                   return $this->responseData($token,'login sccessful');
    }



    public function logout()
    {
      $logout=auth()->logout();
      return $this->responseData(null,'logout sccessful');

    }
}
