<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'application'], function () {
    Route::post('/', [\App\Http\Controllers\ApplicationController::class, 'store'])->name('application.store');
    Route::get('/{application}', [\App\Http\Controllers\ApplicationController::class, 'show'])->name('application.show');
});

Route::group(['prefix' => 'manifest'], function () {
    Route::get('/tonconnect-manifest', function () {
        return response()->json([[
            'url' => "",
            "name" => "Constructor Ton",
            "iconUrl" => "",
        ]]);
    });
});