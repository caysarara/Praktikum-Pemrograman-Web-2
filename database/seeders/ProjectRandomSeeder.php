<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class ProjectRandomSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id');
        $daftarStack = ['PHP', 'Laravel', 'MySQL', 'Java', 'Python', 'JavaScript', 'Bootstrap', 'Tailwind CSS'];
        $technologyIds = Technology::pluck('id', 'name');

        for ($i = 1; $i <= 25; $i++) {
            Project::create([
                'nama'      => ucfirst(fake()->words(3, true)) . ' ' . fake()->numerify('###'),
                'short_description' => fake()->sentence(8),
                'deskripsi' => fake()->sentence(12),
                'stack'     => $stack,
                'status'    => fake()->fake()->boolean(70) ? 'published' : 'draft',
                'category_id' => $categoryIds->isEmpty() ? null : $categoryIds->random(),
                'project_date'      => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                'is_featured'       => fake()->boolean(15),
            ]);

            $project->technologies()->sync(collect($stack)->map(fn ($name) => $technologyIds->get($name))->filter()->values()->all());
        }
    }
}

