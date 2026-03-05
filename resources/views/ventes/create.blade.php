<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                ➕ Nouvelle Vente
            </h2>
            <a href="{{ route('ventes.index') }}" class="btn btn-ghost gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Messages d'erreur -->
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

        @if ($errors->any())
            <div class="alert alert-error shadow-lg mb-6">
                <div class="flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="font-bold">Erreurs de validation</h3>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('ventes.store') }}" method="POST" id="venteForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Colonne gauche : Sélection client + Catalogue produits -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Sélection client -->
                    <div class="card bg-base-100 shadow-xl border border-base-200">
                        <div class="card-body">
                            <h3 class="card-title text-xl mb-4 flex items-center gap-2">
                                <span class="bg-primary/10 p-2 rounded-lg">👤</span>
                                Sélectionner le client
                            </h3>

                            <div class="form-control w-full">
                                <select 
                                    name="client_id" 
                                    id="client_id"
                                    class="select select-bordered select-lg w-full @error('client_id') select-error @enderror"
                                    required
                                >
                                    <option value="" disabled selected>Choisir un client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->nom }} - {{ $client->telephone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Catalogue des produits -->
                    <div class="card bg-base-100 shadow-xl border border-base-200">
                        <div class="card-body">
                            <h3 class="card-title text-xl mb-4 flex items-center gap-2">
                                <span class="bg-success/10 p-2 rounded-lg">📦</span>
                                Catalogue des produits
                            </h3>

                            <!-- Barre de recherche produits -->
                            <div class="form-control w-full mb-4">
                                <input 
                                    type="text" 
                                    id="searchProduit"
                                    placeholder="🔍 Rechercher un produit..." 
                                    class="input input-bordered input-lg w-full"
                                    onkeyup="filtrerProduits()"
                                />
                            </div>

                            <!-- Liste des produits -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto" id="catalogueProduits">
                                @foreach($produits as $produit)
                                    <div class="card bg-base-200/50 border border-base-300 hover:shadow-lg transition-shadow produit-item" data-nom="{{ strtolower($produit->nom) }}" data-categorie="{{ strtolower($produit->categorie->nom) }}">
                                        <div class="card-body p-4">
                                            <div class="flex items-start gap-3">
                                                <!-- Image produit -->
                                                @if($produit->image)
                                                    <img src="{{ asset('images/produits/' . $produit->image) }}" 
                                                         alt="{{ $produit->nom }}" 
                                                         class="w-16 h-16 object-cover rounded-lg">
                                                @else
                                                    <div class="w-16 h-16 bg-gradient-to-br from-primary/10 to-accent/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                                        <span class="text-2xl">📦</span>
                                                    </div>
                                                @endif

                                                <!-- Infos produit -->
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs text-base-content/50 mb-1">{{ $produit->code }}</p>
                                                    <h4 class="font-semibold text-sm line-clamp-2 mb-1">{{ $produit->nom }}</h4>
                                                    <span class="badge badge-primary badge-xs">{{ $produit->categorie->nom }}</span>
                                                    
                                                    <div class="flex items-center justify-between mt-2">
                                                        <div>
                                                            <p class="text-lg font-bold text-primary">{{ number_format($produit->prix_vente, 0, ',', ' ') }} F</p>
                                                            <p class="text-xs text-base-content/60">Stock: {{ $produit->stock_actuel }}</p>
                                                        </div>
                                                        <button 
                                                            type="button"
                                                            class="btn btn-primary btn-sm btn-circle"
                                                            onclick="ajouterAuPanier({{ $produit->id }}, '{{ addslashes($produit->nom) }}', {{ $produit->prix_vente }}, {{ $produit->stock_actuel }})"
                                                        >
                                                            +
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne droite : Panier -->
                <div class="lg:col-span-1">
                    <div class="card bg-base-100 shadow-xl border border-base-200 sticky top-24">
                        <div class="card-body">
                            <h3 class="card-title text-xl mb-4 flex items-center gap-2">
                                <span class="bg-warning/10 p-2 rounded-lg">🛒</span>
                                Panier
                            </h3>

                           <!-- Liste des produits dans le panier -->
<div id="panierContainer" class="space-y-3 mb-4 max-h-80 overflow-y-auto">
    <!-- Les produits seront ajoutés ici par JavaScript -->
</div>

<!-- Empty state (en dehors du container) -->
<div id="panierVide" class="text-center py-8 bg-base-200/30 rounded-2xl mb-4">
    <div class="text-4xl mb-2">🛒</div>
    <p class="text-base-content/60 text-sm">Le panier est vide</p>
    <p class="text-base-content/40 text-xs mt-1">Ajoutez des produits</p>
</div>

                            <div class="divider"></div>

                            <!-- Total -->
                            <div class="bg-primary/10 p-4 rounded-2xl border border-primary/20 mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold">Sous-total</span>
                                    <span class="text-lg font-bold" id="sousTotal">0 F</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-primary">TOTAL</span>
                                    <span class="text-2xl font-bold text-primary" id="total">0 F</span>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="form-control w-full mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold">Notes <span class="text-base-content/50">(optionnel)</span></span>
                                </label>
                                <textarea 
                                    name="notes" 
                                    rows="2"
                                    placeholder="Remarques sur cette vente..." 
                                    class="textarea textarea-bordered"
                                >{{ old('notes') }}</textarea>
                            </div>

                            <!-- Bouton validation -->
                            <button 
                                type="submit" 
                                class="btn btn-primary btn-lg btn-block gap-2"
                                id="btnValider"
                                disabled
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Valider la vente
                            </button>

                            <div id="alertePanier" class="alert alert-warning alert-sm mt-4" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-xs">Ajoutez des produits au panier</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Script JavaScript pour le panier -->
    <script>
        // Panier global
        let panier = [];

        // Ajouter un produit au panier
        function ajouterAuPanier(produitId, nom, prix, stockMax) {
            // Vérifier si le produit existe déjà dans le panier
            const index = panier.findIndex(item => item.produitId === produitId);
            
            if (index !== -1) {
                // Le produit existe déjà, augmenter la quantité
                if (panier[index].quantite < stockMax) {
                    panier[index].quantite++;
                } else {
                    alert('Stock maximum atteint pour ce produit !');
                    return;
                }
            } else {
                // Nouveau produit
                panier.push({
                    produitId: produitId,
                    nom: nom,
                    prix: prix,
                    quantite: 1,
                    stockMax: stockMax
                });
            }
            
            afficherPanier();
        }

        // Retirer un produit du panier
        function retirerDuPanier(produitId) {
            panier = panier.filter(item => item.produitId !== produitId);
            afficherPanier();
        }

        // Modifier la quantité
        function modifierQuantite(produitId, delta) {
            const index = panier.findIndex(item => item.produitId === produitId);
            if (index !== -1) {
                const nouvelleQuantite = panier[index].quantite + delta;
                
                if (nouvelleQuantite <= 0) {
                    retirerDuPanier(produitId);
                } else if (nouvelleQuantite <= panier[index].stockMax) {
                    panier[index].quantite = nouvelleQuantite;
                    afficherPanier();
                } else {
                    alert('Stock maximum atteint !');
                }
            }
        }

       // Afficher le panier
function afficherPanier() {
    const panierContainer = document.getElementById('panierContainer');
    const panierVide = document.getElementById('panierVide');
    const btnValider = document.getElementById('btnValider');
    const alertePanier = document.getElementById('alertePanier');
    
    if (panier.length === 0) {
        // Panier vide
        panierContainer.innerHTML = '';
        panierVide.style.display = 'block';
        btnValider.disabled = true;
        alertePanier.style.display = 'flex';
        
        // Supprimer tous les inputs cachés
        document.querySelectorAll('.panier-input').forEach(el => el.remove());
    } else {
        // Panier avec des produits
        panierVide.style.display = 'none';
        btnValider.disabled = false;
        alertePanier.style.display = 'none';
        
        let html = '';
        panier.forEach(item => {
            const sousTotal = item.prix * item.quantite;
            html += `
                <div class="bg-base-200/50 p-3 rounded-xl border border-base-300">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <p class="font-semibold text-sm">${item.nom}</p>
                            <p class="text-xs text-base-content/60">${item.prix.toLocaleString('fr-FR')} F × ${item.quantite}</p>
                        </div>
                        <button type="button" class="btn btn-ghost btn-xs btn-circle" onclick="retirerDuPanier(${item.produitId})">
                            ✕
                        </button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="join">
                            <button type="button" class="btn btn-xs join-item" onclick="modifierQuantite(${item.produitId}, -1)">-</button>
                            <button type="button" class="btn btn-xs join-item">${item.quantite}</button>
                            <button type="button" class="btn btn-xs join-item" onclick="modifierQuantite(${item.produitId}, 1)">+</button>
                        </div>
                        <span class="font-bold text-primary">${sousTotal.toLocaleString('fr-FR')} F</span>
                    </div>
                </div>
            `;
        });
        
        panierContainer.innerHTML = html;
        
        // Créer les inputs cachés pour le formulaire
        document.querySelectorAll('.panier-input').forEach(el => el.remove());
        panier.forEach((item, index) => {
            const inputProduitId = document.createElement('input');
            inputProduitId.type = 'hidden';
            inputProduitId.name = `produits[${index}][produit_id]`;
            inputProduitId.value = item.produitId;
            inputProduitId.className = 'panier-input';
            document.getElementById('venteForm').appendChild(inputProduitId);
            
            const inputQuantite = document.createElement('input');
            inputQuantite.type = 'hidden';
            inputQuantite.name = `produits[${index}][quantite]`;
            inputQuantite.value = item.quantite;
            inputQuantite.className = 'panier-input';
            document.getElementById('venteForm').appendChild(inputQuantite);
        });
    }
    
    calculerTotal();
}

        // Calculer le total
        function calculerTotal() {
            const total = panier.reduce((sum, item) => sum + (item.prix * item.quantite), 0);
            document.getElementById('sousTotal').textContent = total.toLocaleString('fr-FR') + ' F';
            document.getElementById('total').textContent = total.toLocaleString('fr-FR') + ' F';
        }

        // Filtrer les produits
        function filtrerProduits() {
            const search = document.getElementById('searchProduit').value.toLowerCase();
            const produits = document.querySelectorAll('.produit-item');
            
            produits.forEach(produit => {
                const nom = produit.getAttribute('data-nom');
                const categorie = produit.getAttribute('data-categorie');
                
                if (nom.includes(search) || categorie.includes(search)) {
                    produit.style.display = 'block';
                } else {
                    produit.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>