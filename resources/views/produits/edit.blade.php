<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                ✏️ Modifier le Produit
            </h2>
            <a href="{{ route('produits.index') }}" class="btn btn-ghost gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Afficher les erreurs de validation -->
        @if ($errors->any())
            <div class="alert alert-error shadow-lg mb-6">
                <div class="flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="font-bold text-error-content">Erreurs de validation</h3>
                        <ul class="list-disc list-inside text-error-content mt-2">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulaire -->
        <div class="card bg-base-100 shadow-xl border border-base-200">
            <div class="card-body">
                <!-- En-tête avec info produit -->
                <div class="bg-base-200/50 p-4 rounded-2xl mb-6">
                    <div class="flex items-center gap-4">
                        @if($produit->image)
                            <img src="{{ asset('images/produits/' . $produit->image) }}" alt="{{ $produit->nom }}" class="w-20 h-20 object-cover rounded-xl border border-base-300">
                        @else
                            <div class="w-20 h-20 bg-gradient-to-br from-primary/10 to-accent/10 rounded-xl flex items-center justify-center">
                                <span class="text-3xl">📦</span>
                            </div>
                        @endif
                        <div>
                            <p class="text-xs font-mono text-base-content/50">{{ $produit->code }}</p>
                            <p class="text-2xl font-bold">{{ $produit->nom }}</p>
                            <span class="badge badge-primary badge-sm">{{ $produit->categorie->nom }}</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Section 1 : Informations de base -->
                    <div class="bg-base-200/50 p-4 rounded-2xl mb-6">
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                            <span class="bg-primary/10 p-2 rounded-lg">📋</span>
                            Informations de base
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Code produit -->
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Code produit <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="text" 
                                    name="code" 
                                    value="{{ old('code', $produit->code) }}"
                                    placeholder="Ex: PROD-001" 
                                    class="input input-bordered input-lg w-full @error('code') input-error @enderror" 
                                    required
                                />
                                @error('code')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Catégorie -->
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Catégorie <span class="text-error">*</span></span>
                                </label>
                                <select 
                                    name="categorie_id" 
                                    class="select select-bordered select-lg w-full @error('categorie_id') select-error @enderror"
                                    required
                                >
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}" {{ old('categorie_id', $produit->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categorie_id')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <!-- Nom produit -->
                        <div class="form-control w-full mt-4">
                            <label class="label">
                                <span class="label-text font-semibold">Nom du produit <span class="text-error">*</span></span>
                            </label>
                            <input 
                                type="text" 
                                name="nom" 
                                value="{{ old('nom', $produit->nom) }}"
                                class="input input-bordered input-lg w-full @error('nom') input-error @enderror" 
                                required
                            />
                            @error('nom')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-control w-full mt-4">
                            <label class="label">
                                <span class="label-text font-semibold">Description <span class="text-base-content/50">(optionnel)</span></span>
                            </label>
                            <textarea 
                                name="description" 
                                rows="3"
                                class="textarea textarea-bordered textarea-lg w-full @error('description') textarea-error @enderror"
                            >{{ old('description', $produit->description) }}</textarea>
                        </div>
                    </div>

                    <!-- Section 2 : Prix et marges -->
                    <div class="bg-base-200/50 p-4 rounded-2xl mb-6">
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                            <span class="bg-success/10 p-2 rounded-lg">💰</span>
                            Prix et marges
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Prix d'achat -->
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Prix d'achat (HT) <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="number" 
                                    name="prix_achat" 
                                    value="{{ old('prix_achat', $produit->prix_achat) }}"
                                    step="0.01"
                                    min="0"
                                    class="input input-bordered input-lg w-full @error('prix_achat') input-error @enderror" 
                                    required
                                    id="prix_achat"
                                    onchange="calculerMarge()"
                                />
                            </div>

                            <!-- Prix de vente -->
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Prix de vente (TTC) <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="number" 
                                    name="prix_vente" 
                                    value="{{ old('prix_vente', $produit->prix_vente) }}"
                                    step="0.01"
                                    min="0"
                                    class="input input-bordered input-lg w-full @error('prix_vente') input-error @enderror" 
                                    required
                                    id="prix_vente"
                                    onchange="calculerMarge()"
                                />
                            </div>
                        </div>

                        <!-- Aperçu marge -->
                        <div class="bg-success/10 p-4 rounded-2xl mt-4 border border-success/20" id="marge-info">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-success font-semibold">Marge unitaire</p>
                                    <p class="text-2xl font-bold text-success" id="marge-montant">{{ number_format($produit->marge, 0, ',', ' ') }} XOF</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-success font-semibold">Pourcentage</p>
                                    <p class="text-2xl font-bold text-success" id="marge-pourcent">{{ number_format($produit->pourcentage_marge, 1) }}%</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3 : Stock -->
                    <div class="bg-base-200/50 p-4 rounded-2xl mb-6">
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                            <span class="bg-warning/10 p-2 rounded-lg">📦</span>
                            Gestion du stock
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Stock actuel -->
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Stock actuel <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="number" 
                                    name="stock_actuel" 
                                    value="{{ old('stock_actuel', $produit->stock_actuel) }}"
                                    min="0"
                                    class="input input-bordered input-lg w-full @error('stock_actuel') input-error @enderror" 
                                    required
                                />
                            </div>

                            <!-- Seuil d'alerte -->
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Seuil d'alerte <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="number" 
                                    name="seuil_alerte" 
                                    value="{{ old('seuil_alerte', $produit->seuil_alerte) }}"
                                    min="0"
                                    class="input input-bordered input-lg w-full @error('seuil_alerte') input-error @enderror" 
                                    required
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Section 4 : Image -->
                    <div class="bg-base-200/50 p-4 rounded-2xl mb-6">
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                            <span class="bg-info/10 p-2 rounded-lg">📸</span>
                            Image du produit
                        </h3>

                        <!-- Image actuelle -->
                        @if($produit->image)
                            <div class="mb-4">
                                <p class="text-sm font-semibold mb-2">Image actuelle :</p>
                                <img src="{{ asset('images/produits/' . $produit->image) }}" alt="{{ $produit->nom }}" class="max-w-xs rounded-2xl border border-base-300 shadow-lg">
                            </div>
                        @endif

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">
                                    {{ $produit->image ? 'Remplacer l\'image' : 'Ajouter une image' }} 
                                    <span class="text-base-content/50">(optionnel)</span>
                                </span>
                            </label>
                            <input 
                                type="file" 
                                name="image" 
                                accept="image/*"
                                class="file-input file-input-bordered file-input-lg w-full @error('image') file-input-error @enderror"
                                onchange="previewImage(event)"
                            />
                            <label class="label">
                                <span class="label-text-alt">JPG, PNG ou GIF (max 2 Mo)</span>
                            </label>
                        </div>

                        <!-- Aperçu nouvelle image -->
                        <div id="image-preview" class="mt-4" style="display: none;">
                            <p class="text-sm font-semibold mb-2">Nouvelle image :</p>
                            <img id="preview-img" src="" alt="Aperçu" class="max-w-xs rounded-2xl border border-base-300 shadow-lg">
                        </div>
                    </div>

                    <!-- Informations modification -->
                    <div class="bg-warning/10 p-4 rounded-2xl mb-6 flex items-start gap-3 border border-warning/20">
                        <span class="text-2xl">⚠️</span>
                        <div>
                            <p class="text-sm font-bold text-warning">Attention</p>
                            <p class="text-xs text-warning/80">Les modifications seront appliquées immédiatement et affecteront toutes les ventes futures.</p>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="card-actions justify-end">
                        <a href="{{ route('produits.index') }}" class="btn btn-ghost btn-lg">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-warning btn-lg gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>

                <div class="divider"></div>

                <!-- Zone de danger -->
                <div class="bg-error/10 p-4 rounded-2xl border border-error/20">
                    <h4 class="font-bold text-error mb-2">⚠️ Zone de danger</h4>
                    <p class="text-sm text-error/80 mb-4">La suppression d'un produit est irréversible.</p>
                    <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-error btn-sm gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script pour calcul marge et aperçu image -->
    <script>
        // Calculer la marge en temps réel
        function calculerMarge() {
            const prixAchat = parseFloat(document.getElementById('prix_achat').value) || 0;
            const prixVente = parseFloat(document.getElementById('prix_vente').value) || 0;
            
            if (prixAchat > 0 && prixVente > 0) {
                const marge = prixVente - prixAchat;
                const pourcent = ((marge / prixAchat) * 100).toFixed(1);
                
                document.getElementById('marge-montant').textContent = marge.toLocaleString('fr-FR') + ' XOF';
                document.getElementById('marge-pourcent').textContent = pourcent + '%';
            }
        }

        // Aperçu de l'image
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview-img');
                preview.src = reader.result;
                document.getElementById('image-preview').style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // Calculer la marge au chargement
        window.onload = function() {
            calculerMarge();
        }
    </script>
</x-app-layout>