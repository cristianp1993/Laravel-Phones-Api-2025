<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\CategoryController;

Route::apiResource('phones', PhoneController::class)->names('api.phones');

Route::get('categories/active-with-phones', [CategoryController::class, 'activeWithPhones']);

Route::apiResource('categories', CategoryController::class)->names('api.categories');
