@extends('layouts.portfolio')

@section('title', 'Tambah Skill - Portfolio Caysa')

@section('content')
    <a href="{{ route('skills.index') }}" class="back-link"><span aria-hidden="true">&larr;</span> Kembali ke daftar skill</a>

    <section class="page-header">
        <p class="eyebrow">Portfolio</p>
        <h1>Tambah Skill</h1>
    </section>

    <section class="section">
        <div class="form-card">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    Data belum bisa disimpan. Periksa kembali isian di bawah.
                </div>
            @endif

            <form method="POST" action="{{ route('skills.store') }}">
                @csrf
                

                <div class="form-group">
                    <label for="name" class="form-label">Nama Skill <span class="req" aria-hidden="true">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="level" class="form-label">Level (0-100) <span class="req" aria-hidden="true">*</span></label>
                    <input type="number" id="level" name="level" min="0" max="100" value="{{ old('level', 50) }}"
                           class="form-control {{ $errors->has('level') ? 'is-invalid' : '' }}">
                    @error('level')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Skill</button>
                    <a href="{{ route('skills.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </section>
@endsection
