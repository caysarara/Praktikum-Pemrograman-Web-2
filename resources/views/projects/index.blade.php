@extends('layouts.app')

@section('title', 'Projects - Portfolio Caysa')

@section('content')
    <section class="page-header page-header-row">
        <div>
            <p class="eyebrow">Portfolio</p>
            <h1>Projects</h1>
            <p class="page-lead">Kumpulan proyek yang pernah saya kerjakan.</p>
        </div>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">Tambah Project</a>
    </section>

    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <section class="section">
        <div class="project-grid">
            @forelse($projects as $project)
                <article class="project-card">
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
                        <div class="card-actions">
                            <a href="{{ route('projects.show', $project) }}" class="card-link">
                                Lihat Detail<span aria-hidden="true">&rarr;</span>
                            </a>
                           
                            <div class="action-group">
                                <a href="{{ route('projects.edit', $project) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form method="POST" action="{{ route('projects.destroy', $project) }}" class="inline-form" data-confirm="Apakah Anda yakin ingin menghapus proyek ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <p>Belum ada data proyek.</p>
                    <a href="{{ route('projects.create') }}" class="btn btn-outline">Tambah Project</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection

@push('scripts')
    <script>console.log('Halaman projects dimuat');</script>
@endpush
