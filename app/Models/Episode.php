<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
       // 'saison',
        'saison_id',
        'numero_episode',
        'titre',
        'resume',
        'image_url'
    ];

    public function saison()
    {
        return $this->belongsTo(Saison::class);
    }

    public function visionnages()
    {
        return $this->hasMany(Visionnage::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
}