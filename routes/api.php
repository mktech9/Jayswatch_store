<?php
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\EcomController;


use Illuminate\Support\Facades\Route;



Route::get('/products', [ProductApiController::class, 'homeproducts']);




Route::post('/ccavenue/response', [EcomController::class, 'ccavenueResponse'])
    ->name('ccavenue.response');
