<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlateformeController extends Controller
{
    public function index()
    {
        $plateformes = \App\Models\Plateforme::all();
        return view('web.ajouter.plateformes', compact('plateformes'));
    }

    public function destroy(\App\Models\Plateforme $plateforme)
    {
        // Supprime l'image du stockage si elle existe
        if ($plateforme->url) {
            $path = str_replace('/storage/', '', $plateforme->url);
            \Storage::disk('public')->delete($path);
        }
    
        $plateforme->delete();
    
        return redirect()->route('plateformes.index')->with('success', 'Plateforme supprimée avec succès !');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // 2 Mo max
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('plateformes', 'public');
        }

        \App\Models\Plateforme::create([
            'nom' => $validated['nom'],
            'url' => $imagePath ? '/storage/' . $imagePath : null,
        ]);

        return redirect()->route('plateformes.index')->with('success', 'Plateforme ajoutée avec succès !');
    }


}
