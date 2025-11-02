<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Arr;

Route::get('/', function () {
    return view('welcome');
});

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

use App\Http\Controllers\Company\JobController;
use App\Http\Controllers\Candidate\ProfileController;
use App\Http\Controllers\Candidate\AplicationController;

Route::get('/_debug-mw', function () {
    return app('router')->getMiddleware();
});

Route::middleware(['auth'])->group(function () {

    // -------- Empresa: CRUD Vacantes ----------
    Route::middleware(['auth','ensure.role:Empresa'])
        ->prefix('empresa')->name('empresa.')
        ->group(function () {
            Route::resource('jobs', \App\Http\Controllers\Company\JobController::class);
        });

    // -------- Candidato: Perfil + Postular ----------
    Route::middleware(['auth', 'ensure.role:Candidato'])
        ->prefix('candidato')->name('candidato.')
        ->group(function () {
            Route::get('perfil', [ProfileController::class, 'edit'])->name('perfil.edit');
            Route::put('perfil', [ProfileController::class, 'update'])->name('perfil.update');

            Route::post('aplicar/{job}', [AplicationController::class, 'store'])->name('aplicar');
    });

    // -------- Listado público (ambos) ----------
    Route::get('/jobs', [JobController::class, 'publicIndex'])->name('jobs.public');
    Route::get('/jobs/{job}', [JobController::class, 'publicShow'])->name('jobs.show');
});

use App\Http\Controllers\DashboardController;

Route::middleware(['auth','ensure.role:Empresa'])
    ->get('/empresa/dashboard', [DashboardController::class,'empresa'])
    ->name('empresa.dashboard');

Route::middleware(['auth','ensure.role:Candidato'])
    ->get('/candidato/dashboard', [DashboardController::class,'candidato'])
    ->name('candidato.dashboard');
/*Route::get('/whoami', function () {
    $u = Auth::user();
    return [
        'auth'  => Auth::check(),
        'user'  => $u ? Arr::only($u->toArray(), ['id','name','email','provider_name','provider_id']) : null,
        'roles' => $u && method_exists($u,'getRoleNames') ? $u->getRoleNames()->all() : [],
        'first_role_in_session' => session('first_role'),
    ];
}); */

