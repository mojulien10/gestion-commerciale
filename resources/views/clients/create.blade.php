<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                ➕ Nouveau Client
            </h2>
            <a href="{{ route('clients.index') }}" class="btn btn-ghost gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
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
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf

                    <!-- Nom -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold">Nom complet <span class="text-error">*</span></span>
                        </label>
                        <input 
                            type="text" 
                            name="nom" 
                            value="{{ old('nom') }}"
                            placeholder="Ex: Mohamed Julien Niassy" 
                            class="input input-bordered w-full @error('nom') input-error @enderror" 
                            required
                        />
                        @error('nom')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text font-semibold">Numéro de téléphone <span class="text-error">*</span></span>
                        </label>
                        <input 
                            type="text" 
                            name="telephone" 
                            value="{{ old('telephone') }}"
                            placeholder="Ex: 77 123 45 67" 
                            class="input input-bordered w-full @error('telephone') input-error @enderror" 
                            required
                        />
                        <label class="label">
                            <span class="label-text-alt">Ce numéro servira d'identifiant unique</span>
                        </label>
                        @error('telephone')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text font-semibold">Email <span class="text-base-content/50">(optionnel)</span></span>
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="Ex: julien@email.com" 
                            class="input input-bordered w-full @error('email') input-error @enderror"
                        />
                        @error('email')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Adresse -->
                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text font-semibold">Adresse <span class="text-base-content/50">(optionnel)</span></span>
                        </label>
                        <textarea 
                            name="adresse" 
                            rows="3"
                            placeholder="Ex: Mbatal, Dakar" 
                            class="textarea textarea-bordered w-full @error('adresse') input-error @enderror"
                        >{{ old('adresse') }}</textarea>
                        @error('adresse')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Informations -->
                    <div class="alert alert-info mt-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold">À savoir</h3>
                            <div class="text-sm">
                                <p>• Les champs marqués d'un <span class="text-error">*</span> sont obligatoires</p>
                                <p>• Le numéro de téléphone doit être unique</p>
                                <p>• Les statistiques d'achat seront calculées automatiquement</p>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="card-actions justify-end mt-8">
                        <a href="{{ route('clients.index') }}" class="btn btn-ghost">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Enregistrer le client
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Carte d'aide -->
        <div class="card bg-base-100 shadow-xl mt-6">
            <div class="card-body">
                <h3 class="card-title text-lg">💡 Conseils</h3>
                <div class="space-y-2 text-sm">
                    <p>✅ <strong>Nom complet :</strong> Utilisez le nom complet du client pour faciliter la recherche</p>
                    <p>✅ <strong>Téléphone :</strong> Format recommandé : 77 123 45 67 (avec espaces)</p>
                    <p>✅ <strong>Email :</strong> Permet d'envoyer des factures par email (à venir)</p>
                    <p>✅ <strong>Adresse :</strong> Utile pour les livraisons</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>