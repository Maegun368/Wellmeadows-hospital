<aside class="wm-sidebar" x-data="{ open: false }">

    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="wm-brand">
        <img
            src="{{ asset('images/wellmeadows-logo.png') }}"
            alt="Wellmeadows"
            class="wm-logo-img"
        >
        <div>
            <div class="wm-logo-name">Wellmeadows</div>
            <div class="wm-logo-sub">HOSPITAL</div>
        </div>
    </a>

    {{-- Navigation Links --}}
    <nav class="wm-nav">

        <a href="{{ route('dashboard') }}"
           class="wm-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>

        <a href="{{ route('patients.index') }}"
           class="wm-nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Patients
        </a>

        <a href="{{ route('appointments.index') }}"
           class="wm-nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Appointments
        </a>

        <a href="{{ route('staff.index') }}"
           class="wm-nav-link {{ request()->routeIs('staff.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="7" r="4"/><path d="M2 21c0-3.3 3.1-6 7-6"/><circle cx="17" cy="15" r="4"/><path d="M15 13v4M13 15h4"/></svg>
            Staff
        </a>

        <a href="{{ route('wards.index') }}"
           class="wm-nav-link {{ request()->routeIs('wards.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M3 10h18M3 10V20a1 1 0 001 1h16a1 1 0 001-1V10M3 10l2-7h14l2 7"/><path d="M10 15h4"/></svg>
            Ward & Bed Management
        </a>

    </nav>

    {{-- Profile Controller --}}
    <div class="wm-profile" x-data="{ profileOpen: false }">
        <button @click="profileOpen = !profileOpen" class="wm-profile-trigger">
            <div class="wm-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(strstr(Auth::user()->name, ' '), 1, 1)) }}
            </div>
            <div class="wm-profile-info">
                <div class="wm-profile-name">{{ Auth::user()->name }}</div>
                <div class="wm-profile-role">{{ Auth::user()->email }}</div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="wm-profile-caret" :class="{ 'rotate-180': profileOpen }"><path d="M6 9l6 6 6-6"/></svg>
        </button>

        {{-- Dropdown --}}
        <div x-show="profileOpen"
             @click.outside="profileOpen = false"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="wm-profile-dropdown">
            <a href="{{ route('profile.edit') }}" class="wm-dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="wm-dropdown-item wm-dropdown-logout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/></svg>
                    Log Out
                </button>
            </form>
        </div>
    </div>

</aside>