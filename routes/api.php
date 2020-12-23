<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;

Route::apiResources([
  'products' => ProductController::class
]);
