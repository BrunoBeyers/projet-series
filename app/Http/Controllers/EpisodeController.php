<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Saison;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    // Liste des épisodes d'une saison
    public function index()
    {
        $serie_id = request()->route('serie');
        $saison_id = request()->route('saison');
        
        $saison = Saison::where('serie_id', $serie_id)
                        ->where('id', $saison_id)
                        ->firstOrFail();
        $episodes = $saison->episodes()->orderBy('numero_episode')->get();
        return view('web.episodes.index', compact('saison', 'episodes'));
    }
   
    public function create()
    {
        $serie_id = request()->route('serie');
        $saison_id = request()->route('saison');
        
        $saison = Saison::where('serie_id', $serie_id)
                        ->where('id', $saison_id)
                        ->firstOrFail();
        return view('web.episodes.create', compact('saison'));
    }

    public function store(Request $request)
    {
        $serie_id = request()->route('serie');
        $saison_id = request()->route('saison');
        
        $saison = Saison::where('serie_id', $serie_id)
                        ->where('id', $saison_id)
                        ->firstOrFail();
    
        $validated = $request->validate([
            'numero_episode' => 'required|integer|min:1',
            'titre' => 'required|string|max:255',
            'resume' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);
    
        // Ajout explicite des champs requis
        $validated['saison_id'] = $saison->id;
        $validated['saison'] = $saison->numero;
        // Suppression de serie_id car il n'est pas nécessaire
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('episodes', 'public');
            $validated['image_url'] = $path;
        }
    
        $episode = Episode::create($validated);
    
        return redirect()->route('episodes.index', [$serie_id, $saison_id])->with('success', 'Épisode ajouté avec succès !');
    }
    

    // Formulaire d'édition
    // Formulaire d'édition
public function edit()
{
    $serie_id = request()->route('serie');
    $saison_id = request()->route('saison');
    $episode_id = request()->route('episode');
    
    $saison = Saison::where('serie_id', $serie_id)
                    ->where('id', $saison_id)
                    ->firstOrFail();
    $episode = Episode::findOrFail($episode_id);
    
    return view('web.episodes.edit', compact('saison', 'episode'));
}

// Mise à jour de l'épisode
public function update(Request $request)
{
    $serie_id = request()->route('serie');
    $saison_id = request()->route('saison');
    $episode_id = request()->route('episode');
    
    $saison = Saison::where('serie_id', $serie_id)
                    ->where('id', $saison_id)
                    ->firstOrFail();
    $episode = Episode::findOrFail($episode_id);

    $validated = $request->validate([
        'numero_episode' => 'required|integer|min:1',
        'titre' => 'required|string|max:255',
        'resume' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('episodes', 'public');
        $validated['image_url'] = $path;
    }

    $episode->update($validated);

    return redirect()->route('episodes.index', [$serie_id, $saison_id])->with('success', 'Épisode modifié avec succès !');
}

// Suppression
public function destroy()
{
    $serie_id = request()->route('serie');
    $saison_id = request()->route('saison');
    $episode_id = request()->route('episode');
    
    $episode = Episode::findOrFail($episode_id);
    $episode->delete();

    return redirect()->route('episodes.index', [$serie_id, $saison_id])->with('success', 'Épisode supprimé avec succès !');
}

public function show($serie_id, $episode_id)
{
    $episode = Episode::with(['saison.serie', 'commentaires.user', 'visionnages'])
                     ->where('id', $episode_id)
                     ->whereHas('saison', function($query) use ($serie_id) {
                         $query->where('serie_id', $serie_id);
                     })
                     ->firstOrFail();
    
    return view('web.series.episodesShow.show', compact('episode'));
}
}
