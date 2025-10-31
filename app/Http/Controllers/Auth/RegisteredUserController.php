<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register'); // vista minimal abajo
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users,email'],
            'password' => ['required','min:8','confirmed'],
            'role'     => ['required', Rule::in(['Empresa','Candidato'])],
        ]);

        $user = User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'provider_name' => null,
            'provider_id'   => null,
        ]);

        // Asignar rol (Spatie) — conserva el apartado de roles
        if (method_exists($user,'assignRole')) {
            try {
                $user->assignRole($data['role']);
            } catch (\Throwable $e) {
                // fallback: si la asignación falla, registrar pero continuar
            }
        }

        // Crear perfil base según rol (opcional)
        if ($data['role'] === 'Empresa' && class_exists(Company::class)) {
            Company::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $user->name,
                    'description' => null,
                    'website' => null,
                    'logo' => null,
                    'plan_id' => null,
                ]
            );
        }

        if ($data['role'] === 'Candidato' && class_exists(Candidate::class)) {
            Candidate::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'summary' => null,
                    'experience_years' => 0,
                    'education' => null,
                    'cv_file' => null,
                    'linkedin_url' => null,
                ]
            );
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('status','Registro exitoso');
    }
}