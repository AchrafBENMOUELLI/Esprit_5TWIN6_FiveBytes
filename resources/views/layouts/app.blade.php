<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AquaSecure')</title>
    <style>{!! file_get_contents(resource_path('views/base.css')) !!}</style>
    <style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>
</head>
<body>
    <x-shared.navbar />
    
    <main style="min-height: calc(100vh - 200px);">
        @if($errors->any())
            <div class="aq-alert aq-alert-error" style="margin: 1rem 2rem;">
                <strong>Erreurs de validation :</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="aq-alert aq-alert-success" style="margin: 1rem 2rem;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="aq-alert aq-alert-error" style="margin: 1rem 2rem;">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <x-shared.footer />
</body>
</html>
