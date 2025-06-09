@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="min-h-screen">
    <!-- Hero Section avec l'image de la série -->
    <div class="relative h-[60vh] w-full">
        @if($serie->image_url)
            <img src="{{ $serie->image_url }}" alt="{{ $serie->titre }}" 
                 class="w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold mb-2">{{ $serie->titre }}</h1>
                    <div class="flex items-center space-x-4">
                        @if($serie->annee_sortie)
                            <span class="text-lg">{{ $serie->annee_sortie }}</span>
                        @endif
                        @if($serie->plateforme)
                            <a href="{{ $serie->plateforme->url }}" target="_blank" 
                               class="text-lg hover:text-orange-400 transition">
                                {{ $serie->plateforme->nom }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <form action="{{ route('favoris.toggle', $serie->id) }}" method="POST" class="flex items-center">
                        @csrf
                        <button type="submit" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition">
                            @if($serie->favoris->contains('user_id', auth()->id()))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                                <span>Retirer des favoris</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                                <span>Ajouter aux favoris</span>
                            @endif
                        </button>
                    </form>

                    <form action="{{ route('archives.toggle', $serie->id) }}" method="POST" class="flex items-center">
                        @csrf
                        <button type="submit" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition">
                            @if($serie->archives->contains('user_id', auth()->id()))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Marquer comme non vue</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                                <span>Marquer comme vue</span>
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne principale -->
            <div class="lg:col-span-2">
                <!-- Description -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-4 text-orange-600">Description</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $serie->description }}</p>
                </div>

                <!-- Saisons -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-4 text-orange-600">Saisons</h2>
                    <div class="space-y-4">
                        @foreach($serie->saisons as $saison)
                            <div class="border rounded-lg p-4">
                                <div class="flex items-start space-x-4">
                                    
                                    @if($saison->image_url)
                                        <img src="{{ asset('storage/' . $saison->image_url) }}" 
                                             alt="Saison {{ $saison->numero }}"
                                             class="w-48 h-32 object-cover rounded">
                                    @endif
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center mb-2">
                                            <h3 class="text-xl font-semibold">Saison {{ $saison->numero }}</h3>
                                            @if($saison->annee_sortie)
                                                <span class="text-gray-600">{{ $saison->annee_sortie }}</span>
                                            @endif
                                        </div>
                                        @if($saison->description)
                                            <p class="text-gray-700 mb-4">{{ $saison->description }}</p>
                                        @endif
                                        
                                        <!-- Épisodes -->
                                        <div class="space-y-2">
                                        

@foreach($saison->episodes as $episode)
    <a href="{{ route('episodes.show', ['serie' => $serie->id, 'episode' => $episode->id]) }}" 
       class="block hover:bg-gray-50 transition-colors">
        <div class="bg-gray-50 rounded p-3 hover:bg-gray-100 transition-colors">
            <div class="flex items-start space-x-4">
                @if($episode->image_url)
                    @php
                        $isExternal = Str::startsWith($episode->image_url, ['http://', 'https://']);
                    @endphp
                    <img 
                        src="{{ $isExternal ? $episode->image_url : asset('storage/' . $episode->image_url) }}" 
                        alt="Épisode {{ $episode->numero_episode }}: {{ $episode->titre }}"
                        class="w-32 h-20 object-cover rounded">
                @endif
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium">Épisode {{ $episode->numero_episode }}: {{ $episode->titre }}</h4>
                            @if($episode->resume)
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($episode->resume, 150) }}</p>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2">
                            <form action="{{ route('visionnages.toggle', $episode->id) }}" method="POST" class="flex items-center" onclick="event.stopPropagation()">
                                @csrf
                                <button type="submit" 
                                        class="p-2 rounded-full hover:bg-gray-200 transition-colors"
                                        title="{{ $episode->visionnages->contains('user_id', auth()->id()) ? 'Marquer comme non vu' : 'Marquer comme vu' }}">
                                    @if($episode->visionnages->contains('user_id', auth()->id()))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
@endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Casting -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-4 text-orange-600">Casting</h2>
                    

<div class="space-y-4">
    @foreach($serie->castings as $casting)
        <div class="flex items-center space-x-3">
            @if($casting->acteur->image_url)
                @php
                    $isExternal = Str::startsWith($casting->acteur->image_url, ['http://', 'https://']);
                @endphp

                <img 
                    src="{{ $isExternal ? $casting->acteur->image_url : asset('storage/' . $casting->acteur->image_url) }}" 
                    alt="{{ $casting->acteur->prenom }} {{ $casting->acteur->nom }}"
                    class="w-12 h-12 rounded-full object-cover">
            @endif
            <div>
                <p class="font-medium">{{ $casting->acteur->prenom }} {{ $casting->acteur->nom }}</p>
                <p class="text-sm text-gray-600">{{ $casting->role }}</p>
            </div>
        </div>
    @endforeach
</div>

                </div>

                <!-- Informations supplémentaires -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold mb-4 text-orange-600">Informations</h2>
                    <div class="space-y-3">
                        @if($serie->plateforme)
                            <div>
                                <span class="font-semibold">Plateforme:</span>
                                <a href="{{ $serie->plateforme->url }}" target="_blank" 
                                   class="text-blue-600 hover:underline">
                                    {{ $serie->plateforme->nom }}
                                </a>
                            </div>
                        @endif
                        @if($serie->annee_sortie)
                            <div>
                                <span class="font-semibold">Année de sortie:</span>
                                <span>{{ $serie->annee_sortie }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="font-semibold">Nombre de saisons:</span>
                            <span>{{ $serie->saisons->count() }}</span>
                        </div>
                        <div>
                            <span class="font-semibold">Nombre total d'épisodes:</span>
                            <span>{{ $serie->saisons->sum(function($saison) { return $saison->episodes->count(); }) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleCommentForm(episodeId) {
    const form = document.getElementById('commentForm' + episodeId);
    form.classList.toggle('hidden');
}
</script>
@endpush
@endsection 