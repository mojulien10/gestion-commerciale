<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                📦 Gestion des Produits
            </h2>
            <a href="{{ route('produits.create') }}" class="btn btn-primary gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau Produit
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Message de succès -->
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

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="stat bg-primary text-primary-content rounded-2xl shadow-xl">
                <div class="stat-figure text-primary-content/60">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="stat-title text-primary-content/70">Total Produits</div>
                <div class="stat-value">{{ $produits->count() }}</div>
                <div class="stat-desc text-primary-content/60">Articles référencés</div>
            </div>

            <div class="stat bg-success text-success-content rounded-2xl shadow-xl">
                <div class="stat-figure text-success-content/60">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title text-success-content/70">En Stock</div>
                <div class="stat-value">{{ $produits->where('stock_actuel', '>', 0)->count() }}</div>
                <div class="stat-desc text-success-content/60">Produits disponibles</div>
            </div>

            <div class="stat bg-warning text-warning-content rounded-2xl shadow-xl">
                <div class="stat-figure text-warning-content/60">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="stat-title text-warning-content/70">Stock Bas</div>
                <div class="stat-value">{{ $produits->filter(fn($p) => $p->isStockBas())->count() }}</div>
                <div class="stat-desc text-warning-content/60">Alertes actives</div>
            </div>

            <div class="stat bg-accent text-accent-content rounded-2xl shadow-xl">
                <div class="stat-figure text-accent-content/60">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title text-accent-content/70">Valeur Stock</div>
                <div class="stat-value text-2xl">{{ number_format($produits->sum(fn($p) => $p->stock_actuel * $p->prix_vente), 0, ',', ' ') }}</div>
                <div class="stat-desc text-accent-content/60">XOF</div>
            </div>
        </div>

        <!-- Filtres par catégorie -->
        <div class="card bg-base-100 shadow-xl border border-base-200 mb-6">
            <div class="card-body p-4">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('produits.index') }}" class="btn btn-sm {{ !request('categorie') ? 'btn-primary' : 'btn-ghost' }}">
                        Toutes les catégories ({{ $produits->count() }})
                    </a>
                    @foreach($categories as $categorie)
                        <a href="{{ route('produits.index', ['categorie' => $categorie->id]) }}" 
                           class="btn btn-sm {{ request('categorie') == $categorie->id ? 'btn-primary' : 'btn-ghost' }}">
                            {{ $categorie->nom }} ({{ $produits->where('categorie_id', $categorie->id)->count() }})
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Liste des produits -->
        @if($produits->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($produits as $produit)
                    <div class="card bg-base-100 shadow-xl border border-base-200 hover:shadow-2xl transition-shadow">
                        <!-- Image produit -->
                        <figure class="relative h-48 bg-base-200">
                            @if($produit->image)
                                <img src="{{ asset('images/produits/' . $produit->image) }}" 
                                     alt="{{ $produit->nom }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-accent/10">
                                    <span class="text-6xl">📦</span>
                                </div>
                            @endif
                            
                            <!-- Badge stock -->
                            <div class="absolute top-2 right-2">
                                @if($produit->stock_actuel == 0)
                                    <span class="badge badge-error badge-lg">Rupture</span>
                                @elseif($produit->isStockBas())
                                    <span class="badge badge-warning badge-lg">Stock bas</span>
                                @else
                                    <span class="badge badge-success badge-lg">En stock</span>
                                @endif
                            </div>

                            <!-- Badge catégorie -->
                            <div class="absolute top-2 left-2">
                                <span class="badge badge-primary badge-sm">{{ $produit->categorie->nom }}</span>
                            </div>
                        </figure>

                        <div class="card-body p-4">
                            <!-- Code produit -->
                            <div class="text-xs font-mono text-base-content/50 mb-1">{{ $produit->code }}</div>
                            
                            <!-- Nom produit -->
                            <h3 class="card-title text-lg mb-2 line-clamp-2">{{ $produit->nom }}</h3>

                            <!-- Prix -->
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                <div class="bg-base-200/50 p-2 rounded-lg">
                                    <p class="text-xs text-base-content/60">Prix vente</p>
                                    <p class="text-lg font-bold text-primary">{{ number_format($produit->prix_vente, 0, ',', ' ') }} F</p>
                                </div>
                                <div class="bg-base-200/50 p-2 rounded-lg">
                                    <p class="text-xs text-base-content/60">Stock</p>
                                    <p class="text-lg font-bold">{{ $produit->stock_actuel }}</p>
                                </div>
                            </div>

                            <!-- Marge -->
                            <div class="bg-success/10 p-2 rounded-lg mb-3 border border-success/20">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-success font-semibold">Marge</span>
                                    <span class="text-sm font-bold text-success">{{ number_format($produit->pourcentage_marge, 1) }}%</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card-actions justify-end">
                                <a href="{{ route('produits.edit', $produit->id) }}" class="btn btn-sm btn-ghost" title="Modifier">
                                    ✏️
                                </a>
                                <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost text-error" title="Supprimer">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty state -->
            <div class="card bg-base-100 shadow-xl border border-base-200">
                <div class="card-body">
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">📦</div>
                        <h3 class="text-2xl font-bold mb-2">Aucun produit</h3>
                        <p class="text-base-content/60 mb-6">Commencez par ajouter votre premier produit au catalogue</p>
                        <a href="{{ route('produits.create') }}" class="btn btn-primary">
                            Ajouter un produit
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>