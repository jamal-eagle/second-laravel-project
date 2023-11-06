<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Productcontroller;
use App\Models\Product;

class checkIdforDelet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     private  $allowedemails=[];
    
    public function handle(Request $request, Closure $next)
    {
      $user_id=$request->user()->id;
      $product =Product::where('id',$request->product_id)->first();
      if(!$product){
        return response()->json([ 'ststes'=>false,
        'message'=>' this product not found',
        'data'=>null], 401);
      }
      
      $product_id=$product->user_id;
      if($user_id!=$product_id)
      {
        return response()->json([ 'ststes'=>false,
        'message'=>'you cant delet or update this product',
        'data'=>null], 401);
      }

        return $next($request);
    }
}
