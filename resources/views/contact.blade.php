@extends('layouts.portfolio')

@section('title', 'Kontak - Portfolio Caysa')

@section('content')
    <section class="page-header">
        <p class="eyebrow">Kontak</p>
        <h1>Hubungi Saya</h1>
    </section>

    <section class="section">
        <div class="form-card">
            @if (session('success'))
                <div class="alert alert-success" role="status">{{ session('success') }}</div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nama <span class="req" aria-hidden="true">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email <span class="req" aria-hidden="true">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subject" class="form-label">Subjek</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                           class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}">
                    @error('subject')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="message" class="form-label">Pesan <span class="req" aria-hidden="true">*</span></label>
                    <textarea name="message" id="message" rows="5"
                              class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
