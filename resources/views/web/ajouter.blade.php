@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-slate-100 py-16 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-16">
          
            <h1 class="text-5xl font-bold text-gray-900 mb-6">
                Ajouter du contenu
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Enrichissez votre catalogue de séries TV en ajoutant de nouveaux éléments à votre collection
            </p>
        </div>

        <!-- Action Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Série Card -->
            <a href="{{ route('seriesAjout.index') }}" class="group">
                <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-200 hover:border-orange-300 h-full flex flex-col">
                    <div class="flex-1">
                        <div class="w-20 h-20 bg-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-600 transition-colors duration-300 shadow-md">
                            <span class="text-4xl">🎬</span>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors">
                            Ajouter une série
                        </h3>
                        <p class="text-gray-600 text-base leading-relaxed mb-8">
                            Créez une nouvelle fiche série avec tous les détails : synopsis, casting, saisons et épisodes
                        </p>
                    </div>
                    
                    <div class="flex items justify-end">
                    
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-orange-100 group-hover:translate-x-2 transition-all duration-300">
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Plateforme Card -->
            <a href="{{ route('plateformesAjout.index') }}" class="group">
                <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-200 hover:border-orange-300 h-full flex flex-col">
                    <div class="flex-1">
                        <div class="w-20 h-20 bg-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-700 transition-colors duration-300 shadow-md">
                            <span class="text-4xl">📺</span>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors">
                            Ajouter une plateforme
                        </h3>
                        <p class="text-gray-600 text-base leading-relaxed mb-8">
                            Référencez une nouvelle plateforme de streaming avec ses informations et caractéristiques
                        </p>
                    </div>
                    
                    <div class="flex items justify-end">
                    
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-orange-100 group-hover:translate-x-2 transition-all duration-300">
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Acteur Card -->
            <a href="{{ route('acteursAjout.index') }}" class="group">
                <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-200 hover:border-orange-300 h-full flex flex-col">
                    <div class="flex-1">
                        <div class="w-20 h-20 bg-orange-700 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-600 transition-colors duration-300 shadow-md">
                            <span class="text-4xl">🧑‍🎤</span>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors">
                            Ajouter un acteur
                        </h3>
                        <p class="text-gray-600 text-base leading-relaxed mb-8">
                            Créez un profil d'acteur complet avec sa biographie et sa filmographie détaillée
                        </p>
                    </div>
                    
                    <div class="flex items justify-end">
                    
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-orange-100 group-hover:translate-x-2 transition-all duration-300">
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>

      
    </div>
</div>
@endsection