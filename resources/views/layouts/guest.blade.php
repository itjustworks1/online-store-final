<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Online Store') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --auth-bg-1: #0f172a;
            --auth-bg-2: #1d4ed8;
            --auth-accent: #22c55e;
        }
        body {
            min-height: 100vh;
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.30), transparent 32%),
                radial-gradient(circle at 85% 15%, rgba(34, 197, 94, 0.18), transparent 22%),
                linear-gradient(135deg, #020617 0%, #0f172a 45%, #111827 100%);
        }
        .auth-shell {
            position: relative;
            overflow: hidden;
        }
        .auth-backdrop {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(120deg, rgba(255,255,255,0.06), transparent 35%),
                radial-gradient(circle at 20% 20%, rgba(255,255,255,0.08), transparent 18%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05), transparent 16%);
            pointer-events: none;
        }
        .auth-card {
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(14px);
        }
        .feature-pill {
            display: flex;
            flex-direction: column;
            gap: .15rem;
            padding: .95rem 1rem;
            min-width: 180px;
            border-radius: 18px;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.16);
            color: #fff;
        }
        .feature-pill span {
            color: rgba(255,255,255,0.72);
            font-size: .92rem;
        }
        .text-white-75 {
            color: rgba(255,255,255,.75) !important;
        }
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(15,23,42,.15), transparent);
        }
        .form-control {
            border-radius: 16px;
            border: 1px solid #dbe3ef;
            padding: .9rem 1rem;
        }
        .form-control:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 .25rem rgba(29, 78, 216, .12);
        }
        .btn-dark {
            border-radius: 16px;
            padding: .9rem 1rem;
            background: linear-gradient(135deg, #0f172a, #1d4ed8);
            border: 0;
        }
        .btn-dark:hover {
            filter: brightness(1.05);
        }
        .form-check-input:checked {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        @media (max-width: 991.98px) {
            .feature-pill {
                min-width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased">
    {{ $slot }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
