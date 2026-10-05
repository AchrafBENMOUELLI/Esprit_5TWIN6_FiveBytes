<style>{!! file_get_contents(resource_path('views/components/authentification/registercomponent.css')) !!}</style>

<x-shared.navbar />

<main class="aq-auth">
    <form method="POST" action="{{ route('register') }}" class="aq-auth-card">
        @csrf

        <h1>Créer un compte</h1>
        <p class="aq-auth-sub">Rejoignez AquaSecure.</p>

        <div class="aq-field">
            <label for="name">Nom complet</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name') <span class="aq-error">{{ $message }}</span> @enderror
        </div>

        <div class="aq-field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span class="aq-error">{{ $message }}</span> @enderror
        </div>

        <div class="aq-field">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required>
            @error('password') <span class="aq-error">{{ $message }}</span> @enderror
        </div>

        <div class="aq-field">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="aq-submit">S'inscrire</button>

        <p class="aq-switch">
            Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
        </p>
    </form>
</main>

<x-shared.footer />
