<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassionMetierTalent extends Model
{
    use HasFactory;

    public function membre_has_passion_metier_talents()
    {
        return $this->hasMany(MembreHasPassionMetierTalent::class);
    }
}
