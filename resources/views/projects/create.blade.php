@extends('layouts.app')

@section('title', 'Tambah Project - Portfolio Caysa')

@section('content')
    <section class="page-header">
        <p class="eyebrow">Portfolio</p>
        <h1>Tambah Project</h1>
        <p class="page-lead">Isi form di bawah untuk menambahkan project baru ke portofolio.</p>
    </section>

    <section class="section">
        <div class="form-card">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    Data belum bisa disimpan. Periksa kembali isian di bawah.
                </div>
            @endif

            <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama" class="form-label">Nama Project <span class="req" aria-hidden="true">*</span></label>
                    <input type="text" id="nama" name="nama"
                           value="{{ old('nama') }}"
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
                              placeholder="Jelaskan project ini secara singkat">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="form-error" id="deskripsi-error">{{ $message }}</p>
                    @else
                        <p class="form-hint" id="deskripsi-hint">Minimal 10 karakter.</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="short_description" class="form-label">Deskripsi Singkat</label>
                    <input type="text" id="short_description" name="short_description" maxlength="255"
                           value="{{ old('short_description') }}"
                           class="form-control {{ $errors->has('short_description') ? 'is-invalid' : '' }}"
                           placeholder="Ringkasan satu kalimat untuk kartu project">
                    @error('short_description')
                        <p class="form-error">{{ $message }}</p>
                    @else
                        <p class="form-hint">Tampil di kartu project dan meta description. Maksimal 255 karakter.</p>
                    @enderror
                </div>

                div class="form-group">
                    <span class="form-label">Technologies</span>
                    <div class="check-grid">
                        @forelse ($technologies as $technology)
                            <label class="check-item">
                                <input type="checkbox" name="technologies[]" value="{{ $technology->id }}"
                                       @checked(in_array($technology->id, old('technologies', [])))>
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
                            <option value="{{ $category->id }}" @selected((string) old('category_id', null) === (string) $category->id)>{{ $category->name }}</option>
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
                        <option value="draft" {{ old('status', 'published') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="project_date" class="form-label">Tanggal Project</label>
                    <input type="date" id="project_date" name="project_date"
                           value="{{ old('project_date') }}"
                           class="form-control {{ $errors->has('project_date') ? 'is-invalid' : '' }}">
                    @error('project_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror  
                </div>

                <div class="form-group">
                    <label for="project_url" class="form-label">URL Project</label>
                    <input type="url" id="project_url" name="project_url"
                           value="{{ old('project_url') }}"
                           class="form-control {{ $errors->has('project_url') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: https://example.com">
                    @error('project_url')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="repository_url" class="form-label">URL Repository</label>
                    <input type="url" id="repository_url" name="repository_url"
                           value="{{ old('repository_url') }}"
                           class="form-control {{ $errors->has('repository_url') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: https://github.com/user/repo">
                    @error('repository_url')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="check-item">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1" @checked((bool) old('is_featured'))>
                        Tampilkan sebagai project unggulan
                    </label>
                </div>

                <div class="form-group">
                    <label for="thumbnail" class="form-label">Thumbnail</label>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/jpeg,image/png,image/webp"
                           class="form-control {{ $errors->has('thumbnail') ? 'is-invalid' : '' }}">
                    @error('thumbnail')
                        <p class="form-error">{{ $message }}</p>
                    @else
                        <p class="form-hint">Opsional. JPG, PNG, atau WEBP. Maksimal 2 MB, minimal 400 x 300 px.</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Project</button>
                    <a href="{{ route('projects.index') }}" class="btn btn-outline">Kembali</a>
                </div>
            </form>
        </div>
    </section>
@endsection
