<?php

namespace App\Http\Controllers;

use App\Models\Saison;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaisonController extends Controller
{
    // Formulaire d'ajout
    public function create(Serie $serie)
    {
        return view('web.saisons.create', compact('serie'));
    }

    // Enregistrement
   public function store(Request $request, Serie $serie)
{
    $validated = $request->validate([
        'numero' => 'required|integer|min:1',
        'description' => 'nullable|string',
        'annee_sortie' => 'required|integer|min:1900|max:' . date('Y'),
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('saisons', 'public');
        $validated['image_url'] = $path;
    }

    $validated['serie_id'] = $serie->id;

    Saison::create($validated);

    return redirect()->route('seriesAjout.index')->with('success', 'Saison ajoutée avec succès !');
}


    // Formulaire de modification
    public function edit(Saison $saison)
    {
        return view('web.saisons.edit', compact('saison'));
    }

    // Mise à jour
    public function update(Request $request, Saison $saison)
    {
        // Si la requête est de type DELETE, on supprime la saison
        if ($request->isMethod('delete')) {
            // Supprimer l'image si elle existe
            if ($saison->image_url) {
                Storage::disk('public')->delete($saison->image_url);
            }

            // Supprimer la saison
            $saison->delete();

            return redirect()->back()->with('success', 'Saison supprimée avec succès !');
        }

        // Sinon, on met à jour la saison normalement
        $validated = $request->validate([
            'numero' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'annee_sortie' => 'required|integer|min:1900|max:' . date('Y'),
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('saisons', 'public');
            $validated['image_url'] = $path;
        }

        $saison->update($validated);

        return redirect()->route('seriesAjout.index')->with('success', 'Saison modifiée avec succès !');
    }


    public function indexForSerie(Serie $serie)
{
    $saisons = $serie->saisons()->orderBy('numero')->get();
    return view('web.saisons.index', compact('serie', 'saisons'));
}

    public function destroy(Saison $saison)
    {
        // Supprimer l'image si elle existe
        if ($saison->image_url) {
            Storage::disk('public')->delete($saison->image_url);
        }

        // Supprimer la saison
        $saison->delete();

        return redirect()->back()->with('success', 'Saison supprimée avec succès !');
    }
}


