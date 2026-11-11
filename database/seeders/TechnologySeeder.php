<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['PHP', 'Laravel', 'MySQL', 'Java', 'Python', 'JavaScript', 'Tailwind CSS'] as $name) {
            Technology::firstOrCreate(['name' => $name]);
        }
    }
}
