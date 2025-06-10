@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section avec l'image de la série -->
    <div class="relative h-[70vh] w-full overflow-hidden">
        @if($serie->image_url)
            @php
                $imageUrl = $serie->image_url;
                if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                    $imageUrl = asset($imageUrl);
                }
            @endphp
            <img src="{{ $imageUrl }}" alt="{{ $serie->titre }}" 
                 class="w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end space-y-6 lg:space-y-0">
                    <div class="flex-1">
                        <h1 class="text-5xl lg:text-6xl font-bold mb-4 drop-shadow-lg">{{ $serie->titre }}</h1>
                        <div class="flex flex-wrap items-center space-x-6 text-lg">
                            @if($serie->annee_sortie)
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                                    <span>{{ $serie->annee_sortie }}</span>
                                </div>
                            @endif
                            @if($serie->plateforme)
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                                    <a href="{{ $serie->plateforme->url }}" target="_blank" 
                                       class="hover:text-orange-400 transition-colors duration-300 underline decoration-transparent hover:decoration-orange-400">
                                        {{ $serie->plateforme->nom }}
                                    </a>
                                </div>
                            @endif
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                                <span>{{ $serie->saisons->count() }} saison{{ $serie->saisons->count() > 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <form action="{{ route('favoris.toggle', $serie->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="group bg-white/10 backdrop-blur-sm hover:bg-orange-500/20 text-white px-6 py-3 rounded-xl flex items-center space-x-3 transition-all duration-300 border border-white/20 hover:border-orange-500/50">
                                @if($serie->favoris->contains('user_id', auth()->id()))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400 group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-medium">Favoris</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="font-medium">Favoris</span>
                                @endif
                            </button>
                        </form>

                        <form action="{{ route('archives.toggle', $serie->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="group bg-white/10 backdrop-blur-sm hover:bg-green-500/20 text-white px-6 py-3 rounded-xl flex items-center space-x-3 transition-all duration-300 border border-white/20 hover:border-green-500/50">
                                @if($serie->archives->contains('user_id', auth()->id()))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400 group-hover:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-medium">Vue</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span class="font-medium">Marquer vue</span>
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <!-- Colonne principale -->
            <div class="xl:col-span-3">
                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-8 bg-gradient-to-b from-orange-400 to-orange-600 rounded-full mr-4"></div>
                        <h2 class="text-3xl font-bold text-gray-800">Synopsis</h2>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-lg">{{ $serie->description }}</p>
                </div>

                <!-- Saisons -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                    <div class="flex items-center mb-8">
                        <div class="w-1 h-8 bg-gradient-to-b from-orange-400 to-orange-600 rounded-full mr-4"></div>
                        <h2 class="text-3xl font-bold text-gray-800">Saisons et Épisodes</h2>
                    </div>
                    
                    <div class="space-y-8">
                        @foreach($serie->saisons as $saison)
                            <div class="border border-gray-200 rounded-xl overflow-hidden">
                                <!-- En-tête de saison -->
                                <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            @if($saison->image_url)
                                                @php
                                                    $isExternal = Str::startsWith($saison->image_url, ['http://', 'https://']);
                                                @endphp
                                                <img src="{{ $isExternal ? $saison->image_url : asset('storage/' . $saison->image_url) }}" 
                                                     alt="Saison {{ $saison->numero }}"
                                                     class="w-16 h-16 object-cover rounded-xl shadow-md">
                                            @endif
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-800">Saison {{ $saison->numero }}</h3>
                                                @if($saison->annee_sortie)
                                                    <p class="text-orange-600 font-medium">{{ $saison->annee_sortie }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-200 text-orange-800">
                                                {{ $saison->episodes->count() }} épisodes
                                            </span>
                                        </div>
                                    </div>
                                    @if($saison->description)
                                        <p class="text-gray-700 mt-4 leading-relaxed">{{ $saison->description }}</p>
                                    @endif
                                </div>
                                
                                <!-- Liste des épisodes -->
                                <div class="divide-y divide-gray-100">
                                    @foreach($saison->episodes->take(10) as $episode)
                                        <a href="{{ route('episodes.show', ['serie' => $serie->id, 'episode' => $episode->id]) }}" 
                                           class="block hover:bg-gray-50 transition-all duration-200 group">
                                            <div class="p-6">
                                                <div class="flex items-start space-x-4">
                                                    @if($episode->image_url)
                                                        @php
                                                            $isExternal = Str::startsWith($episode->image_url, ['http://', 'https://']);
                                                        @endphp
                                                        <div class="relative overflow-hidden rounded-lg shadow-md group-hover:shadow-lg transition-shadow">
                                                            <img 
                                                                src="{{ $isExternal ? $episode->image_url : asset('storage/' . $episode->image_url) }}" 
                                                                alt="Épisode {{ $episode->numero_episode }}"
                                                                class="w-32 h-20 object-cover group-hover:scale-105 transition-transform duration-300">
                                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                                                        </div>
                                                    @endif
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex justify-between items-start">
                                                            <div class="flex-1 pr-4">
                                                                <div class="flex items-center space-x-2 mb-2">
                                                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-orange-100 text-orange-800">
                                                                        Ép. {{ $episode->numero_episode }}
                                                                    </span>
                                                                </div>
                                                                <h4 class="font-semibold text-lg text-gray-800 group-hover:text-orange-600 transition-colors">
                                                                    {{ $episode->titre }}
                                                                </h4>
                                                                @if($episode->resume)
                                                                    <p class="text-gray-600 mt-2 text-sm leading-relaxed">
                                                                        {{ Str::limit($episode->resume, 120) }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            <div class="flex items-center space-x-2 flex-shrink-0">
                                                                <form action="{{ route('visionnages.toggle', $episode->id) }}" method="POST" onclick="event.stopPropagation()">
                                                                    @csrf
                                                                    <button type="submit" 
                                                                            class="p-3 rounded-full hover:bg-gray-200 transition-colors duration-200 group/btn"
                                                                            title="{{ $episode->visionnages->contains('user_id', auth()->id()) ? 'Marquer comme non vu' : 'Marquer comme vu' }}">
                                                                        @if($episode->visionnages->contains('user_id', auth()->id()))
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 group-hover/btn:scale-110 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                            </svg>
                                                                        @else
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 group-hover/btn:text-gray-600 group-hover/btn:scale-110 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
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
                                    
                                    @if($saison->episodes->count() > 10)
                                        <div class="p-6 text-center bg-gray-50">
                                            <button class="text-orange-600 hover:text-orange-700 font-medium transition-colors" onclick="toggleAllEpisodes({{ $saison->id }})">
                                                Voir tous les épisodes ({{ $saison->episodes->count() - 10 }} de plus)
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="xl:col-span-1">
                <!-- Casting -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-6 bg-gradient-to-b from-orange-400 to-orange-600 rounded-full mr-3"></div>
                        <h2 class="text-xl font-bold text-gray-800">Casting</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($serie->castings->take(8) as $casting)
                            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                @if($casting->acteur->image_url)
                                    @php
                                        $isExternal = Str::startsWith($casting->acteur->image_url, ['http://', 'https://']);
                                    @endphp
                                    <div class="relative">
                                        <img 
                                            src="{{ $isExternal ? $casting->acteur->image_url : asset('storage/' . $casting->acteur->image_url) }}" 
                                            alt="{{ $casting->acteur->prenom }} {{ $casting->acteur->nom }}"
                                            class="w-12 h-12 rounded-full object-cover ring-2 ring-orange-100">
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-200 to-orange-300 flex items-center justify-center">
                                        <span class="text-orange-800 font-semibold text-sm">
                                            {{ substr($casting->acteur->prenom, 0, 1) }}{{ substr($casting->acteur->nom, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-800 truncate">
                                        {{ $casting->acteur->prenom }} {{ $casting->acteur->nom }}
                                    </p>
                                    <p class="text-sm text-gray-600 truncate">{{ $casting->role }}</p>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($serie->castings->count() > 8)
                            <div class="text-center pt-2">
                                <button class="text-orange-600 hover:text-orange-700 text-sm font-medium transition-colors" onclick="toggleAllCasting()">
                                    Voir tout le casting ({{ $serie->castings->count() - 8 }} de plus)
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informations supplémentaires -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="w-1 h-6 bg-gradient-to-b from-orange-400 to-orange-600 rounded-full mr-3"></div>
                        <h2 class="text-xl font-bold text-gray-800">Informations</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @if($serie->plateforme)
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">Plateforme</span>
                                <a href="{{ $serie->plateforme->url }}" target="_blank" 
                                   class="text-orange-600 hover:text-orange-700 font-medium transition-colors">
                                    {{ $serie->plateforme->nom }}
                                </a>
                            </div>
                        @endif
                        
                        @if($serie->annee_sortie)
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 font-medium">Année</span>
                                <span class="text-gray-800 font-medium">{{ $serie->annee_sortie }}</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600 font-medium">Saisons</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                {{ $serie->saisons->count() }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600 font-medium">Épisodes</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                {{ $serie->saisons->sum(function($saison) { return $saison->episodes->count(); }) }}
                            </span>
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

function toggleAllEpisodes(saisonId) {
    // Logique pour afficher tous les épisodes d'une saison
    console.log('Toggle episodes for season:', saisonId);
}

function toggleAllCasting() {
    // Logique pour afficher tout le casting
    console.log('Toggle all casting');
}
</script>
@endpush
@endsection