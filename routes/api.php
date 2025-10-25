<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/user', [App\Http\Controllers\AuthController::class, 'user']);
    Route::post('/auth/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    Route::get('/dashboard', function (Request $request) {
        return response()->json([
            'message' => 'Bienvenido, ' . $request->user()->name,
            'role' => $request->user()->role,
        ]);
    });
});

use App\Http\Controllers\JobPostingController;

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:admin,recruiter')->group(function () {

        Route::post('/jobs', [JobPostingController::class, 'store']);

        Route::put('/jobs/{id}', [JobPostingController::class, 'update']);

        Route::delete('/jobs/{id}', [JobPostingController::class, 'destroy']);
    });

    // Rutas públicas para listar vacantes
    Route::get('/jobs', [JobPostingController::class, 'index']);
    Route::get('/jobs/{id}', [JobPostingController::class, 'show']);
});


