<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementStock extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'mouvements_stock';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'produit_id',
        'type',
        'quantite',
        'stock_avant',
        'stock_apres',
        'motif',
        'user_id',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'quantite' => 'integer',
        'stock_avant' => 'integer',
        'stock_apres' => 'integer',
    ];

    /**
     * Relation : Un mouvement appartient à un produit.
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    /**
     * Relation : Un mouvement appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
 * Relation : Un produit a plusieurs mouvements de stock.
 */
    public function mouvementsStock()
    {
    return $this->hasMany(MouvementStock::class);
    }
}