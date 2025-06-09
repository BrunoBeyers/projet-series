@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-8 text-orange-600">Mes Séries Favorites</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    @if($favoris->isEmpty())
        <div class="text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <p class="text-xl text-gray-600">Vous n'avez pas encore de séries favorites</p>
            <a href="{{ route('series.index') }}" class="mt-4 inline-block bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">
                Découvrir des séries
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favoris as $favori)
                <a href="{{ route('series.show', $favori->serie->id) }}" class="block">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                        @if($favori->serie->image_url)
                            <img src="{{ $favori->serie->image_url }}" alt="{{ $favori->serie->titre }}" class="w-full h-48 object-cover">
                        @endif
                        
                        <div class="p-4">
                            <h2 class="text-xl font-bold mb-2">{{ $favori->serie->titre }}</h2>
                            
                            @if($favori->serie->plateforme)
                                <p class="text-gray-600 mb-2">
                                    <span class="font-semibold">Plateforme:</span> 
                                    <span class="text-blue-600">
                                        {{ $favori->serie->plateforme->nom }}
                                    </span>
                                </p>
                            @endif

                            <p class="text-gray-600 mb-2">
                                <span class="font-semibold">Année de sortie:</span> {{ $favori->serie->annee_sortie }}
                            </p>

                            <p class="text-gray-600">{{ Str::limit($favori->serie->description, 150) }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection