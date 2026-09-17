@extends('layouts.app')

@section('title', 'Home - Portfolio Caysa')

@section('content')
    <section class="hero">
        <p class="eyebrow">Halo, saya</p>
        <h1>Caysa Rara Kirani</h1>
        <p class="hero-role">Mahasiswa Teknologi Rekayasa Perangkat Lunak</p>
        <p class="hero-desc">
            Sedang menempuh studi di Sekolah Vokasi, Universitas Gadjah Mada.
            Belajar membangun aplikasi web dan desktop, dari sisi backend
            hingga tampilan antarmuka.
        </p>
        <div class="hero-actions">
            <a href="{{ route('projects') }}" class="btn btn-primary">Lihat Proyek</a>
            <a href="{{ route('about') }}" class="btn btn-outline">Tentang Saya</a>
        </div>
    </section>

    <section class="section">
        <h2>Jelajahi</h2>
        <div class="link-grid">
            <a href="{{ route('about') }}" class="link-card">
                <h3>About</h3>
                <p>Kenali latar belakang dan skill saya.</p>
            </a>
            <a href="{{ route('education') }}" class="link-card">
                <h3>Education</h3>
                <p>Riwayat pendidikan dan mata kuliah yang ditempuh.</p>
            </a>
            <a href="{{ route('projects') }}" class="link-card">
                <h3>Projects</h3>
                <p>Kumpulan proyek yang pernah saya kerjakan.</p>
            </a>
        </div>
    </section>
@endsection
