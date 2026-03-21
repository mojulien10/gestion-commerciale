<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('associations_produits', function (Blueprint $table) {
            $table->id();
            
            // Les deux produits de l'association
            $table->foreignId('produit_a_id')->constrained('produits')->onDelete('cascade');
            $table->foreignId('produit_b_id')->constrained('produits')->onDelete('cascade');
            
            // Les 3 métriques Apriori
            $table->decimal('support', 5, 2)->comment('Fréquence ensemble (%)');
            $table->decimal('confiance', 5, 2)->comment('Probabilité A→B (%)');
            $table->decimal('lift', 5, 2)->comment('Pertinence de l\'association');
            
            // Nombre de ventes analysées
            $table->integer('nb_ventes_a')->comment('Nombre de ventes avec produit A');
            $table->integer('nb_ventes_ab')->comment('Nombre de ventes avec A et B ensemble');
            
            $table->timestamps();
            
            // Index pour performance
            $table->index('produit_a_id');
            $table->index('confiance');
            
            // Empêcher les doublons (A,B) et (B,A)
            $table->unique(['produit_a_id', 'produit_b_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associations_produits');
    }
};