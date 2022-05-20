<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngeInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'membre'
    ];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }
}