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
        <a href="{{ route('projects.index', array_filter(['search' => $search, 'per_page' => $perPage])) }}"
           class="{{ $status === '' ? 'active' : '' }}">Semua</a>
        <a href="{{ route('projects.index', array_filter(['search' => $search, 'per_page' => $perPage, 'status' => 'published'])) }}"
           class="{{ $status === 'published' ? 'active' : '' }}">Published</a>
        <a href="{{ route('projects.index', array_filter(['search' => $search, 'per_page' => $perPage, 'status' => 'draft'])) }}"
           class="{{ $status === 'draft' ? 'active' : '' }}">Draft</a>
    </div>

    <form method="GET" action="{{ route('projects.index') }}" class="toolbar">
        @if ($status !== '')
            <input type="hidden" name="status" value="{{ $status }}">
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

        @if ($search !== '' || $status !== '')
            <a href="{{ route('projects.index') }}"
               class="btn btn-outline btn-sm">Reset</a>
        @endif
    </form>

    <p class="result-info" role="status">{{ $projects->total() }} hasil ditemukan</p>

    <section class="section">
        <div class="project-grid">
            @forelse($projects as $project)
                <article class="project-card">
                    @if ($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->nama }}" class="card-thumb">
                    @endif
                    <span class="badge badge-sm badge-status badge-{{ $project->status }}">{{ ucfirst($project->status) }}</span>
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
                     @if ($search !== '' || $status !== '')
                    <p>Tidak ada project yang cocok dengan pencarian atau filter.</p>
                    <a href="{{ route('projects.index') }}" class="btn btn-outline">Reset</a>
                    @else
                    <p>Belum ada project yang ditambahkan.</p>
                    <a href="{{ route('projects.create') }}" class="btn btn-outline">Tambah Project</a>
                    @endif
                </div>
            @endforelse
        </div>
        <div class="pagination-bar">
            <div class="pagination-info">
                Halaman : {{ $projects->currentPage() }} dari {{ $projects->lastPage() }} <br>
                Jumlah Data : {{ $projects->total() }} <br>
                Data Per Halaman : {{ $projects->perPage() }}
            </div>

            {{ $projects->links() }}
        </div>
    </section>
@endsection



@push('scripts')
    <script>console.log('Halaman projects dimuat');</script>
@endpush
