<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                👤 Détails du Client
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('clients.index') }}" class="btn btn-ghost gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="alert alert-success shadow-lg mb-6">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2">
                <div class="card bg-base-100 shadow-xl border border-base-200">
                    <div class="card-body">
                        <div class="flex flex-col md:flex-row items-center gap-6 mb-8">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content rounded-full w-24 h-24 flex items-center justify-center ring ring-primary ring-offset-base-100 ring-offset-2">
                                    <span class="text-4xl font-bold">{{ strtoupper(substr($client->nom, 0, 1)) }}</span>
                                </div>
                            </div>
                            <div class="text-center md:text-left">
                                <h3 class="text-4xl font-black text-base-content">{{ $client->nom }}</h3>
                                <p class="text-base-content/60 text-lg">Client depuis le {{ $client->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="divider uppercase text-xs font-bold opacity-50">Informations de contact</div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div class="bg-base-200/50 p-4 rounded-2xl">
                                <label class="text-xs font-bold uppercase text-base-content/50">Téléphone</label>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xl font-semibold">{{ $client->telephone }}</span>
                                </div>
                            </div>

                            <div class="bg-base-200/50 p-4 rounded-2xl">
                                <label class="text-xs font-bold uppercase text-base-content/50">Email</label>
                                <div class="mt-1">
                                    @if($client->email)
                                        <span class="text-xl font-semibold">{{ $client->email }}</span>
                                    @else
                                        <span class="text-lg italic opacity-40">Non renseigné</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-base-200/50 p-4 rounded-2xl mt-6">
                            <label class="text-xs font-bold uppercase text-base-content/50">Adresse Résidentielle</label>
                            <div class="mt-1">
                                @if($client->adresse)
                                    <p class="text-lg font-medium leading-relaxed">{{ $client->adresse }}</p>
                                @else
                                    <p class="text-lg italic opacity-40">Aucune adresse enregistrée</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-8 pt-4 border-t border-base-200 text-sm text-base-content/40 flex justify-between items-center">
                            <span>ID Client: #{{ str_pad($client->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span>Dernière modification : {{ $client->updated_at->format('d/m/Y à H:i') }}</span>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl mt-6 border border-base-200">
                    <div class="card-body">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="text-xl font-bold flex items-center gap-2">
                                <span class="bg-secondary/10 p-2 rounded-lg">🛒</span> 
                                Historique des Achats
                            </h4>
                            <span class="badge badge-outline opacity-50">Mode démo</span>
                        </div>
                        
                        <div class="text-center py-12 bg-base-200/30 rounded-3xl border-2 border-dashed border-base-300">
                            <div class="text-5xl mb-4">📦</div>
                            <p class="text-base-content/60 font-medium">Aucun achat enregistré pour le moment</p>
                            <p class="text-xs text-base-content/40 mt-2">Les transactions s'afficheront ici automatiquement après le module Ventes.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="space-y-6">
                    <div class="card bg-base-100 shadow-xl border border-base-200">
                        <div class="card-body">
                            <h4 class="text-lg font-bold mb-4">Analyse Client</h4>
                            
                            <div class="stat bg-primary text-primary-content rounded-2xl mb-4">
                                <div class="stat-title text-primary-content/70">Nombre d'achats</div>
                                <div class="stat-value text-3xl">{{ $client->nombre_achats }}</div>
                                <div class="stat-desc text-primary-content/60">Total cumulé</div>
                            </div>

                            <div class="stat bg-accent text-accent-content rounded-2xl mb-4">
                                <div class="stat-title text-accent-content/70">Chiffre d'affaires</div>
                                <div class="stat-value text-2xl">{{ number_format($client->total_achats, 0, ',', ' ') }}</div>
                                <div class="stat-desc text-accent-content/60">Devise : XOF</div>
                            </div>

                            <div class="bg-info/10 p-4 rounded-2xl flex items-start gap-3 border border-info/20">
                                <span class="text-2xl">💡</span>
                                <div>
                                    <p class="text-sm font-bold text-info">Recommandation</p>
                                    <p class="text-xs text-info/80">Activez le module de recommandation pour voir les suggestions ici.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-base-100 shadow-xl border border-base-200">
                        <div class="card-body p-4">
                            <h4 class="text-lg font-bold px-2 mb-2">⚡ Actions Rapides</h4>
                            <div class="grid grid-cols-1 gap-2">
                                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning btn-block justify-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Éditer le profil
                                </a>

                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Attention : Cette action est irréversible.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-error btn-block justify-start gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Supprimer définitivement
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>