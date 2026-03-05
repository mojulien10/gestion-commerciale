<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'ventes';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'numero_vente',
        'client_id',
        'user_id',
        'montant_total',
        'statut',
        'notes',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'montant_total' => 'decimal:2',
    ];

    /**
     * Relation : Une vente appartient à un client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation : Une vente appartient à un utilisateur (vendeur).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : Une vente a plusieurs lignes de vente.
     */
    public function lignesVente()
    {
        return $this->hasMany(LigneVente::class);
    }

    /**
     * Générer un numéro de vente unique.
     */
    public static function genererNumeroVente()
    {
        $annee = date('Y');
        $derniere = self::whereYear('created_at', $annee)->count() + 1;
        return 'VTE-' . $annee . '-' . str_pad($derniere, 4, '0', STR_PAD_LEFT);
    }
}