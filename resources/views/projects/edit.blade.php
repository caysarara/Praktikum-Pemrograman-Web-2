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

            <form method="POST" action="{{ route('projects.update', $project) }}">
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
                    <label for="stack" class="form-label">Stack / Teknologi</label>
                    <input type="text" id="stack" name="stack"
                           value="{{ old('stack', implode(', ', $project->stack ?? [])) }}"
                           class="form-control {{ $errors->has('stack') ? 'is-invalid' : '' }}"
                           placeholder="Java, Java Swing">
                    @error('stack')
                        <p class="form-error">{{ $message }}</p>
                    @else
                        <p class="form-hint">Pisahkan tiap teknologi dengan koma. Boleh dikosongkan.</p>
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

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </section>
@endsection
