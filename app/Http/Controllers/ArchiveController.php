<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Serie;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = auth()->user()->archives()->with('serie')->get();
        return view('web.archives', compact('archives'));
    }

    public function toggle(Serie $serie)
    {
        $archive = Archive::where('user_id', auth()->id())
                        ->where('serie_id', $serie->id)
                        ->first();

        if ($archive) {
            $archive->delete();
            $message = 'Série marquée comme non vue';
        } else {
            Archive::create([
                'user_id' => auth()->id(),
                'serie_id' => $serie->id
            ]);
            $message = 'Série marquée comme vue';
        }

        return redirect()->back()->with('success', $message);
    }
} 