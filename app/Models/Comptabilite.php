<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comptabilite extends Model
{
    use HasFactory;

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }

    public function comptabilite_has_depense_recettes()
    {
        return $this->hasMany(ComptabiliteHasDepenseRecette::class);
    }
}
