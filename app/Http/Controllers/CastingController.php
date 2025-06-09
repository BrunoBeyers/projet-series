<?php

namespace App\Http\Controllers;

use App\Models\Casting;
use App\Models\Acteur;
use App\Models\Serie;
use Illuminate\Http\Request;

class CastingController extends Controller
{
    public function create()
    {
        $acteurs = Acteur::all();
        $series = Serie::all();
        return view('web.ajouter.castings', compact('acteurs', 'series'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'acteur_id' => 'required|exists:acteurs,id',
            'serie_id' => 'required|exists:series,id',
            'role' => 'required|string|max:255',
        ]);

        // Vérifier si le casting existe déjà
        $existingCasting = Casting::where('acteur_id', $validated['acteur_id'])
            ->where('serie_id', $validated['serie_id'])
            ->first();

        if ($existingCasting) {
            return redirect()->back()->with('error', 'Cet acteur est déjà associé à cette série.');
        }

        Casting::create($validated);

        return redirect()->back()->with('success', 'Casting ajouté avec succès !');
    }

    public function destroy(Casting $casting)
    {
        $casting->delete();
        return redirect()->back()->with('success', 'Casting supprimé avec succès !');
    }
} 