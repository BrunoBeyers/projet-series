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
        filter: blur(5px) brightness(0.3);
    }

    /* Custom scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #fb923c;
        border-radius: 10px;
    }

    /* Gradient overlay */
    .gradient-overlay {
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,237,213,0.9) 100%);
        backdrop-filter: blur(10px);
    }

    /* Card hover effects */
    .serie-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .serie-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(251, 146, 60, 0.3);
    }

    /* Actor tags animation */
    .actor-tag {
        transition: all 0.3s ease;
    }
    
    .actor-tag:hover {
        transform: scale(1.05);
        background: linear-gradient(45deg, #fb923c, #f97316);
        color: white;
    }

    /* Season info styling */
    .season-info {
        background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%);
        border-left: 4px solid #fb923c;
    }

    /* Search and filter bar */
    .filter-bar {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(251, 146, 60, 0.2);
    }

    /* Loading animation for images */
    .image-container {
        position: relative;
        overflow: hidden;
    }
    
    .image-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: shimmer 2s infinite;
        z-index: 1;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Platform badge */
    .platform-badge {
        background: linear-gradient(45deg, #1e40af, #3b82f6);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    /* Stats counter */
    .stats-card {
        background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
        color: white;
    }
</style>

<div class="background-carousel">
    @foreach($series->take(4) as $serie)
        <div class="carousel-slide">
            <img src="{{ $serie->image_url }}" alt="{{ $serie->titre }}" loading="lazy">
        </div>
    @endforeach
</div>

<div class="relative z-10 min-h-screen">
    <!-- Header Section -->
    <div class="gradient-overlay py-12 mb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-8">
                <h1 class="text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-700 mb-4">
                    Découvre nos Séries
                </h1>
                <p class="text-xl text-gray-700 max-w-2xl mx-auto">
                    Plongez dans un univers de divertissement avec notre collection exclusive de séries
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stats-card rounded-2xl p-6 text-center shadow-lg">
                    <div class="text-3xl font-bold">{{ $series->count() }}</div>
                    <div class="text-sm opacity-90">Séries</div>
                </div>
                <div class="stats-card rounded-2xl p-6 text-center shadow-lg">
                    <div class="text-3xl font-bold">{{ $series->sum(function($s) { return $s->saisons->count(); }) }}</div>
                    <div class="text-sm opacity-90">Saisons</div>
                </div>
                <div class="stats-card rounded-2xl p-6 text-center shadow-lg">
                    <div class="text-3xl font-bold">{{ $series->sum(function($s) { return $s->saisons->sum(function($saison) { return $saison->episodes->count(); }); }) }}</div>
                    <div class="text-sm opacity-90">Épisodes</div>
                </div>
                <div class="stats-card rounded-2xl p-6 text-center shadow-lg">
                    <div class="text-3xl font-bold">{{ $series->flatMap(function($s) { return $s->castings; })->unique('acteur_id')->count() }}</div>
                    <div class="text-sm opacity-90">Acteurs</div>
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="filter-bar rounded-2xl p-6 shadow-lg">
                <div class="flex flex-col md:flex-row gap-4 items-center">
                    <div class="flex-1">
                        <input type="text" 
                               placeholder="Rechercher une série..." 
                               class="w-full px-4 py-3 rounded-xl border-2 border-orange-200 focus:border-orange-400 focus:outline-none transition-colors"
                               id="searchInput">
                    </div>
                    <div class="flex gap-3">
                        <select class="px-4 py-3 rounded-xl border-2 border-orange-200 focus:border-orange-400 focus:outline-none bg-white" id="platformFilter">
                            <option value="">Toutes les plateformes</option>
                            @foreach($series->pluck('plateforme')->unique()->filter() as $plateforme)
                                <option value="{{ $plateforme->nom }}">{{ $plateforme->nom }}</option>
                            @endforeach
                        </select>
                        <select class="px-4 py-3 rounded-xl border-2 border-orange-200 focus:border-orange-400 focus:outline-none bg-white" id="yearFilter">
                            <option value="">Toutes les années</option>
                            @foreach($series->pluck('annee_sortie')->sort()->reverse()->unique() as $annee)
                                <option value="{{ $annee }}">{{ $annee }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Series Grid -->
    <div class="max-w-7xl mx-auto px-6 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8" id="seriesGrid">
            @foreach($series as $serie)
                <a href="{{ route('series.show', $serie->id) }}" 
                   class="block group serie-card"
                   data-title="{{ strtolower($serie->titre) }}"
                   data-platform="{{ $serie->plateforme ? strtolower($serie->plateforme->nom) : '' }}"
                   data-year="{{ $serie->annee_sortie }}">
                   
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden h-full">
                        <!-- Image Container -->
                        <div class="image-container relative h-64">
                            @if($serie->image_url)
                                @php
                                    $imageUrl = $serie->image_url;
                                    if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                                        $imageUrl = asset($imageUrl);
                                    }
                                @endphp
                                <img src="{{ $imageUrl }}" 
                                     alt="{{ $serie->titre }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-orange-200 to-orange-300 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Platform Badge -->
                            @if($serie->plateforme)
                                <div class="absolute top-4 right-4 platform-badge px-3 py-1 rounded-full text-white text-sm font-semibold shadow-lg">
                                    {{ $serie->plateforme->nom }}
                                </div>
                            @endif
                            
                            <!-- Year Badge -->
                            <div class="absolute bottom-4 left-4 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $serie->annee_sortie }}
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-3 text-gray-800 group-hover:text-orange-600 transition-colors line-clamp-2">
                                {{ $serie->titre }}
                            </h2>
                            
                            <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                                {{ Str::limit($serie->description, 120) }}
                            </p>

                            <!-- Seasons Info -->
                            @if($serie->saisons->count() > 0)
                                <div class="mb-4">
                                    <h3 class="text-sm font-semibold text-orange-700 mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                        </svg>
                                        Saisons
                                    </h3>
                                    <div class="space-y-2 max-h-32 overflow-y-auto custom-scroll">
                                        @foreach($serie->saisons->take(3) as $saison)
                                            <div class="season-info p-3 rounded-lg">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-medium">Saison {{ $saison->numero }}</span>
                                                    <span class="text-sm text-orange-600 font-semibold">
                                                        {{ $saison->episodes->count() }} ép.
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($serie->saisons->count() > 3)
                                            <div class="text-center text-sm text-gray-500 pt-2">
                                                +{{ $serie->saisons->count() - 3 }} autres saisons
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Actors -->
                            @if($serie->castings->count() > 0)
                                <div>
                                    <h3 class="text-sm font-semibold text-orange-700 mb-2 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                        </svg>
                                        Casting principal
                                    </h3>
                                    <div class="flex flex-wrap gap-2 max-h-24 overflow-hidden">
                                        @foreach($serie->castings->take(4) as $casting)
                                            <span class="actor-tag bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-medium">
                                                {{ $casting->acteur->prenom }} {{ $casting->acteur->nom }}
                                            </span>
                                        @endforeach
                                        @if($serie->castings->count() > 4)
                                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-medium">
                                                +{{ $serie->castings->count() - 4 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- No results message -->
        <div id="noResults" class="hidden text-center py-12">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Aucun résultat trouvé</h3>
            <p class="text-gray-600">Essayez de modifier vos critères de recherche</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const platformFilter = document.getElementById('platformFilter');
    const yearFilter = document.getElementById('yearFilter');
    const seriesGrid = document.getElementById('seriesGrid');
    const noResults = document.getElementById('noResults');
    const serieCards = document.querySelectorAll('.serie-card');

    function filterSeries() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedPlatform = platformFilter.value.toLowerCase();
        const selectedYear = yearFilter.value;
        
        let visibleCount = 0;

        serieCards.forEach(card => {
            const title = card.dataset.title;
            const platform = card.dataset.platform;
            const year = card.dataset.year;

            const matchesSearch = title.includes(searchTerm);
            const matchesPlatform = !selectedPlatform || platform === selectedPlatform;
            const matchesYear = !selectedYear || year === selectedYear;

            if (matchesSearch && matchesPlatform && matchesYear) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
            seriesGrid.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            seriesGrid.classList.remove('hidden');
        }
    }

    searchInput.addEventListener('input', filterSeries);
    platformFilter.addEventListener('change', filterSeries);
    yearFilter.addEventListener('change', filterSeries);
});
</script>

@endsection