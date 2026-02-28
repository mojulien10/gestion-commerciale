<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class CategorieController extends Controller
{
   /**
 * Afficher la liste des catégories.
 */
public function index()
{
    $categories = Categorie::orderBy('nom', 'asc')->get();
    return view('categories.index', compact('categories'));
}

/**
 * Afficher le formulaire de création.
 */
public function create()
{
    return view('categories.create');
}

/**
 * Enregistrer une nouvelle catégorie.
 */
public function store(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|string|max:255|unique:categories,nom',
        'description' => 'nullable|string',
    ]);
    
    Categorie::create($validated);
    
    return redirect()->route('categories.index')
        ->with('success', 'Catégorie ajoutée avec succès !');
}

/**
 * Afficher le formulaire de modification.
 */
public function edit($id)
{
    $categorie = Categorie::findOrFail($id);
    return view('categories.edit', compact('categorie'));
}

/**
 * Mettre à jour une catégorie.
 */
public function update(Request $request, $id)
{
    $categorie = Categorie::findOrFail($id);
    
    $validated = $request->validate([
        'nom' => 'required|string|max:255|unique:categories,nom,' . $categorie->id,
        'description' => 'nullable|string',
    ]);
    
    $categorie->update($validated);
    
    return redirect()->route('categories.index')
        ->with('success', 'Catégorie modifiée avec succès !');
}

/**
 * Supprimer une catégorie.
 */
public function destroy($id)
{
    $categorie = Categorie::findOrFail($id);
    $categorie->delete();
    
    return redirect()->route('categories.index')
        ->with('success', 'Catégorie supprimée avec succès !');
}
}
