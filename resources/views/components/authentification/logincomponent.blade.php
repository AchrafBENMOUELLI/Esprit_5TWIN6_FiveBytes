<style>{!! file_get_contents(resource_path('views/components/authentification/logincomponent.css')) !!}</style>

<x-shared.navbar />

<main class="aq-auth">
    <form method="POST" action="{{ route('login') }}" class="aq-auth-card">
        @csrf

        <h1>Connexion</h1>
        <p class="aq-auth-sub">Accédez à votre espace AquaSecure.</p>

        <div class="aq-field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus>
            @error('email') <span class="aq-error">{{ $message }}</span> @enderror
        </div>

        <div class="aq-field">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password">
            @error('password') <span class="aq-error">{{ $message }}</span> @enderror
        </div>

        <label class="aq-remember">
            <input type="checkbox" name="remember"> Se souvenir de moi
        </label>

        <button type="submit" class="aq-submit">Se connecter</button>

        <p class="aq-switch">
            Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte</a>
        </p>
    </form>
</main>

<x-shared.footer />
