<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;  

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //       // Récupérer tous les clients, triés par nom
    // $clients = Client::orderBy('nom', 'asc')->get();
    
    // // Retourner la vue avec les clients
    // return view('clients.index', compact('clients'));
    // }
    public function index(Request $request)
{
    // Récupérer le terme de recherche
    $search = $request->input('search');
    
    // Construire la requête
    $clients = Client::query()
        ->when($search, function ($query, $search) {
            return $query->where('nom', 'like', "%{$search}%")
                         ->orWhere('telephone', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })
        ->orderBy('nom', 'asc')
        ->get();
    
    // Retourner la vue avec les clients ET le terme de recherche
    return view('clients.index', compact('clients', 'search'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // Afficher le formulaire de création
    return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'telephone' => 'required|string|max:20|unique:clients,telephone',
        'email' => 'nullable|email|max:255',
        'adresse' => 'nullable|string',
    ]);
    
    // Créer le client
    Client::create($validated);
    
    // Rediriger vers la liste avec un message de succès
    return redirect()->route('clients.index')
        ->with('success', 'Client ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
         // Laravel récupère automatiquement le client grâce au Route Model Binding
    return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Client $client)
{
    // Afficher le formulaire de modification avec les données du client
    return view('clients.edit', compact('client'));
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
{
    // Valider les données
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'telephone' => 'required|string|max:20|unique:clients,telephone,' . $client->id,
        'email' => 'nullable|email|max:255',
        'adresse' => 'nullable|string',
    ]);
    
    // Mettre à jour le client
    $client->update($validated);
    
    // Rediriger vers les détails avec un message de succès
    return redirect()->route('clients.show', $client->id)
        ->with('success', 'Client modifié avec succès !');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Client $client)
{
    // Supprimer le client
    $client->delete();
    
    // Rediriger vers la liste avec un message de succès
    return redirect()->route('clients.index')
        ->with('success', 'Client supprimé avec succès !');
}
}
