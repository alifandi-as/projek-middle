<?php

namespace App\Http\Controllers\Api\User;

use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Session;

class ApiUserController extends ApiController
{
    public function index(Request $request){
        $user_list = UserData::query()
        ->where("remember_token", "=", $request->token)
        ->get();

        return $this->send_success($user_list[0]);
    }
    
    public function login(Request $request){
        $user = UserData::query()
        ->where("email", "=", $request->email)
        ->get()
        ->pluck("token")
        ->toArray()[0];
       Session::put("token", $user);

        return $this->send_success("You have logged in.");
    }

    public function register(Request $request){
        $name = $request->name;
        $password = Hash::make($request->password);
        $token = sha1($password);
        $email = $request->email;
        
        UserData::create([
            "name" => $name,
            "password" => $password,
            "remember_token" => $token,
            "email" => $email,
        ]);

        return $this->send_success("Registration successful");
    }

    public function edit(Request $request){
        $name = $request->name;
        $password = Hash::make($request->password);
        $token = sha1($password);
        $email = $request->email;

        UserData::query()
        ->where("id", "=", UserData::query()
            ->where("remember_token", "=", $request->token)
            ->get()
            ->pluck("id")
            ->toArray()[0]
        )
        ->take(1)
        ->update([
            "name" => $name,
            "password" => $password,
            "remember_token" => $token,
            "email" => $email,
        ]);
        return $this->send_success("Edit complete.");
    
    }

    public function logout(){
        Session::forget("token");

        return $this->send_success("You have logged out.");
    }

    public function delete(Request $request){
        Session::forget("token");
        $product = UserData::query()
        ->where("remember_token", "=", $request->token)
        ->take(1)
        ->delete();
        return $this->send_success("Your account has been deleted");
    }
}
