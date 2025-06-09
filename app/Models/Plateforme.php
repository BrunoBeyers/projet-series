<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plateforme extends Model
{
    use HasFactory;

   
    
    protected $fillable = [
        'nom',
        'url',
    ];

    public function series()
    {
        return $this->hasMany(Serie::class);
    }
}