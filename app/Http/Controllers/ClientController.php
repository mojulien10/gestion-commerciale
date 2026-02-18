<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;  

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          // Récupérer tous les clients, triés par nom
    $clients = Client::orderBy('nom', 'asc')->get();
    
    // Retourner la vue avec les clients
    return view('clients.index', compact('clients'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
