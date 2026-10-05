@php
use Carbon\Carbon;
@endphp

<x-project.layouts.front 
    title="Faire un don - {{ $project->titre }}"
    :hero="[
        'title' => 'Soutenir ce Projet',
        'subtitle' => $project->titre,
        'background' => 'linear-gradient(135deg, var(--ocean) 0%, var(--aqua) 100%)'
    ]">

    <div class="aq-grid-3">
        {{-- Formulaire de don (2 colonnes) --}}
        <div style="grid-column: span 2;">
            <div class="aq-card">
                <div class="aq-card-header">
                    <div>
                        <h2 class="aq-card-title">Formulaire de Don</h2>
                        <p class="aq-card-subtitle">Votre contribution aide à financer ce projet de rénovation</p>
                    </div>
                </div>

                <form action="{{ route('projects.storeDonation', $project) }}" method="POST" class="aq-form">
                    @csrf

                    {{-- Montant suggéré --}}
                    <div class="aq-form-group">
                        <label class="aq-form-label">Montant suggéré</label>
                        <div class="aq-grid-4" style="gap: 1rem;">
                            @foreach([50, 100, 250, 500] as $amount)
                                <button type="button" 
                                        class="aq-amount-btn" 
                                        onclick="setAmount({{ $amount }})">
                                    {{ number_format($amount, 0, ',', ' ') }} €
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Montant personnalisé --}}
                    <div class="aq-form-group">
                        <label for="montant" class="aq-form-label">
                            Montant du don (€) <span class="aq-required">*</span>
                        </label>
                        <input type="number" 
                               id="montant" 
                               name="montant" 
                               class="aq-form-control @error('montant') aq-form-error @enderror" 
                               value="{{ old('montant') }}"
                               min="10"
                               step="0.01"
                               required
                               placeholder="Saisissez un montant">
                        @error('montant')
                            <span class="aq-error-message">{{ $message }}</span>
                        @else
                            <small class="aq-form-help">Montant minimum: 10 €</small>
                        @enderror
                    </div>

                    {{-- Description optionnelle --}}
                    <div class="aq-form-group">
                        <label for="description" class="aq-form-label">
                            Message (optionnel)
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  class="aq-form-control @error('description') aq-form-error @enderror" 
                                  rows="4"
                                  placeholder="Laissez un message de soutien...">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="aq-error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Anonymat --}}
                    <div class="aq-form-group">
                        <label class="aq-checkbox-label">
                            <input type="checkbox" 
                                   name="anonyme" 
                                   value="1"
                                   {{ old('anonyme') ? 'checked' : '' }}>
                            <span>Je souhaite rester anonyme</span>
                        </label>
                        <small class="aq-form-help">Si coché, votre nom n'apparaîtra pas dans la liste des donateurs</small>
                    </div>

                    {{-- Accord --}}
                    <div class="aq-form-group">
                        <label class="aq-checkbox-label">
                            <input type="checkbox" 
                                   name="accord" 
                                   required>
                            <span>
                                J'accepte que mon don soit utilisé pour financer ce projet <span class="aq-required">*</span>
                            </span>
                        </label>
                    </div>

                    {{-- Informations importantes --}}
                    <div class="aq-alert aq-alert-info">
                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <strong>Informations importantes:</strong>
                            <ul style="margin: 0.5rem 0 0 1.5rem; padding: 0;">
                                <li>Votre don sera vérifié par un administrateur avant validation</li>
                                <li>Vous recevrez une notification une fois votre don approuvé</li>
                                <li>Un reçu fiscal vous sera envoyé par email</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="aq-form-actions">
                        <button type="submit" class="aq-btn aq-btn-primary">
                            <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            Confirmer mon don
                        </button>
                        <a href="{{ route('projects.show', $project) }}" class="aq-btn aq-btn-outline">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>

            {{-- Impact du don --}}
            <div class="aq-card" style="margin-top: 1.5rem; background: var(--bg);">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--navy); margin-bottom: 1rem;">
                    L'impact de votre don
                </h3>
                <div class="aq-grid-2">
                    <div class="aq-impact-item">
                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--aqua);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <strong>Transparence totale</strong>
                            <p class="aq-text-muted">Suivez l'utilisation de votre don en temps réel</p>
                        </div>
                    </div>
                    <div class="aq-impact-item">
                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--aqua);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <div>
                            <strong>Impact communautaire</strong>
                            <p class="aq-text-muted">Amélioration de l'accès à l'eau potable</p>
                        </div>
                    </div>
                    <div class="aq-impact-item">
                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--aqua);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <strong>Déduction fiscale</strong>
                            <p class="aq-text-muted">Reçu fiscal pour votre déclaration</p>
                        </div>
                    </div>
                    <div class="aq-impact-item">
                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--aqua);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <div>
                            <strong>Sécurisé</strong>
                            <p class="aq-text-muted">Transaction 100% sécurisée</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Résumé du projet (1 colonne) --}}
        <div>
            <div class="aq-card aq-sticky-card">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--navy); margin-bottom: 1rem;">
                    Résumé du Projet
                </h3>

                <div style="margin-bottom: 1.5rem;">
                    <h4 style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                        {{ $project->titre }}
                    </h4>
                    <p class="aq-text-muted" style="font-size: 0.875rem; line-height: 1.6;">
                        {{ Str::limit($project->description, 150) }}
                    </p>
                </div>

                <div class="aq-budget-info">
                    <div class="aq-budget-item">
                        <div class="aq-budget-label">Budget total</div>
                        <div class="aq-budget-value">{{ number_format($project->budget_prevu, 0, ',', ' ') }} €</div>
                    </div>

                    <div class="aq-budget-item">
                        <div class="aq-budget-label">Déjà financé</div>
                        <div class="aq-budget-value" style="color: var(--success);">
                            {{ number_format($project->fundingTotal(), 0, ',', ' ') }} €
                        </div>
                        @php
                            $tauxFinancement = $project->budget_prevu > 0 ? ($project->fundingTotal() / $project->budget_prevu) * 100 : 0;
                        @endphp
                        <div class="aq-progress" style="margin-top: 0.5rem;">
                            <div class="aq-progress-bar" style="width: {{ min($tauxFinancement, 100) }}%"></div>
                        </div>
                        <small class="aq-text-muted">{{ number_format($tauxFinancement, 1) }}%</small>
                    </div>

                    <div class="aq-budget-item">
                        <div class="aq-budget-label">Encore nécessaire</div>
                        <div class="aq-budget-value" style="color: var(--ocean);">
                            {{ number_format(max($project->budgetRemaining(), 0), 0, ',', ' ') }} €
                        </div>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
                    <div class="aq-info-item" style="margin-bottom: 0.75rem;">
                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $project->zone->nom ?? 'Non défini' }}</span>
                    </div>

                    <div class="aq-info-item" style="margin-bottom: 0.75rem;">
                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>{{ $project->infrastructure->nom ?? 'Non défini' }}</span>
                    </div>

                    <div class="aq-info-item">
                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $project->avancement_pourcentage }}% complété</span>
                    </div>
                </div>

                @php
                    $donateurs = $project->fundings->where('statut', 'confirmé')->where('source', 'don')->count();
                @endphp
                @if($donateurs > 0)
                    <div class="aq-alert aq-alert-success" style="margin-top: 1.5rem;">
                        <svg class="aq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <div>
                            <strong>{{ $donateurs }}</strong> citoyen(s) ont déjà soutenu ce projet
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function setAmount(amount) {
            document.getElementById('montant').value = amount;
            
            // Ajouter un feedback visuel
            const buttons = document.querySelectorAll('.aq-amount-btn');
            buttons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent.includes(amount.toString())) {
                    btn.classList.add('active');
                }
            });
        }
    </script>
    @endpush

    @push('styles')
    <style>
        .aq-amount-btn {
            padding: 1rem;
            border: 2px solid var(--border);
            background: white;
            border-radius: 0.5rem;
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--navy);
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .aq-amount-btn:hover {
            border-color: var(--ocean);
            background: var(--bg);
        }
        
        .aq-amount-btn.active {
            border-color: var(--ocean);
            background: var(--ocean);
            color: white;
        }

        .aq-impact-item {
            display: flex;
            gap: 0.75rem;
            padding: 1rem;
            background: white;
            border-radius: 0.5rem;
        }

        .aq-impact-item .aq-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .aq-impact-item strong {
            display: block;
            color: var(--navy);
            margin-bottom: 0.25rem;
        }

        .aq-checkbox-label {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            cursor: pointer;
        }

        .aq-checkbox-label input[type="checkbox"] {
            margin-top: 0.25rem;
            flex-shrink: 0;
        }
    </style>
    @endpush

</x-project.layouts.front>
