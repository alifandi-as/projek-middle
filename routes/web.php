<?php

use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiProductController;
use Illuminate\Support\Facades\Route;


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