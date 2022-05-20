<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abandon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nb_rate',
        'membre_id',
        'evenement_id',
        'motif'
    ];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function event()
    {
        return $this->belongsTo(Evenement::class);
    }
}
