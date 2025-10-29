<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles base
        $admin = Role::create(['name' => 'Admin']);
        $empresa = Role::create(['name' => 'Empresa']);
        $candidato = Role::create(['name' => 'Candidato']);

        // Crear permisos generales
        $permissions = [
            'crear vacantes',
            'postular a vacante',
            'ver candidatos',
            'gestionar usuarios',
        ];

        foreach ($permissions as $perm) {
            Permission::create(['name' => $perm]);
        }

        // Asignar permisos según rol
        $admin->givePermissionTo(Permission::all());
        $empresa->givePermissionTo(['crear vacantes', 'ver candidatos']);
        $candidato->givePermissionTo(['postular a vacante']);
    }
}
