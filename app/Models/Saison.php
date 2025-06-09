<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    use HasFactory;

    protected $table = 'saisons';

    protected $fillable = [
        'numero',
        'serie_id',
        'description',
        'annee_sortie',
        'image_url',  // URL de l'image de la saison
    ];

    // Relation avec la série
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }

    // Relation avec les épisodes
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
}
