@extends('layouts.app')

@section('title', 'Education - Portfolio Caysa')

@php
    $riwayat = [
        [
            'jenjang' => 'Sarjana Terapan (D4) - Teknologi Rekayasa Perangkat Lunak',
            'institusi' => 'Universitas Gadjah Mada, Sekolah Vokasi',
            'tahun' => 'Sekarang (Semester 2)',
        ],
        // Tambahkan riwayat pendidikan sebelumnya (SMA/SMK, dll) di sini
    ];

    $mataKuliah = [
        'Pemrograman Berorientasi Objek (PPBO)',
        'Pemrograman Basis Data',
        'Praktikum Pemrograman Web',
        'Analisis Algoritma',
        'Statistika',
        'Aljabar, Vektor, dan Matriks',
    ];
@endphp

@section('content')
    <section class="page-header">
        <p class="eyebrow">Riwayat</p>
        <h1>Education</h1>
    </section>

    <section class="section">
        <div class="timeline">
            @forelse($riwayat as $item)
                <div class="timeline-item">
                    <span class="timeline-year">{{ $item['tahun'] }}</span>
                    <h3>{{ $item['jenjang'] }}</h3>
                    <p>{{ $item['institusi'] }}</p>
                </div>
            @empty
                <p>Belum ada data riwayat pendidikan.</p>
            @endforelse
        </div>
    </section>

    <section class="section">
        <h2>Mata Kuliah yang Ditempuh</h2>
        <div class="badge-list">
            @foreach($mataKuliah as $mk)
                <span class="badge">{{ $mk }}</span>
            @endforeach
        </div>
    </section>
@endsection
