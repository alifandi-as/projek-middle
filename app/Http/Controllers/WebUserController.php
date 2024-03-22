<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Http\MessageAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebUserController extends MessageAlert
{
    public function show(Request $request){
        
        $user_list = UserData::query()
        ->where("remember_token", "=", session()->get("token"))
        ->get();

        return MessageAlert::send_success($user_list[0]);
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

            $credentials = request(["name", "email", "password"]);

            if(Auth::attempt($credentials)){
                $user = UserData::query()
                ->where("name", "=", $request->name)
                ->where("email", "=", $request->email)
                ->get()
                ->pluck("remember_token")
                ->toArray()[0];
                
                $token = $request->user()->createToken($request->name);
                $request->session()->put($request->name, $token->plainTextToken);
                return redirect("/");
                // return MessageAlert::send_success("You have logged in.");
            }

            // If password exists
            /*if(count($user_password) >= 1){
                $user_password = $user_password[0];

                // If password isn't null & password is correct
                if(isset($user_password) && Hash::check($request->password, $user_password)){
                    $user = UserData::query()
                    ->where("name", "=", $request->name)
                    ->where("email", "=", $request->email)
                    ->get()
                    ->pluck("remember_token")
                    ->toArray()[0];
                    $request->session()->put("token", $user);
                    return redirect("/");
                    // return MessageAlert::send_success("You have logged in.");
                }
            }*/

        }

        return MessageAlert::send_unauthorized("Incorrect email or password");

        
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

        session()->put("token", $token);

        return $this->send_success("Registration successful");
    }

    public function logout(Request $request){
        // $request->session()->forget("token");
        auth()->user()->tokens()->delete();
        auth()->logout();

        return MessageAlert::send_success("You have logged out.");
    }

    public function delete(Request $request){
        $request->session()->forget("token");
        $product = UserData::query()
        ->where("remember_token", "=", $request->token)
        ->take(1)
        ->delete();
        return MessageAlert::send_success("Your account has been deleted");
    }
}
