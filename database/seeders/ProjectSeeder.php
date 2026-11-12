<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'nama' => 'Dungeon Battle: Rise of Hero',
                'deskripsi' => 'Game RPG berbasis Java Swing, proyek akhir mata kuliah OOP dikerjakan 
                bersama tim (Kelompok 5). Mencakup sistem battle, world map, sprite musuh, dan animasi 
                start screen.',
                'stack' => ['Java', 'Java Swing'],
                'category' => 'Game',
                'short_description' => 'Game RPG berbasis Java Swing dengan sistem battle dan world map.',
                'project_date' => '2024-06-15',
                'status' => 'published',
            ],
            [
                'nama' => 'Bank Sampah Digital',
                'deskripsi' => 'Aplikasi web full-stack untuk praktikum Pemrograman Web, memenuhi kriteria 
                5 tabel database beserta view, stored procedure, trigger, dan function.',
                'stack' => ['PHP', 'MySQL', 'Bootstrap'],
                'category' => 'Web',
                'short_description' => 'Aplikasi web pengelolaan bank sampah untuk praktikum Pemrograman Web.',
                'project_date' => '2025-01-20',
                'status' => 'published',
            ],

        ];

        foreach ($projects as $project) {
            $project['category_id'] = Category::where('name', $project['category'])->value('id');
            unset($project['category']);

            $model = Project::updateOrCreate(['nama' => $project['nama']], $project);

            $model->technologies()->sync(Technology::whereIn('name', $project['stack'])->pluck('id'));

        }
    }
}
