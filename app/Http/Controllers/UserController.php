<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function login(Request $request){
        $user = User::where("email", $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){ 
            return "username and password is not matched";
        }
        $request->session()->put("user", $user);
        return redirect("/");
    }
}
