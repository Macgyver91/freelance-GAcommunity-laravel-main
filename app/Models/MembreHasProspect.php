<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembreHasProspect extends Model
{
    use HasFactory;

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function prospect()
    {
        return $this->belongsTo(Membre::class);
    }
}
