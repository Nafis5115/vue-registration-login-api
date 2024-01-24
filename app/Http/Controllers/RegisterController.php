<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function store(Request $request){
        $input = $request->all();

        try{
            User::create([
                'name'=>$input['name'],
                'email'=>$input['email'],
                'password'=>Hash::make($input['password']),
            ]);

            return response()->json(['status'=>true,'message'=>'Success']);
        }
        catch(QueryException $exception){
            if ($exception->errorInfo[1] == 1062) {
                // Duplicate entry error (unique constraint violation)
                return response()->json(['error' => 'Email is already registered.'], 422);
            }
            return response()->json(['error' => 'Database error.'], 500);
        }
    }
}
