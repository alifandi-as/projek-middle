<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\User\ApiUserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ApiUserController::class)
->prefix("/users")
->group(function(){
    Route::post("/", "index")->middleware("token-middleware");
    Route::post("/login", "login")->middleware("login-middleware");
    Route::put("/register", "register");
    Route::post("/edit", "edit")->middleware("token-middleware");
    Route::get("/logout", "logout");
    Route::delete("/delete", "delete")->middleware("token-middleware");
});

Route::controller(ApiProductController::class)
->prefix("/products")
->group(function(){
    Route::get("/", "index");
    Route::get("/select/{id}", "select");
    Route::put("/add/{id}", "add")->middleware("admin-middleware");
    Route::put("/multi/add", "multi_add")->middleware("admin-middleware");
    Route::post("/edit/{id}", "edit")->middleware("admin-middleware");
    Route::post("/multi/edit", "multi_edit")->middleware("admin-middleware");
    Route::delete("/delete/{id}", "delete")->middleware("admin-middleware");
    Route::delete("/multi/delete", "multi_delete")->middleware("admin-middleware");
});

Route::controller(ApiCategoryController::class)
->prefix("/categories")
->group(function(){
    Route::get("/", "index");
    Route::get("/{id}", "select");
    Route::put("/add/{id}", "add")->middleware("admin-middleware");
    Route::put("/multi/add", "multi_add")->middleware("admin-middleware");
    Route::post("/edit/{id}", "edit")->middleware("admin-middleware");
    Route::post("/multi/edit", "multi_edit")->middleware("admin-middleware");
    Route::delete("/delete/{id}", "delete")->middleware("admin-middleware");
    Route::delete("/multi/delete", "multi_delete")->middleware("admin-middleware");
});