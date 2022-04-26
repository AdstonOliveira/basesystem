<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginApiRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{


    public function login(LoginApiRequest $request){

        $user = User::where("email", $request->input("email"))->first();

        if (! $user || ! Hash::check($request->input("password"), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if( $user->currentAccessToken() )
            $user->currentAccessToken()->delete();

        return $user->createToken($request->device_name)->plainTextToken;
    }



}
