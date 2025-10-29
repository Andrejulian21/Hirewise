<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Administrador General',
            'email' => 'admin@hirewise.com',
            'password' => Hash::make('admin123'),
        ]);
        $admin->assignRole('Admin');

        // Empresa
        $empresa = User::create([
            'name' => 'TechCorp',
            'email' => 'empresa@hirewise.com',
            'password' => Hash::make('empresa123'),
        ]);
        $empresa->assignRole('Empresa');

        // Candidato
        $candidato = User::create([
            'name' => 'Juan Pérez',
            'email' => 'candidato@hirewise.com',
            'password' => Hash::make('candidato123'),
        ]);
        $candidato->assignRole('Candidato');
    }
}
