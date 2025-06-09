<?php

namespace App\Http\Controllers;

use App\Models\Acteur;
use Illuminate\Http\Request;

class ActeurController extends Controller
{
    public function index()
    {
        $acteurs = Acteur::all();
        return view('web.ajouter.acteurs', compact('acteurs'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'date_naissance' => 'required|date',
        'biographie' => 'nullable|string',
        'image' => 'nullable|image|max:2048', // validation image
    ]);

    if ($request->hasFile('image')) {
        // Stocker l'image dans storage/app/public/acteurs
        $path = $request->file('image')->store('acteurs', 'public');
        $validated['image_url'] = $path; // chemin relatif stocké en base
    }

    Acteur::create($validated);

    return redirect()->route('acteurs.index')->with('success', 'Acteur ajouté avec succès !');
}


    public function destroy(Acteur $acteur)
    {
        $acteur->delete();

        return redirect()->route('acteurs.index')->with('success', 'Acteur supprimé avec succès !');
    }
}
