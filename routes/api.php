<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhoneController;

Route::apiResource('phones', PhoneController::class);
