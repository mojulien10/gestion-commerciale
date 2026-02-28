<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                ✏️ Modifier la Catégorie
            </h2>
            <a href="{{ route('categories.index') }}" class="btn btn-ghost gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
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
                <!-- En-tête avec info catégorie -->
                <div class="bg-base-200/50 p-4 rounded-2xl mb-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-primary/10 p-3 rounded-xl">
                            <span class="text-2xl">📦</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase text-base-content/50">Modification de</p>
                            <p class="text-2xl font-bold">{{ $categorie->nom }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('categories.update', $categorie->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nom de la catégorie -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold text-lg">Nom de la catégorie <span class="text-error">*</span></span>
                        </label>
                        <input 
                            type="text" 
                            name="nom" 
                            value="{{ old('nom', $categorie->nom) }}"
                            placeholder="Ex: Matériaux de construction" 
                            class="input input-bordered input-lg w-full @error('nom') input-error @enderror" 
                            required
                            autofocus
                        />
                        @error('nom')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @else
                            <label class="label">
                                <span class="label-text-alt">Le nom doit être unique</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-control w-full mt-6">
                        <label class="label">
                            <span class="label-text font-semibold text-lg">Description <span class="text-base-content/50">(optionnel)</span></span>
                        </label>
                        <textarea 
                            name="description" 
                            rows="4"
                            placeholder="Décrivez cette catégorie de produits..." 
                            class="textarea textarea-bordered textarea-lg w-full @error('description') input-error @enderror"
                        >{{ old('description', $categorie->description) }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Informations modification -->
                    <div class="bg-warning/10 p-4 rounded-2xl mt-6 flex items-start gap-3 border border-warning/20">
                        <span class="text-2xl">⚠️</span>
                        <div>
                            <p class="text-sm font-bold text-warning">Attention</p>
                            <p class="text-xs text-warning/80">Les modifications seront appliquées immédiatement.</p>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="card-actions justify-end mt-8">
                        <a href="{{ route('categories.index') }}" class="btn btn-ghost btn-lg">
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
                    <p class="text-sm text-error/80 mb-4">La suppression d'une catégorie est irréversible.</p>
                    <form action="{{ route('categories.destroy', $categorie->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.');">
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

        <!-- Historique -->
        <div class="card bg-base-100 shadow-xl border border-base-200 mt-6">
            <div class="card-body">
                <h3 class="card-title text-lg mb-4">📅 Historique</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-base-content/60">Créée le :</span>
                        <span class="font-semibold">{{ $categorie->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/60">Dernière modification :</span>
                        <span class="font-semibold">{{ $categorie->updated_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>