<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'produits';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'code',
        'nom',
        'description',
        'categorie_id',
        'prix_achat',
        'prix_vente',
        'stock_actuel',
        'seuil_alerte',
        'image',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'prix_achat' => 'decimal:2',
        'prix_vente' => 'decimal:2',
        'stock_actuel' => 'integer',
        'seuil_alerte' => 'integer',
    ];

    /**
     * Relation : Un produit appartient à une catégorie.
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    /**
     * Relation : Un produit a plusieurs mouvements de stock.
     */
    public function mouvementsStock()
    {
        return $this->hasMany(MouvementStock::class);
    }
    /** Relation avec les lignes de vente
     */
    public function lignesVente(): HasMany
    {
        return $this->hasMany(LigneVente::class, 'produit_id');
    }

    /**
     * Accesseur : Calculer la marge.
     */
    public function getMargeAttribute()
    {
        return $this->prix_vente - $this->prix_achat;
    }

    /**
     * Accesseur : Calculer le pourcentage de marge.
     */
    public function getPourcentageMargeAttribute()
    {
        if ($this->prix_achat == 0) return 0;
        return (($this->prix_vente - $this->prix_achat) / $this->prix_achat) * 100;
    }

    /**
     * Vérifier si le stock est bas.
     */
    public function isStockBas()
    {
        return $this->stock_actuel <= $this->seuil_alerte;
    }
}