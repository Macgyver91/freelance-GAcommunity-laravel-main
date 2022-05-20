<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefinePassword extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

    protected $primaryKey = 'email';
    public $timestamps = false;
    protected $table = 'define_passwords';
}
