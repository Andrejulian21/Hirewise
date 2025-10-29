<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['name' => 'PHP', 'category' => 'Backend'],
            ['name' => 'Laravel', 'category' => 'Backend'],
            ['name' => 'JavaScript', 'category' => 'Frontend'],
            ['name' => 'React', 'category' => 'Frontend'],
            ['name' => 'SQL', 'category' => 'Database'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
