<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GatewayController;

Route::get('/posts',[GatewayController::class, 'postIndex']);
Route::post('/posts',[GatewayController::class, 'postCreate']);

