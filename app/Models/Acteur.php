<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Acteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'biographie',
        'image_url',  // très important pour l’image
    ];
    public function castings()
    {
        return $this->hasMany(Casting::class);
    }
}