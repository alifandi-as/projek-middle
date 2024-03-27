<?php

namespace App\Http\Controllers;

use App\Models\User;
// use App\Models\UserData;
use App\Http\MessageAlert;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

class WebUserController extends Controller
{
// Create new user
public function register(Request $request){
    $form_fields = $request->validate([
        'name' => 'required',
        'email' => 'required',
        'password' => 'required'
    ]);
    // $form_fields = $request->validate(["name" => ["required", "min:3"]
    // , "email" => ["required", "email"]
    // , "password" => ["required", "min:6"]]);
    // dd($form_fields);

    // Hash password
    $form_fields['password'] = bcrypt($form_fields['password']);

    // Create user
    $user = User::create($form_fields);

    // Login
    auth()->login($user);

    return "test";
}

public function logout(Request $request){
    auth()->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return "logout";
}

    public function login(Request $request){
        $form_fields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        if(auth()->attempt($form_fields)){
            $request->session()->regenerate();

            return redirect("/");
        }

        return "fail";
    }
}
