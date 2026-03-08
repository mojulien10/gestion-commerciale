<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\VenteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
});
// Routes pour les clients
Route::middleware(['auth'])->group(function () {
Route::resource('clients', ClientController::class);
Route::resource('categories', CategorieController::class);
Route::resource('produits', ProduitController::class);
Route::resource('ventes', VenteController::class); 
// Routes supplémentaires pour le stock
    Route::get('/produits/{produit}/stock', [ProduitController::class, 'stock'])->name('produits.stock');
    Route::post('/produits/{produit}/stock/ajuster', [ProduitController::class, 'ajusterStock'])->name('produits.ajuster');
    // Route pour générer la facture PDF
    Route::get('/ventes/{vente}/pdf', [VenteController::class, 'pdf'])->name('ventes.pdf');
});
require __DIR__.'/auth.php';
