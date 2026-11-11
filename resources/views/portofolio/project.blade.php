@extends('layouts.portfolio')

@section('title', $project->nama . ' - Portfolio Caysa')

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

            <div class="detail-block">
                <h3 class="detail-label">Deskripsi</h3>
                <p class="detail-text">{{ $project->deskripsi }}</p>
            </div>

            @if (!empty($project->stack))
                <div class="detail-block">
                    <h3 class="detail-label">Teknologi / Stack</h3>
                    <div class="badge-list">
                        @foreach ($project->stack as $tech)
                            <span class="badge">{{ $tech }}</span>
                        @endforeach
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
