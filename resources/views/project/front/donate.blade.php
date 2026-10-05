<x-project.layouts.front>
    <div class="container py-5">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none">Projets</a></li>
                <li class="breadcrumb-item"><a href="{{ route('projects.show', $project) }}" class="text-decoration-none">{{ Str::limit($project->titre, 30) }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Faire un Don</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{-- Success Message (shown after submission) --}}
                @if(session('donation_success'))
                <div class="card border-0 shadow-sm mb-4 bg-success text-white">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-check-circle fa-4x opacity-75"></i>
                        </div>
                        <h3 class="mb-3">Merci pour votre Générosité !</h3>
                        <p class="lead mb-3">
                            Votre don de <strong>{{ number_format(session('donation_amount', 0), 0, ',', ' ') }} TND</strong> 
                            a été enregistré avec succès.
                        </p>
                        <p class="mb-4">
                            Votre contribution aidera à financer le projet "{{ $project->titre }}" 
                            et contribuera à l'amélioration des infrastructures hydrauliques de votre région.
                        </p>
                        <div class="row g-3 justify-content-center mb-4">
                            <div class="col-md-4">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <div class="small opacity-75 mb-1">Nouveau Total Collecté</div>
                                    <div class="h5 mb-0">{{ number_format($project->fundingTotal(), 0, ',', ' ') }} TND</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <div class="small opacity-75 mb-1">Objectif Restant</div>
                                    <div class="h5 mb-0">{{ number_format($project->budgetRemaining(), 0, ',', ' ') }} TND</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <div class="small opacity-75 mb-1">Progression</div>
                                    <div class="h5 mb-0">{{ $project->budget_prevu > 0 ? round(($project->fundingTotal() / $project->budget_prevu) * 100) : 0 }}%</div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>
                                Retour au Projet
                            </a>
                            <a href="{{ route('projects.index') }}" class="btn btn-outline-light">
                                <i class="fas fa-list me-2"></i>
                                Tous les Projets
                            </a>
                            <a href="{{ route('my-donations') }}" class="btn btn-outline-light">
                                <i class="fas fa-history me-2"></i>
                                Mes Dons
                            </a>
                        </div>
                    </div>
                </div>
                @else
                {{-- Donation Form --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        {{-- Project Info Header --}}
                        <div class="d-flex align-items-start gap-3 mb-4 pb-4 border-bottom">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <i class="fas fa-{{ $project->type === 'rénovation' ? 'tools' : ($project->type === 'extension' ? 'expand-arrows-alt' : 'water') }} fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="mb-2">{{ $project->titre }}</h4>
                                <p class="text-muted mb-2">{{ Str::limit($project->description, 120) }}</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $project->zone->nom }}
                                    </span>
                                    <span class="badge bg-{{ $project->statut === 'en_cours' ? 'success' : ($project->statut === 'planifié' ? 'info' : 'secondary') }}">
                                        {{ ucfirst(str_replace('_', ' ', $project->statut)) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Funding Progress --}}
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="fas fa-chart-line me-2 text-primary"></i>
                                Progression du Financement
                            </h5>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <div class="text-center p-3 bg-light rounded">
                                        <div class="small text-muted mb-1">Objectif</div>
                                        <div class="h5 mb-0 text-primary">{{ number_format($project->budget_prevu, 0, ',', ' ') }}</div>
                                        <div class="x-small text-muted">TND</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 bg-light rounded">
                                        <div class="small text-muted mb-1">Collecté</div>
                                        <div class="h5 mb-0 text-success">{{ number_format($project->fundingTotal(), 0, ',', ' ') }}</div>
                                        <div class="x-small text-muted">TND</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3 bg-light rounded">
                                        <div class="small text-muted mb-1">Restant</div>
                                        <div class="h5 mb-0 text-warning">{{ number_format($project->budgetRemaining(), 0, ',', ' ') }}</div>
                                        <div class="x-small text-muted">TND</div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $project->budget_prevu > 0 ? min(($project->fundingTotal() / $project->budget_prevu) * 100, 100) : 0 }}%"
                                     aria-valuenow="{{ $project->budget_prevu > 0 ? ($project->fundingTotal() / $project->budget_prevu) * 100 : 0 }}" 
                                     aria-valuemin="0" aria-valuemax="100">
                                    <span class="fw-bold">{{ $project->budget_prevu > 0 ? round(($project->fundingTotal() / $project->budget_prevu) * 100) : 0 }}%</span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Donation Form --}}
                        <form action="{{ route('projects.storeDonation', $project) }}" method="POST" id="donationForm">
                            @csrf

                            <div class="text-center mb-4">
                                <i class="fas fa-hand-holding-heart fa-3x text-primary mb-3"></i>
                                <h5 class="mb-2">Faire un Don Simulé</h5>
                                <p class="text-muted">
                                    Votre contribution, même modeste, fait la différence. 
                                    Chaque don rapproche ce projet de sa réalisation.
                                </p>
                            </div>

                            {{-- Amount Selection --}}
                            <div class="mb-4">
                                <label for="montant" class="form-label fw-bold">
                                    <i class="fas fa-coins me-2"></i>
                                    Montant du Don <span class="text-danger">*</span>
                                </label>
                                
                                {{-- Quick Amount Buttons --}}
                                <div class="row g-2 mb-3">
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" data-amount="50">
                                            50 TND
                                        </button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" data-amount="100">
                                            100 TND
                                        </button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" data-amount="250">
                                            250 TND
                                        </button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-primary w-100 amount-btn" data-amount="500">
                                            500 TND
                                        </button>
                                    </div>
                                </div>

                                {{-- Custom Amount Input --}}
                                <div class="input-group input-group-lg">
                                    <input type="number" 
                                           class="form-control @error('montant') is-invalid @enderror" 
                                           id="montant" 
                                           name="montant" 
                                           min="10" 
                                           max="{{ $project->budgetRemaining() }}"
                                           step="10"
                                           value="{{ old('montant') }}"
                                           placeholder="Ou entrez un montant personnalisé"
                                           required>
                                    <span class="input-group-text">TND</span>
                                    @error('montant')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Montant minimum: 10 TND | Maximum: {{ number_format($project->budgetRemaining(), 0, ',', ' ') }} TND
                                </div>
                            </div>

                            {{-- Message (Optional) --}}
                            <div class="mb-4">
                                <label for="message" class="form-label fw-bold">
                                    <i class="fas fa-comment me-2"></i>
                                    Message de Soutien <span class="text-muted small">(Optionnel)</span>
                                </label>
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          id="message" 
                                          name="message" 
                                          rows="4"
                                          maxlength="500"
                                          placeholder="Partagez vos motivations ou encouragements pour ce projet...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-end">
                                    <span id="charCount">0</span> / 500 caractères
                                </div>
                            </div>

                            {{-- Anonymous Option --}}
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="anonyme" name="anonyme" value="1" {{ old('anonyme') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="anonyme">
                                        <i class="fas fa-user-secret me-2"></i>
                                        Faire un don anonyme
                                        <small class="text-muted d-block">Votre nom ne sera pas affiché publiquement</small>
                                    </label>
                                </div>
                            </div>

                            {{-- Terms Acceptance --}}
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('terms') is-invalid @enderror" 
                                           type="checkbox" 
                                           id="terms" 
                                           name="terms"
                                           required>
                                    <label class="form-check-label" for="terms">
                                        Je confirme que ce don est simulé à des fins de démonstration et j'accepte les 
                                        <a href="#" class="text-decoration-none">conditions d'utilisation</a>
                                    </label>
                                    @error('terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Impact Preview --}}
                            <div class="alert alert-info border-0 mb-4" id="impactPreview" style="display: none;">
                                <div class="d-flex align-items-start gap-3">
                                    <i class="fas fa-lightbulb fa-2x"></i>
                                    <div>
                                        <h6 class="alert-heading mb-2">Impact de Votre Don</h6>
                                        <p class="mb-1">
                                            Votre contribution de <strong><span id="previewAmount">0</span> TND</strong> permettra de :
                                        </p>
                                        <ul class="mb-0 small">
                                            <li>Contribuer à l'amélioration de l'infrastructure hydraulique</li>
                                            <li>Rapprocher le projet de <strong><span id="previewPercentage">0</span>%</strong> de son objectif</li>
                                            <li>Participer activement au développement durable de votre région</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="d-flex gap-2 justify-content-between">
                                <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>
                                    Annuler
                                </a>
                                <button type="button" class="btn btn-primary btn-lg" id="reviewBtn">
                                    <i class="fas fa-eye me-2"></i>
                                    Vérifier et Confirmer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Information Card --}}
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-shield-alt me-2 text-success"></i>
                            Pourquoi Faire un Don ?
                        </h6>
                        <ul class="mb-0">
                            <li class="mb-2">
                                <strong>Transparence Totale:</strong> Suivez l'utilisation de votre contribution en temps réel
                            </li>
                            <li class="mb-2">
                                <strong>Impact Direct:</strong> Votre don finance directement les travaux d'infrastructure
                            </li>
                            <li class="mb-2">
                                <strong>Engagement Citoyen:</strong> Participez activement au développement de votre région
                            </li>
                            <li class="mb-0">
                                <strong>Sécurisé:</strong> Cette simulation démontre un système de don sécurisé et traçable
                            </li>
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 bg-primary text-white">
                    <h5 class="modal-title" id="confirmModalLabel">
                        <i class="fas fa-check-circle me-2"></i>
                        Confirmation de Don
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-hand-holding-heart fa-4x text-primary mb-3"></i>
                        <h5>Récapitulatif de Votre Don</h5>
                    </div>

                    <div class="card bg-light border-0 mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6 text-muted">Projet:</div>
                                <div class="col-6 text-end fw-bold">{{ Str::limit($project->titre, 25) }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 text-muted">Montant:</div>
                                <div class="col-6 text-end">
                                    <span class="h5 text-success mb-0" id="confirmAmount">0</span>
                                    <span class="text-success">TND</span>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-6 text-muted">Mode:</div>
                                <div class="col-6 text-end">
                                    <span class="badge bg-info" id="confirmAnonymous">Public</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="confirmMessage" class="alert alert-light border mb-3" style="display: none;">
                        <small class="text-muted d-block mb-1">Votre message:</small>
                        <div id="confirmMessageText" class="fst-italic"></div>
                    </div>

                    <div class="alert alert-warning border-0 mb-0 small">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> Il s'agit d'un don simulé à des fins de démonstration. 
                        Aucune transaction financière réelle ne sera effectuée.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left me-2"></i>
                        Modifier
                    </button>
                    <button type="button" class="btn btn-success" id="confirmSubmit">
                        <i class="fas fa-heart me-2"></i>
                        Confirmer le Don
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('donationForm');
            const montantInput = document.getElementById('montant');
            const messageInput = document.getElementById('message');
            const charCount = document.getElementById('charCount');
            const impactPreview = document.getElementById('impactPreview');
            const reviewBtn = document.getElementById('reviewBtn');
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            const confirmSubmit = document.getElementById('confirmSubmit');
            const budgetPrevu = {{ $project->budget_prevu }};
            const fundingTotal = {{ $project->fundingTotal() }};

            // Quick amount buttons
            document.querySelectorAll('.amount-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const amount = this.dataset.amount;
                    montantInput.value = amount;
                    document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    updateImpactPreview();
                });
            });

            // Character counter for message
            if (messageInput) {
                messageInput.addEventListener('input', function() {
                    charCount.textContent = this.value.length;
                });
                charCount.textContent = messageInput.value.length;
            }

            // Update impact preview when amount changes
            montantInput.addEventListener('input', updateImpactPreview);

            function updateImpactPreview() {
                const amount = parseFloat(montantInput.value) || 0;
                
                if (amount >= 10) {
                    impactPreview.style.display = 'block';
                    document.getElementById('previewAmount').textContent = amount.toLocaleString('fr-TN');
                    
                    const newTotal = fundingTotal + amount;
                    const newPercentage = budgetPrevu > 0 ? Math.round((newTotal / budgetPrevu) * 100) : 0;
                    document.getElementById('previewPercentage').textContent = newPercentage;
                } else {
                    impactPreview.style.display = 'none';
                }
            }

            // Review button - show confirmation modal
            reviewBtn.addEventListener('click', function() {
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const amount = parseFloat(montantInput.value);
                const message = messageInput.value.trim();
                const isAnonymous = document.getElementById('anonyme').checked;

                // Update modal content
                document.getElementById('confirmAmount').textContent = amount.toLocaleString('fr-TN');
                document.getElementById('confirmAnonymous').textContent = isAnonymous ? 'Anonyme' : 'Public';
                
                if (message) {
                    document.getElementById('confirmMessage').style.display = 'block';
                    document.getElementById('confirmMessageText').textContent = message;
                } else {
                    document.getElementById('confirmMessage').style.display = 'none';
                }

                confirmModal.show();
            });

            // Confirm submit
            confirmSubmit.addEventListener('click', function() {
                form.submit();
            });

            // Initial impact preview
            updateImpactPreview();
        });
    </script>

    <style>
        .amount-btn {
            transition: all 0.3s ease;
        }

        .amount-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .amount-btn.active {
            background-color: var(--bs-primary);
            color: white;
            border-color: var(--bs-primary);
        }

        .form-control:focus,
        .form-check-input:focus {
            border-color: #00b8d9;
            box-shadow: 0 0 0 0.25rem rgba(0, 184, 217, 0.25);
        }
    </style>
</x-project.layouts.front>
