<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                ➕ Nouvelle Catégorie
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
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <!-- Nom de la catégorie -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold text-lg">Nom de la catégorie <span class="text-error">*</span></span>
                        </label>
                        <input 
                            type="text" 
                            name="nom" 
                            value="{{ old('nom') }}"
                            placeholder="Ex: Matériaux de construction, Électricité, Plomberie..." 
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
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @else
                            <label class="label">
                                <span class="label-text-alt">Ajoutez une description pour faciliter la gestion</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Informations -->
                    <div class="bg-info/10 p-4 rounded-2xl mt-6 flex items-start gap-3 border border-info/20">
                        <span class="text-2xl">💡</span>
                        <div>
                            <p class="text-sm font-bold text-info">Conseil</p>
                            <p class="text-xs text-info/80">Créez des catégories claires et distinctes pour faciliter le classement de vos produits. Exemples : Ciment, Fer, Peinture, Carrelage, Outils.</p>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="card-actions justify-end mt-8">
                        <a href="{{ route('categories.index') }}" class="btn btn-ghost btn-lg">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Créer la catégorie
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Exemples de catégories -->
        <div class="card bg-base-100 shadow-xl border border-base-200 mt-6">
            <div class="card-body">
                <h3 class="card-title text-lg mb-4">📋 Exemples de catégories courantes</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    <div class="badge badge-outline badge-lg">Ciment</div>
                    <div class="badge badge-outline badge-lg">Fer & Acier</div>
                    <div class="badge badge-outline badge-lg">Peinture</div>
                    <div class="badge badge-outline badge-lg">Carrelage</div>
                    <div class="badge badge-outline badge-lg">Plomberie</div>
                    <div class="badge badge-outline badge-lg">Électricité</div>
                    <div class="badge badge-outline badge-lg">Quincaillerie</div>
                    <div class="badge badge-outline badge-lg">Bois</div>
                    <div class="badge badge-outline badge-lg">Outils</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>