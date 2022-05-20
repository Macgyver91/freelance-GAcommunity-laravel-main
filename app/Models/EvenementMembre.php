<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvenementMembre extends Model
{
    use HasFactory;

    protected $fillable = [
        'membre_id',
        'evenement_id'
    ];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }
}
