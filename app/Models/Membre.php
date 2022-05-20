<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'info'
    ];

    public function membre_has_prospects()
    {
        return $this->hasMany(MembreHasProspect::class);
    }

    public function liens()
    {
        return $this->hasMany(Lien::class);
    }

    public function membre_has_passion_metier_talents()
    {
        return $this->hasMany(MembreHasPassionMetierTalent::class);
    }

    public function petit_groupe_membres()
    {
        return $this->hasMany(PetitGroupeMembre::class);
    }

    public function abandons()
    {
        return $this->hasMany(Abandon::class);
    }

    public function events()
    {
        return $this->hasMany(Evenement::class);
    }

    public function staff_has_membres()
    {
        return $this->hasMany(StaffHasMembre::class);
    }

    public function evenement_membres()
    {
        return $this->hasMany(EvenementMembre::class);
    }
}