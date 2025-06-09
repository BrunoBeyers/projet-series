@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8 py-8">
                <!-- Image de l'épisode -->
                <div class="lg:w-1/3">
                    <div class="aspect-video rounded-xl overflow-hidden shadow-lg bg-gray-100">
                        @if($episode->image_url)
                            @php
                                $isExternal = Str::startsWith($episode->image_url, ['http://', 'https://']);
                            @endphp
                            <img src="{{ $isExternal ? $episode->image_url : asset('storage/' . $episode->image_url) }}" 
                                 alt="Épisode {{ $episode->numero_episode }}: {{ $episode->titre }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informations de l'épisode -->
                <div class="lg:w-2/3">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center space-x-3 mb-2">
                              
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Épisode {{ $episode->numero_episode }}
                                </span>
                            </div>
                            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
                                {{ $episode->titre }}
                            </h1>
                         
                        </div>
                        
                        <!-- Bouton de visionnage -->
                        <form action="{{ route('visionnages.toggle', $episode->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white 
                                           {{ $episode->visionnages->contains('user_id', auth()->id()) 
                                              ? 'bg-green-600 hover:bg-green-700' 
                                              : 'bg-orange-600 hover:bg-orange-700' }} 
                                           transition-colors duration-200">
                                @if($episode->visionnages->contains('user_id', auth()->id()))
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Épisode vu
                                @else
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Marquer comme vu
                                @endif
                            </button>
                        </form>
                    </div>

                    <!-- Résumé -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Résumé
                        </h2>
                        <p class="text-gray-700 leading-relaxed">{{ $episode->resume ?: 'Aucun résumé disponible pour cet épisode.' }}</p>
                    </div>

                    <!-- Informations supplémentaires -->
                    @if(isset($episode->duree) || isset($episode->date_diffusion))
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            @if(isset($episode->duree))
                                <div class="bg-white border border-gray-200 rounded-lg p-4">
                                    <dt class="text-sm font-medium text-gray-500">Durée</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $episode->duree }} min</dd>
                                </div>
                            @endif
                            @if(isset($episode->date_diffusion))
                                <div class="bg-white border border-gray-200 rounded-lg p-4">
                                    <dt class="text-sm font-medium text-gray-500">Date de diffusion</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($episode->date_diffusion)->format('d/m/Y') }}</dd>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne principale - Commentaires -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Commentaires
                            <span class="ml-2 text-sm text-gray-500">({{ $episode->commentaires->count() }})</span>
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <!-- Formulaire de commentaire -->
                        <form action="{{ route('commentaires.store', $episode->id) }}" method="POST" class="mb-8">
                            @csrf
                            <div class="mb-4">
                                <label for="contenu" class="block text-sm font-medium text-gray-700 mb-2">
                                    Votre commentaire
                                </label>
                                <textarea name="contenu" id="contenu" rows="4" 
                                          class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 resize-none"
                                          placeholder="Partagez votre avis sur cet épisode..."></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Publier
                                </button>
                            </div>
                        </form>

                        <!-- Liste des commentaires -->
                        <div class="space-y-4">
                            @forelse($episode->commentaires as $commentaire)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-medium text-orange-600">
                                                        {{ strtoupper(substr($commentaire->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $commentaire->user->name }}</p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ \Carbon\Carbon::parse($commentaire->date_commentaire)->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                            <p class="text-gray-700 ml-11">{{ $commentaire->contenu }}</p>
                                        </div>
                                        
                                        @if($commentaire->user_id === auth()->id())
                                            <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" class="ml-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-gray-400 hover:text-red-500 transition-colors duration-200"
                                                        title="Supprimer le commentaire"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun commentaire</h3>
                                    <p class="mt-1 text-sm text-gray-500">Soyez le premier à commenter cet épisode.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="space-y-6">
                    <!-- Navigation des épisodes -->
                    @if(isset($previousEpisode) || isset($nextEpisode))
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Navigation</h3>
                            <div class="space-y-3">
                                @if(isset($previousEpisode))
                                    <a href="{{ route('episodes.show', $previousEpisode->id) }}" 
                                       class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        <div class="text-left">
                                            <p class="text-xs text-gray-500">Épisode précédent</p>
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $previousEpisode->titre }}</p>
                                        </div>
                                    </a>
                                @endif
                                @if(isset($nextEpisode))
                                    <a href="{{ route('episodes.show', $nextEpisode->id) }}" 
                                       class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200">
                                        <div class="text-left flex-1">
                                            <p class="text-xs text-gray-500">Épisode suivant</p>
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $nextEpisode->titre }}</p>
                                        </div>
                                        <svg class="w-4 h-4 ml-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Statistiques -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Vues</span>
                                <span class="text-sm font-medium text-gray-900">{{ $episode->visionnages->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Commentaires</span>
                                <span class="text-sm font-medium text-gray-900">{{ $episode->commentaires->count() }}</span>
                            </div>
                            @if(isset($episode->note_moyenne))
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Note moyenne</span>
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900 mr-1">{{ number_format($episode->note_moyenne, 1) }}</span>
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Acteurs/Cast (si disponible) -->
                    @if(isset($episode->acteurs) && $episode->acteurs->count() > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Casting</h3>
                            <div class="space-y-3">
                                @foreach($episode->acteurs->take(5) as $acteur)
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            @if($acteur->photo)
                                                <img src="{{ asset('storage/' . $acteur->photo) }}" 
                                                     alt="{{ $acteur->nom }}" 
                                                     class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <span class="text-sm font-medium text-gray-600">
                                                    {{ strtoupper(substr($acteur->nom, 0, 1)) }}
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $acteur->nom }}</p>
                                            @if(isset($acteur->pivot->role))
                                                <p class="text-xs text-gray-500">{{ $acteur->pivot->role }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                @if($episode->acteurs->count() > 5)
                                    <button class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                                        Voir tous les acteurs ({{ $episode->acteurs->count() }})
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection