@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-orange-50">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-400 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                            <a href="{{ route('series.index') }}" class="hover:text-orange-600 transition-colors">Séries</a>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="text-orange-600 font-medium">{{ $serie->titre }}</span>
                        </nav>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Saisons de <span class="text-orange-600">{{ $serie->titre }}</span>
                        </h1>
                        <p class="text-gray-600 mt-1">
                            {{ $saisons->count() }} saison{{ $saisons->count() > 1 ? 's' : '' }} disponible{{ $saisons->count() > 1 ? 's' : '' }}
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="bg-orange-50 px-4 py-2 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600">{{ $saisons->count() }}</div>
                        <div class="text-xs text-gray-600 uppercase tracking-wide">Saisons</div>
                    </div>
                    <a href="{{ route('saisons.create', $serie->id) }}"
                       class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Ajouter une saison</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        @if ($saisons->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucune saison disponible</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Commencez par ajouter la première saison de <strong>{{ $serie->titre }}</strong> pour organiser vos épisodes.
                </p>
                <a href="{{ route('saisons.create', $serie->id) }}"
                   class="inline-flex items-center space-x-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span>Créer la première saison</span>
                </a>
            </div>
        @else
            <!-- Filter & View Options -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-700">Affichage :</span>
                            <button id="gridView" class="view-toggle active p-2 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </button>
                            <button id="listView" class="view-toggle p-2 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-600">Trier par :</span>
                        <select id="sortSelect" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="numero">Numéro de saison</option>
                            <option value="annee">Année de sortie</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Grid View -->
            <div id="gridContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($saisons as $saison)
                    <div class="season-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group"
                         data-numero="{{ $saison->numero }}" data-annee="{{ $saison->annee_sortie }}">
                        <!-- Image Header -->
                        <div class="relative h-48 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                            @if($saison->image_url)
                                @php
                                    $isExternal = Str::startsWith($saison->image_url, ['http://', 'https://']);
                                @endphp
                                <img src="{{ $isExternal ? $saison->image_url : asset('storage/' . $saison->image_url) }}" 
                                     alt="Saison {{ $saison->numero }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        <p class="text-gray-500 text-sm">Aucune image</p>
                                    </div>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-orange-600 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                                    Saison {{ $saison->numero }}
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="bg-black bg-opacity-60 text-white px-2 py-1 rounded text-xs">
                                    {{ $saison->annee_sortie }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">
                                    Saison {{ $saison->numero }}
                                </h3>
                                <p class="text-gray-600 text-sm line-clamp-3">
                                    {{ $saison->description ?: 'Aucune description disponible pour cette saison.' }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('episodes.index', [$serie->id, $saison->id]) }}"
                                   class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-center py-2 px-3 rounded-lg text-sm font-medium transition-all duration-200 flex items-center justify-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 013-3h6a3 3 0 013 3v2M7 21h10a2 2 0 002-2v-2a2 2 0 00-2-2H7a2 2 0 00-2 2v2a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Épisodes</span>
                                </a>
                                <a href="{{ route('saisons.edit', $saison->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button onclick="deleteSeason({{ $saison->id }}, {{ $saison->numero }})"
                                        class="bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- List View -->
            <div id="listContainer" class="hidden space-y-4">
                @foreach ($saisons as $saison)
                    <div class="season-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden"
                         data-numero="{{ $saison->numero }}" data-annee="{{ $saison->annee_sortie }}">
                        <div class="flex items-center p-6 space-x-6">
                            <!-- Image -->
                            <div class="flex-shrink-0">
                                @if($saison->image_url)
                                    @php
                                        $isExternal = Str::startsWith($saison->image_url, ['http://', 'https://']);
                                    @endphp
                                    <img src="{{ $isExternal ? $saison->image_url : asset('storage/' . $saison->image_url) }}" 
                                         alt="Saison {{ $saison->numero }}"
                                         class="w-24 h-32 object-cover rounded-lg shadow-sm">
                                @else
                                    <div class="w-24 h-32 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">Saison {{ $saison->numero }}</h3>
                                    <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                                        {{ $saison->annee_sortie }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ $saison->description ?: 'Aucune description disponible pour cette saison.' }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex-shrink-0 flex items-center space-x-3">
                                <a href="{{ route('episodes.index', [$serie->id, $saison->id]) }}"
                                   class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-all duration-200 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 013-3h6a3 3 0 013 3v2M7 21h10a2 2 0 002-2v-2a2 2 0 00-2-2H7a2 2 0 00-2 2v2a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Épisodes</span>
                                </a>
                                <a href="{{ route('saisons.edit', $saison->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button onclick="deleteSeason({{ $saison->id }}, {{ $saison->numero }})"
                                        class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Delete Forms (Hidden) -->
@foreach ($saisons as $saison)
    <form id="delete-form-{{ $saison->id }}" action="{{ route('saisons.update', $saison->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach

<style>
.view-toggle {
    color: #6b7280;
    background-color: #f9fafb;
}

.view-toggle:hover {
    color: #ea580c;
    background-color: #fed7aa;
}

.view-toggle.active {
    color: #ea580c;
    background-color: #fed7aa;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.season-card {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const gridViewBtn = document.getElementById('gridView');
    const listViewBtn = document.getElementById('listView');
    const gridContainer = document.getElementById('gridContainer');
    const listContainer = document.getElementById('listContainer');
    const sortSelect = document.getElementById('sortSelect');

    // View Toggle
    gridViewBtn.addEventListener('click', function() {
        gridViewBtn.classList.add('active');
        listViewBtn.classList.remove('active');
        gridContainer.classList.remove('hidden');
        listContainer.classList.add('hidden');
    });

    listViewBtn.addEventListener('click', function() {
        listViewBtn.classList.add('active');
        gridViewBtn.classList.remove('active');
        listContainer.classList.remove('hidden');
        gridContainer.classList.add('hidden');
    });

    // Sort Functionality
    sortSelect.addEventListener('change', function() {
        const sortBy = this.value;
        const gridCards = Array.from(gridContainer.querySelectorAll('.season-card'));
        const listCards = Array.from(listContainer.querySelectorAll('.season-card'));

        function sortCards(cards) {
            return cards.sort((a, b) => {
                if (sortBy === 'numero') {
                    return parseInt(a.dataset.numero) - parseInt(b.dataset.numero);
                } else if (sortBy === 'annee') {
                    return parseInt(a.dataset.annee) - parseInt(b.dataset.annee);
                }
            });
        }

        // Sort and re-append grid cards
        const sortedGridCards = sortCards(gridCards);
        sortedGridCards.forEach(card => gridContainer.appendChild(card));

        // Sort and re-append list cards
        const sortedListCards = sortCards(listCards);
        sortedListCards.forEach(card => listContainer.appendChild(card));
    });
});

function deleteSeason(seasonId, seasonNumber) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer la saison ${seasonNumber} ? Cette action est irréversible.`)) {
        document.getElementById(`delete-form-${seasonId}`).submit();
    }
}
</script>
@endsection