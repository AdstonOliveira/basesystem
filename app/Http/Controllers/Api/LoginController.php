<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginApiRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{


    public function login(LoginApiRequest $request){
        $user = User::where("email", $request->input("email"))->first();

        if (! $user ) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }else{

            $credentials= [
                "email"     => $request->input("email"),
                "password"  => $request->input("password")
            ];

            if( !Auth::attempt($credentials) ){
                throw ValidationException::withMessages([
                    'email' => ['Dados incorretos.'],
                ]);
            }else{
                auth()->user()->tokens()->delete();
                return auth()->user()->createToken($request->device_name)->plainTextToken;
            }
        }



    }



}
