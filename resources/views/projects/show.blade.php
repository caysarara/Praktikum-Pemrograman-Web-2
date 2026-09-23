@extends('layouts.app')

@section('title', $project->nama . ' - Portfolio Caysa')

@section('content')
    <section class="page-header">
        <p class="eyebrow">Detail Project</p>
        <h1>{{ $project->nama }}</h1>
    </section>

    <section class="section">
        <div class="detail-card">
            <div class="detail-block">
                <h3 class="detail-label">Deskripsi</h3>
                <p class="detail-text">{{ $project->deskripsi }}</p>
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
        </div>
    </section>
@endsection
