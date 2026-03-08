<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                📄 Détails de la Vente
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('ventes.pdf', $vente->id) }}" target="_blank" class="btn btn-accent gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Télécharger PDF
                </a>
                <a href="{{ route('ventes.index') }}" class="btn btn-ghost gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- En-tête vente -->
        <div class="card bg-base-100 shadow-xl border border-base-200 mb-6">
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Numéro vente -->
                    <div class="bg-primary/10 p-4 rounded-2xl border border-primary/20">
                        <p class="text-xs font-bold uppercase text-primary/60 mb-1">Numéro de vente</p>
                        <p class="text-2xl font-bold font-mono text-primary">{{ $vente->numero_vente }}</p>
                    </div>

                    <!-- Date -->
                    <div class="bg-base-200/50 p-4 rounded-2xl">
                        <p class="text-xs font-bold uppercase text-base-content/50 mb-1">Date de vente</p>
                        <p class="text-xl font-bold">{{ $vente->created_at->format('d/m/Y') }}</p>
                        <p class="text-sm text-base-content/60">{{ $vente->created_at->format('H:i') }}</p>
                    </div>

                    <!-- Statut -->
                    <div class="bg-base-200/50 p-4 rounded-2xl">
                        <p class="text-xs font-bold uppercase text-base-content/50 mb-1">Statut</p>
                        @if($vente->statut === 'validee')
                            <span class="badge badge-success badge-lg gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Validée
                            </span>
                        @elseif($vente->statut === 'en_attente')
                            <span class="badge badge-warning badge-lg gap-2">⏳ En attente</span>
                        @else
                            <span class="badge badge-error badge-lg gap-2">✗ Annulée</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Informations client et vendeur -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Client -->
                <div class="card bg-base-100 shadow-xl border border-base-200">
                    <div class="card-body">
                        <h3 class="card-title text-lg mb-4 flex items-center gap-2">
                            <span class="bg-primary/10 p-2 rounded-lg">👤</span>
                            Client
                        </h3>

                        <div class="flex items-center gap-3 mb-4">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content rounded-full w-12 h-12 flex items-center justify-center ring ring-primary ring-offset-2">
                                    <span class="text-xl font-bold">{{ strtoupper(substr($vente->client->nom, 0, 1)) }}</span>
                                </div>
                            </div>
                            <div>
                                <p class="font-bold text-lg">{{ $vente->client->nom }}</p>
                                <p class="text-sm text-base-content/60">{{ $vente->client->telephone }}</p>
                            </div>
                        </div>

                        @if($vente->client->email)
                            <div class="bg-base-200/50 p-3 rounded-xl">
                                <p class="text-xs text-base-content/50 mb-1">Email</p>
                                <p class="text-sm">{{ $vente->client->email }}</p>
                            </div>
                        @endif

                        @if($vente->client->adresse)
                            <div class="bg-base-200/50 p-3 rounded-xl mt-2">
                                <p class="text-xs text-base-content/50 mb-1">Adresse</p>
                                <p class="text-sm">{{ $vente->client->adresse }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Vendeur -->
                <div class="card bg-base-100 shadow-xl border border-base-200">
                    <div class="card-body">
                        <h3 class="card-title text-lg mb-4 flex items-center gap-2">
                            <span class="bg-accent/10 p-2 rounded-lg">👨‍💼</span>
                            Vendeur
                        </h3>

                        <div class="flex items-center gap-3">
                            <div class="avatar placeholder">
                                <div class="bg-accent text-accent-content rounded-full w-12 h-12 flex items-center justify-center">
                                    <span class="text-xl font-bold">{{ strtoupper(substr($vente->user->name, 0, 1)) }}</span>
                                </div>
                            </div>
                            <div>
                                <p class="font-bold">{{ $vente->user->name }}</p>
                                <p class="text-sm text-base-content/60">{{ $vente->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="card bg-primary text-primary-content shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title text-lg mb-2">Montant Total</h3>
                        <p class="text-4xl font-bold">{{ number_format($vente->montant_total, 0, ',', ' ') }} F</p>
                        <p class="text-sm opacity-70">{{ $vente->lignesVente->count() }} produit(s)</p>
                    </div>
                </div>
            </div>

            <!-- Liste des produits -->
            <div class="lg:col-span-2">
                <div class="card bg-base-100 shadow-xl border border-base-200">
                    <div class="card-body">
                        <h3 class="card-title text-xl mb-4 flex items-center gap-2">
                            <span class="bg-success/10 p-2 rounded-lg">📦</span>
                            Produits vendus
                        </h3>

                        <div class="overflow-x-auto">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th class="text-right">Prix Unit.</th>
                                        <th class="text-center">Qté</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vente->lignesVente as $ligne)
                                        <tr>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    @if($ligne->produit->image)
                                                        <img src="{{ asset('images/produits/' . $ligne->produit->image) }}" 
                                                             alt="{{ $ligne->produit->nom }}" 
                                                             class="w-12 h-12 object-cover rounded-lg">
                                                    @else
                                                        <div class="w-12 h-12 bg-gradient-to-br from-primary/10 to-accent/10 rounded-lg flex items-center justify-center">
                                                            <span class="text-xl">📦</span>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="font-semibold">{{ $ligne->produit->nom }}</p>
                                                        <p class="text-xs text-base-content/50">{{ $ligne->produit->code }}</p>
                                                        @if($ligne->is_recommended)
                                                            <span class="badge badge-warning badge-xs">⭐ Recommandé</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right font-semibold">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} F</td>
                                            <td class="text-center">
                                                <span class="badge badge-primary">{{ $ligne->quantite }}</span>
                                            </td>
                                            <td class="text-right font-bold text-primary text-lg">{{ number_format($ligne->prix_total, 0, ',', ' ') }} F</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="font-bold">
                                        <td colspan="3" class="text-right text-lg">TOTAL</td>
                                        <td class="text-right text-2xl text-primary">{{ number_format($vente->montant_total, 0, ',', ' ') }} F</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($vente->notes)
                            <div class="bg-info/10 p-4 rounded-2xl mt-6 border border-info/20">
                                <p class="text-sm font-bold text-info mb-2">📝 Notes</p>
                                <p class="text-sm text-info/80">{{ $vente->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>