<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Back Office' }} — AquaSecure</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        {!! file_get_contents(resource_path('views/base.css')) !!}
        {!! file_get_contents(resource_path('views/components/dashboard/dashboard.css')) !!}
    </style>
</head>
<body>
    <x-dashboard.dashboardsidebar />
    <x-dashboard.dashboardnavbar />

    <main class="aq-dash-main">
        {{ $slot }}
    </main>
</body>
</html>
