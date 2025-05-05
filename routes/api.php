<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['auth:sanctum', 'role:company_admin,user'])->group(function () {
    Route::apiResource('leads', LeadController::class);
});

Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});
