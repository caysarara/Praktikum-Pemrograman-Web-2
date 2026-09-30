@extends('layouts.app')

@section('title', 'Tambah Project - Portfolio Caysa')

@section('content')
    <section class="page-header">
        <p class="eyebrow">Portfolio</p>
        <h1>Tambah Project</h1>
        <p class="page-lead">Isi form di bawah untuk menambahkan project baru ke portfolio.</p>
    </section>

    <section class="section">
        <div class="form-card">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    Data belum bisa disimpan. Periksa kembali isian di bawah.
                </div>
            @endif

            <form method="POST" action="{{ route('projects.store') }}">
                @csrf

                <div class="form-group">
                    <label for="nama" class="form-label">Nama Project <span class="req" 
                    aria-hidden="true">*</label>
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
                    <label for="deskripsi" class="form-label">Deskripsi <span class="req" 
                    aria-hidden="true">*</span></label>
                    <textarea id="deskripsi" name="deskripsi" rows="5"
                              class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                              placeholder="Jelaskan project ini secara singkat">{{ old('deskripsi') }}
                            </textarea>
                    @error('deskripsi')
                        <p class="form-error" id="deskripsi-error">{{ $message }}</p>
                    @else
                        <p class="form-hint" id="deskripsi-hint">Minimal 10 karakter.</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stack" class="form-label">Stack / Teknologi</label>
                    <input type="text" id="stack" name="stack"
                           value="{{ old('stack') }}"
                           class="form-control {{ $errors->has('stack') ? 'is-invalid' : '' }}"
                           placeholder="Java, Java Swing"
                           aria-describedby="stack-hint @error('stack') stack-error @enderror" 
                           @error('stack') aria-invalid="true" @enderror>
                    <p class="form-hint">Pisahkan tiap teknologi dengan koma. Boleh dikosongkan.</p>
                    @error('stack')
                        <p class="form-error">{{ $message }}</p>
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
