<?php

namespace App\Services;

use App\Models\Vente;
use App\Models\Produit;
use App\Models\AssociationProduit;
use Illuminate\Support\Facades\DB;

/**
 * Service de recommandation de produits basé sur l'algorithme Apriori
 * 
 * L'algorithme Apriori analyse l'historique des ventes pour identifier
 * les produits fréquemment achetés ensemble (Market Basket Analysis)
 */
class RecommendationService
{
    /**
     * Seuil minimum de confiance pour considérer une association valide
     * 50% = Si quelqu'un achète A, il y a au moins 50% de chances qu'il achète B
     */
    private float $confianceMinimale = 30.0;

    /**
     * Seuil minimum de support pour éviter les associations rares
     * 5% = L'association doit apparaître dans au moins 5% des ventes
     */
    private float $supportMinimal = 0.0;

    /**
     * MÉTHODE PRINCIPALE : Analyser toutes les ventes et générer les associations
     * 
     * Cette méthode va :
     * 1. Récupérer toutes les ventes validées
     * 2. Pour chaque paire de produits possible, calculer support/confiance/lift
     * 3. Sauvegarder les associations pertinentes en base de données
     */
    public function analyserVentes(): array
    {
        // Supprimer les anciennes associations pour recalculer
        AssociationProduit::truncate();

        // Récupérer toutes les ventes validées avec leurs produits
        $ventes = Vente::with('lignesVente.produit')
            ->where('statut', 'validee')
            ->get();

        $totalVentes = $ventes->count();

        if ($totalVentes < 5) {
            return [
                'success' => false,
                'message' => "Pas assez de ventes (minimum 5 requis, vous avez $totalVentes)",
            ];
        }

        // Récupérer tous les produits qui ont été vendus au moins une fois
        $produitsVendus = Produit::whereHas('lignesVente')->get();

        $associationsCreees = 0;
        $associationsIgnorees = 0;

        // Pour chaque paire de produits (A, B)
        foreach ($produitsVendus as $produitA) {
            foreach ($produitsVendus as $produitB) {
                
                // Ne pas associer un produit avec lui-même
                if ($produitA->id === $produitB->id) {
                    continue;
                }

                // Calculer les métriques pour cette paire
                $metriques = $this->calculerMetriques($ventes, $produitA, $produitB, $totalVentes);

                // Vérifier si l'association est pertinente
                if ($this->estAssociationValide($metriques)) {
                    $this->sauvegarderAssociation($produitA, $produitB, $metriques);
                    $associationsCreees++;
                } else {
                    $associationsIgnorees++;
                }
            }
        }

        return [
            'success' => true,
            'message' => "Analyse terminée avec succès",
            'stats' => [
                'ventes_analysees' => $totalVentes,
                'produits_analyses' => $produitsVendus->count(),
                'associations_creees' => $associationsCreees,
                'associations_ignorees' => $associationsIgnorees,
            ]
        ];
    }

    /**
     * Calculer les 3 métriques Apriori pour une paire de produits
     * 
     * @param Collection $ventes Toutes les ventes à analyser
     * @param Produit $produitA Le premier produit (ex: Ciment)
     * @param Produit $produitB Le second produit (ex: Fer)
     * @param int $totalVentes Nombre total de ventes
     * @return array [support, confiance, lift, nb_ventes_a, nb_ventes_ab]
     */
    private function calculerMetriques($ventes, $produitA, $produitB, $totalVentes): array
    {
        // Compter combien de ventes contiennent le produit A
        $nbVentesA = $this->compterVentesAvecProduit($ventes, $produitA->id);

        // Compter combien de ventes contiennent A ET B ensemble
        $nbVentesAB = $this->compterVentesAvecDeuxProduits($ventes, $produitA->id, $produitB->id);

        // Compter combien de ventes contiennent le produit B
        $nbVentesB = $this->compterVentesAvecProduit($ventes, $produitB->id);

        // CALCUL DU SUPPORT
        // Support(A,B) = Nb ventes avec A ET B / Total ventes
        // Exemple : 3 ventes sur 5 contiennent (Ciment, Fer) = 60%
        $support = $totalVentes > 0 ? ($nbVentesAB / $totalVentes) * 100 : 0;

        // CALCUL DE LA CONFIANCE
        // Confiance(A→B) = Nb ventes avec A ET B / Nb ventes avec A
        // Exemple : 3 ventes (Ciment+Fer) sur 4 ventes Ciment = 75%
        // Interprétation : "Si client achète Ciment, 75% de chances qu'il achète Fer"
        $confiance = $nbVentesA > 0 ? ($nbVentesAB / $nbVentesA) * 100 : 0;

        // CALCUL DU LIFT
        // Lift(A,B) = Confiance(A→B) / Support(B)
        // Lift > 1 : Association positive (significative)
        // Lift = 1 : Pas de relation (hasard)
        // Lift < 1 : Association négative
        $supportB = $totalVentes > 0 ? ($nbVentesB / $totalVentes) * 100 : 0;
        $lift = $supportB > 0 ? $confiance / $supportB : 0;

        return [
            'support' => round($support, 2),
            'confiance' => round($confiance, 2),
            'lift' => round($lift, 2),
            'nb_ventes_a' => $nbVentesA,
            'nb_ventes_ab' => $nbVentesAB,
        ];
    }

    /**
     * Compter combien de ventes contiennent un produit donné
     */
    private function compterVentesAvecProduit($ventes, $produitId): int
    {
        return $ventes->filter(function ($vente) use ($produitId) {
            return $vente->lignesVente->contains('produit_id', $produitId);
        })->count();
    }

    /**
     * Compter combien de ventes contiennent DEUX produits ensemble
     */
    private function compterVentesAvecDeuxProduits($ventes, $produitAId, $produitBId): int
    {
        return $ventes->filter(function ($vente) use ($produitAId, $produitBId) {
            $produitsIds = $vente->lignesVente->pluck('produit_id');
            return $produitsIds->contains($produitAId) && $produitsIds->contains($produitBId);
        })->count();
    }

    /**
     * Vérifier si une association est valide (pertinente)
     * 
     * Critères :
     * - Confiance >= 50% (fiabilité minimale)
     * - Support >= 5% (pas trop rare)
     * - Lift > 1 (association significative, pas due au hasard)
     */
    private function estAssociationValide(array $metriques): bool
    {
        return $metriques['confiance'] >= $this->confianceMinimale
            && $metriques['support'] >= $this->supportMinimal
            && $metriques['lift'] > 1;
    }

    /**
     * Sauvegarder une association en base de données
     */
    private function sauvegarderAssociation($produitA, $produitB, array $metriques): void
    {
        AssociationProduit::create([
            'produit_a_id' => $produitA->id,
            'produit_b_id' => $produitB->id,
            'support' => $metriques['support'],
            'confiance' => $metriques['confiance'],
            'lift' => $metriques['lift'],
            'nb_ventes_a' => $metriques['nb_ventes_a'],
            'nb_ventes_ab' => $metriques['nb_ventes_ab'],
        ]);
    }

    /**
     * Obtenir les recommandations pour un produit donné
     * (Sera utilisé dans la Session 10)
     * 
     * @param int $produitId ID du produit dans le panier
     * @return Collection Produits recommandés triés par confiance
     */
    public function recommanderPour(int $produitId)
    {
        return AssociationProduit::where('produit_a_id', $produitId)
            ->confianceMinimale(50)
            ->with('produitB.categorie')
            ->orderBy('confiance', 'desc')
            ->limit(5)
            ->get();
    }
}