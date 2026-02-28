<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'categories';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'nom',
        'description',
    ];

    /**
     * Relation : Une catégorie a plusieurs produits.
     */
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}