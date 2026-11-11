<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
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
            ],
            [
                'nama' => 'Bank Sampah Digital',
                'deskripsi' => 'Aplikasi web full-stack untuk praktikum Pemrograman Web, memenuhi kriteria 
                5 tabel database beserta view, stored procedure, trigger, dan function.',
                'stack' => ['PHP', 'MySQL', 'Bootstrap'],
                'category' => 'Web',
            ],

        ];

        foreach ($projects as $project) {
            $project['category_id'] = Category::where('name', $project['category'])->value('id');
            unset($project['category']);

            Project::updateOrCreate(['nama' => $project['nama']], $project);
        }
    }
}
