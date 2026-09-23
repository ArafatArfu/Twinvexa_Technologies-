<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - {{ config('app.name', 'TwinVexa Technology BD') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    @stack('css')
</head>
<body>
    <button class="sidebar-toggler" id="sidebar-toggler">
        <i class="fas fa-bars"></i>
    </button>
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
                <a href="{{ route('admin.brands.index') }}" class="sidebar-nav-item {{ request()->is('admin/brands*') ? 'active' : '' }}">
                    <i class="fas fa-tag"></i>
                    Manage Brands
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
                <a href="{{ route('admin.trending-products.index') }}" class="sidebar-nav-item {{ request()->is('admin/trending-products*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    Manage Keyboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.recommendations.index') }}" class="sidebar-nav-item {{ request()->is('admin/recommendations*') ? 'active' : '' }}">
                    <i class="fas fa-thumbs-up"></i>
                    Manage Recommendations
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
                <a href="{{ route('admin.icon-boxes.index') }}" class="sidebar-nav-item {{ request()->is('admin/icon-boxes*') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    Manage Icon Boxes
                </a>
            </li>
            <li>
                <a href="{{ route('admin.footer.index') }}" class="sidebar-nav-item {{ request()->is('admin/footer*') ? 'active' : '' }}">
                    <i class="fas fa-shoe-prints"></i>
                    Manage Footer
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings.index') }}" class="sidebar-nav-item {{ request()->is('admin/settings*') ? 'active' : '' }}">
                    <i class="fas fa-sliders-h"></i>
                    Site Settings
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggler = document.getElementById('sidebar-toggler');
            const sidebar = document.getElementById('sidebar');
            if (toggler && sidebar) {
                toggler.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
                document.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !toggler.contains(e.target) && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>