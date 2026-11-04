<header class="site-header">
    <nav class="navbar">
        <a href="{{ route('home') }}" class="brand">Caysa<span>.</span></a>

        <ul class="nav-links">
            <li>
                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            </li>
            <li>
                <a href="{{ route('about') }}"
                   class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            </li>
            <li>
                <a href="{{ route('education') }}"
                   class="{{ request()->routeIs('education') ? 'active' : '' }}">Education</a>
            </li>
            {{-- Menu Projects disembunyikan untuk user login non-admin (akan 403) --}}
            @if (! Auth::check() || Auth::user()->role === 'admin')
            <li>
                <a href="{{ route('projects.index') }}"
                   class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">Projects</a>
            </li>
            @endif
        </ul>

        <div class="nav-auth">
            @auth
                <a href="{{ route('profile.saya') }}"
                   class="nav-user {{ request()->routeIs('profile.saya') ? 'active' : '' }}">
                    Halo, {{ Auth::user()->name }}
                </a>

                {{-- Logout wajib POST + CSRF --}}
                <form method="POST" action="{{ route('logout') }}" class="inline-form">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
            @endauth
        </div>

    </nav>
</header>
  