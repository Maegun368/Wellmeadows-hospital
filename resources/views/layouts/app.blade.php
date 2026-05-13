<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellmeadows Hospital</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Sergio', sans-serif;
            background: #f0f4f8;
            display: flex;
            min-height: 100vh;
        }

        /* ══════════════════════════════════
           SIDEBAR
        ══════════════════════════════════ */

        .sidebar {
            width: 230px;
            min-width: 230px;
            background: #1a3a5c;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 50;
        }

        /* ── Logo ── */
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 18px 16px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.09);
            flex-shrink: 0;
            text-decoration: none;
        }

        .sidebar-logo img {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .logo-text-wrap {
            display: flex;
            flex-direction: column;
        }

        .logo-name {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            line-height: 1.25;
        }

        .logo-sub {
            font-size: 9.5px;
            color: rgba(255,255,255,0.4);
            letter-spacing: 1px;
            font-weight: 500;
        }

        /* ── Nav items ── */
        .nav-links {
            flex: 1;
            padding: 10px 8px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13px;
            color: rgba(255,255,255,0.58);
            text-decoration: none;
            position: relative;
            transition: background 0.18s ease,
                        color 0.18s ease,
                        transform 0.12s ease;
        }

        .nav-item svg {
            flex-shrink: 0;
            opacity: 0.65;
            transition: opacity 0.18s ease;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.09);
            color: #fff;
            transform: translateX(3px);
        }

        .nav-item:hover svg {
            opacity: 1;
        }

        .nav-item.active {
            background: #1e4fa0;
            color: #fff;
            font-weight: 500;
        }

        .nav-item.active svg {
            opacity: 1;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 22%;
            bottom: 22%;
            width: 3px;
            background: #7ab8f5;
            border-radius: 0 3px 3px 0;
        }

        /* ── Profile controller ── */
        .sidebar-profile {
            border-top: 1px solid rgba(255,255,255,0.09);
            padding: 10px 8px;
            flex-shrink: 0;
            position: relative;
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 8px 10px;
            border-radius: 8px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: background 0.18s ease;
            text-align: left;
        }

        .profile-trigger:hover {
            background: rgba(255,255,255,0.07);
        }

        .profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2e7dd1, #4a9ff5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: #fff;
            flex-shrink: 0;
        }

        .profile-info {
            flex: 1;
            min-width: 0;
        }

        .profile-name {
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-role {
            color: rgba(255,255,255,0.38);
            font-size: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-caret {
            color: rgba(255,255,255,0.35);
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .profile-caret.open {
            transform: rotate(180deg);
        }

        /* ── Profile dropdown (pops upward) ── */
        .profile-dropdown {
            display: none;
            position: absolute;
            bottom: calc(100% + 4px);
            left: 8px;
            right: 8px;
            background: #1e3556;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            overflow: hidden;
            z-index: 100;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.25);
        }

        .profile-dropdown.open {
            display: block;
            animation: dropUp 0.15s ease;
        }

        @keyframes dropUp {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 10px 14px;
            color: rgba(255,255,255,0.7);
            font-size: 13px;
            text-decoration: none;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
            font-family: 'Segoe UI', sans-serif;
            text-align: left;
        }

        .dropdown-item:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .dropdown-item.logout {
            border-top: 1px solid rgba(255,255,255,0.07);
            color: rgba(255, 110, 110, 0.8);
        }

        .dropdown-item.logout:hover {
            background: rgba(255,80,80,0.09);
            color: #ff7b7b;
        }

        .sidebar-footer {
            padding: 8px 16px 12px;
            font-size: 10.5px;
            color: rgba(255,255,255,0.25);
            text-align: center;
            letter-spacing: 0.3px;
        }

        /* ══════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════ */

        .main {
            margin-left: 230px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .content {
            padding: 0;
            width: 100%;
        }

        /* ══════════════════════════════════
           SHARED COMPONENTS (unchanged)
        ══════════════════════════════════ */

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            border: 1px solid #cbd5e0;
            background: #fff;
            color: #2d3748;
            text-decoration: none;
        }

        .btn-primary {
            background: #1a3a5c;
            color: #fff;
            border-color: #1a3a5c;
        }

        .btn-danger {
            background: #fff;
            color: #e53e3e;
            border-color: #e53e3e;
        }

        .btn:hover { opacity: 0.85; }

        .card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a3a5c;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th {
            text-align: left;
            padding: 10px 12px;
            background: #f7fafc;
            color: #718096;
            font-weight: 500;
            border-bottom: 1px solid #e2e8f0;
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid #f0f4f8;
            color: #2d3748;
        }

        tr:hover td { background: #f7fafc; }

        .badge {
            display: inline-block;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 500;
        }

        .badge-green  { background: #e1f5ee; color: #085041; }
        .badge-amber  { background: #faeeda; color: #633806; }
        .badge-red    { background: #fcebeb; color: #501313; }

        .form-group { margin-bottom: 1rem; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 4px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e0;
            font-size: 13px;
            color: #2d3748;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 1rem;
        }

        .alert-success { background: #e1f5ee; color: #085041; }
        .alert-error   { background: #fcebeb; color: #501313; }

        .toast-success {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #22C55E;
            color: white;
            padding: 16px 22px;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            z-index: 9999;
            animation: slideIn .4s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(100%); }
            to   { opacity: 1; transform: translateX(0); }
        }

    </style>
</head>

<body>

    <!-- ═══════════════════════════════════
         SIDEBAR
    ════════════════════════════════════ -->
    <div class="sidebar">

        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('image/wellmeadows-logo.png') }}" alt="Wellmeadows Hospital">
            <div class="logo-text-wrap">
                <span class="logo-name">Wellmeadows</span>
                <span class="logo-sub">HOSPITAL</span>
            </div>
        </a>

        {{-- Nav Links --}}
        <div class="nav-links">

            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('patients.index') }}"
               class="nav-item {{ request()->routeIs('patients*') ? 'active' : '' }}">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
                Patients
            </a>

            <a href="{{ route('appointments.index') }}"
               class="nav-item {{ request()->routeIs('appointments*') ? 'active' : '' }}">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                Appointments
            </a>

            <a href="{{ route('staff.index') }}"
               class="nav-item {{ request()->routeIs('staff*') ? 'active' : '' }}">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M2 21c0-3.3 3.1-6 7-6"/>
                    <circle cx="17" cy="15" r="4"/>
                    <path d="M15 13v4M13 15h4"/>
                </svg>
                Staff
            </a>

            <a href="{{ route('wards.index') }}"
               class="nav-item {{ request()->routeIs('wards*') ? 'active' : '' }}">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path d="M3 10h18M3 10V20a1 1 0 001 1h16a1 1 0 001-1V10M3 10l2-7h14l2 7"/>
                    <path d="M10 15h4"/>
                </svg>
                Ward & Bed Management
            </a>

        </div>

        {{-- Profile Controller --}}
        <div class="sidebar-profile">

            {{-- Dropdown (pops upward) --}}
            <div class="profile-dropdown" id="profileDropdown">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item logout">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>

            {{-- Trigger button --}}
            <button class="profile-trigger" id="profileTrigger" onclick="toggleProfile()">
                <div class="profile-avatar" id="profileAvatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(strstr(Auth::user()->name ?? '', ' '), 1, 1)) }}
                </div>
                <div class="profile-info">
                    <div class="profile-name">{{ Auth::user()->name ?? 'User' }}</div>
                    <div class="profile-role">{{ Auth::user()->email ?? '' }}</div>
                </div>
                <svg class="profile-caret" id="profileCaret" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M6 9l6 6 6-6"/>
                </svg>
            </button>

        </div>

    </div>

    <!-- ═══════════════════════════════════
         MAIN CONTENT
    ════════════════════════════════════ -->
    <div class="main">
        <div class="content">

            @if(session('success'))
                <div id="toast-success" class="toast-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>
    </div>

    <script>

        /* ── Profile dropdown toggle ── */
        function toggleProfile() {
            const dropdown = document.getElementById('profileDropdown');
            const caret    = document.getElementById('profileCaret');
            dropdown.classList.toggle('open');
            caret.classList.toggle('open');
        }

        /* Close dropdown when clicking outside */
        document.addEventListener('click', function(e) {
            const profile = document.querySelector('.sidebar-profile');
            if (!profile.contains(e.target)) {
                document.getElementById('profileDropdown').classList.remove('open');
                document.getElementById('profileCaret').classList.remove('open');
            }
        });

        /* ── Toast auto-dismiss ── */
        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.style.transition = '0.5s';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);

    </script>

</body>
</html>