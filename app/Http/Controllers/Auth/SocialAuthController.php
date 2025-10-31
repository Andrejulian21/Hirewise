<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Throwable;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        // opcional: guardar rol elegido en la sesión (?rol=Empresa|Candidato)
        if ($rol = request('rol')) {
            session(['first_role' => $rol]);
        }

        // redirige a Google
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        Log::info('GOOGLE CALLBACK HIT', ['at' => now()->toDateTimeString()]);

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            // registrar error completo
            Log::error('Socialite callback error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            // devolver mensaje detallado temporalmente (para depurar)
            return redirect()->route('login')->withErrors([
                'email' => 'Error al autenticar con Google: ' . $e->getMessage()
            ]);
        }


        $email = $googleUser->getEmail() ?: (Str::slug($googleUser->getId()) . '@no-email.local');
        $name  = $googleUser->getName() ?: ($googleUser->getNickname() ?? 'Usuario');

        // crear o actualizar por email
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name'          => $name,
                'provider_name' => 'google',
                'provider_id'   => $googleUser->getId(),
                // password nulo para cuentas sociales
                'password'      => null,
            ]
        );

        // asignar rol si usas Spatie y si guardaste rol en sesión
        if (method_exists($user, 'assignRole') && $role = session('first_role')) {
            try {
                $user->syncRoles([$role]);
            } catch (Throwable $e) {
                Log::warning('Could not assign role', ['role' => $role, 'err' => $e->getMessage()]);
            }
        }

        // crear perfiles opcionales según rol (si existen modelos Company/Candidate)
        try {
            if (class_exists(Company::class) && $user->isEmpresa()) {
                if (! $user->company) {
                    Company::create(['name' => $user->name . ' (empresa)', 'email' => $user->email, 'created_at' => now(), 'updated_at' => now(), 'slug' => Str::slug($user->name)]);
                }
            }
            if (class_exists(Candidate::class) && $user->isCandidato()) {
                if (! $user->candidate) {
                    Candidate::create(['user_id' => $user->id]);
                }
            }
        } catch (Throwable $e) {
            Log::info('Profile creation skipped or failed', ['err' => $e->getMessage()]);
        }

        // Login y regenerar sesión
        Auth::login($user, true);
        request()->session()->regenerate();
        session()->forget('first_role');

        return redirect()->intended(route('dashboard'));
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}
