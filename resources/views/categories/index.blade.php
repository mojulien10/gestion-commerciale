<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                📁 Gestion des Catégories
            </h2>
            <a href="{{ route('categories.create') }}" class="btn btn-primary gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle Catégorie
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

        <!-- Statistique -->
        <div class="stat bg-primary text-primary-content rounded-2xl shadow-xl mb-6 w-full max-w-sm">
            <div class="stat-figure text-primary-content/60">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div class="stat-title text-primary-content/70">Total Catégories</div>
            <div class="stat-value">{{ $categories->count() }}</div>
            <div class="stat-desc text-primary-content/60">Catégories actives</div>
        </div>

        <!-- Liste des catégories -->
        @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $categorie)
                    <div class="card bg-base-100 shadow-xl border border-base-200 hover:shadow-2xl transition-shadow">
                        <div class="card-body">
                            <div class="flex justify-between items-start mb-4">
                                <div class="bg-primary/10 p-3 rounded-xl">
                                    <span class="text-3xl">📦</span>
                                </div>
                                <div class="dropdown dropdown-end">
                                    <label tabindex="0" class="btn btn-ghost btn-sm btn-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-5 h-5 stroke-current">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                    </label>
                                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-200">
                                        <li>
                                            <a href="{{ route('categories.edit', $categorie->id) }}">
                                                ✏️ Modifier
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('categories.destroy', $categorie->id) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-error w-full text-left">
                                                    🗑️ Supprimer
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <h3 class="card-title text-2xl font-bold mb-2">{{ $categorie->nom }}</h3>
                            
                            @if($categorie->description)
                                <p class="text-base-content/60 mb-4">{{ Str::limit($categorie->description, 80) }}</p>
                            @else
                                <p class="text-base-content/40 italic mb-4">Aucune description</p>
                            @endif

                            <div class="divider my-2"></div>

                            <div class="flex items-center justify-between text-sm">
                                <span class="text-base-content/50">
                                    Créée le {{ $categorie->created_at->format('d/m/Y') }}
                                </span>
                                <span class="badge badge-ghost">
                                    ID: {{ str_pad($categorie->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
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
                        <div class="text-6xl mb-4">📁</div>
                        <h3 class="text-2xl font-bold mb-2">Aucune catégorie</h3>
                        <p class="text-base-content/60 mb-6">Commencez par créer votre première catégorie de produits</p>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                            Créer une catégorie
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
