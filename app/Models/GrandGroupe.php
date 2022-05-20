<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrandGroupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'nom',
        'mantra',
        'declaration',
        'photo',
        'petit_groupe_id',
        'logo',
        'musique_choree',
        'video_choree',
        'photo_drapeau',
        'capitaine',
        'co_capitaine',
        'resp_com',
        'resp_heritage',
        'resp_anges',
        'resp_bateau'
    ];

    public function petit_groupes()
    {
        return $this->hasMany(PetitGroupe::class);
    }

    public function events()
    {
        return $this->hasMany(Evenement::class);
    }
}
