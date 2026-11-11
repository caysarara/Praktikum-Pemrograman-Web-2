<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            'PHP' => 80, 'Laravel' => 75, 'MySQL' => 70, 'Java' => 65,
            'JavaScript' => 60, 'Tailwind CSS' => 55, 'Python' => 50,
        ];

        foreach ($skills as $name => $level) {
            Skill::updateOrCreate(['name' => $name], ['level' => $level]);
        }
    }
}
