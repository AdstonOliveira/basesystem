<?php

use App\Http\Controllers\Api\Customer\CustomerController;
use App\Http\Controllers\Api\LoginController as ApiLoginController;
use App\Models\User;
use App\Services\RetornoApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['forceJson'])->group(function () {

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post("login", [ApiLoginController::class, "login"])->name("login.api");



    Route::group(["middleware"=>"auth:sanctum"], function(){

        Route::get("users", function(){
            return RetornoApi::paginate(request(), User::all());
        });

        Route::group(["prefix"=>"customer"], function(){
            Route::post("/", [CustomerController::class, "store"]);
            Route::get("/", [CustomerController::class, "index"]);
        });
    });

});
