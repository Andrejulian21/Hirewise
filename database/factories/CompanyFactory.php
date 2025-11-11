<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CompanyFactory extends Factory
{
    // Indicar el modelo que genera (si tu factory no lo infiere)
    protected $model = \App\Models\Company::class;

    public function definition(): array
    {
        $companyName = $this->faker->company();

        return [
            'user_id' => null, // se asigna con ->for($user) en el seeder
            'name' => $companyName,
            'description' => $this->faker->paragraph(),
            'website' => $this->faker->url(),
            'logo' => null,
        ];
    }
}
