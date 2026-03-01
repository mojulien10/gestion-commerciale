<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Support\Str;

class ProduitController extends Controller
{
    /**
 * Afficher la liste des produits.
 */
public function index()
{
    $produits = Produit::with('categorie')->orderBy('nom', 'asc')->get();
    $categories = Categorie::all();
    
    return view('produits.index', compact('produits', 'categories'));
}

/**
 * Afficher le formulaire de création.
 */
public function create()
{
    $categories = Categorie::all();
    return view('produits.create', compact('categories'));
}

/**
 * Enregistrer un nouveau produit.
 */
public function store(Request $request)
{
    $validated = $request->validate([
        'code' => 'required|string|max:50|unique:produits,code',
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'categorie_id' => 'required|exists:categories,id',
        'prix_achat' => 'required|numeric|min:0',
        'prix_vente' => 'required|numeric|min:0',
        'stock_actuel' => 'required|integer|min:0',
        'seuil_alerte' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    
    // Upload de l'image si présente
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . Str::slug($request->nom) . '.' . $image->extension();
        $image->move(public_path('images/produits'), $imageName);
        $validated['image'] = $imageName;
    }
    
    Produit::create($validated);
    
    return redirect()->route('produits.index')
        ->with('success', 'Produit ajouté avec succès !');
}

/**
 * Display the specified resource.
 */
public function show(string $id)
{
    //
}

/**
 * Afficher le formulaire de modification.
 */
public function edit($id)
{
    $produit = Produit::findOrFail($id);
    $categories = Categorie::all();
    return view('produits.edit', compact('produit', 'categories'));
}

/**
 * Mettre à jour un produit.
 */
public function update(Request $request, $id)
{
    $produit = Produit::findOrFail($id);
    
    $validated = $request->validate([
        'code' => 'required|string|max:50|unique:produits,code,' . $produit->id,
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'categorie_id' => 'required|exists:categories,id',
        'prix_achat' => 'required|numeric|min:0',
        'prix_vente' => 'required|numeric|min:0',
        'stock_actuel' => 'required|integer|min:0',
        'seuil_alerte' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    
    // Upload nouvelle image si présente
    if ($request->hasFile('image')) {
        // Supprimer ancienne image
        if ($produit->image && file_exists(public_path('images/produits/' . $produit->image))) {
            unlink(public_path('images/produits/' . $produit->image));
        }
        
        $image = $request->file('image');
        $imageName = time() . '_' . Str::slug($request->nom) . '.' . $image->extension();
        $image->move(public_path('images/produits'), $imageName);
        $validated['image'] = $imageName;
    }
    
    $produit->update($validated);
    
    return redirect()->route('produits.index')
        ->with('success', 'Produit modifié avec succès !');
}

/**
 * Supprimer un produit.
 */
public function destroy($id)
{
    $produit = Produit::findOrFail($id);
    
    // Supprimer l'image si existe
    if ($produit->image && file_exists(public_path('images/produits/' . $produit->image))) {
        unlink(public_path('images/produits/' . $produit->image));
    }
    
    $produit->delete();
    
    return redirect()->route('produits.index')
        ->with('success', 'Produit supprimé avec succès !');
}
}
