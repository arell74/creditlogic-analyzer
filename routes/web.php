<?php

use App\Http\Controllers\CreditController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CreditController::class, 'index']);
Route::post('/analyze',       [CreditController::class, 'analyze']);
Route::get('/analyze/reset',  [CreditController::class, 'reset']);
