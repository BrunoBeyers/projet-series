<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Serie;
use App\Models\Saison;
use App\Models\Episode;

class ImportController extends Controller
{
    public function importFromTVMaze()
    {
        // Liste des séries à importer
        $shows = ['Breaking Bad', 'Game of Thrones', 'Stranger Things'];

        foreach ($shows as $showName) {
            try {
                // 1. Recherche de la série
                $response = Http::withoutVerifying()->get('https://api.tvmaze.com/singlesearch/shows', [
                    'q' => $showName
                ]);

                if (!$response->ok()) {
                    \Log::error("Impossible de trouver la série: {$showName}");
                    continue;
                }

                $show = $response->json();

                // 2. Création de la série
                $serie = Serie::firstOrCreate(
                    ['titre' => $show['name']],
                    [
                        'description' => $show['summary'] ?? '',
                        'annee_sortie' => isset($show['premiered']) ? substr($show['premiered'], 0, 4) : null,
                        'image_url' => $show['image']['medium'] ?? null,
                    ]
                );

                // 3. Récupération des saisons
                $seasonsResponse = Http::withoutVerifying()->get('https://api.tvmaze.com/shows/' . $show['id'] . '/seasons');
                
                if (!$seasonsResponse->ok()) {
                    \Log::error("Impossible de récupérer les saisons pour la série: {$show['name']}");
                    continue;
                }

                $seasons = $seasonsResponse->json();

                foreach ($seasons as $season) {
                    $saison = Saison::firstOrCreate(
                        [
                            'serie_id' => $serie->id,
                            'numero' => $season['number'],
                        ],
                        [
                            'annee_sortie' => isset($season['premiereDate']) ? substr($season['premiereDate'], 0, 4) : null,
                        ]
                    );

                    // 4. Récupération des épisodes de la saison
                    $episodesResponse = Http::withoutVerifying()->get('https://api.tvmaze.com/seasons/' . $season['id'] . '/episodes');
                    
                    if (!$episodesResponse->ok()) {
                        \Log::error("Impossible de récupérer les épisodes pour la saison {$season['number']} de la série {$show['name']}");
                        continue;
                    }

                    $episodes = $episodesResponse->json();

                    foreach ($episodes as $ep) {
                        Episode::firstOrCreate(
                            [
                                'saison_id' => $saison->id,
                                'numero_episode' => $ep['number'],
                            ],
                            [
                                'titre' => $ep['name'],
                                'resume' => $ep['summary'] ?? '',
                                'image_url' => $ep['image']['medium'] ?? null,
                                'saison' => $season['number'],
                            ]
                        );
                    }
                }
            } catch (\Exception $e) {
                // Log l'erreur avec le nom de la série actuelle
                \Log::error("Erreur lors de l'importation de la série {$showName}: " . $e->getMessage());
                continue;
            }
        }

        return redirect()->back()->with('success', 'Importation terminée !');
    }
}