@extends('layouts.app')

@section('content')
<style>
    /* Background carousel */
    .background-carousel {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -10;
        overflow: hidden;
    }

    .carousel-slide {
        width: 100%;
        height: 100%;
        position: absolute;
        animation: slideShow 40s linear infinite;
    }

    @keyframes slideShow {
        0%, 100% { opacity: 0; }
        10%, 30% { opacity: 1; }
        33%, 100% { transform: scale(1.1); }
    }

    .carousel-slide:nth-child(1) { animation-delay: 0s; }
    .carousel-slide:nth-child(2) { animation-delay: 10s; }
    .carousel-slide:nth-child(3) { animation-delay: 20s; }
    .carousel-slide:nth-child(4) { animation-delay: 30s; }

    .carousel-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: blur(5px) brightness(0.5);
    }
</style>

<div class="background-carousel">
    @foreach($series->take(4) as $serie)
        <div class="carousel-slide">
            <img src="{{ $serie->image_url }}" alt="{{ $serie->titre }}">
        </div>
    @endforeach
</div>

<div class="relative z-10 max-w-7xl mx-auto p-6 text-white">
    <div class="flex justify-between items-center mb-12">
        <h1 class="text-5xl font-extrabold text-orange-400 drop-shadow-lg">Découvre nos séries</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($series as $serie)
            <a href="{{ route('series.show', $serie->id) }}" class="block group">
                <div class="bg-white bg-opacity-90 rounded-xl shadow-2xl overflow-hidden transform transition duration-300 group-hover:scale-105">
                    @if($serie->image_url)
                        <img src="{{ $serie->image_url }}" alt="{{ $serie->titre }}" class="w-full h-56 object-cover">
                    @endif
                    
                    <div class="p-5 text-gray-800">
                        <h2 class="text-2xl font-bold mb-2 group-hover:text-orange-600">{{ $serie->titre }}</h2>
                        
                        @if($serie->plateforme)
                            <p class="text-gray-600 mb-1">
                                <strong>Plateforme :</strong> 
                                <span class="text-blue-700">{{ $serie->plateforme->nom }}</span>
                            </p>
                        @endif

                        <p class="text-gray-600 mb-2">
                            <strong>Année :</strong> {{ $serie->annee_sortie }}
                        </p>

                        <p class="text-gray-700 mb-3">{{ Str::limit($serie->description, 120) }}</p>

                        <div class="mb-3">
                            <h3 class="text-lg font-semibold text-orange-700 mb-1">Saisons</h3>
                            <div class="space-y-1">
                                @foreach($serie->saisons as $saison)
                                    <div class="bg-gray-100 p-2 rounded">
                                        Saison {{ $saison->numero }} - 
                                        <span class="text-sm text-gray-600">
                                            {{ $saison->episodes->count() }} épisodes
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-orange-700 mb-1">Acteurs</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($serie->castings as $casting)
                                    <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs">
                                        {{ $casting->acteur->prenom }} {{ $casting->acteur->nom }} 
                                        <span class="text-orange-600">({{ $casting->role }})</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
