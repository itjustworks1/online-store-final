<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Online Store') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.12), transparent 30%),
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.10), transparent 24%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
        }
        .filter-card,
        .catalog-card,
        .detail-card {
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
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">Online Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">Каталог</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
