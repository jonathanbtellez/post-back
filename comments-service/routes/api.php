<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/comments', [App\Http\Controllers\CommentController::class, 'index']);
