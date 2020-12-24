<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Purchase\PurchaseController;

Route::apiResources([
  'products' => ProductController::class
]);

Route::post(
  '/purchase',
  [PurchaseController::class, 'store']
);
