<?php

namespace App\Services;

use App\Models\Produit;
use App\Models\MouvementStock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Enregistrer une entrée de stock.
     */
    public function entree(Produit $produit, int $quantite, string $motif)
    {
        return DB::transaction(function () use ($produit, $quantite, $motif) {
            $stockAvant = $produit->stock_actuel;
            $stockApres = $stockAvant + $quantite;

            // Mettre à jour le stock du produit
            $produit->update(['stock_actuel' => $stockApres]);

            // Enregistrer le mouvement
            return MouvementStock::create([
                'produit_id' => $produit->id,
                'type' => 'entree',
                'quantite' => $quantite,
                'stock_avant' => $stockAvant,
                'stock_apres' => $stockApres,
                'motif' => $motif,
                'user_id' => Auth::id(),
            ]);
        });
    }

    /**
     * Enregistrer une sortie de stock.
     */
    public function sortie(Produit $produit, int $quantite, string $motif)
    {
        return DB::transaction(function () use ($produit, $quantite, $motif) {
            if ($produit->stock_actuel < $quantite) {
                throw new \Exception("Stock insuffisant pour {$produit->nom}. Disponible: {$produit->stock_actuel}, Demandé: {$quantite}");
            }

            $stockAvant = $produit->stock_actuel;
            $stockApres = $stockAvant - $quantite;

            // Mettre à jour le stock du produit
            $produit->update(['stock_actuel' => $stockApres]);

            // Enregistrer le mouvement
            return MouvementStock::create([
                'produit_id' => $produit->id,
                'type' => 'sortie',
                'quantite' => $quantite,
                'stock_avant' => $stockAvant,
                'stock_apres' => $stockApres,
                'motif' => $motif,
                'user_id' => Auth::id(),
            ]);
        });
    }

    /**
     * Ajuster le stock (correction manuelle).
     */
    public function ajuster(Produit $produit, int $nouveauStock, string $motif)
    {
        return DB::transaction(function () use ($produit, $nouveauStock, $motif) {
            $stockAvant = $produit->stock_actuel;
            $difference = $nouveauStock - $stockAvant;

            // Mettre à jour le stock du produit
            $produit->update(['stock_actuel' => $nouveauStock]);

            // Enregistrer le mouvement
            return MouvementStock::create([
                'produit_id' => $produit->id,
                'type' => 'ajustement',
                'quantite' => $difference,
                'stock_avant' => $stockAvant,
                'stock_apres' => $nouveauStock,
                'motif' => $motif,
                'user_id' => Auth::id(),
            ]);
        });
    }

    /**
     * Obtenir l'historique des mouvements pour un produit.
     */
    public function historique(Produit $produit, $limit = 10)
    {
        return $produit->mouvementsStock()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtenir tous les produits en stock bas.
     */
    public function produitsStockBas()
    {
        return Produit::whereColumn('stock_actuel', '<=', 'seuil_alerte')
            ->with('categorie')
            ->orderBy('stock_actuel', 'asc')
            ->get();
    }
}