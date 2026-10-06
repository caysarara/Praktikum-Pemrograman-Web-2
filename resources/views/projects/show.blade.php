@extends('layouts.app')

@section('title', $project->nama . ' - Portfolio Caysa')

@section('content')
    <section class="page-header">
        <p class="eyebrow">Detail Project</p>
        <h1>{{ $project->nama }}</h1>
    </section>

    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <section class="section">
        <div class="detail-card">
            <div class="detail-block">
                <h3 class="detail-label">Deskripsi</h3>
                <p class="detail-text">{{ $project->deskripsi }}</p>
            </div>

            <div class="detail-block">
                <h3 class="detail-label">Status</h3>
                <span class="badge badge-status badge-{{ $project->status }}">{{ ucfirst($project->status) }}</span>
            </div>

            <div class="detail-block">
                <h3 class="detail-label">Teknologi / Stack</h3>
                @if (!empty($project->stack))
                    <div class="badge-list">
                        @foreach($project->stack as $tech)
                            <span class="badge">{{ $tech }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="detail-text detail-empty">Belum ada data teknologi.</p>
                @endif
            </div>
         
            <div class="detail-block">
                <div class="action-group">
                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">Edit</a>

                    <form method="POST"
                          action="{{ route('projects.destroy', $project) }}"
                          class="inline-form"
                          data-confirm="Yakin ingin menghapus project &quot;{{ $project->nama }}&quot;?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
