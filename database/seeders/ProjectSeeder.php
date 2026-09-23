<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'nama' => 'Dungeon Battle: Rise of Hero',
                'deskripsi' => 'Game RPG berbasis Java Swing, proyek akhir mata kuliah OOP dikerjakan bersama tim (Kelompok 5). Mencakup sistem battle, world map, sprite musuh, dan animasi start screen.',
                'stack' => ['Java', 'Java Swing'],
            ],
            [
                'nama' => 'Bank Sampah Digital',
                'deskripsi' => 'Aplikasi web full-stack untuk praktikum Pemrograman Web, memenuhi kriteria 5 tabel database beserta view, stored procedure, trigger, dan function.',
                'stack' => ['PHP', 'MySQL', 'Bootstrap'],
            ],
            [
                'nama' => 'Si Pengembang Diri',
                'deskripsi' => 'Perancangan Information Architecture untuk sistem pengajuan dana pengembangan diri dosen, mencakup pemetaan fitur per role dan alur pengajuan multi-tahap.',
                'stack' => ['UI/UX', 'Information Architecture'],
            ],
            [
                'nama' => 'REVEAL 2026 - Sistem Pengelolaan Sampah Terintegrasi',
                'deskripsi' => 'Studi kasus kompetisi untuk merancang sistem pengelolaan sampah rendah karbon terintegrasi bagi PT Cikaengan Tirta Energi (PLTM).',
                'stack' => ['Case Study', 'Riset'],
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(['nama' => $project['nama']], $project);
        }
    }
}
