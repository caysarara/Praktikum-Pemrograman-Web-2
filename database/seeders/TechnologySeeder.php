<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['PHP', 'Laravel', 'MySQL', 'Java', 'Python', 'JavaScript', 'Tailwind CSS', 'Bootstrap', 'Java Swing', 'Figma'] as $name) {
            Technology::firstOrCreate(['name' => $name]);
        }
    }
}
