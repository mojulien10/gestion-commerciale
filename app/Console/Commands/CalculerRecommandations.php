<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RecommendationService;

class CalculerRecommandations extends Command
{
    /**
     * Nom de la commande
     */
    protected $signature = 'recommandations:calculer';

    /**
     * Description de la commande
     */
    protected $description = 'Analyser les ventes et générer les associations de produits (Algorithme Apriori)';

    /**
     * Exécuter la commande
     */
    public function handle(RecommendationService $service)
    {
        $this->info('🤖 Démarrage de l\'analyse des ventes...');
        $this->info('📊 Algorithme : Apriori (Market Basket Analysis)');
        $this->newLine();

        // Lancer l'analyse
        $resultat = $service->analyserVentes();

        if ($resultat['success']) {
            $this->info('✅ ' . $resultat['message']);
            $this->newLine();

            // Afficher les statistiques
            $stats = $resultat['stats'];
            $this->table(
                ['Métrique', 'Valeur'],
                [
                    ['Ventes analysées', $stats['ventes_analysees']],
                    ['Produits analysés', $stats['produits_analyses']],
                    ['Associations créées', $stats['associations_creees']],
                    ['Associations ignorées', $stats['associations_ignorees']],
                ]
            );

            $this->info('💡 Les recommandations sont maintenant disponibles !');
            
            return Command::SUCCESS;
        } else {
            $this->error('❌ ' . $resultat['message']);
            return Command::FAILURE;
        }
    }
}