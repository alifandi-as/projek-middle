<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiOrderController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiCategoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function(){
    $api_category = new ApiCategoryController;
    if (isset($_GET["category_id"])){
        $category_id = $_GET["category_id"];
    }
    else{
        $category_id = 1;
    }
    $api_product = new ApiProductController;
    
    return view('home', ['category' => $api_category->select($category_id),
                         'products' => $api_product->index()]);
});

Route::get("/order/{product_id}", function($product_id, Request $request){
    $api_order = new ApiOrderController;
    $request->merge(["user_id" => ""]);
    $api_order->add($request);
    return redirect()->back();
});