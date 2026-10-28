<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectRandomSeeder extends Seeder
{
    public function run(): void
    {
        $daftarStack = ['PHP', 'Laravel', 'MySQL', 'Java', 'Python', 'JavaScript', 'Bootstrap', 'Tailwind CSS'];

        for ($i = 1; $i <= 25; $i++) {
            Project::create([
                'nama'      => ucfirst(fake()->words(3, true)) . ' ' . fake()->numerify('###'),
                'deskripsi' => fake()->sentence(12),
                'stack'     => fake()->randomElements($daftarStack, fake()->numberBetween(1, 3)),
                'status'    => fake()->randomElement(['draft', 'published']),
            ]);
        }
    }
}

