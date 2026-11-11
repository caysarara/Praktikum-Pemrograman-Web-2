@extends('layouts.portfolio')

@section('title', 'Projects - Portfolio Caysa')

@section('content')
    <section class="page-header">
        <p class="eyebrow">Portfolio</p>
        <h1>Projects</h1>
    </section>

    <section class="section">
        <div class="project-grid">
            @forelse($projects as $project)
                <article class="project-card">
                    @if ($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->nama }}" class="card-thumb">
                    @endif

                    @if ($project->category)
                        <span class="badge badge-sm">{{ $project->category->name }}</span>
                    @endif
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
                        <a href="{{ route('portfolio.projects.show', $project) }}" class="card-link">
                            Lihat Detail<span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </article>
            @empty
                <p>Belum ada data proyek.</p>
            @endforelse
        </div>
    </section>
@endsection

@push('scripts')
    <script>console.log('Halaman projects dimuat');</script>
@endpush
