<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Serie;

class SerieAjoutController extends Controller
{
    public function index()
    {
        $series = Serie::all();
        return view('web.ajouter.series', compact('series'));
    }

    

    public function create()
    {
        $plateformes = \App\Models\Plateforme::all();
        return view('web.ajouter.seriesCreate', compact('plateformes'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'annee_sortie' => 'required|integer|min:1900|max:' . date('Y'),
            'plateforme_id' => 'required|exists:plateformes,id',
            'image' => 'nullable|image|max:2048', // max 2Mo, accepte jpeg/png/gif...
        ]);
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('series_images', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }
    
        Serie::create($validated);
    
        return redirect()->route('seriesAjout.store')->with('success', 'Série ajoutée avec succès !');
    }
    
    
    public function edit(Serie $serie)
    {
        return view('web.ajouter.seriesEdit', compact('serie'));
    }

    public function update(Request $request, Serie $serie)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ]);

    // Si une nouvelle image est uploadée
    if ($request->hasFile('image')) {
        // Supprimer l’ancienne si elle existe (facultatif)
        if ($serie->image_url && file_exists(public_path($serie->image_url))) {
            unlink(public_path($serie->image_url));
        }

        // Stocker la nouvelle
        $path = $request->file('image')->store('series_images', 'public');
        $validated['image_url'] = '/storage/' . $path;
    }

    $serie->update($validated);

    return redirect()->route('seriesAjout.index')->with('success', 'Série modifiée avec succès !');
}


    public function destroy(Serie $serie)
    {
        $serie->delete();

        return redirect()->route('series.index')->with('success', 'Série supprimée avec succès !');
    }
}