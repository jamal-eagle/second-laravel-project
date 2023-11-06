<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\Console\Helper\FormatterHelper;
use App\Models\Category;
use App\Models\Like;
use App\Models\View;
class Productcontroller extends ResponseController
{
  public function __construct()
     {
         $this->middleware('check_token:api');
     }


public function creatproduct(Request $request)
    {
        $validate=Validator::make($request->all(),
        [
          'name'=>'required|min:2',
          'price'=>'required|numeric',
          'expiry_date'=>'required|date',
          'quantity'=>'required|integer',
          'image'=>'required',
          'contact_info'=>'required',
          'category'=>'required',
          'discount_1'=>'required',
          'date_1'=>'required|date',
          'discount_2'=>'required',
          'date_2'=>'required|date',
          'discount_3'=>'required',
          'date_3'=>'required|date',
        ]);
       if($validate->fails())
        {
          return $this->responseError($validate->errors());
        }

        if($request->expiry_date < today())
        {
          return $this->responseError('invalid expiry date');
        }
       $data= Product::create([
          'name'=>$request->name,
          'price'=>$request->price,
          'expiry_date'=>$request->expiry_date,
          'quantity'=>$request->quantity,
          'image'=>$request->image,
          'category'=>$request->category,
          'contact_info'=>$request->contact_info,
          'user_id'=>$request->user()->id,
          'category'=>$request->category,
          'discount_1'=>$request->discount_1,
          'date_1'=>$request->date_1,
          'discount_2'=>$request->discount_2,
          'date_2'=>$request->date_2,
          'discount_3'=>$request->discount_3,
          ]);
        //   $data->save();

       return $this->responseData($data,'product has been add successfully');
    }


    public function deletproduct(Request $request)
    {
         $product= Product::find($request->product_id)->first();
         $product->delete();
        $data=Product::where('user_id',$request->user()->id)->get();
        return $this->responseData($data,'deleted successfully');
    }


    public function updateproduct(Request $request)
    {
      $validate=Validator::make($request->all(),
      [
        'name'=>'required|min:2',
        'price'=>'required|numeric',
        'quantity'=>'required|integer',
        'image'=>'required',
        'contact_info'=>'required',
        'discount_1'=>'required',
        'date_1'=>'required|date',
        'discount_2'=>'required',
        'date_2'=>'required|date',
        'discount_3'=>'required',
        'date_3'=>'required|date',
      ]);
     if($validate->fails())
      {
        return $this->responseError($validate->errors());
      }
      $product =Product::where('id',$request->product_id)->first();

       $product->update([
        'name'=>$request->name,
        'price'=>$request->price,
        'quantity'=>$request->quantity,
        'image'=>$request->image,
        'contact_info'=>$request->contact_info,
        'discount_1'=>$request->discount_1,
        'date_1'=>$request->date_1,
        'discount_2'=>$request->discount_2,
        'date_2'=>$request->date_2,
        'discount_3'=>$request->discount_3,
         ]);

         
         return $this->responseData($product,'updated successfully');
    }



    public function listAllproduct(Request $request)
    {
      if($request->sortby)
      {
        $sortby=$request->sortby;
        $products =Product::where('expiry_date','>',today())->orderBY($sortby,'desc')->withCount('comment','view','like')->get();

        return $this->responseData($products,'successfully fetched');
      }
      $products =Product::latest()->where('expiry_date','>',today())->withCount('comment','view','like')->get();
       $products_invalid =Product::where('expiry_date','<',today());
      $products_invalid->delete();
       return $this->responseData($products,'successfully fetched');
    }
    public function listproduct()
    {
        $user_id = auth()->user()->id;

        $Products = Product::where("user_id", $user_id)->get()->all();
        return $this->responseData($Products, 'this is all products which you add it');
    }


    public function index(Request $request,$product_id)
    {

      $product =Product::find($product_id);

      if(!$product)
      {
        return $this->responseError('product not found');
      }
     $view=View::where('product_id',$product_id)->where('user_id',$request->user()->id)->first();
     if(!$view)
     {
       View::create([
         'product_id'=>$product_id,
         'user_id'=>$request->user()->id
      ]);
     }
     $product1 =Product::where('id',$product_id)->withCount('comment','view','like')->with('comment')->first();

      return $this->responseData($product1,'successfully');
    }



    public function search_name(Request $request)
    {
      $validate=Validator::make($request->all(), ['name'=>'required']);
      if($validate->fails())
      {
        return $this->responseError($validate->errors());
      }

      $product =Product::where('name',$request->name)->first();
      if(!$product)
      {
        return $this->responseError('product not found');
      }
      $product1 =Product::where('name',$request->name)->get();

      return $this->responseData($product1,'successfully');
    }







    public function search_expiry(Request $request)
    {
      $validate=Validator::make($request->all(), ['expiry_date'=>'required|date']);
      if($validate->fails())
      {
        return $this->responseError($validate->errors());
      }

      $product =Product::where('expiry_date',$request->expiry_date)->first();

      if(!$product)
      {

        return $this->responseError('product not found');
      }
      $product1 =Product::where('expiry_date',$request->expiry_date)->select('name','price','quantity','contact_info','image','expiry_date')->get();
      return $this->responseData($product1,'successfully');

    }




    // public function search_category(Request $request)
    // {
    //   $validate=Validator::make($request->all(), ['category'=>'required']);
    //   if($validate->fails())
    //   {
    //     return $this->responseError($validate->errors());
    //   }

    //   $category =Category::where('name',$request->category)->first();

    //   if(!$category)
    //   {

    //     return $this->responseError('category not found');
    //   }
    //   $product =Product::where('category_id',$category->id)->first();
    //   if(!$product)
    //   {

    //     return $this->responseError('product not found');
    //   }
    //   $product1 =Product::where('category_id',$category->id)->select('name','price','quantity','contact_info','image','expiry_date')->get();
    //   return $this->responseData($product1,'successfully');
    // }


    public function like(Request $request,$product_id)
    {
      $product=Product::where('id',$product_id)->first();
      if(!$product)
      {
        return $this->responseError('product not found');
      }
      $product_like=Like::where('product_id',$product_id)->where('user_id',$request->user()->id)->first();
      if($product_like)
      {
         $product_like->delete();
         return response()->json([ 'ststes'=>true,
         'message'=>' Like successfully removed',
         ], 200);
      }
      else{
        Like::create([
          'product_id'=>$product_id,
          'user_id'=>$request->user()->id
        ]);
        return response()->json([ 'ststes'=>true,
        'message'=>' Like successfully toggled',
        ], 200);
      }

    }
}
