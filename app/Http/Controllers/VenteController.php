<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vente;
use App\Models\LigneVente;
use App\Models\Client;
use App\Models\Produit;
use App\Services\StockService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VenteController extends Controller
{
   /**
 * Afficher la liste des ventes.
 */
public function index()
{
    $ventes = Vente::with(['client', 'user'])
        ->orderBy('created_at', 'desc')
        ->get();
    
    return view('ventes.index', compact('ventes'));
}

/**
 * Afficher le formulaire de création.
 */
public function create()
{
    $clients = Client::orderBy('nom', 'asc')->get();
    $produits = Produit::with('categorie')
        ->where('stock_actuel', '>', 0)
        ->orderBy('nom', 'asc')
        ->get();
    
    return view('ventes.create', compact('clients', 'produits'));
}

/**
 * Enregistrer une nouvelle vente.
 */
public function store(Request $request)
{
    $validated = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'notes' => 'nullable|string',
        'produits' => 'required|array|min:1',
        'produits.*.produit_id' => 'required|exists:produits,id',
        'produits.*.quantite' => 'required|integer|min:1',
    ]);
    
    try {
        DB::beginTransaction();
        
        // Créer la vente
        $vente = Vente::create([
            'numero_vente' => Vente::genererNumeroVente(),
            'client_id' => $validated['client_id'],
            'user_id' => Auth::id(),
            'montant_total' => 0, // Sera calculé après
            'statut' => 'validee',
            'notes' => $validated['notes'] ?? null,
        ]);
        
        $montantTotal = 0;
        $stockService = new StockService();
        
        // Créer les lignes de vente et mettre à jour le stock
        foreach ($validated['produits'] as $ligne) {
            $produit = Produit::findOrFail($ligne['produit_id']);
            $quantite = $ligne['quantite'];
            $prixUnitaire = $produit->prix_vente;
            $prixTotal = $prixUnitaire * $quantite;
            
            // Vérifier le stock
            if ($produit->stock_actuel < $quantite) {
                throw new \Exception("Stock insuffisant pour {$produit->nom}. Disponible: {$produit->stock_actuel}, Demandé: {$quantite}");
            }
            
            // Créer la ligne de vente
            LigneVente::create([
                'vente_id' => $vente->id,
                'produit_id' => $produit->id,
                'quantite' => $quantite,
                'prix_unitaire' => $prixUnitaire,
                'prix_total' => $prixTotal,
                'is_recommended' => false, // Sera géré dans les sessions 9-10
            ]);
            
            // Mettre à jour le stock
            $stockService->sortie($produit, $quantite, "Vente {$vente->numero_vente}");
            
            $montantTotal += $prixTotal;
        }
        
        // Mettre à jour le montant total de la vente
        $vente->update(['montant_total' => $montantTotal]);
        
        DB::commit();
        
        return redirect()->route('ventes.index')
            ->with('success', 'Vente enregistrée avec succès !');
            
    } catch (\Exception $e) {
        DB::rollBack();
        
        return redirect()->back()
            ->with('error', 'Erreur : ' . $e->getMessage())
            ->withInput();
    }
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
