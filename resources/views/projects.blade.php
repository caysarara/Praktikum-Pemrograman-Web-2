@extends('layouts.portfolio')

@section('title', 'Projects - Portfolio Caysa')

@section('content')
    <section class="page-header">
        <p class="eyebrow">Portofolio</p>
        <h1>Projects</h1>
    </section>

        <form method="GET" action="{{ route('portfolio.projects') }}" class="toolbar" role="search">
        <input type="search" name="search" value="{{ $search }}"
               class="form-control toolbar-search" placeholder="Cari project..."
               aria-label="Cari project">

        <select name="category" class="form-control toolbar-select" aria-label="Filter kategori">
            <option value="">Semua kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c->slug }}" @selected($category === $c->slug)>{{ $c->name }}</option>
            @endforeach
        </select>

        <select name="sort" class="form-control toolbar-select" aria-label="Urutkan">
            <option value="terbaru" @selected($sort === 'terbaru')>Terbaru</option>
            <option value="terlama" @selected($sort === 'terlama')>Terlama</option>
            <option value="judul" @selected($sort === 'judul')>Judul A-Z</option>
        </select>

        <button type="submit" class="btn btn-primary btn-sm">Cari</button>

    </form>

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
                    <p>{{ $project->short_description ?: \Illuminate\Support\Str::limit($project->deskripsi, 120) }}</p>

                    @php($techNames = $project->technologyNames())
                    @if ($techNames->isNotEmpty())
                        <div class="badge-list">
                            @foreach ($techNames as $tech)
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
                <div class="empty-state">
                    <p>Tidak ada project yang ditemukan.</p>
                </div>
            @endforelse
            {{ $projects->links() }}
        </div>
    </section>
@endsection

@push('scripts')
    <script>console.log('Halaman projects dimuat');</script>
@endpush
