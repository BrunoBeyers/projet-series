<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Accueil;

use App\Http\Controllers\Ajouter;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\ProfilPersoController;
use App\Http\Controllers\ActeurController;
use App\Http\Controllers\PlateformeController;
use App\Http\Controllers\SerieAjoutController;
use App\Http\Controllers\SaisonController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\CastingController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\VisionnageController;
use App\Http\Controllers\CommentaireController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/accueil', [Accueil::class, 'index'])->name('accueil');
    Route::get('/series', [SerieController::class, 'index'])->name('series.index');
    Route::get('/series/{serie}', [SerieController::class, 'show'])->name('series.show');
    Route::get('/series/{serie}/episodes/{episode}', [EpisodeController::class, 'show'])->name('episodes.show');
    Route::get('/favoris', [FavoriController::class, 'index'])->name('favoris.index');
    Route::post('/favoris/{serie}', [FavoriController::class, 'toggle'])->name('favoris.toggle');
    Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');
    Route::post('/archives/{serie}', [ArchiveController::class, 'toggle'])->name('archives.toggle');
    Route::get('/visionnages', [VisionnageController::class, 'index'])->name('visionnages.index');
    Route::post('/visionnages/{episode}', [VisionnageController::class, 'toggle'])->name('visionnages.toggle');
    Route::post('/episodes/{episode}/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');
    Route::delete('/commentaires/{commentaire}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy');
    Route::get('/ajouter', [Ajouter::class, 'index'])->name('ajouter.index');
    Route::get('/profil', [ProfilPersoController::class, 'index'])->name('profil.perso');

    Route::get('/ajouter/series', [SerieAjoutController::class, 'index'])->name('seriesAjout.index');
    Route::get('/ajouter/plateformes', [PlateformeController::class, 'index'])->name('plateformesAjout.index');
    Route::get('/ajouter/acteurs', [ActeurController::class, 'index'])->name('acteursAjout.index');

    Route::get('/plateformes', [PlateformeController::class, 'index'])->name('plateformes.index');
    Route::post('/plateformes', [PlateformeController::class, 'store'])->name('plateformes.store');
    Route::delete('/plateformes/{plateforme}', [PlateformeController::class, 'destroy'])->name('plateformes.destroy');

    Route::get('/acteurs', [ActeurController::class, 'index'])->name('acteurs.index');
    Route::post('/acteurs', [ActeurController::class, 'store'])->name('acteurs.store');
    Route::delete('/acteurs/{acteur}', [ActeurController::class, 'destroy'])->name('acteurs.destroy');
    
    Route::get('/ajouter/series', [SerieAjoutController::class, 'index'])->name('seriesAjout.index');
    Route::get('/ajouter/series/create', [SerieAjoutController::class, 'create'])->name('seriesAjout.create');
    Route::post('/ajouter/series/create', [SerieAjoutController::class, 'store'])->name('seriesAjout.store');
    Route::put('/ajouter/series/{serie}', [SerieAjoutController::class, 'update'])->name('seriesAjout.update');
    Route::get('/ajouter/series/{serie}/edit', [SerieAjoutController::class, 'edit'])->name('seriesAjout.edit');
    Route::delete('/ajouter/{serie}', [SerieAjoutController::class, 'destroy'])->name('seriesAjout.destroy');

    Route::get('/series/{serie}/saisons/create', [SaisonController::class, 'create'])->name('saisons.create');
    Route::post('/series/{serie}/saisons', [SaisonController::class, 'store'])->name('saisons.store');
    Route::get('/saisons/{saison}/edit', [SaisonController::class, 'edit'])->name('saisons.edit');
    Route::put('/saisons/{saison}', [SaisonController::class, 'update'])->name('saisons.update');
    Route::get('/series/{serie}/saisons', [SaisonController::class, 'indexForSerie'])->name('saisons.index');
    Route::delete('/saisons/{saison}', [SaisonController::class, 'destroy'])->name('saisons.destroy');

    Route::get('/import-tvmaze', [ImportController::class, 'importFromTVMaze']);
    Route::prefix('series/{serie}/saisons/{saison}')->group(function () {
        Route::get('episodes', [EpisodeController::class, 'index'])->name('episodes.index');
        Route::get('episodes/create', [EpisodeController::class, 'create'])->name('episodes.create');
        Route::post('episodes', [EpisodeController::class, 'store'])->name('episodes.store');
        Route::get('episodes/{episode}/edit', [EpisodeController::class, 'edit'])->name('episodes.edit');
        Route::put('episodes/{episode}', [EpisodeController::class, 'update'])->name('episodes.update');
        Route::delete('episodes/{episode}', [EpisodeController::class, 'destroy'])->name('episodes.destroy');
    });

    // Routes pour les castings
    Route::get('/ajouter/castings', [CastingController::class, 'create'])->name('castings.create');
    Route::post('/ajouter/castings', [CastingController::class, 'store'])->name('castings.store');
    Route::delete('/ajouter/castings/{casting}', [CastingController::class, 'destroy'])->name('castings.destroy');
});
