<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Trackio') }} - Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
        }
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
            z-index: 100;
            overflow: hidden;
        }
        .sidebar-nav {
            padding: 10px 0;
        }
        .sidebar-brand {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand a {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar-brand i {
            margin-right: 10px;
            font-size: 1.3rem;
        }
        .nav-section {
            padding: 0 10px;
            margin-bottom: 2px;
        }
        .nav-section-title {
            color: rgba(255,255,255,0.5);
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 12px 4px;
            font-weight: 600;
        }
        .sidebar-nav a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .sidebar-nav a i {
            width: 18px;
            margin-right: 10px;
            font-size: 0.9rem;
            text-align: center;
        }
        .sidebar-nav a:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .sidebar-nav a.active {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }
        .main-wrapper {
            margin-left: 250px;
            min-height: 100vh;
        }
        .topbar {
            background: #fff;
            padding: 18px 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar h4 {
            font-weight: 600;
            color: #333;
            margin: 0;
            font-size: 1.25rem;
        }
        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .topbar .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
        }
        .content-area {
            padding: 30px;
        }
        .content-area-full {
            padding: 30px 30px 30px 280px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            background: #212529 !important;
            color: #fff !important;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 12px;
            border: none;
        }
        .table-dark th {
            background: #212529 !important;
            color: #fff !important;
        }
        .table tbody td {
            padding: 12px;
            vertical-align: middle;
        }
        .logout-link {
            background: rgba(255,255,255,0.1) !important;
        }
        .logout-link:hover {
            background: rgba(220, 53, 69, 0.3) !important;
        }
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }
            .sidebar-brand span, .nav-section-title, .sidebar-nav a span {
                display: none;
            }
            .sidebar-nav a {
                justify-content: center;
                padding: 15px;
                margin: 3px 10px;
            }
            .sidebar-nav a i {
                margin-right: 0;
                font-size: 1.2rem;
            }
            .main-wrapper {
                margin-left: 80px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fas fa-clock"></i>
                <span>Trackio</span>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="nav-section-title">Management</div>
            <div class="nav-section">
                <a href="{{ route('admin.departments.index') }}" class="{{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i>
                    <span>Departments</span>
                </a>
                <a href="{{ route('admin.designations.index') }}" class="{{ request()->routeIs('admin.designations.*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i>
                    <span>Designations</span>
                </a>
                <a href="{{ route('admin.employees.index') }}" class="{{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Employees</span>
                </a>
                <a href="{{ route('admin.shifts.index') }}" class="{{ request()->routeIs('admin.shifts.*') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i>
                    <span>Shifts</span>
                </a>
            </div>

            <div class="nav-section-title">Attendance</div>
            <div class="nav-section">
                <a href="{{ route('admin.attendance.index') }}" class="{{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Attendance</span>
                </a>
                <a href="{{ route('admin.attendance-adjustments.index') }}" class="{{ request()->routeIs('admin.attendance-adjustments.*') ? 'active' : '' }}">
                    <i class="fas fa-file-signature"></i>
                    <span>Adjustments</span>
                </a>
            </div>

            <div class="nav-section-title">Leave Management</div>
            <div class="nav-section">
                <a href="{{ route('admin.leaves.index') }}" class="{{ request()->routeIs('admin.leaves.*') ? 'active' : '' }}">
                    <i class="fas fa-plane-departure"></i>
                    <span>Leave Requests</span>
                </a>
            </div>

            <div class="nav-section-title">Account</div>
            <div class="nav-section">
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Profile</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper">
        @if(View::hasSection('show_topbar') ? View::getSection('show_topbar') : true)
        <!-- Top Bar -->
        <div class="topbar">
            <h4>@yield('title', 'Dashboard')</h4>
            <div class="user-info">
                <span class="text-muted">{{ Auth::user()->email }}</span>
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="content-area">
            @yield('content')
        </div>
        @else
        <!-- Page Content (Full Width) -->
        <div class="content-area-full">
            @yield('content')
        </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
