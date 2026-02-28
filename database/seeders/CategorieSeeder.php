<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $categories = [
            [
                'nom' => 'Ciment',
                'description' => 'Ciments de différentes qualités pour tous types de construction : ciment gris, ciment blanc, ciment prompt.',
            ],
            [
                'nom' => 'Fer & Acier',
                'description' => 'Barres de fer, fers à béton, tubes métalliques, tôles ondulées et profilés pour structure.',
            ],
            [
                'nom' => 'Peinture',
                'description' => 'Peintures murales, laques, vernis, anti-rouille et produits de finition pour intérieur et extérieur.',
            ],
            [
                'nom' => 'Carrelage & Revêtements',
                'description' => 'Carrelages muraux et de sol, faïence, grès cérame, revêtements décoratifs et colles spécialisées.',
            ],
            [
                'nom' => 'Plomberie',
                'description' => 'Tuyaux PVC, raccords, robinetterie, sanitaires, éviers, lavabos et accessoires de plomberie.',
            ],
            [
                'nom' => 'Électricité',
                'description' => 'Câbles électriques, disjoncteurs, prises, interrupteurs, tableaux électriques et matériel d\'installation.',
            ],
            [
                'nom' => 'Quincaillerie',
                'description' => 'Vis, clous, chevilles, charnières, serrures, cadenas et petite quincaillerie diverse.',
            ],
            [
                'nom' => 'Bois & Menuiserie',
                'description' => 'Planches, contreplaqué, panneaux, portes, fenêtres et matériaux de menuiserie.',
            ],
            [
                'nom' => 'Outils',
                'description' => 'Outils manuels et électriques : marteaux, perceuses, scies, truelles, niveaux et équipement professionnel.',
            ],
            [
                'nom' => 'Isolation & Étanchéité',
                'description' => 'Isolants thermiques et phoniques, membranes d\'étanchéité, mousses expansives et matériaux d\'isolation.',
            ],
        ];

        foreach ($categories as $categorie) {
            Categorie::firstOrCreate(
    ['nom' => $categorie['nom']], // Condition de recherche
    $categorie // Données à créer si n'existe pas
);
        }
    }
}