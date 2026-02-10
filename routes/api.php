<?php

use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::middleware(['auth:api', 'role:admin,nurse'])->group(function () {
    Route::apiResource('patients', \App\Http\Controllers\Api\PatientController::class);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::apiResource('polyclinics', \App\Http\Controllers\Api\PolyclinicController::class);
    Route::apiResource('doctors', \App\Http\Controllers\Api\DoctorController::class);
});
