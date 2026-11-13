@extends('layouts.app')

@section('title', 'Edit ' . $project->nama . ' - Portfolio Caysa')

@section('content')
    <a href="{{ route('projects.show', $project) }}" class="back-link"><span aria-hidden="true">&larr;</span> Kembali ke detail project</a>

    <section class="page-header">
        <p class="eyebrow">Portfolio</p>
        <h1>Edit Project</h1>
        <p class="page-lead">Ubah data project lalu simpan perubahannya.</p>
    </section>

    <section class="section">
        <div class="form-card">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    Data belum bisa disimpan. Periksa kembali isian di bawah.
                </div>
            @endif

            <form method="POST" action="{{ route('projects.update', $project) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama" class="form-label">Nama Project <span class="req" aria-hidden="true">*</span></label>
                    <input type="text" id="nama" name="nama"
                           value="{{ old('nama', $project->nama) }}"
                           class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: Dungeon Battle: Rise of Hero">
                    @error('nama')
                        <p class="form-error">{{ $message }}</p>
                    @else
                        <p class="form-hint">Minimal 5 karakter.</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi" class="form-label">Deskripsi <span class="req" aria-hidden="true">*</span></label>
                    <textarea id="deskripsi" name="deskripsi" rows="5"
                              class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                              placeholder="Jelaskan project ini secara singkat">{{ old('deskripsi', $project->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="form-error">{{ $message }}</p>
                    @else
                        <p class="form-hint">Minimal 10 karakter.</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="short_description" class="form-label">Deskripsi Singkat</label>
                    <input type="text" id="short_description" name="short_description" maxlength="255"
                           value="{{ old('short_description', $project->short_description) }}"
                           class="form-control {{ $errors->has('short_description') ? 'is-invalid' : '' }}"
                           placeholder="Ringkasan satu kalimat untuk kartu project">
                    @error('short_description')
                        <p class="form-error">{{ $message }}</p>
                    @else
                        <p class="form-hint">Tampil di kartu project dan meta description. Maksimal 255 karakter.</p>
                    @enderror
                </div>

                <div class="form-group">
                    <span class="form-label">Technologies</span>
                    <div class="check-grid">
                        @forelse ($technologies as $technology)
                            <label class="check-item">
                                <input type="checkbox" name="technologies[]" value="{{ $technology->id }}"
                                       @checked(in_array($technology->id, $errors->any() ? old('technologies', []) : $project->technologies->pluck('id')->all()))>
                                {{ $technology->name }}
                            </label>
                        @empty
                            <p class="form-hint">Belum ada data technology.</p>
                        @endforelse
                    </div>
                    @error('technologies')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                    @error('technologies.*')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select id="category_id" name="category_id"
                            class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) old('category_id', $project->category_id) === (string) $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status <span class="req" aria-hidden="true">*</span></label>
                    <select id="status" name="status"
                            class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <option value="draft" {{ old('status', $project->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $project->status) === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="project_date" class="form-label">Tanggal Project</label>
                    <input type="date" id="project_date" name="project_date"
                           value="{{ old('project_date', $project->project_date?->format('Y-m-d')) }}"
                           class="form-control {{ $errors->has('project_date') ? 'is-invalid' : '' }}">
                    @error('project_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="project_url" class="form-label">URL Project</label>
                    <input type="url" id="project_url" name="project_url"
                           value="{{ old('project_url', $project->project_url) }}"
                           class="form-control {{ $errors->has('project_url') ? 'is-invalid' : '' }}"
                           placeholder="https://contoh.com">
                    @error('project_url')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="repository_url" class="form-label">URL Repository</label>
                    <input type="url" id="repository_url" name="repository_url"
                           value="{{ old('repository_url', $project->repository_url) }}"
                           class="form-control {{ $errors->has('repository_url') ? 'is-invalid' : '' }}"
                           placeholder="https://github.com/user/repo">
                    @error('repository_url')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="check-item">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1" @checked((bool) old('is_featured', $project->is_featured))>
                        Tampilkan sebagai project unggulan
                    </label>
                </div>

                <div class="form-group">
                    <label for="thumbnail" class="form-label">Thumbnail</label>
                    @if ($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}"
                             alt="Thumbnail {{ $project->nama }}" class="thumb-preview">
                    @endif
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/jpeg,image/png,image/webp"
                           class="form-control {{ $errors->has('thumbnail') ? 'is-invalid' : '' }}">
                    @error('thumbnail')
                        <p class="form-error">{{ $message }}</p>
                    @else
                        <p class="form-hint">Kosongkan jika tidak ingin mengganti. JPG, PNG, atau WEBP. Maksimal 2 MB, minimal 400 x 300 px.</p>
                    @enderror
                </div>


                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </section>

    <section class="section">
        <div class="form-card">
            <h2 class="gallery-title">Gallery ({{ $project->images->count() }}/{{ \App\Models\Project::MAX_GALLERY_IMAGES }})</h2>

            @if (session('success'))
                <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('projects.images.store', $project) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="images" class="form-label">Tambah gambar</label>
                    <input type="file" id="images" name="images[]" multiple accept="image/jpeg,image/png,image/webp"
                           class="form-control {{ $errors->has('images') || $errors->has('images.*') ? 'is-invalid' : '' }}">
                    @error('images')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                    @foreach ($errors->get('images.*') as $messages)
                        @foreach ($messages as $message)
                            <p class="form-error">{{ $message }}</p>
                        @endforeach
                    @endforeach
                    <p class="form-hint">Bisa pilih banyak file. JPG, PNG, atau WEBP, maksimal 4 MB per gambar, lebar minimal 800 px. Maksimal {{ \App\Models\Project::MAX_GALLERY_IMAGES }} gambar per project.</p>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Unggah</button>
            </form>

            @if ($project->images->isNotEmpty())
                <div class="gallery-grid">
                    @foreach ($project->images as $img)
                        <figure class="gallery-item">
                            <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->caption ?: $project->nama }}">

                            <form method="POST" action="{{ route('projects.images.update', [$project, $img]) }}" class="caption-form">
                                @csrf
                                @method('PUT')
                                <input type="text" name="caption" value="{{ $img->caption }}" maxlength="255"
                                       class="form-control" placeholder="Caption (opsional)"
                                       aria-label="Caption gambar {{ $loop->iteration }}">
                                <button type="submit" class="btn btn-outline btn-sm">Simpan</button>
                            </form>

                            <form method="POST" action="{{ route('projects.images.destroy', [$project, $img]) }}"
                                  class="inline-form" data-confirm="Hapus gambar ini?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </figure>
                    @endforeach
                </div>
            @else
                <p class="form-hint">Belum ada gambar gallery.</p>
            @endif
        </div>
    </section>

@endsection
