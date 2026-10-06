<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AquaSecure')</title>
    <style>{!! file_get_contents(resource_path('views/base.css')) !!}</style>
</head>
<body>
    <x-shared.navbar />
    
    <main style="min-height: calc(100vh - 200px);">
        @yield('content')
    </main>

    <x-shared.footer />
</body>
</html>
