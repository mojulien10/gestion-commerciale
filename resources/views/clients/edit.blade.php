<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-base-content">
                ✏️ Modifier le Client
            </h2>
            <a href="{{ route('clients.show', $client->id) }}" class="btn btn-ghost gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Annuler
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
                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nom -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text font-semibold">Nom complet <span class="text-error">*</span></span>
                        </label>
                        <input 
                            type="text" 
                            name="nom" 
                            value="{{ old('nom', $client->nom) }}"
                            placeholder="Ex: Mamadou Diallo" 
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
                            value="{{ old('telephone', $client->telephone) }}"
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
                            value="{{ old('email', $client->email) }}"
                            placeholder="Ex: mamadou@email.com" 
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
                            placeholder="Ex: Médina, Rue 15, Dakar" 
                            class="textarea textarea-bordered w-full @error('adresse') input-error @enderror"
                        >{{ old('adresse', $client->adresse) }}</textarea>
                        @error('adresse')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Informations -->
                    <div class="alert alert-warning mt-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <h3 class="font-bold">Attention</h3>
                            <div class="text-sm">
                                <p>• Les modifications seront enregistrées immédiatement</p>
                                <p>• Le numéro de téléphone doit rester unique</p>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="card-actions justify-end mt-8">
                        <a href="{{ route('clients.show', $client->id) }}" class="btn btn-ghost">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-warning gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>