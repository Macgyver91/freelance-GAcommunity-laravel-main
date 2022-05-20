<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetitGroupeMembre extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'membre_id',
        'petit_groupe_id'
    ];

    public function petit_groupe()
    {
        return $this->belongsTo(PetitGroupe::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }
}
