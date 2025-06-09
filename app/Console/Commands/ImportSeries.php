<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Serie;
use App\Models\Saison;
use App\Models\Episode;
use App\Models\Acteur;
use App\Models\Casting;

class ImportSeries extends Command
{
    protected $signature = 'import:series';

    protected $description = 'Importe les séries depuis un fichier JSON';

    public function handle()
    {
        $this->info("Début de l'import...");

        $jsonPath = storage_path('app/data/series.json');
        if (!file_exists($jsonPath)) {
            $this->error("Fichier JSON introuvable : $jsonPath");
            return 1;
        }

        $jsonData = json_decode(file_get_contents($jsonPath), true);

        foreach ($jsonData as $serieData) {
            // --- Import Serie ---
            $plateformesPossibles = [3, 4, 5, 6];
            $plateformeId = $plateformesPossibles[array_rand($plateformesPossibles)];

            $anneeSortie = $serieData['premiereDiffusion'] ?? null;
            if ($anneeSortie) {
                $anneeSortie = substr($anneeSortie, 0, 4);
            } else {
                $anneeSortie = 2000;
            }

            $serie = Serie::updateOrCreate(
                ['id' => $serieData['showId']],
                [
                    'titre' => $serieData['title'],
                    'description' => strip_tags($serieData['summary']),
                    'image_url' => $serieData['image'] ?? 'https://example.com/default.jpg',
                    'annee_sortie' => $anneeSortie,
                    'plateforme_id' => $plateformeId,
                ]
            );

            // --- Import Saisons ---
            if (!empty($serieData['seasons'])) {
                foreach ($serieData['seasons'] as $index => $seasonData) {
                    $anneeSortieSaison = 2000; // par défaut
                    // Si tu as une date dans $seasonData, l'extraire ici

                    $saison = Saison::updateOrCreate(
                        ['id' => $seasonData['seasonId']],
                        [
                            'numero' => $index + 1,  // Correction ici : numéro de saison à partir de l'index
                            'serie_id' => $serie->id,
                            'description' => strip_tags($seasonData['summary'] ?? ''),
                            'annee_sortie' => $anneeSortieSaison,
                            'image_url' => $seasonData['image'] ?? 'https://example.com/default-season.jpg',
                        ]
                    );

                    // --- Import Episodes ---
                    if (!empty($seasonData['episodes'])) {
                        foreach ($seasonData['episodes'] as $episodeData) {
                            $episode = Episode::updateOrCreate(
                                ['id' => $episodeData['episodeId']],
                                [
                                    'saison_id' => $saison->id,
                                    'numero_episode' => $episodeData['number'] ?? 0,  // Valeur par défaut à 0 ici
                                    'titre' => $episodeData['name'] ?? '',
                                    'resume' => strip_tags($episodeData['summary'] ?? ''),
                                    'image_url' => $episodeData['image'] ?? 'https://example.com/default-episode.jpg',
                                ]
                            );
                        }
                    }
                }
            }

            // --- Import Casting et Acteurs ---
            if (!empty($serieData['casts'])) {
                foreach ($serieData['casts'] as $castData) {
                    $acteur = Acteur::updateOrCreate(
                        ['id' => $castData['personId']],
                        [
                            'nom' => explode(' ', $castData['name'])[1] ?? $castData['name'],
                            'prenom' => explode(' ', $castData['name'])[0] ?? '',
                            'date_naissance' => '1900-01-01', // valeur fictive
                            'biographie' => '', // pas de NULL ici !
                            'image_url' => $castData['image'] ?? 'https://example.com/default-actor.jpg',
                        ]
                    );
                    Casting::updateOrCreate(
                        [
                            'acteur_id' => $acteur->id,
                            'serie_id' => $serie->id,
                        ],
                        [
                            'role' => $castData['character'] ?? '',
                        ]
                    );
                }
            }
        }

        $this->info("Import terminé.");

        return 0;
    }
}
