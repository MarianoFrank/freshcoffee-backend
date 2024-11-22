<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Private routes 🔒
Route::middleware('auth:jwt')->group(function () {
    Route::get("/user", function (Request $request) {
        return auth()->user();
    });
    // Route::get("/logout/all", [AuthController::class, "logoutFromAllDevices"]);
    // Route::post("/logout", [AuthController::class, "logout"]);

    //el metodo apiResources excluye los metodos "create" y "edit" ya que eso se encarga el frontend
    Route::apiResources([
        'categories' => CategoryController::class,
        'products' => ProductController::class,
        'orders' => OrderController::class
    ]);
});

//Public routes 🌎
//TODO descomentar luego 
//Route::middleware(['throttle:auth'])->group(function () {
Route::post("/register", [AuthController::class, "register"])->name('register');
Route::post("/login", [AuthController::class, "login"])->name('login');
Route::post('/refresh/token', [AuthController::class, "refreshToken"])->name('refresh-token');

//reset pass
Route::post('/forgot-password', [AuthController::class, "forgotPassword"]);
Route::post('/reset-password', [AuthController::class, "resetPassword"]);
//});
