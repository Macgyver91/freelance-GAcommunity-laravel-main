<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembreHasPassionMetierTalent extends Model
{
    use HasFactory;

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function passion_metier_talent()
    {
        return $this->belongsTo(PassionMetierTalent::class);
    }
}
