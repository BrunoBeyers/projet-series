<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilPersoController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $archives = $user->archives()
                        ->with(['serie' => function($query) {
                            $query->with('plateforme');
                        }])
                        ->get();
        
        $favoris = $user->favoris()
                       ->with(['serie' => function($query) {
                           $query->with('plateforme');
                       }])
                       ->get();
        
        $visionnages = $user->visionnages()
                           ->with(['episode' => function($query) {
                               $query->with(['saison' => function($query) {
                                   $query->with('serie');
                               }]);
                           }])
                           ->orderBy('date_visionnage', 'desc')
                           ->get();
        
        $commentaires = $user->commentaires()
                            ->with(['episode' => function($query) {
                                $query->with(['saison' => function($query) {
                                    $query->with('serie');
                                }]);
                            }])
                            ->orderBy('date_commentaire', 'desc')
                            ->get();

        return view('web.profilPerso', compact('archives', 'favoris', 'visionnages', 'commentaires'));
    }
}
