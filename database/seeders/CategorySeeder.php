<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Web', 'Mobile', 'Game', 'Desktop'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }

    // public function run(): void
    // {
    //    for ($i = 0; $i < 5; $i++) {
    //         Category::create([
    //             'name' => 'Category ' . ($i + 1),
    //         ]);
    //     }
    // }
}
