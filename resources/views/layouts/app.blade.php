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
            font-family: 'Segoe UI', sans-serif;
            background: #f0f4f8;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 380px;
            background: #1a3a5c;
            display: flex;
            flex-direction: column;
            padding: 1rem 0;
            position: fixed;
            height: 100vh;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 1rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 0.5rem;
        }

        .sidebar-logo span {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 1rem;
            font-size: 13px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            transition: background 0.15s;
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(255,255,255,0.12);
            color: #fff;
            border-left: 3px solid #7ab8f5;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: 12px;
            color: rgba(255,255,255,0.5);
        }

        .main {
            margin-left: 230px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: #fff;
            padding: 14px 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar h1 {
            font-size: 16px;
            font-weight: 600;
            color: #1a3a5c;
        }

       .content{
            padding:0;
            width:100%;
        }

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

        .btn:hover {
            opacity: 0.85;
        }

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

        tr:hover td {
            background: #f7fafc;
        }

        .badge {
            display: inline-block;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 500;
        }

        .badge-green {
            background: #e1f5ee;
            color: #085041;
        }

        .badge-amber {
            background: #faeeda;
            color: #633806;
        }

        .badge-red {
            background: #fcebeb;
            color: #501313;
        }

        .form-group {
            margin-bottom: 1rem;
        }

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

        .alert-success {
            background: #e1f5ee;
            color: #085041;
        }

        .alert-error {
            background: #fcebeb;
            color: #501313;
        }

            /* TOAST SUCCESS */

    .toast-success{
        position:fixed;
        top:20px;
        right:20px;

        background:#22C55E;
        color:white;

        padding:16px 22px;

        border-radius:12px;

        font-weight:600;

        box-shadow:0 8px 20px rgba(0,0,0,0.15);

        z-index:9999;

        animation:slideIn .4s ease;
    }

    /* ANIMATION */

    @keyframes slideIn{

        from{
            opacity:0;
            transform:translateX(100%);
        }

        to{
            opacity:1;
            transform:translateX(0);
        }

    }

    </style>

</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo"><span>Wellmeadows</span></div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard*') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('patients.index') }}" class="nav-item {{ request()->routeIs('patients*') ? 'active' : '' }}">Patients</a>
        <a href="{{ route('appointments.index') }}" class="nav-item {{ request()->routeIs('appointments*') ? 'active' : '' }}">Appointments</a>
        <a href="{{ route('staff.index') }}" class="nav-item {{ request()->routeIs('staff*') ? 'active' : '' }}">Staff</a>
        <a href="{{ route('wards.index') }}" class="nav-item {{ request()->routeIs('wards*') ? 'active' : '' }}">Ward & Bed Management</a>
   </div>
        <div class="sidebar-bottom">Module 4 – Quitoriano</div>


    <!-- Main Content -->
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

    setTimeout(() => {

        const toast =
            document.getElementById('toast-success');

        if(toast){

            toast.style.transition = '0.5s';

            toast.style.opacity = '0';

            setTimeout(() => {

                toast.remove();

            }, 500);

        }

    }, 3000);

</script>

</body>
</html>