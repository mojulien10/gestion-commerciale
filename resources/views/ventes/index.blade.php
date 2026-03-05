<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                💰 Gestion des Ventes
            </h2>
            <a href="{{ route('ventes.create') }}" class="btn btn-primary gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvelle Vente
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="stat-title text-primary-content/70">Total Ventes</div>
                <div class="stat-value">{{ $ventes->count() }}</div>
                <div class="stat-desc text-primary-content/60">Ventes enregistrées</div>
            </div>

            <div class="stat bg-success text-success-content rounded-2xl shadow-xl">
                <div class="stat-figure text-success-content/60">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-title text-success-content/70">Chiffre d'affaires</div>
                <div class="stat-value text-2xl">{{ number_format($ventes->sum('montant_total'), 0, ',', ' ') }}</div>
                <div class="stat-desc text-success-content/60">XOF</div>
            </div>

            <div class="stat bg-accent text-accent-content rounded-2xl shadow-xl">
                <div class="stat-figure text-accent-content/60">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="stat-title text-accent-content/70">Panier Moyen</div>
                <div class="stat-value text-2xl">{{ $ventes->count() > 0 ? number_format($ventes->avg('montant_total'), 0, ',', ' ') : 0 }}</div>
                <div class="stat-desc text-accent-content/60">XOF</div>
            </div>

            <div class="stat bg-info text-info-content rounded-2xl shadow-xl">
                <div class="stat-figure text-info-content/60">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="stat-title text-info-content/70">Clients Actifs</div>
                <div class="stat-value">{{ $ventes->unique('client_id')->count() }}</div>
                <div class="stat-desc text-info-content/60">Clients différents</div>
            </div>
        </div>

        <!-- Liste des ventes -->
        @if($ventes->count() > 0)
            <div class="card bg-base-100 shadow-xl border border-base-200">
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th>N° Vente</th>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Vendeur</th>
                                    <th>Statut</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventes as $vente)
                                    <tr>
                                        <td>
                                            <span class="font-mono font-semibold">{{ $vente->numero_vente }}</span>
                                        </td>
                                        <td>
                                            <div class="text-sm">
                                                {{ $vente->created_at->format('d/m/Y') }}
                                                <br>
                                                <span class="text-xs text-base-content/50">{{ $vente->created_at->format('H:i') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <div class="avatar placeholder">
                                                    <div class="bg-primary text-primary-content rounded-full w-8 h-8 flex items-center justify-center">
                                                        <span class="text-xs font-bold">{{ strtoupper(substr($vente->client->nom, 0, 1)) }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-semibold">{{ $vente->client->nom }}</div>
                                                    <div class="text-xs text-base-content/50">{{ $vente->client->telephone }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-lg font-bold text-primary">{{ number_format($vente->montant_total, 0, ',', ' ') }} F</span>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <div class="avatar placeholder">
                                                    <div class="bg-accent text-accent-content rounded-full w-8 h-8 flex items-center justify-center">
                                                        <span class="text-xs font-bold">{{ strtoupper(substr($vente->user->name, 0, 1)) }}</span>
                                                    </div>
                                                </div>
                                                <span class="text-sm">{{ $vente->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($vente->statut === 'validee')
                                                <span class="badge badge-success badge-sm">✓ Validée</span>
                                            @elseif($vente->statut === 'en_attente')
                                                <span class="badge badge-warning badge-sm">⏳ En attente</span>
                                            @else
                                                <span class="badge badge-error badge-sm">✗ Annulée</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="join join-horizontal">
                                                <button class="btn btn-sm btn-ghost join-item" title="Détails">
                                                    👁️
                                                </button>
                                                <button class="btn btn-sm btn-ghost join-item" title="Facture PDF">
                                                    📄
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty state -->
            <div class="card bg-base-100 shadow-xl border border-base-200">
                <div class="card-body">
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">💰</div>
                        <h3 class="text-2xl font-bold mb-2">Aucune vente</h3>
                        <p class="text-base-content/60 mb-6">Commencez par enregistrer votre première vente</p>
                        <a href="{{ route('ventes.create') }}" class="btn btn-primary">
                            Nouvelle Vente
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>