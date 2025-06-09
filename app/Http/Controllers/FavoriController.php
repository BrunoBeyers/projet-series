<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Serie;
use Illuminate\Http\Request;

class FavoriController extends Controller
{
    public function index()
    {
        $favoris = auth()->user()->favoris()->with('serie')->get();
        return view('web.favoris', compact('favoris'));
    }

    public function toggle(Serie $serie)
    {
        $favori = Favori::where('user_id', auth()->id())
                        ->where('serie_id', $serie->id)
                        ->first();

        if ($favori) {
            $favori->delete();
            $message = 'Série retirée des favoris';
        } else {
            Favori::create([
                'user_id' => auth()->id(),
                'serie_id' => $serie->id
            ]);
            $message = 'Série ajoutée aux favoris';
        }

        return redirect()->back()->with('success', $message);
    }
}
