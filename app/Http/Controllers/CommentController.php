<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponseController;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
class CommentController extends ResponseController
{


   public function create(Request $request,$product_id)
   {

    $validate=Validator::make($request->all(),
    [
      'comment'=>'required',
    ]);
    if($validate->fails())
    {
      return $this->responseError($validate->errors());
    }
    $product=Product::where('id',$product_id)->first();

    if(!$product)
    {
        return response()->json([ 'ststes'=>false,
        'message'=>' this product not found',
        'data'=>null], 401);
    }

   $comment=Comment::create([
    'comment'=>$request->comment,
    'user_id'=>$request->user()->id,
    'product_id'=>$product_id]);

    return $this->responseData($comment,'comment sccessfully created');
   }






   public function getcomments(Request $request,$product_id)
   {
       $product=Product::where('id',$product_id)->first();

       if(!$product)
      {
        return response()->json([ 'ststes'=>false,
        'message'=>' this product not found',
        'data'=>null], 401);
      }
      $comment= Comment::where('product_id',$product_id)->get();

      return $this->responseData($comment,'comments sccessfully fetched');
   }

}
