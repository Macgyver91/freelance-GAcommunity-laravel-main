<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffMembre extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'membre_id',
        'staff_list_id',
        'commentaire',
        'taux_de_passage',
        'role_du_staff'
    ];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function staff_list()
    {
        return $this->belongsTo(StaffList::class);
    }
}
