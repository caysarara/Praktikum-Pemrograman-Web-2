@extends('layouts.app')

@section('title', 'Projects - Portfolio Caysa')

@section('content')
    <section class="page-header page-header-row">
        <div>
            <p class="eyebrow">Portofolio</p>
            <h1>Projects</h1>
            <p class="page-lead">Kumpulan proyek yang pernah saya kerjakan.</p>
        </div>
         <div class="action-group">
            <a href="{{ route('projects.trash') }}" class="btn btn-outline">Trash ({{ $trashedCount }})</a>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">Tambah Project</a>
        </div>
    </section>

    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <div class="filter-tabs">
        <a href="{{ route('projects.index', request()->only(['search', 'per_page'])) }}"
           class="{{ request('status') !== 'published' ? 'active' : '' }}">Semua</a>
        <a href="{{ route('projects.index', array_merge(request()->only(['search', 'per_page']), ['status' => 'published'])) }}"
           class="{{ request('status') === 'published' ? 'active' : '' }}">Published</a>
    </div>

    <form method="GET" action="{{ route('projects.index') }}" class="toolbar">
        @if (request('status') === 'published')
            <input type="hidden" name="status" value="published">
        @endif

        <input type="search" name="search" value="{{ $search }}"
               class="form-control toolbar-search" placeholder="Cari judul project..."
               aria-label="Cari judul project">

        <select name="per_page" class="form-control toolbar-select"
                aria-label="Jumlah data per halaman" onchange="this.form.submit()">
            @foreach ([5, 10, 25] as $size)
                <option value="{{ $size }}" @selected($perPage === $size)>{{ $size }} per halaman</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary btn-sm">Cari</button>

        @if ($search !== '')
            <a href="{{ route('projects.index', array_filter(['status' => request('status'), 'per_page' => $perPage])) }}"
               class="btn btn-outline btn-sm">Reset</a>
        @endif
    </form>

    <section class="section">
        <div class="project-grid">
            @forelse($projects as $project)
                <article class="project-card">
                    <span class="badge badge-sm badge-status badge-{{ $project->status }}">{{ ucfirst($project->status) }}</span>
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

        <div class="pagination-info">
            Halaman : {{ $projects->currentPage() }} dari {{ $projects->lastPage() }} <br>
            Jumlah Data : {{ $projects->total() }} <br>
            Data Per Halaman : {{ $projects->perPage() }}
        </div>

        {{ $projects->links() }}
    </section>
@endsection



@push('scripts')
    <script>console.log('Halaman projects dimuat');</script>
@endpush
