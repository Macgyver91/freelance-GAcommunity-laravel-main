<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComptabiliteHasDepenseRecette extends Model
{
    use HasFactory;

    public function comptabilite()
    {
        return $this->belongsTo(Comptabilite::class);
    }

    public function depense_recette()
    {
        return $this->belongsTo(DepenseRecette::class);
    }
}
