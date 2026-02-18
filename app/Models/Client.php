<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'clients';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'nom',
        'telephone',
        'email',
        'adresse',
        'total_achats',
        'nombre_achats',
        'dernier_achat_le',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'total_achats' => 'decimal:2',
        'nombre_achats' => 'integer',
        'dernier_achat_le' => 'datetime',
    ];
}