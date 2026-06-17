<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Only Store') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body {
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.12), transparent 30%),
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.10), transparent 24%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
        }
        .filter-card,
        .catalog-card,
        .detail-card,
        .cart-card,
        .order-card {
            border: 0;
            border-radius: 1.25rem;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        }
        .product-image {
            object-fit: cover;
            aspect-ratio: 4 / 3;
            min-height: 260px;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        }
        .product-image.detail {
            min-height: 420px;
        }
        .image-shell {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        .image-shell::after {
            content: "";
            position: absolute;
            inset: auto 0 0 0;
            height: 70px;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0) 0%, rgba(15, 23, 42, 0.08) 100%);
            pointer-events: none;
        }
        .catalog-chip {
            border-radius: 999px;
            padding: .5rem .85rem;
        }
        .price-badge {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%);
            color: #fff;
        }
        .soft-badge {
            background: rgba(15, 23, 42, 0.06);
            color: #334155;
            border: 1px solid rgba(15, 23, 42, 0.08);
        }
        .product-card {
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
        }
        .section-title {
            letter-spacing: -0.02em;
        }
        .info-panel {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }
        .stat-pill {
            min-width: 120px;
        }
        .nav-glass {
            background: rgba(15, 23, 42, 0.94);
            backdrop-filter: blur(18px);
        }
        .nav-link-pill {
            border-radius: 999px;
            padding: 0.45rem 0.85rem;
        }
        .cart-badge {
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            color: #fff;
        }
        .cart-badge:hover {
            color: #fff;
        }
        .summary-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.25rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    @php($cartCount = app(\App\Services\ShoppingCartService::class)->count())

    <nav class="navbar navbar-expand-lg navbar-dark nav-glass shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ route('products.index') }}">Only Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link nav-link-pill {{ request()->routeIs('products.*') ? 'active bg-white text-dark' : '' }}" href="{{ route('products.index') }}">Каталог</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-pill position-relative {{ request()->routeIs('cart.*') ? 'active bg-white text-dark' : '' }}" href="{{ route('cart.index') }}">
                            Корзина
                            @if ($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link nav-link-pill {{ request()->routeIs('orders.my') ? 'active bg-white text-dark' : '' }}" href="{{ route('orders.my') }}">Мои заказы</a>
                        </li>
                        @if (in_array(auth()->user()->role, ['admin', 'order_manager'], true))
                            <li class="nav-item">
                                <a class="nav-link nav-link-pill {{ request()->routeIs('admin.dashboard') ? 'active bg-white text-dark' : '' }}" href="{{ route('admin.dashboard') }}">Админка</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <div class="d-flex gap-2 align-items-center">
                    @auth
                        <span class="navbar-text text-white-50 d-none d-md-inline">{{ auth()->user()->name }}</span>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-sm">Профиль</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Выйти</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Войти</a>
                        <a href="{{ route('register') }}" class="btn btn-light btn-sm">Регистрация</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
            @endif

            @isset($header)
                <div class="mb-4">
                    {{ $header }}
                </div>
            @endisset

            @yield('content')
            {{ $slot ?? '' }}
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
