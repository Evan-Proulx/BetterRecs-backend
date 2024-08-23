<?php

use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Public Routes
Route::post('/auth', [AuthController::class, 'auth']);
Route::post('/reg', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::apiResource('albums', AlbumController::class);
});

