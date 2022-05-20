<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'numero_week_end',
        'pays',
        'ville',
        'centre',
        'date_debut',
        'date_fin',
        'lieu',
        'adresse',
        'coach',
        'tarif',
        'grand_groupe_id',
        'abandon_id',
        'abd_membre_id'
    ];

    public function grand_groupe()
    {
        return $this->belongsTo(GrandGroupe::class);
    }

    public function staff_lists()
    {
        return $this->hasMany(StaffList::class);
    }

    public function comptabilites()
    {
        return $this->hasMany(Comptabilite::class);
    }

    public function evenement_membres()
    {
        return $this->hasMany(EvenementMembre::class);
    }

    public function abandons()
    {
        return $this->hasMany(Abandon::class);
    }
}