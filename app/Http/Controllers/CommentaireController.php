<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Episode;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    public function store(Request $request, Episode $episode)
    {
        $validated = $request->validate([
            'contenu' => 'required|string|max:1000',
        ]);

        $commentaire = Commentaire::create([
            'user_id' => auth()->id(),
            'episode_id' => $episode->id,
            'contenu' => $validated['contenu'],
            'date_commentaire' => now()
        ]);

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès !');
    }

    public function destroy(Commentaire $commentaire)
    {
        // Vérifier que l'utilisateur est l'auteur du commentaire
        if ($commentaire->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire.');
        }

        $commentaire->delete();
        return redirect()->back()->with('success', 'Commentaire supprimé avec succès !');
    }
} 