<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index()
    {
        $series = Serie::with(['plateforme', 'saisons.episodes', 'castings.acteur'])->get();
        return view('web.series', compact('series'));
    }

    public function show(Serie $serie)
    {
        $serie->load(['plateforme', 'saisons.episodes', 'castings.acteur']);
        return view('web.series.show', compact('serie'));
    }
}
