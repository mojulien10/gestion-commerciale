<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneVente extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'lignes_vente';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'vente_id',
        'produit_id',
        'quantite',
        'prix_unitaire',
        'prix_total',
        'is_recommended',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'quantite' => 'integer',
        'prix_unitaire' => 'decimal:2',
        'prix_total' => 'decimal:2',
        'is_recommended' => 'boolean',
    ];

    /**
     * Relation : Une ligne de vente appartient à une vente.
     */
    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }

    /**
     * Relation : Une ligne de vente appartient à un produit.
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}