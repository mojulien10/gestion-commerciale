<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                ➕ Nouveau Produit
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
                <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                                    value="{{ old('code') }}"
                                    placeholder="Ex: PROD-001" 
                                    class="input input-bordered input-lg w-full @error('code') input-error @enderror" 
                                    required
                                    autofocus
                                />
                                @error('code')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @else
                                    <label class="label">
                                        <span class="label-text-alt">Code unique pour identifier le produit</span>
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
                                    <option value="" disabled selected>Choisir une catégorie</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
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
                                value="{{ old('nom') }}"
                                placeholder="Ex: Sac de ciment 50kg Portland" 
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
                                placeholder="Description détaillée du produit..." 
                                class="textarea textarea-bordered textarea-lg w-full @error('description') textarea-error @enderror"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
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
                                    value="{{ old('prix_achat') }}"
                                    placeholder="0" 
                                    step="0.01"
                                    min="0"
                                    class="input input-bordered input-lg w-full @error('prix_achat') input-error @enderror" 
                                    required
                                    id="prix_achat"
                                    onchange="calculerMarge()"
                                />
                                @error('prix_achat')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @else
                                    <label class="label">
                                        <span class="label-text-alt">Prix auquel vous achetez le produit</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Prix de vente -->
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Prix de vente (TTC) <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="number" 
                                    name="prix_vente" 
                                    value="{{ old('prix_vente') }}"
                                    placeholder="0" 
                                    step="0.01"
                                    min="0"
                                    class="input input-bordered input-lg w-full @error('prix_vente') input-error @enderror" 
                                    required
                                    id="prix_vente"
                                    onchange="calculerMarge()"
                                />
                                @error('prix_vente')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @else
                                    <label class="label">
                                        <span class="label-text-alt">Prix auquel vous vendez le produit</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        <!-- Aperçu marge -->
                        <div class="bg-success/10 p-4 rounded-2xl mt-4 border border-success/20" id="marge-info" style="display: none;">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-success font-semibold">Marge unitaire</p>
                                    <p class="text-2xl font-bold text-success" id="marge-montant">0 XOF</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-success font-semibold">Pourcentage</p>
                                    <p class="text-2xl font-bold text-success" id="marge-pourcent">0%</p>
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
                                    <span class="label-text font-semibold">Stock initial <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="number" 
                                    name="stock_actuel" 
                                    value="{{ old('stock_actuel', 0) }}"
                                    placeholder="0" 
                                    min="0"
                                    class="input input-bordered input-lg w-full @error('stock_actuel') input-error @enderror" 
                                    required
                                />
                                @error('stock_actuel')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @else
                                    <label class="label">
                                        <span class="label-text-alt">Quantité en stock actuellement</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Seuil d'alerte -->
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Seuil d'alerte <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="number" 
                                    name="seuil_alerte" 
                                    value="{{ old('seuil_alerte', 10) }}"
                                    placeholder="10" 
                                    min="0"
                                    class="input input-bordered input-lg w-full @error('seuil_alerte') input-error @enderror" 
                                    required
                                />
                                @error('seuil_alerte')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @else
                                    <label class="label">
                                        <span class="label-text-alt">Alerte si stock ≤ cette valeur</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 4 : Image -->
                    <div class="bg-base-200/50 p-4 rounded-2xl mb-6">
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                            <span class="bg-info/10 p-2 rounded-lg">📸</span>
                            Image du produit
                        </h3>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-semibold">Photo du produit <span class="text-base-content/50">(optionnel)</span></span>
                            </label>
                            <input 
                                type="file" 
                                name="image" 
                                accept="image/*"
                                class="file-input file-input-bordered file-input-lg w-full @error('image') file-input-error @enderror"
                                onchange="previewImage(event)"
                            />
                            @error('image')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @else
                                <label class="label">
                                    <span class="label-text-alt">JPG, PNG ou GIF (max 2 Mo)</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Aperçu image -->
                        <div id="image-preview" class="mt-4" style="display: none;">
                            <p class="text-sm font-semibold mb-2">Aperçu :</p>
                            <img id="preview-img" src="" alt="Aperçu" class="max-w-xs rounded-2xl border border-base-300 shadow-lg">
                        </div>
                    </div>

                    <!-- Informations -->
                    <div class="bg-info/10 p-4 rounded-2xl mb-6 flex items-start gap-3 border border-info/20">
                        <span class="text-2xl">💡</span>
                        <div>
                            <p class="text-sm font-bold text-info">Conseil</p>
                            <p class="text-xs text-info/80">Remplissez tous les champs avec soin. Le code produit doit être unique et facilement identifiable.</p>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="card-actions justify-end">
                        <a href="{{ route('produits.index') }}" class="btn btn-ghost btn-lg">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Créer le produit
                        </button>
                    </div>
                </form>
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
                document.getElementById('marge-info').style.display = 'block';
            } else {
                document.getElementById('marge-info').style.display = 'none';
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
    </script>
</x-app-layout>