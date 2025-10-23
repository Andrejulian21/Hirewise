<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;


Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/user', [App\Http\Controllers\AuthController::class, 'user']);
    Route::post('/auth/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    // 🚀 Ejemplo de ruta protegida de prueba:
    Route::get('/dashboard', function (Request $request) {
        return response()->json([
            'message' => 'Bienvenido, ' . $request->user()->name,
            'role' => $request->user()->role,
        ]);
    });
});

