<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--dark) 0%, #0f172a 100%);
            width: 260px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
            text-decoration: none;
        }

        .sidebar-nav {
            padding: 1rem 0;
            margin: 0;
            list-style: none;
        }

        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            margin: 0.25rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .sidebar-nav-item:hover,
        .sidebar-nav-item.active {
            background: rgba(99, 102, 241, 0.2);
            color: white;
        }

        .sidebar-nav-item i {
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 260px;
            padding: 1.5rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .header {
            background: white;
            border-radius: 0.5rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--gray);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            padding: 0.75rem 1rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .table th {
            font-weight: 600;
            color: var(--dark);
            background-color: #f8fafc;
        }

        .badge {
            font-weight: 600;
            padding: 0.375rem 0.75rem;
        }

        .image-preview {
            max-width: 200px;
            max-height: 100px;
            border-radius: 0.375rem;
            overflow: hidden;
            border: 1px dashed #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8fafc;
        }

        .image-preview img {
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .icon-preview {
            font-size: 2rem;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            background-color: #f8fafc;
            border: 1px solid #d1d5db;
            margin: 0.5rem 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-260px);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.header.index') }}" class="sidebar-brand">
                <i class="fas fa-cog"></i>
                Admin Panel
            </a>
        </div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.header.index') }}" class="sidebar-nav-item {{ request()->is('admin/header*') && !request()->is('admin/header-sections*') ? 'active' : '' }}">
                    <i class="fas fa-bars"></i>
                    Menu Management
                </a>
            </li>
            <li>
                <a href="{{ route('admin.header-sections.index') }}" class="sidebar-nav-item {{ request()->is('admin/header-sections*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i>
                    Header Sections
                </a>
            </li>
            <li>
                <a href="{{ route('admin.intro-slider.index') }}" class="sidebar-nav-item {{ request()->is('admin/intro-slider*') ? 'active' : '' }}">
                    <i class="fas fa-image"></i>
                    Intro Slider
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}" class="sidebar-nav-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    Manage Explore Popular Categories
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.index') }}" class="sidebar-nav-item {{ request()->is('admin/products*') ? 'active' : '' }}">
                    <i class="fas fa-box-open"></i>
                    Manage Category Products
                </a>
            </li>
            <li>
                <a href="{{ route('admin.banners.index') }}" class="sidebar-nav-item {{ request()->is('admin/banners*') ? 'active' : '' }}">
                    <i class="fas fa-image"></i>
                    Banner Management
                </a>
            </li>
            <li>
                <a href="{{ route('admin.banner-products.index') }}" class="sidebar-nav-item {{ request()->is('admin/banner-products*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    Manage Banner Product Details
                </a>
            </li>
            <li>
                <a href="{{ route('admin.new-arrivals.index') }}" class="sidebar-nav-item {{ request()->is('admin/new-arrivals*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    Manage New Arrivals
                </a>
            </li>
            <li>
                <a href="{{ route('admin.deals.index') }}" class="sidebar-nav-item {{ request()->is('admin/deals*') ? 'active' : '' }}">
                    <i class="fas fa-fire"></i>
                    Manage Deals & Outlet
                </a>
            </li>
            <li>
                <a href="{{ route('admin.cta-sections.index') }}" class="sidebar-nav-item {{ request()->is('admin/cta-sections*') ? 'active' : '' }}">
                    <i class="fas fa-image"></i>
                    Manage CTA Products
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}" class="sidebar-nav-item {{ request()->is('admin/orders*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    Order Management
                </a>
            </li>
            <li>
                <a href="{{ route('admin.navbar.settings') }}" class="sidebar-nav-item {{ request()->is('admin/navbar/settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    Header Settings
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <header class="header">
            <h1 class="header-title mb-0">@yield('header-title', 'Dashboard')</h1>
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ Auth::user() ? strtoupper(substr(Auth::user()->name, 0, 1)) : '' }}
                    </div>
                    <div>
                        <div>{{ Auth::user() ? Auth::user()->name : '' }}</div>
                        <small class="text-muted">{{ Auth::user() ? Auth::user()->email : '' }}</small>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </header>

        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>