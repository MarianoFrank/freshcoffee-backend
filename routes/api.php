<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Requests\CustomEmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

//Private routes 🔒
Route::middleware(['auth:jwt', 'verified'])->group(function () {
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


/* Esta forma no me sirve porque tengo un custom guard, entonces dentro de EmailVerificationRequest
//al momento de ejecutra $this->user() intentara obtener el usuario con mi guard custom */

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
//     return redirect(env('FRONTEND_URL') . '/login');
// })->middleware(['signed'])->name('verification.verify');

//La solucion seria hacer un Form Request Validation custom

Route::get('/email/verify/{id}/{hash}', function (CustomEmailVerificationRequest $request) {
    $request->fulfill();
    return redirect(env('FRONTEND_URL') . '/auth/login?verified=true');
})->middleware(['signed'])->name('verification.verify');

//});
