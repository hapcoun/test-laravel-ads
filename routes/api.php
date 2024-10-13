<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\AdController;

Route::apiResource('users', UserController::class);
Route::get('users/{user}/campaigns', [UserController::class, 'campaigns']);
Route::post('users/{user}/campaigns', [UserController::class, 'storeCampaign']);

Route::apiResource('campaigns', CampaignController::class);
Route::get('campaigns/{campaign}/ads', [CampaignController::class, 'ads']);
Route::post('campaigns/{campaign}/ads', [CampaignController::class, 'storeAd']);

Route::apiResource('ads', AdController::class);

