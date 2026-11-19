@extends('layouts.app')

@section('title', 'Messages - Portfolio Caysa')

@section('content')
    <section class="page-header page-header-row">
        <div>
            <p class="eyebrow">Portfolio</p>
            <h1>Messages</h1>
            <p class="page-lead">Pesan masuk dari form contact.</p>
        </div>
        <div class="action-group">
            <a href="{{ route('post.dashboard.index') }}" class="btn btn-outline">Dashboard</a>
        </div>
    </section>

    <section class="section">
        <div class="project-grid">
            @forelse ($contacts as $contact)
                <article class="project-card">
                    @if ($contact->is_read)
                        <span class="badge badge-sm">Sudah dibaca</span>
                    @else
                        <span class="badge badge-sm badge-status badge-draft">Belum dibaca</span>
                    @endif

                    <h3>{{ $contact->subject ?: '(Tanpa subjek)' }}</h3>
                    <p>{{ $contact->name }} &middot; {{ $contact->email }}</p>

                    <div class="card-footer">
                        <p class="trash-meta">{{ $contact->created_at->format('d M Y, H:i') }}</p>
                        <a href="{{ route('post.contacts.show', $contact) }}" class="card-link">
                            Buka<span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <p>Belum ada pesan masuk.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $contacts->links() }}
        </div>
    </section>
@endsection
