<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Serie extends Model
{
    use HasFactory;

    protected $table = 'series'; // facultatif si ta table s'appelle 'series'

    protected $fillable = [
        'titre',
        'description',
        'annee_sortie',
        'image_url',
        'plateforme_id',
    ];

    // Une série appartient à une plateforme
    public function plateforme()
    {
        return $this->belongsTo(Plateforme::class);
    }

    // Une série a plusieurs épisodes
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    // Relations avec favoris
    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }

    // Relations avec archives
    public function archives()
    {
        return $this->hasMany(Archive::class);
    }

    // Relation avec castings
    public function castings()
    {
        return $this->hasMany(Casting::class);
    }
    

     public function saisons()
    {
        return $this->hasMany(Saison::class);
    }
}
