@extends('layouts.app')

@section('content')
<style>{!! file_get_contents(resource_path('views/components/drought/drought.css')) !!}</style>

<div class="aq-drought-container">
    <div class="aq-drought-header">
        <h1>Mes Abonnements aux Alertes</h1>
        <p>Gérez vos notifications sur les restrictions d'eau</p>
    </div>

    @if($message = session('success'))
        <div class="aq-alert aq-alert-success">{{ $message }}</div>
    @endif
    @if($message = session('error'))
        <div class="aq-alert aq-alert-error">{{ $message }}</div>
    @endif

    <div class="aq-card" style="margin-bottom: 2rem;">
        <h3>Ajouter un Abonnement</h3>
        <form method="POST" action="{{ route('front.drought.subscriptions.store') }}">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: end;">
                <div class="aq-form-group" style="margin-bottom: 0;">
                    <label for="zone_id">Zone</label>
                    <select id="zone_id" name="zone_id" required>
                        <option value="">-- Sélectionner une zone --</option>
                        @foreach($allZones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->nom }}</option>
                        @endforeach
                    </select>
                    @error('zone_id')
                        <div class="aq-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="aq-form-group" style="margin-bottom: 0;">
                    <label for="canal">Canal</label>
                    <select id="canal" name="canal" required>
                        <option value="email">Email</option>
                        <option value="sms">SMS</option>
                        <option value="app">App</option>
                    </select>
                    @error('canal')
                        <div class="aq-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="aq-btn aq-btn-success">S'abonner</button>
            </div>
        </form>
    </div>

    <h2 style="color: var(--navy);">Vos Abonnements</h2>
    @if($subscriptions->count())
        <table class="aq-table">
            <thead>
                <tr>
                    <th>Zone</th>
                    <th>Canal</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $subscription)
                    <tr>
                        <td><strong>{{ $subscription->zone->nom }}</strong></td>
                        <td>
                            @if($subscription->canal === 'email')
                                📧 Email
                            @elseif($subscription->canal === 'sms')
                                📱 SMS
                            @else
                                📲 App
                            @endif
                        </td>
                        <td>
                            <span class="aq-badge {{ $subscription->actif ? 'aq-badge-actif' : 'aq-badge-inactif' }}">
                                {{ $subscription->actif ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('front.drought.subscriptions.toggle', $subscription) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="aq-btn aq-btn-info" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                                    {{ $subscription->actif ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('front.drought.subscriptions.destroy', $subscription) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="aq-btn aq-btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="aq-card">
            <p style="text-align: center; color: var(--muted);">Vous n'êtes abonné à aucune zone. Ajoutez un abonnement ci-dessus!</p>
        </div>
    @endif

    <div style="margin-top: 2rem;">
        <a href="{{ route('front.drought.dashboard') }}" class="aq-btn aq-btn-secondary">Retour au tableau de bord</a>
    </div>
</div>
@endsection
