<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'tel',
        'type'
    ];

    public function membre_has_prospects()
    {
        return $this->hasMany(MembreHasProspect::class);
    }

    public function liens()
    {
        return $this->hasMany(Lien::class);
    }
}
