<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\AdController;

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
//Route::get('/', function () {
//    return view('welcome');
//});
//Route::resource('users', UserController::class);
//Route::resource('campaigns', CampaignController::class);
//Route::resource('ads', AdController::class);
