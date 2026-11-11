@extends('layouts.portfolio')

@section('title', 'Projects - Portfolio Caysa')

<!-- @php
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
        // Tambahkan proyek lain di sini
    ];
@endphp -->

@section('content')
    <section class="page-header">
        <p class="eyebrow">Portfolio</p>
        <h1>Projects</h1>
    </section>

    <section class="section">
        <div class="project-grid">
            @forelse($projects as $project)
                <article class="project-card">
                    @if ($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->nama }}" class="card-thumb">
                    @endif

                    @if ($project->category)
                        <span class="badge badge-sm">{{ $project->category->name }}</span>
                    @endif
                    <h3>{{ $project->nama }}</h3>
                    <p>{{ $project->deskripsi }}</p>

                    @if (!empty($project->stack))
                        <div class="badge-list">
                            @foreach($project->stack as $tech)
                                <span class="badge badge-sm">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="card-footer">
                        <a href="{{ route('portfolio.projects.show', $project) }}" class="card-link">
                            Lihat Detail<span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </article>
            @empty
                <p>Belum ada data proyek.</p>
            @endforelse
        </div>
    </section>
@endsection

@push('scripts')
    <script>console.log('Halaman projects dimuat');</script>
@endpush
