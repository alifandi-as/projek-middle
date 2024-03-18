<?php

use App\Models\Product;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiOrderController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiCategoryController;

if (!Session::isStarted()) {
    Session::start();
}
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

Route::get('/home', function(){
    $api_category = new ApiCategoryController;
    if (isset($_GET["category_id"])){
        $category_id = $_GET["category_id"];
    }
    else{
        $category_id = 1;
    }
    $api_product = new ApiProductController;
    $token = session()->get("token");
    if(isset($token)){
        $user = UserData::query()
        ->where("remember_token", "=", session()->get("token"))
        ->get()
        ->toArray()[0];
    }
    else{
        $user = null;
    }
    
    // ddd(session()->get("token"));
    return view('home', ['category' => $api_category->select($category_id),
                         'products' => $api_product->index(),
                         'user' => $user]);
});

Route::get('/login', function(){
    return view("public/login");
});

Route::get("/order/{product_id}", function($product_id, Request $request){
    if(session()->get("token")){
        $api_order = new ApiOrderController;
        $request->merge([
        "user_id" => UserData::query()
        ->where("remember_token", "=", session()->get("token"))
        ->get()
        ->pluck("remember_token")
        ->toArray()[0],
        "food_id" => $product_id, 
        "quantity" => $_GET["quantity"],
        "price" => Product::query()
                    ->where("id", "=", $product_id)
                    ->get()
                    ->pluck("price")
                    ->toArray()[0]]
        );
        $api_order->add($request);
    }
    
    return redirect()->back();
});