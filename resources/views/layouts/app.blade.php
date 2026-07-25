<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --primary: #4f46e5; --primary-light: #818cf8; --dark-bg: #0f172a; --dark-sidebar: #1e293b; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f1f5f9; }
        .sidebar { position: fixed; top: 0; left: 0; width: var(--sidebar-width); height: 100vh; background: var(--dark-bg); color: #fff; overflow-y: auto; z-index: 1000; transition: transform 0.25s ease; }
        .sidebar .brand { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .brand h4 { margin: 0; font-size: 1.1rem; color: var(--primary-light); }
        .sidebar .user-summary { padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .user-summary img { width: 38px; height: 38px; object-fit: cover; }
        .sidebar .user-summary strong { display: block; max-width: 165px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .sidebar .nav-link { color: #94a3b8; padding: 12px 20px; display: flex; align-items: center; gap: 12px; text-decoration: none; transition: all 0.2s; border-left: 3px solid transparent; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(79,70,229,0.1); color: #fff; border-left-color: var(--primary); }
        .sidebar .nav-link i { width: 20px; text-align: center; }
        .sidebar .nav-section { padding: 15px 20px 5px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: #64748b; }
        .main-content { margin-left: var(--sidebar-width); padding: 20px 30px; min-height: 100vh; }
        .topbar { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; margin-bottom: 20px; }
        .topbar h5 { margin: 0; font-weight: 600; }
        .sidebar-toggle { display: none; border: 0; background: transparent; color: var(--dark-bg); font-size: 1.25rem; padding: 4px 8px; }
        .sidebar-backdrop { display: none; }
        .card-stat { border: none; border-radius: 12px; padding: 20px; transition: transform 0.2s; }
        .card-stat:hover { transform: translateY(-2px); }
        .card-stat .icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #fff; }
        .card-stat .number { font-size: 1.8rem; font-weight: 700; margin: 10px 0 5px; }
        .card-stat .label { font-size: 0.85rem; color: #64748b; }
        .table-custom { border-radius: 10px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-light); border-color: var(--primary-light); }
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); box-shadow: 8px 0 24px rgba(15,23,42,0.2); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 16px 20px; }
            .sidebar-toggle { display: inline-block; }
            .sidebar-backdrop { position: fixed; inset: 0; background: rgba(15,23,42,0.45); z-index: 999; }
            .sidebar-backdrop.show { display: block; }
        }
        @media (max-width: 575.98px) {
            .main-content { padding: 12px 14px; }
            .topbar { gap: 8px; }
            .topbar > .d-flex > .alert { display: none; }
            .topbar .dropdown span { display: none; }
        }
    </style>
    @yield('styles')
</head>
<body>
    @auth
    <div class="sidebar">
        <div class="brand">
            <h4><i class="fas fa-graduation-cap me-2"></i>SMS</h4>
            <small class="text-muted">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</small>
        </div>
        @php
            $profileRole = Auth::user()->role === 'super_admin' ? 'admin' : Auth::user()->role;
            $profileUrl = Route::has($profileRole . '.profile.edit') ? route($profileRole . '.profile.edit') : '#';
        @endphp
        <a href="{{ $profileUrl }}" class="user-summary d-flex align-items-center gap-2 text-white text-decoration-none">
            <img src="{{ Auth::user()->photo_url }}" alt="{{ Auth::user()->name }}" class="rounded-circle">
            <span><strong>{{ Auth::user()->name }}</strong><small class="text-white-50">View profile</small></span>
        </a>
        <nav class="mt-3">
            @if(Auth::user()->role === 'super_admin')
                @include('layouts.sidebar-admin')
            @elseif(Auth::user()->role === 'teacher')
                @include('layouts.sidebar-teacher')
            @elseif(Auth::user()->role === 'student')
                @include('layouts.sidebar-student')
            @endif
        </nav>
    </div>
    <div class="sidebar-backdrop" data-sidebar-close></div>
    @endauth

    <div class="main-content">
        <div class="topbar">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="sidebar-toggle" data-sidebar-toggle aria-label="Open navigation"><i class="fas fa-bars"></i></button>
                <h5>@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-0" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="{{ Auth::user()->photo_url }}" alt="" width="32" height="32" class="rounded-circle me-2">
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @php
                            $profileRole = Auth::user()->role === 'super_admin' ? 'admin' : Auth::user()->role;
                            $profileUrl = Route::has($profileRole . '.profile.edit') ? route($profileRole . '.profile.edit') : '#';
                        @endphp
                        <li><a class="dropdown-item" href="{{ $profileUrl }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const sidebar = document.querySelector('.sidebar');
        const sidebarBackdrop = document.querySelector('[data-sidebar-close]');
        const closeSidebar = () => {
            sidebar?.classList.remove('open');
            sidebarBackdrop?.classList.remove('show');
        };
        document.querySelector('[data-sidebar-toggle]')?.addEventListener('click', () => {
            sidebar?.classList.toggle('open');
            sidebarBackdrop?.classList.toggle('show');
        });
        sidebarBackdrop?.addEventListener('click', closeSidebar);
        sidebar?.querySelectorAll('.nav-link').forEach(link => link.addEventListener('click', closeSidebar));

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Are you sure?', text: 'This action cannot be undone.', icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#dc3545', confirmButtonText: 'Yes, delete!'
                }).then(result => { if (result.isConfirmed) form.submit(); });
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
