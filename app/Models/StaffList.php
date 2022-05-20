<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffList extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nom',
        'mantra',
        'evenement_id',
        'type',
        'logo',
        'photo',
        'event_gg_id',
        'event_mem_id',
        'event_abandon_id',
        'ev_abd_membre_id'

    ];

    protected $table = 'staff_lists';

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }

    public function staff_membres()
    {
        return $this->hasMany(StaffMembre::class);
    }
}
