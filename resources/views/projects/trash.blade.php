@extends('layouts.app')

@section('title', 'Trash Projects - Portfolio Caysa')

@section('content')
    <a href="{{ route('projects.index') }}" class="back-link"><span aria-hidden="true">&larr;</span> Kembali ke daftar project</a>

    <section class="page-header">
        <p class="eyebrow">Portfolio</p>
        <h1>Trash</h1>
        <p class="page-lead">Project yang sudah dihapus. Pulihkan atau hapus permanen.</p>
    </section>

    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <section class="section">
        <div class="project-grid">
            @forelse($projects as $project)
                <article class="project-card">
                    <span class="badge badge-sm badge-status badge-{{ $project->status }}">{{ ucfirst($project->status) }}</span>
                    <h3>{{ $project->nama }}</h3>
                    <p>{{ $project->deskripsi }}</p>

                    <div class="card-footer">
                        <p class="trash-meta">Dihapus: {{ $project->deleted_at->format('d M Y, H:i') }}</p>

                        <div class="action-group">
                            <form method="POST" action="{{ route('projects.restore', $project->id) }}" class="inline-form">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline btn-sm">Restore</button>
                            </form>

                            <form method="POST" action="{{ route('projects.force-delete', $project->id) }}" class="inline-form"
                                  data-confirm="Hapus permanen project &quot;{{ $project->nama }}&quot;? Data tidak bisa dikembalikan.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus Permanen</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <p>Trash kosong.</p>
                    <a href="{{ route('projects.index') }}" class="btn btn-outline">Kembali</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
