@extends('layouts.portfolio')

@section('title', $project->nama . ' - Portfolio Caysa')
@section('meta_description', $project->short_description ?: \Illuminate\Support\Str::limit($project->deskripsi, 150))

@section('content')
    <a href="{{ route('portfolio.projects') }}" class="back-link"><span aria-hidden="true">&larr;</span> Kembali ke daftar project</a>

    <section class="page-header">
        <p class="eyebrow">{{ $project->category?->name ?? 'Detail Project' }}</p>
        <h1>{{ $project->nama }}</h1>
    </section>

    <section class="section">
        <div class="detail-card">
            @if ($project->thumbnail)
                <div class="detail-block">
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->nama }}" class="detail-thumb">
                </div>
            @endif

            @if ($project->short_description)
                <div class="detail-block">
                    <p class="detail-text">{{ $project->short_description }}</p>
                </div>
            @endif

            <div class="detail-block">
                <h3 class="detail-label">Deskripsi</h3>
                <p class="detail-text">{{ $project->deskripsi }}</p>
            </div>

            @if ($project->project_date)
                <div class="detail-block">
                    <h3 class="detail-label">Tanggal Project</h3>
                    <p class="detail-text">{{ $project->project_date->Format('d F Y') }}</p>
                </div>
            @endif

            @php($techNames = $project->technologyNames())
            @if ($techNames->isNotEmpty())
                <div class="detail-block">
                    <h3 class="detail-label">Teknologi / Stack</h3>
                    <div class="badge-list">
                        @foreach ($techNames as $tech)
                            <span class="badge">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($project->project_url || $project->repository_url)
                <div class="detail-block">
                    <div class="action-group">
                        @if ($project->project_url)
                            <a href="{{ $project->project_url }}" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Lihat Project</a>
                        @endif
                        @if ($project->repository_url)
                            <a href="{{ $project->repository_url }}" class="btn btn-outline" target="_blank" rel="noopener noreferrer">Repository</a>
                        @endif
                    </div>
                </div>
            @endif


            @if ($project->images->isNotEmpty())
                <div class="detail-block">
                    <h3 class="detail-label">Gallery</h3>
                    <div class="gallery-grid">
                        @foreach ($project->images as $img)
                            <figure class="gallery-item">
                                <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->caption ?: $project->nama }}">
                                @if ($img->caption)
                                    <figcaption>{{ $img->caption }}</figcaption>
                                @endif
                            </figure>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
