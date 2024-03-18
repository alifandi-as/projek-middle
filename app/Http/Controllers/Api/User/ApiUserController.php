<?php

namespace App\Http\Controllers\Api\User;

use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;

class ApiUserController extends ApiController
{
    public function index(Request $request){
        
        $user_list = UserData::query()
        ->where("remember_token", "=", $request->token)
        ->get();

        return $this->send_success($user_list[0]);
    }
    
    public function login(Request $request){

        if(isset($request->email)){

            // Authorization
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required'
            ]);
            $user_password = UserData::query()
            ->where("name", "=", $request->name)
            ->where("email", "=", $request->email)
            ->get()
            ->pluck("password")
            ->toArray();

            // If password exists
            if(count($user_password) >= 1){
                $user_password = $user_password[0];

                // If password isn't null & password is correct
                if(isset($user_password) && Hash::check($request->password, $user_password)){
                    $user = UserData::query()
                    ->where("name", "=", $request->name)
                    ->where("email", "=", $request->email)
                    ->get()
                    ->pluck("remember_token")
                    ->toArray()[0];
                    session()->put("token", $user);
                    return $this->send_success("You have logged in.");
                }
            }

        }

        return $this->send_unauthorized("Incorrect email or password");

        
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        $name = $request->name;
        $password = Hash::make($request->password);
        $token = sha1($password);
        $email = $request->email;

        // $name = filter_input(INPUT_POST, $request->name, FILTER_SANITIZE_SPECIAL_CHARS);
        // $password = Hash::make(filter_input(INPUT_POST, $request->password, FILTER_SANITIZE_SPECIAL_CHARS));
        // $token = sha1($password);
        // $email = filter_input(INPUT_POST, $request->email, FILTER_SANITIZE_EMAIL);
        
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
        session()->forget("token");

        return $this->send_success("You have logged out.");
    }

    public function delete(Request $request){
        session()->delete("token");
        $product = UserData::query()
        ->where("remember_token", "=", $request->token)
        ->take(1)
        ->delete();
        return $this->send_success("Your account has been deleted");
    }
}
