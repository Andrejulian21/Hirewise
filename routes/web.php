<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Arr;

/** Formularios */
Route::get('/login', [AuthenticatedSessionController::class,'create'])->middleware('guest')->name('login');
Route::get('/register', [RegisteredUserController::class,'create'])->middleware('guest')->name('register');

/** Registro propio + Login propio */
Route::post('/register', [RegisteredUserController::class,'store'])->middleware('guest')->name('register.store');
Route::post('/login', [AuthenticatedSessionController::class,'store'])->middleware('guest')->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class,'destroy'])->middleware('auth')->name('logout');



Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');

// Botones en login/registro → /auth/google/redirect?rol=Empresa|Candidato
Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])
    ->name('auth.redirect.google');

// Callback que configuraste en Google Cloud Console
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])
    ->name('auth.callback.google');

// Logout (POST recomendable en prod)
Route::post('/logout', [SocialAuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::get('/whoami', function () {
    $u = Auth::user();
    return [
        'auth'  => Auth::check(),
        'user'  => $u ? Arr::only($u->toArray(), ['id','name','email','provider_name','provider_id']) : null,
        'roles' => $u && method_exists($u,'getRoleNames') ? $u->getRoleNames()->all() : [],
        'first_role_in_session' => session('first_role'),
    ];
});

