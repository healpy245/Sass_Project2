<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('register',[UserController::class,'register']);

Route::post('login',[UserController::class,'login']);






Route::middleware(['auth:sanctum', RoleMiddleware::class.':super_admin'])->group(function () {
    Route::apiResource('/admin/dashboard/companies', CompaniesController::class);
});
