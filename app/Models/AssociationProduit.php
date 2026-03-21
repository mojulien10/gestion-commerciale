<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssociationProduit extends Model
{
    protected $table = 'associations_produits';

    protected $fillable = [
        'produit_a_id',
        'produit_b_id',
        'support',
        'confiance',
        'lift',
        'nb_ventes_a',
        'nb_ventes_ab',
    ];

    protected $casts = [
        'support' => 'decimal:2',
        'confiance' => 'decimal:2',
        'lift' => 'decimal:2',
    ];

    /**
     * Relation avec le produit A (ex: Ciment)
     */
    public function produitA(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_a_id');
    }

    /**
     * Relation avec le produit B (ex: Fer)
     */
    public function produitB(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_b_id');
    }

    /**
     * Scope pour récupérer les associations d'un produit
     */
    public function scopePourProduit($query, $produitId)
    {
        return $query->where('produit_a_id', $produitId)
                     ->orderBy('confiance', 'desc');
    }

    /**
     * Scope pour les associations avec bonne confiance
     */
    public function scopeConfianceMinimale($query, $min = 50)
    {
        return $query->where('confiance', '>=', $min);
    }
}