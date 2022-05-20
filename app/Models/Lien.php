<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lien extends Model
{
    use HasFactory;

    protected $fillable = [
        'membre_id',
        'prospect_id',
        'type_lien_id'
    ];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function prospect()
    {
        return $this->belongsTo(Membre::class);
    }

    public function type_lien()
    {
        return $this->belongsTo(TypeLien::class);
    }
}