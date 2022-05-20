<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetitGroupe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'capitaine',
        'photo',
        'grand_groupe_id'
    ];


    public function grand_groupe()
    {
        return $this->belongsTo(GrandGroupe::class);
    }
}