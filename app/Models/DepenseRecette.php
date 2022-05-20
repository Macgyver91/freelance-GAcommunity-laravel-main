<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepenseRecette extends Model
{
    use HasFactory;

    public function comptabilite_has_depense_recettes()
    {
        return $this->hasMany(ComptabiliteHasDepenseRecette::class);
    }
}
