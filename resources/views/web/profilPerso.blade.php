@extends('layouts.app') 

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-orange-50">
    <!-- Header Profile -->
    <div class="bg-white shadow-sm border-b-2 border-orange-100">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                        <p class="text-gray-600 mt-1">Membre depuis {{ Auth::user()->created_at->format('F Y') }}</p>
                    </div>
                </div>
                <div class="flex space-x-6 text-center">
                    <div class="bg-orange-50 px-4 py-3 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600">{{ $favoris->count() }}</div>
                        <div class="text-sm text-gray-600">Favoris</div>
                    </div>
                    <div class="bg-orange-50 px-4 py-3 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600">{{ $archives->count() }}</div>
                        <div class="text-sm text-gray-600">Archivées</div>
                    </div>
                    <div class="bg-orange-50 px-4 py-3 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600">{{ $visionnages->count() }}</div>
                        <div class="text-sm text-gray-600">Épisodes vus</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="bg-white rounded-lg shadow-sm p-2">
            <nav class="flex space-x-1" role="tablist">
                <button class="tab-button active px-6 py-3 text-sm font-medium rounded-md transition-all duration-200" 
                        data-tab="favoris">Séries Favorites</button>
                <button class="tab-button px-6 py-3 text-sm font-medium rounded-md transition-all duration-200" 
                        data-tab="archives">Séries Archivées</button>
                <button class="tab-button px-6 py-3 text-sm font-medium rounded-md transition-all duration-200" 
                        data-tab="visionnages">Épisodes Vus</button>
                <button class="tab-button px-6 py-3 text-sm font-medium rounded-md transition-all duration-200" 
                        data-tab="commentaires">Mes Commentaires</button>
            </nav>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="max-w-7xl mx-auto px-6 pb-12">
        
        <!-- Séries Favorites -->
        <div id="favoris-content" class="tab-content">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        Séries Favorites
                    </h2>
                </div>
                
                @if($favoris->isEmpty())
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune série favorite</h3>
                        <p class="text-gray-500">Commencez à explorer et ajoutez vos séries préférées à vos favoris.</p>
                    </div>
                @else
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($favoris as $favori)
                                <div class="group bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                    <div class="relative">
                                        @if($favori->serie->image_url)
                                            <img src="{{ $favori->serie->image_url }}" 
                                                 alt="{{ $favori->serie->titre }}" 
                                                 class="w-full h-48 object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                                        @else
                                            <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <a href="{{ route('series.show', $favori->serie->id) }}" 
                                           class="block text-lg font-semibold text-gray-900 hover:text-orange-600 transition-colors duration-200 mb-2">
                                            {{ $favori->serie->titre }}
                                        </a>
                                        <div class="flex items-center justify-between text-sm text-gray-500">
                                            <span>Ajouté le {{ \Carbon\Carbon::parse($favori->created_at)->format('d/m/Y') }}</span>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-orange-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                                </svg>
                                                <span>Favori</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Séries Archivées -->
        <div id="archives-content" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-gray-500 to-gray-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                            <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Séries Archivées
                    </h2>
                </div>
                
                @if($archives->isEmpty())
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune série archivée</h3>
                        <p class="text-gray-500">Les séries que vous archivez apparaîtront ici.</p>
                    </div>
                @else
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($archives as $archive)
                                <div class="flex items-center space-x-6 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    @if($archive->serie->image_url)
                                        <img src="{{ $archive->serie->image_url }}" 
                                             alt="{{ $archive->serie->titre }}" 
                                             class="w-20 h-28 object-cover rounded-lg shadow-sm">
                                    @else
                                        <div class="w-20 h-28 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <a href="{{ route('series.show', $archive->serie->id) }}" 
                                           class="text-xl font-semibold text-gray-900 hover:text-orange-600 transition-colors duration-200 block mb-1">
                                            {{ $archive->serie->titre }}
                                        </a>
                                        <p class="text-sm text-gray-500 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Archivé le {{ \Carbon\Carbon::parse($archive->created_at)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-700">
                                            Archivé
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Épisodes Vus -->
        <div id="visionnages-content" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Épisodes Vus
                    </h2>
                </div>
                
                @if($visionnages->isEmpty())
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun épisode vu</h3>
                        <p class="text-gray-500">Commencez à regarder des épisodes et marquez-les comme vus.</p>
                    </div>
                @else
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($visionnages as $visionnage)
                                <div class="flex items-center space-x-6 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    @if($visionnage->episode->image_url)
                                        <img src="{{ asset('storage/' . $visionnage->episode->image_url) }}" 
                                             alt="Épisode {{ $visionnage->episode->numero_episode }}: {{ $visionnage->episode->titre }}"
                                             class="w-20 h-28 object-cover rounded-lg shadow-sm">
                                    @else
                                        <div class="w-20 h-28 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 013-3h6a3 3 0 013 3v2M7 21h10a2 2 0 002-2v-2a2 2 0 00-2-2H7a2 2 0 00-2 2v2a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                            {{ $visionnage->episode->titre ?? 'Épisode ' . $visionnage->episode->numero_episode }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-2">
                                            Saison {{ $visionnage->episode->numero_saison ?? 'N/A' }} - 
                                            Épisode {{ $visionnage->episode->numero_episode }}
                                        </p>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Vu le {{ \Carbon\Carbon::parse($visionnage->created_at)->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Vu
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Commentaires -->
        <div id="commentaires-content" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"/>
                        </svg>
                        Mes Commentaires
                    </h2>
                </div>
                
                @if($commentaires->isEmpty())
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun commentaire</h3>
                        <p class="text-gray-500">Vos commentaires sur les épisodes apparaîtront ici.</p>
                    </div>
                @else
                    <div class="p-6">
                        <div class="space-y-6">
                            @foreach($commentaires as $commentaire)
                                <div class="bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($commentaire->date_commentaire)->format('d/m/Y à H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                            Commentaire
                                        </span>
                                    </div>
                                    <div class="ml-13">
                                        <p class="text-gray-700 leading-relaxed">{{ $commentaire->contenu }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.tab-button {
    color: #6b7280;
    background-color: transparent;
}

.tab-button:hover {
    color: #ea580c;
    background-color: #fed7aa;
}

.tab-button.active {
    color: #ea580c;
    background-color: #fed7aa;
    font-weight: 600;
}

.tab-content {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all buttons
            tabButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Hide all tab contents
            tabContents.forEach(content => content.classList.add('hidden'));
            
            // Show target tab content
            document.getElementById(targetTab + '-content').classList.remove('hidden');
        });
    });
});
</script>
@endsection