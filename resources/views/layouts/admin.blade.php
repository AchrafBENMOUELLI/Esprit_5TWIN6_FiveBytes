<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} - AquaSecure</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Dashboard Sidebar CSS --}}
    <link rel="stylesheet" href="{{ asset('css/dashboardsidebar.css') }}">

    <style>
        body {
            background: #f4f8fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .aq-admin-main {
            margin-left: 240px;
            padding: 88px 24px 24px;
            min-height: 100vh;
        }

        @media (max-width: 991px) {
            .aq-admin-main {
                margin-left: 0;
                padding: 88px 16px 16px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    {{-- Sidebar --}}
    <x-dashboard.dashboardsidebar />

    {{-- Navbar --}}
    <x-dashboard.dashboardnavbar />

    {{-- Main Content --}}
    <main class="aq-admin-main">
        @yield('content')
    </main>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
