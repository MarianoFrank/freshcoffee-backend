<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->group(function () {
// });

//el metodo apiResources excluye los metodos "create" y "edit" ya que eso se encarga el frontend
Route::apiResources([
    'categories' => CategoryController::class,
    'products' => ProductController::class,
]);

Route::post("/register",[AuthController::class,"register"]);
