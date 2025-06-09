<?php

namespace App\Http\Controllers;

use App\Models\Visionnage;
use App\Models\Episode;
use Illuminate\Http\Request;

class VisionnageController extends Controller
{
    public function index()
    {
        $visionnages = auth()->user()->visionnages()->with('episode.saison.serie')->get();
        return view('web.visionnages', compact('visionnages'));
    }

    public function toggle(Episode $episode)
    {
        $visionnage = Visionnage::where('user_id', auth()->id())
                        ->where('episode_id', $episode->id)
                        ->first();

        if ($visionnage) {
            $visionnage->delete();
            $message = 'Épisode marqué comme non vu';
        } else {
            Visionnage::create([
                'user_id' => auth()->id(),
                'episode_id' => $episode->id,
                'date_visionnage' => now()
            ]);
            $message = 'Épisode marqué comme vu';
        }

        return redirect()->back()->with('success', $message);
    }
} 