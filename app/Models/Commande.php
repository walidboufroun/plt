<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Commande.php
class Commande extends Model
{
    protected $fillable = [
        'date',
        'id_client',
        'id_societe',
        'id_produit',
        'number',
        'statut',
    ];

    public function client()
    {
        return $this->belongsTo(Societe::class, 'id_client');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
    public function Commande()
    {
        return $this->belongsTo(Commande::class, 'id_societe');
    }


}
