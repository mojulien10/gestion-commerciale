<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                📦 Gestion du Stock
            </h2>
            <a href="{{ route('produits.index') }}" class="btn btn-ghost gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success shadow-lg mb-6">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error shadow-lg mb-6">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Colonne gauche : Informations produit + Historique -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Informations produit -->
                <div class="card bg-base-100 shadow-xl border border-base-200">
                    <div class="card-body">
                        <div class="flex items-start gap-4">
                            <!-- Image produit -->
                            <div class="flex-shrink-0">
                                @if($produit->image)
                                    <img src="{{ asset('images/produits/' . $produit->image) }}" 
                                         alt="{{ $produit->nom }}" 
                                         class="w-24 h-24 object-cover rounded-2xl border border-base-300">
                                @else
                                    <div class="w-24 h-24 bg-gradient-to-br from-primary/10 to-accent/10 rounded-2xl flex items-center justify-center">
                                        <span class="text-4xl">📦</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Détails produit -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-xs font-mono text-base-content/50">{{ $produit->code }}</p>
                                        <h3 class="text-2xl font-bold mb-2">{{ $produit->nom }}</h3>
                                        <span class="badge badge-primary">{{ $produit->categorie->nom }}</span>
                                    </div>
                                    <a href="{{ route('produits.edit', $produit->id) }}" class="btn btn-sm btn-ghost">
                                        ✏️ Modifier
                                    </a>
                                </div>

                                @if($produit->description)
                                    <p class="text-base-content/60 mt-3">{{ $produit->description }}</p>
                                @endif

                                <!-- Prix -->
                                <div class="grid grid-cols-2 gap-3 mt-4">
                                    <div class="bg-base-200/50 p-3 rounded-xl">
                                        <p class="text-xs text-base-content/60">Prix de vente</p>
                                        <p class="text-lg font-bold text-primary">{{ number_format($produit->prix_vente, 0, ',', ' ') }} F</p>
                                    </div>
                                    <div class="bg-success/10 p-3 rounded-xl border border-success/20">
                                        <p class="text-xs text-success">Marge</p>
                                        <p class="text-lg font-bold text-success">{{ number_format($produit->pourcentage_marge, 1) }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock actuel -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="stat bg-base-100 shadow-xl border border-base-200 rounded-2xl">
                        <div class="stat-figure text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="stat-title">Stock actuel</div>
                        <div class="stat-value text-primary">{{ $produit->stock_actuel }}</div>
                        <div class="stat-desc">
                            @if($produit->stock_actuel == 0)
                                <span class="text-error font-semibold">⚠️ Rupture de stock</span>
                            @elseif($produit->isStockBas())
                                <span class="text-warning font-semibold">⚠️ Stock bas</span>
                            @else
                                <span class="text-success">✓ Stock suffisant</span>
                            @endif
                        </div>
                    </div>

                    <div class="stat bg-base-100 shadow-xl border border-base-200 rounded-2xl">
                        <div class="stat-figure text-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="stat-title">Seuil d'alerte</div>
                        <div class="stat-value text-warning">{{ $produit->seuil_alerte }}</div>
                        <div class="stat-desc">Alerte si stock ≤ {{ $produit->seuil_alerte }}</div>
                    </div>
                </div>

                <!-- Historique des mouvements -->
                <div class="card bg-base-100 shadow-xl border border-base-200">
                    <div class="card-body">
                        <h3 class="card-title text-xl mb-4 flex items-center gap-2">
                            <span class="bg-info/10 p-2 rounded-lg">📊</span>
                            Historique des mouvements
                        </h3>

                        @if($mouvements->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="table table-zebra">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Quantité</th>
                                            <th>Stock</th>
                                            <th>Motif</th>
                                            <th>Utilisateur</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mouvements as $mouvement)
                                            <tr>
                                                <td>
                                                    <div class="text-sm">
                                                        {{ $mouvement->created_at->format('d/m/Y') }}
                                                        <br>
                                                        <span class="text-xs text-base-content/50">{{ $mouvement->created_at->format('H:i') }}</span>
                                                    </div>
                                                </td>
                                                    <td>
    @if($mouvement->type === 'entree')
        <div class="badge badge-success badge-sm gap-1 whitespace-nowrap">
            ⬆️ Entrée
        </div>
    @elseif($mouvement->type === 'sortie')
        <div class="badge badge-error badge-sm gap-1 whitespace-nowrap">
            ⬇️ Sortie
        </div>
    @else
        <div class="badge badge-warning badge-sm gap-1 whitespace-nowrap">
            🔄 Ajustement
        </div>
    @endif
</td>
                                                <td>
                                                    <span class="font-semibold {{ $mouvement->quantite > 0 ? 'text-success' : 'text-error' }}">
                                                        {{ $mouvement->quantite > 0 ? '+' : '' }}{{ $mouvement->quantite }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="text-sm">
                                                        <span class="text-base-content/60">{{ $mouvement->stock_avant }}</span>
                                                        →
                                                        <span class="font-semibold">{{ $mouvement->stock_apres }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-sm">{{ $mouvement->motif }}</span>
                                                </td>
                                                <td>
                                                    <div class="flex items-center gap-2">
                                                        <div class="avatar placeholder">
                                                            <div class="bg-primary text-primary-content rounded-full w-8 h-8 flex items-center justify-center">
                                                                <span class="text-xs font-bold">{{ strtoupper(substr($mouvement->user->name, 0, 1)) }}</span>
                                                            </div>
                                                        </div>
                                                        <span class="text-sm">{{ $mouvement->user->name }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 bg-base-200/30 rounded-2xl">
                                <div class="text-4xl mb-2">📊</div>
                                <p class="text-base-content/60">Aucun mouvement de stock enregistré</p>
                                <p class="text-sm text-base-content/40 mt-1">Les mouvements s'afficheront ici automatiquement</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Formulaire ajustement -->
            <div class="lg:col-span-1">
                <div class="card bg-base-100 shadow-xl border border-base-200 sticky top-24">
                    <div class="card-body">
                        <h3 class="card-title text-xl mb-4 flex items-center gap-2">
                            <span class="bg-warning/10 p-2 rounded-lg">🔄</span>
                            Ajuster le stock
                        </h3>

                        @if ($errors->any())
                            <div class="alert alert-error alert-sm mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <span class="text-xs">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('produits.ajuster', $produit->id) }}" method="POST">
                            @csrf

                            <!-- Stock actuel (lecture seule) -->
                            <div class="form-control w-full mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold">Stock actuel</span>
                                </label>
                                <input 
                                    type="text" 
                                    value="{{ $produit->stock_actuel }}" 
                                    class="input input-bordered input-lg bg-base-200" 
                                    disabled
                                />
                            </div>

                            <!-- Nouveau stock -->
                            <div class="form-control w-full mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold">Nouveau stock <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="number" 
                                    name="nouveau_stock" 
                                    value="{{ old('nouveau_stock', $produit->stock_actuel) }}"
                                    placeholder="0" 
                                    min="0"
                                    class="input input-bordered input-lg w-full @error('nouveau_stock') input-error @enderror" 
                                    required
                                    id="nouveau_stock"
                                    onchange="calculerDifference()"
                                />
                            </div>

                            <!-- Aperçu différence -->
                            <div class="bg-info/10 p-3 rounded-xl mb-4 border border-info/20" id="difference-info" style="display: none;">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-info font-semibold">Différence</span>
                                    <span class="text-lg font-bold text-info" id="difference-value">0</span>
                                </div>
                            </div>

                            <!-- Motif -->
                            <div class="form-control w-full mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold">Motif de l'ajustement <span class="text-error">*</span></span>
                                </label>
                                <textarea 
                                    name="motif" 
                                    rows="3"
                                    placeholder="Ex: Inventaire physique, produits endommagés, erreur de saisie..." 
                                    class="textarea textarea-bordered textarea-lg w-full @error('motif') textarea-error @enderror"
                                    required
                                >{{ old('motif') }}</textarea>
                                <label class="label">
                                    <span class="label-text-alt">Expliquez la raison de cet ajustement</span>
                                </label>
                            </div>

                            <!-- Informations -->
                            <div class="bg-warning/10 p-3 rounded-xl mb-4 flex items-start gap-2 border border-warning/20">
                                <span class="text-lg">⚠️</span>
                                <p class="text-xs text-warning/80">
                                    Cet ajustement sera enregistré dans l'historique et ne pourra pas être annulé.
                                </p>
                            </div>

                            <!-- Bouton -->
                            <button type="submit" class="btn btn-warning btn-block btn-lg gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Ajuster le stock
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script pour calculer la différence -->
    <script>
        const stockActuel = {{ $produit->stock_actuel }};

        function calculerDifference() {
            const nouveauStock = parseInt(document.getElementById('nouveau_stock').value) || 0;
            const difference = nouveauStock - stockActuel;
            
            if (difference !== 0) {
                document.getElementById('difference-value').textContent = (difference > 0 ? '+' : '') + difference;
                document.getElementById('difference-info').style.display = 'block';
            } else {
                document.getElementById('difference-info').style.display = 'none';
            }
        }

        // Calculer au chargement si valeur pré-remplie
        window.onload = function() {
            calculerDifference();
        }
    </script>
</x-app-layout>