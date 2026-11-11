@extends('layouts.app')

@section('title', 'Skills - Portfolio Caysa')

@section('content')
    <section class="page-header page-header-row">
        <div>
            <p class="eyebrow">Portfolio</p>
            <h1>Skills</h1>
            <p class="page-lead">Kelola daftar skill dan levelnya (0-100).</p>
        </div>
        <div class="action-group">
            <a href="{{ route('post.dashboard.index') }}" class="btn btn-outline">Dashboard</a>
            <a href="{{ route('skills.create') }}" class="btn btn-primary">Tambah Skill</a>
        </div>
    </section>

    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <section class="section">
        <div class="project-grid">
            @forelse ($skills as $skill)
                <article class="project-card">
                    <h3>{{ $skill->name }}</h3>
                    <p>Level: {{ $skill->level }}%</p>
                    <div class="card-footer">
                        <div class="action-group">
                            <a href="{{ route('skills.edit', $skill) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form method="POST" action="{{ route('skills.destroy', $skill) }}" class="inline-form"
                                  data-confirm="Hapus skill &quot;{{ $skill->name }}&quot;?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <p>Belum ada skill.</p>
                    <a href="{{ route('skills.create') }}" class="btn btn-outline">Tambah Skill</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
