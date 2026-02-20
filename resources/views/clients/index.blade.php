<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                👥 Gestion des Clients
            </h2>
            <a href="{{ route('clients.create') }}" class="btn btn-primary gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau Client
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
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

        <!-- Statistiques rapides -->
        <div class="stats shadow mb-6 w-full">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Total Clients</div>
                <div class="stat-value text-primary">{{ $clients->count() }}</div>
                <div class="stat-desc">Clients enregistrés</div>
            </div>
            
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Achats Totaux</div>
                <div class="stat-value text-secondary">{{ $clients->sum('nombre_achats') }}</div>
                <div class="stat-desc">Transactions effectuées</div>
            </div>
            
            <div class="stat">
                <div class="stat-figure text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title">Chiffre d'Affaires</div>
                <div class="stat-value text-accent">{{ number_format($clients->sum('total_achats'), 0, ',', ' ') }}</div>
                <div class="stat-desc">XOF</div>
            </div>
        </div>
        <!-- Barre de recherche -->
<div class="card bg-base-100 shadow-xl mb-6">
    <div class="card-body">
        <form action="{{ route('clients.index') }}" method="GET" class="flex gap-2">
            <input 
                type="text" 
                name="search" 
                value="{{ $search ?? '' }}"
                placeholder="🔍 Rechercher par nom, téléphone ou email..." 
                class="input input-bordered flex-1"
            />
            <button type="submit" class="btn btn-primary">
                Rechercher
            </button>
            @if($search ?? false)
                <a href="{{ route('clients.index') }}" class="btn btn-ghost">
                    Réinitialiser
                </a>
            @endif
        </form>
        
        @if($search ?? false)
            <div class="mt-2 text-sm text-base-content/60">
                📊 {{ $clients->count() }} résultat(s) pour "<strong>{{ $search }}</strong>"
            </div>
        @endif
    </div>
</div>

        <!-- Tableau des clients -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                @if($clients->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
                                    <th class="text-center">Achats</th>
                                    <th class="text-right">Total (XOF)</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($clients as $client)
    <tr class="hover">
        <td>
            <div class="flex items-center space-x-3">
                <div class="avatar placeholder">
                    <div class="bg-primary text-primary-content rounded-full w-12 h-12 flex items-center justify-center">
                        <span class="text-xl font-bold">{{ strtoupper(substr($client->nom, 0, 1)) }}</span>
                    </div>
                </div>
                <div>
                    <div class="font-bold">{{ $client->nom }}</div>
                    @if($client->adresse)
                        <div class="text-sm opacity-50">{{ Str::limit($client->adresse, 30) }}</div>
                    @endif
                </div>
            </div>
        </td>
        <td>
            <span class="badge badge-ghost">{{ $client->telephone }}</span>
        </td>
        <td>
            @if($client->email)
                <span class="text-sm">{{ $client->email }}</span>
            @else
                <span class="text-sm opacity-50">N/A</span>
            @endif
        </td>
        <td class="text-center">
            <div class="badge badge-info badge-lg gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                {{ $client->nombre_achats }}
            </div>
        </td>
        
        <td class="text-right font-semibold">
            {{ number_format($client->total_achats, 0, ',', ' ') }}
        </td>

        <td class="text-center">
            <div class="flex gap-1 items-center justify-center">
                <a href="{{ route('clients.show', $client->id) }}" class="btn btn-sm btn-ghost btn-square" title="Voir">
                    👁️
                </a>
                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-ghost btn-square" title="Modifier">
                    ✏️
                </a>
                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Supprimer {{ $client->nom }} ?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-ghost btn-square text-error" title="Supprimer">
                        🗑️
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">📋</div>
                        <h3 class="text-2xl font-bold mb-2">Aucun client enregistré</h3>
                        <p class="text-base-content/60 mb-6">Commencez par ajouter votre premier client</p>
                        <a href="{{ route('clients.create') }}" class="btn btn-primary">
                            Ajouter un client
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
