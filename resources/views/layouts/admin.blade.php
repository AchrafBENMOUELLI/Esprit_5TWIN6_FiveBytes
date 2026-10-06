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

    {{-- Modern Admin Design --}}
    <link rel="stylesheet" href="{{ asset('css/admin-modern.css') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f4f8fb;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

    {{-- Toast Container --}}
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        @if(session('success'))
            <div class="toast align-items-center border-0 show" role="alert" aria-live="assertive" aria-atomic="true" style="background: linear-gradient(135deg, #10b981, #34d399); color: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);">
                <div class="d-flex">
                    <div class="toast-body" style="padding: 16px 20px; font-size: 14px; font-weight: 500;">
                        <i class="fas fa-check-circle" style="margin-right: 10px; font-size: 16px;"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast align-items-center border-0 show" role="alert" aria-live="assertive" aria-atomic="true" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(239, 68, 68, 0.3);">
                <div class="d-flex">
                    <div class="toast-body" style="padding: 16px 20px; font-size: 14px; font-weight: 500;">
                        <i class="fas fa-exclamation-circle" style="margin-right: 10px; font-size: 16px;"></i>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="toast align-items-center border-0 show" role="alert" aria-live="assertive" aria-atomic="true" style="background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(245, 158, 11, 0.3);">
                <div class="d-flex">
                    <div class="toast-body" style="padding: 16px 20px; font-size: 14px; font-weight: 500;">
                        <i class="fas fa-exclamation-triangle" style="margin-right: 10px; font-size: 16px;"></i>
                        {{ session('warning') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="toast align-items-center border-0 show" role="alert" aria-live="assertive" aria-atomic="true" style="background: linear-gradient(135deg, #3b82f6, #60a5fa); color: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);">
                <div class="d-flex">
                    <div class="toast-body" style="padding: 16px 20px; font-size: 14px; font-weight: 500;">
                        <i class="fas fa-info-circle" style="margin-right: 10px; font-size: 16px;"></i>
                        {{ session('info') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Toast Auto-dismiss --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto dismiss toasts after 5 seconds
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    const bsToast = new bootstrap.Toast(toast);
                    bsToast.hide();
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
