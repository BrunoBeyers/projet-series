<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Casting extends Model
{
    use HasFactory;

    protected $fillable = [
        'acteur_id',
        'serie_id',
        'role',
    ];

    public function acteur()
    {
        return $this->belongsTo(Acteur::class);
    }

    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }
}