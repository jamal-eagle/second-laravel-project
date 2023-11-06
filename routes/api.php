<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Route:: post('product/create','Productcontroller@creatproduct');
Route:: delete('product/delete','Productcontroller@deletproduct')->middleware('check_Id:api');
Route:: put('product/update/{id}','Productcontroller@updateproduct')->middleware('check_Id:api');
Route:: get('product/list','Productcontroller@listAllproduct');
route::get('list/product/user','Productcontroller@listProduct');
Route:: get('product/{product_id}/index','Productcontroller@index');
Route:: get('product/index/name','Productcontroller@search_name');
Route:: get('product/index/expiry','Productcontroller@search_expiry');
//Route:: get('product/index/category','Productcontroller@search_category');
Route:: post('register','RegisterController@register');
Route:: post('login','LoginController@login');
Route:: post('logout','LoginController@logout');
Route:: post('product/{product_id}/comment/create','CommentController@create')->middleware('check_token:api');
Route:: post('product/{product_id}/comment/get','CommentController@getcomments')->middleware('check_token:api');
Route:: post('product/{product_id}/like','Productcontroller@like')->middleware('check_token:api');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('check_token')->get('user', function (Request $request) {
 //return auth()->user();
//});
