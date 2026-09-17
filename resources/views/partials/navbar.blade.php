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
            <li>
                <a href="{{ route('projects') }}"
                   class="{{ request()->routeIs('projects') ? 'active' : '' }}">Projects</a>
            </li>
        </ul>
    </nav>
</header>
