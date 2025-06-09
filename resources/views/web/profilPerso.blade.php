@extends('layouts.app') 

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8 text-orange-600">Mon profil</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Séries archivées -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-orange-600">Séries archivées</h2>
            @if($archives->isEmpty())
                <p class="text-gray-500">Vous n'avez pas encore archivé de séries.</p>
            @else
                <div class="space-y-4">
                    @foreach($archives as $archive)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            @if($archive->serie->image_url)
                                <img src="{{ $archive->serie->image_url }}" alt="{{ $archive->serie->titre }}" 
                                     class="w-24 h-32 object-cover rounded">
                            @endif
                            <div>
                                <a href="{{ route('series.show', $archive->serie->id) }}" 
                                   class="text-lg font-semibold hover:text-orange-500">
                                    {{ $archive->serie->titre }}
                                </a>
                                <p class="text-sm text-gray-600">
                                    Archivé le {{ \Carbon\Carbon::parse($archive->created_at)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Séries favorites -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-orange-600">Séries favorites</h2>
            @if($favoris->isEmpty())
                <p class="text-gray-500">Vous n'avez pas encore de séries favorites.</p>
            @else
                <div class="space-y-4">
                    @foreach($favoris as $favori)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            @if($favori->serie->image_url)
                                <img src="{{ $favori->serie->image_url }}" alt="{{ $favori->serie->titre }}" 
                                     class="w-24 h-32 object-cover rounded">
                            @endif
                            <div>
                                <a href="{{ route('series.show', $favori->serie->id) }}" 
                                   class="text-lg font-semibold hover:text-orange-500">
                                    {{ $favori->serie->titre }}
                                </a>
                                <p class="text-sm text-gray-600">
                                    Ajouté le {{ \Carbon\Carbon::parse($favori->created_at)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Épisodes vus -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-orange-600">Épisodes vus</h2>
            @if($visionnages->isEmpty())
                <p class="text-gray-500">Vous n'avez pas encore marqué d'épisodes comme vus.</p>
            @else
                <div class="space-y-4">
                    @foreach($visionnages as $visionnage)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            @if($visionnage->episode->image_url)
                                <img src="{{ asset('storage/' . $visionnage->episode->image_url) }}" 
                                     alt="Épisode {{ $visionnage->episode->numero_episode }}: {{ $visionnage->episode->titre }}"
                                     class="w-24 h-32 object-cover rounded">
                            @endif
                            <div>
                         
                           
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Commentaires -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4 text-orange-600">Mes commentaires</h2>
            @if($commentaires->isEmpty())
                <p class="text-gray-500">Vous n'avez pas encore commenté d'épisodes.</p>
            @else
                <div class="space-y-4">
                    @foreach($commentaires as $commentaire)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                               
                                <span class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($commentaire->date_commentaire)->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <p class="text-gray-700">{{ $commentaire->contenu }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection