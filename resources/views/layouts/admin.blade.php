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
        :root {
            --admin-bg: #081120;
            --admin-surface: rgba(15, 23, 42, 0.72);
            --admin-surface-strong: rgba(15, 23, 42, 0.9);
            --admin-border: rgba(148, 163, 184, 0.18);
            --admin-text: #e5eefb;
            --admin-muted: #94a3b8;
            --admin-accent: #f59e0b;
            --admin-accent-2: #38bdf8;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(56, 189, 248, 0.18), transparent 28%),
                radial-gradient(circle at top right, rgba(245, 158, 11, 0.16), transparent 24%),
                linear-gradient(180deg, #060b16 0%, #0b1220 52%, #10192b 100%);
            color: var(--admin-text);
        }

        .admin-shell {
            position: relative;
            min-height: 100vh;
        }

        .admin-shell::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
            background-size: 56px 56px;
            mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.5), transparent 85%);
            pointer-events: none;
            opacity: 0.22;
        }

        .admin-navbar {
            background: rgba(7, 11, 22, 0.82);
            border-bottom: 1px solid var(--admin-border);
            backdrop-filter: blur(18px);
        }

        .admin-brand {
            letter-spacing: -0.03em;
        }

        .admin-badge {
            border: 1px solid rgba(245, 158, 11, 0.35);
            background: rgba(245, 158, 11, 0.12);
            color: #ffd18a;
        }

        .admin-main {
            position: relative;
            z-index: 1;
        }

        .admin-panel {
            background: var(--admin-surface);
            border: 1px solid var(--admin-border);
            border-radius: 1.5rem;
            box-shadow: 0 24px 70px rgba(2, 6, 23, 0.45);
            backdrop-filter: blur(16px);
        }

        .admin-card {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.92), rgba(15, 23, 42, 0.78));
            border: 1px solid var(--admin-border);
            border-radius: 1.25rem;
            box-shadow: 0 18px 42px rgba(2, 6, 23, 0.35);
        }

        .admin-soft {
            color: var(--admin-muted);
        }

        .admin-divider {
            border-color: rgba(148, 163, 184, 0.16);
        }

        .admin-stat {
            min-height: 138px;
        }

        .admin-table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--admin-text);
            --bs-table-border-color: rgba(148, 163, 184, 0.16);
        }

        .admin-table thead th {
            color: #cbd5e1;
            border-bottom-color: rgba(148, 163, 184, 0.22);
        }

        .admin-input,
        .admin-select,
        .admin-textarea {
            background: rgba(15, 23, 42, 0.8);
            border-color: rgba(148, 163, 184, 0.2);
            color: var(--admin-text);
        }

        .admin-input:focus,
        .admin-select:focus,
        .admin-textarea:focus {
            border-color: rgba(56, 189, 248, 0.7);
            box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, 0.12);
            background: rgba(15, 23, 42, 0.9);
            color: var(--admin-text);
        }

        .admin-section-title {
            letter-spacing: -0.03em;
        }

        .admin-hero {
            background:
                linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(56, 189, 248, 0.08)),
                rgba(15, 23, 42, 0.7);
            border: 1px solid var(--admin-border);
            border-radius: 1.5rem;
        }

        .admin-chip {
            border-radius: 999px;
            padding: 0.55rem 0.9rem;
            background: rgba(148, 163, 184, 0.12);
            color: #dbeafe;
            border: 1px solid rgba(148, 163, 184, 0.15);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-shell">
        <nav class="navbar navbar-expand-lg navbar-dark admin-navbar sticky-top">
            <div class="container-fluid px-3 px-lg-4 py-2">
                <a class="navbar-brand fw-semibold admin-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                    <span class="badge rounded-pill admin-badge">Admin</span>
                    Only Store
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="adminNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-semibold' : '' }}" href="{{ route('admin.dashboard') }}">Панель</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active fw-semibold' : '' }}" href="{{ route('admin.products.index') }}">Товары</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active fw-semibold' : '' }}" href="{{ route('admin.categories.index') }}">Категории</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active fw-semibold' : '' }}" href="{{ route('admin.orders.index') }}">Заказы</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-end d-none d-md-block">
                            <div class="small text-white-50">Вы вошли как</div>
                            <div class="fw-semibold">{{ auth()->user()->name }}</div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-sm">Профиль</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">Выйти</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <main class="admin-main py-4 py-lg-5">
            <div class="container-fluid px-3 px-lg-4">
                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
                @endif

                @isset($header)
                    <div class="mb-4">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
