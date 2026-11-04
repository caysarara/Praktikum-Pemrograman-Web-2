@extends('layouts.portfolio')

@section('title', 'Profil Saya - Portfolio Caysa')

@section('content')
    <section class="page-header">
        <p class="eyebrow">Akun</p>
        <h1>Profil Saya</h1>
        <p class="page-lead">Halaman ini hanya bisa dibuka setelah login.</p>
    </section>

    <section class="section">
        <dl class="profile-details">
            <dt>Nama</dt>
            <dd>{{ $user->name }}</dd>

            <dt>Email</dt>
            <dd>{{ $user->email }}</dd>

            <dt>Role</dt>
            <dd><span class="badge badge-sm">{{ ucfirst($user->role) }}</span></dd>

            <dt>Terdaftar sejak</dt>
            <dd>{{ $user->created_at?->format('d M Y') }}</dd>
        </dl>

        <div class="action-group">
            <a href="{{ route('profile.edit') }}" class="btn btn-outline">Ubah Profil</a>
            @if ($user->role === 'admin')
                <a href="{{ route('projects.index') }}" class="btn btn-primary">Kelola Project</a>
            @endif
        </div>
    </section>
@endsection
