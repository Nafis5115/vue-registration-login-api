<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class LoginController extends Controller
{
    public function check(Request $request){

         $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user instanceof \App\Models\User) {

             $token = $user->createToken('authToken')->accessToken;
        }


        return response()->json(['token' => $token, 'user' => $user]);
    }

    return response()->json(['error' => 'Invalid credentials'], 401);

    }

    public function getUser(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // User is authenticated, return user information
            return response()->json(['user' => $user], 200);
        } else {
            // User is not authenticated
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    }
}
