@extends('layouts.app')

@section('title', 'Detail Pesan - Portfolio Caysa')

@section('content')
    <a href="{{ route('post.contacts.index') }}" class="back-link"><span aria-hidden="true">&larr;</span> Kembali ke daftar pesan</a>

    <section class="page-header">
        <p class="eyebrow">Pesan</p>
        <h1>{{ $contact->subject ?: '(Tanpa subjek)' }}</h1>
    </section>

    <section class="section">
        <div class="detail-card">
            <div class="detail-block">
                <p class="detail-label">Dari</p>
                <p class="detail-text">{{ $contact->name }} &lt;{{ $contact->email }}&gt;</p>
            </div>
            <div class="detail-block">
                <p class="detail-label">Dikirim</p>
                <p class="detail-text">{{ $contact->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="detail-block">
                <p class="detail-label">Pesan</p>
                <p class="detail-text">{!! nl2br(e($contact->message)) !!}</p>
            </div>
        </div>
    </section>
@endsection
