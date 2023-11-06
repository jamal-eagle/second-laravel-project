<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class RegisterController extends ResponseController
{


    public function register(Request $request)
    {

       $validate=Validator::make($request->all(),['email'=>'required|string|email|unique:users',
                                    'name'=>'required|min:2|max:100',
                                    'password'=>'required|min:8|max:100',
                                    'conf_password'=>'required|same:password'
                                    ]);
       if($validate->fails())
                              {
                                return $this->responseError($validate->errors());
                              }

      User::create(['name'=>$request->get('name'),
                    'email'=>$request->get('email'),
                    'password'=>Hash::make($request->get('password')),
                    'conf_password'=>Hash::make($request->get('conf_password')),]);

                  $user=User::first();
                  $token = JWTAuth::fromUser($user);
                  return $this->responseData($token,'Registeration sccessful');
    }

}
