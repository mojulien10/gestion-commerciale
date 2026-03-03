<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;
use App\Models\Categorie;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Récupérer les catégories existantes
        $ciment = Categorie::where('nom', 'Ciment')->first();
        $fer = Categorie::where('nom', 'Fer & Acier')->first();
        $peinture = Categorie::where('nom', 'Peinture')->first();
        $carrelage = Categorie::where('nom', 'Carrelage & Revêtements')->first();
        $plomberie = Categorie::where('nom', 'Plomberie')->first();
        $electricite = Categorie::where('nom', 'Électricité')->first();
        $quincaillerie = Categorie::where('nom', 'Quincaillerie')->first();
        $bois = Categorie::where('nom', 'Bois & Menuiserie')->first();
        $outils = Categorie::where('nom', 'Outils')->first();
        $isolation = Categorie::where('nom', 'Isolation & Étanchéité')->first();

        $produits = [
            // CIMENT
            ['code' => 'CIM-001', 'nom' => 'Sac de ciment gris 50kg Portland', 'description' => 'Ciment haute résistance pour tous travaux de maçonnerie', 'categorie_id' => $ciment?->id, 'prix_achat' => 3500, 'prix_vente' => 4500, 'stock_actuel' => 200, 'seuil_alerte' => 50],
            ['code' => 'CIM-002', 'nom' => 'Sac de ciment blanc 50kg', 'description' => 'Ciment blanc pour finitions décoratives', 'categorie_id' => $ciment?->id, 'prix_achat' => 4200, 'prix_vente' => 5500, 'stock_actuel' => 80, 'seuil_alerte' => 20],
            ['code' => 'CIM-003', 'nom' => 'Ciment prompt 25kg', 'description' => 'Prise rapide, idéal pour réparations urgentes', 'categorie_id' => $ciment?->id, 'prix_achat' => 5000, 'prix_vente' => 6500, 'stock_actuel' => 45, 'seuil_alerte' => 15],

            // FER & ACIER
            ['code' => 'FER-001', 'nom' => 'Fer à béton Ø8mm - 12m', 'description' => 'Barres de fer pour armatures béton', 'categorie_id' => $fer?->id, 'prix_achat' => 4500, 'prix_vente' => 6000, 'stock_actuel' => 150, 'seuil_alerte' => 30],
            ['code' => 'FER-002', 'nom' => 'Fer à béton Ø10mm - 12m', 'description' => 'Barres de fer haute résistance', 'categorie_id' => $fer?->id, 'prix_achat' => 6000, 'prix_vente' => 7800, 'stock_actuel' => 120, 'seuil_alerte' => 25],
            ['code' => 'FER-003', 'nom' => 'Tôle ondulée galvanisée 2m', 'description' => 'Toiture résistante à la corrosion', 'categorie_id' => $fer?->id, 'prix_achat' => 8500, 'prix_vente' => 11000, 'stock_actuel' => 60, 'seuil_alerte' => 15],
            ['code' => 'FER-004', 'nom' => 'Treillis soudé 6x2.4m', 'description' => 'Armature pré-assemblée pour dalles', 'categorie_id' => $fer?->id, 'prix_achat' => 12000, 'prix_vente' => 15500, 'stock_actuel' => 35, 'seuil_alerte' => 10],

            // PEINTURE
            ['code' => 'PEI-001', 'nom' => 'Peinture murale blanche 10L', 'description' => 'Peinture acrylique lessivable', 'categorie_id' => $peinture?->id, 'prix_achat' => 15000, 'prix_vente' => 19500, 'stock_actuel' => 75, 'seuil_alerte' => 20],
            ['code' => 'PEI-002', 'nom' => 'Peinture extérieure 10L', 'description' => 'Résistante aux intempéries et UV', 'categorie_id' => $peinture?->id, 'prix_achat' => 18000, 'prix_vente' => 23500, 'stock_actuel' => 50, 'seuil_alerte' => 15],
            ['code' => 'PEI-003', 'nom' => 'Vernis bois incolore 2.5L', 'description' => 'Protection et finition bois', 'categorie_id' => $peinture?->id, 'prix_achat' => 8500, 'prix_vente' => 11000, 'stock_actuel' => 40, 'seuil_alerte' => 10],

            // CARRELAGE
            ['code' => 'CAR-001', 'nom' => 'Carrelage sol 45x45cm (carton)', 'description' => 'Grès cérame antidérapant, 10 pièces', 'categorie_id' => $carrelage?->id, 'prix_achat' => 25000, 'prix_vente' => 32500, 'stock_actuel' => 90, 'seuil_alerte' => 20],
            ['code' => 'CAR-002', 'nom' => 'Faïence murale 25x40cm (carton)', 'description' => 'Carrelage mural brillant, 12 pièces', 'categorie_id' => $carrelage?->id, 'prix_achat' => 18000, 'prix_vente' => 23500, 'stock_actuel' => 65, 'seuil_alerte' => 15],
            ['code' => 'CAR-003', 'nom' => 'Colle carrelage 25kg', 'description' => 'Mortier colle gris pour carrelage', 'categorie_id' => $carrelage?->id, 'prix_achat' => 4500, 'prix_vente' => 6000, 'stock_actuel' => 110, 'seuil_alerte' => 30],

            // PLOMBERIE
            ['code' => 'PLO-001', 'nom' => 'Tuyau PVC Ø110mm - 3m', 'description' => 'Évacuation eaux usées', 'categorie_id' => $plomberie?->id, 'prix_achat' => 3500, 'prix_vente' => 4800, 'stock_actuel' => 85, 'seuil_alerte' => 20],
            ['code' => 'PLO-002', 'nom' => 'Robinet mélangeur évier', 'description' => 'Chrome, montage mural', 'categorie_id' => $plomberie?->id, 'prix_achat' => 8500, 'prix_vente' => 12000, 'stock_actuel' => 30, 'seuil_alerte' => 8],
            ['code' => 'PLO-003', 'nom' => 'WC complet avec mécanisme', 'description' => 'Cuvette + abattant + réservoir', 'categorie_id' => $plomberie?->id, 'prix_achat' => 35000, 'prix_vente' => 48000, 'stock_actuel' => 18, 'seuil_alerte' => 5],

            // ÉLECTRICITÉ
            ['code' => 'ELE-001', 'nom' => 'Câble électrique 2.5mm² (rouleau 100m)', 'description' => 'Câble cuivre pour circuits prises', 'categorie_id' => $electricite?->id, 'prix_achat' => 45000, 'prix_vente' => 58000, 'stock_actuel' => 25, 'seuil_alerte' => 5],
            ['code' => 'ELE-002', 'nom' => 'Disjoncteur 20A', 'description' => 'Protection circuit électrique', 'categorie_id' => $electricite?->id, 'prix_achat' => 2500, 'prix_vente' => 3500, 'stock_actuel' => 95, 'seuil_alerte' => 25],
            ['code' => 'ELE-003', 'nom' => 'Boîte de 10 prises encastrables', 'description' => 'Prises 2P+T blanches', 'categorie_id' => $electricite?->id, 'prix_achat' => 8000, 'prix_vente' => 11000, 'stock_actuel' => 55, 'seuil_alerte' => 15],

            // QUINCAILLERIE
            ['code' => 'QUI-001', 'nom' => 'Boîte de vis acier 5x50mm (500 pièces)', 'description' => 'Vis à bois tête fraisée', 'categorie_id' => $quincaillerie?->id, 'prix_achat' => 3500, 'prix_vente' => 5000, 'stock_actuel' => 70, 'seuil_alerte' => 20],
            ['code' => 'QUI-002', 'nom' => 'Serrure de porte avec clés', 'description' => 'Serrure à encastrer 3 points', 'categorie_id' => $quincaillerie?->id, 'prix_achat' => 12000, 'prix_vente' => 16500, 'stock_actuel' => 28, 'seuil_alerte' => 8],
            ['code' => 'QUI-003', 'nom' => 'Paire de charnières renforcées', 'description' => 'Charnières acier pour portes lourdes', 'categorie_id' => $quincaillerie?->id, 'prix_achat' => 2500, 'prix_vente' => 3800, 'stock_actuel' => 90, 'seuil_alerte' => 25],

            // BOIS & MENUISERIE
            ['code' => 'BOI-001', 'nom' => 'Planche contreplaqué 250x125cm 18mm', 'description' => 'Contreplaqué marine résistant humidité', 'categorie_id' => $bois?->id, 'prix_achat' => 18000, 'prix_vente' => 24000, 'stock_actuel' => 45, 'seuil_alerte' => 10],
            ['code' => 'BOI-002', 'nom' => 'Porte pleine bois 80x200cm', 'description' => 'Porte intérieure isoplane', 'categorie_id' => $bois?->id, 'prix_achat' => 25000, 'prix_vente' => 35000, 'stock_actuel' => 12, 'seuil_alerte' => 3],

            // OUTILS
            ['code' => 'OUT-001', 'nom' => 'Perceuse électrique 600W', 'description' => 'Mandrin 13mm, vitesse variable', 'categorie_id' => $outils?->id, 'prix_achat' => 35000, 'prix_vente' => 48000, 'stock_actuel' => 15, 'seuil_alerte' => 5],
            ['code' => 'OUT-002', 'nom' => 'Niveau à bulle 60cm', 'description' => 'Niveau professionnel 3 fioles', 'categorie_id' => $outils?->id, 'prix_achat' => 4500, 'prix_vente' => 6500, 'stock_actuel' => 38, 'seuil_alerte' => 10],
        ];

        foreach ($produits as $produitData) {
            if ($produitData['categorie_id']) { // Créer seulement si la catégorie existe
                Produit::create($produitData);
            }
        }
    }
}