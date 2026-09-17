@extends('layouts.app')

@section('title', 'About - Portfolio Caysa')

@php
    $nama = 'Caysa Rara Kirani';
    $deskripsi = 'Mahasiswa Teknologi Rekayasa Perangkat Lunak (TRPL), Sekolah Vokasi, Universitas Gadjah Mada.';
    $skills = [
        'PHP & Laravel',
        'MySQL',
        'Java (OOP, Swing)',
        'HTML, CSS, JavaScript',
        'Python (data processing)',
    ];
@endphp

@section('content')
    <section class="page-header">
        <p class="eyebrow">Tentang Saya</p>
        <h1>{{ $nama }}</h1>
        <p class="page-lead">{{ $deskripsi }}</p>
    </section>

    <section class="section">
        <p>
            Sedang menempuh semester 2, aktif mengerjakan mata kuliah Pemrograman
            Berorientasi Objek, Pemrograman Basis Data, Praktikum Pemrograman Web,
            Analisis Algoritma, Statistika, dan Aljabar/Vektor/Matriks.
        </p>
    </section>

    <section class="section">
        <h2>Skill</h2>
        <div class="badge-list">
            @foreach($skills as $skill)
                <span class="badge">{{ $skill }}</span>
            @endforeach
        </div>
    </section>
@endsection
