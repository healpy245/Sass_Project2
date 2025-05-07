<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::post('refresh', [UserController::class,'refresh'])->middleware('auth:sanctum');





Route::middleware(['auth:sanctum', RoleMiddleware::class . ':super_admin'])->group(function () {
    Route::apiResource('/admin/companies', CompaniesController::class);
});




Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/company/leads', LeadController::class);
});






Route::middleware(['auth:sanctum', RoleMiddleware::class .':admin,super_admin'])->group(function () {
    // Route::get('users/admin', [UserController::class, 'index']);
    Route::apiResource('users/admin', UserController::class);
    Route::put("users/admin",[UserController::class,'update']);
});