<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Trackio') }} - Employee</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

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
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar-nav {
            padding: 10px 0;
        }
        .sidebar-brand {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 10px;
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
            border-left: 3px solid #fff;
            padding-left: 9px;
        }
        .main-wrapper {
            margin-left: 250px;
            min-height: 100vh;
        }
        .topbar {
            background: white;
            padding: 15px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .topbar-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            background: #f5f7fb;
            border-radius: 25px;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        .content {
            padding: 30px 25px;
        }
        .content-full {
            padding: 30px 25px 30px 280px;
        }
        .page-header {
            margin-bottom: 30px;
        }
        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        .page-header p {
            color: #666;
            font-size: 0.95rem;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
            .topbar {
                padding: 12px 15px;
            }
            .sidebar-brand {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <a href="{{ route('employee.dashboard') }}">
                <i class="fas fa-chart-line"></i>
                <span>Trackio</span>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <!-- Main Section -->
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                <a href="{{ route('employee.dashboard') }}" class="@if(request()->routeIs('employee.dashboard')) active @endif">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('employee.attendance.today') }}" class="@if(request()->routeIs('employee.attendance.today')) active @endif">
                    <i class="fas fa-calendar-check"></i>
                    <span>Today's Attendance</span>
                </a>
            </div>

            <!-- QR Section -->
            <div class="nav-section">
                <div class="nav-section-title">Attendance</div>
                <a href="{{ route('employee.qr.show') }}" class="@if(request()->routeIs('employee.qr.show')) active @endif">
                    <i class="fas fa-qrcode"></i>
                    <span>My QR Card</span>
                </a>
                <a href="{{ route('employee.attendance-adjustments.index') }}" class="@if(request()->routeIs('employee.attendance-adjustments.*')) active @endif">
                    <i class="fas fa-file-signature"></i>
                    <span>Adjustments</span>
                </a>
            </div>

            <!-- Leave Management Section -->
            <div class="nav-section">
                <div class="nav-section-title">Leave</div>
                <a href="{{ route('employee.leaves.index') }}" class="@if(request()->routeIs('employee.leaves.*')) active @endif">
                    <i class="fas fa-plane-departure"></i>
                    <span>My Leaves</span>
                </a>
            </div>

            <!-- Account Section -->
            <div class="nav-section">
                <div class="nav-section-title">Account</div>
                <a href="{{ route('profile.edit') }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        @if(View::hasSection('show_topbar') ? View::getSection('show_topbar') : true)
        <!-- Top Bar -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="btn btn-link d-md-none" id="sidebar-toggle">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
                <div class="topbar-title">
                    @isset($title)
                        {{ $title }}
                    @else
                        Dashboard
                    @endisset
                </div>
            </div>

            <div class="topbar-right">
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ substr(auth()->user()->employeeProfile->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: #333;">
                            {{ auth()->user()->employeeProfile->name ?? 'User' }}
                        </div>
                        <div style="font-size: 0.75rem; color: #999;">
                            Employee
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="content">
            @yield('content')
        </div>
        @else
        <!-- Page Content (Full Width) -->
        <div class="content-full">
            @yield('content')
        </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Close sidebar when clicking on a link (mobile)
        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    document.querySelector('.sidebar').classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>
