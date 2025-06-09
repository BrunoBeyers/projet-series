@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- En-tête de l'épisode -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="relative h-64">
                @if($episode->image_url)
                    <img src="{{ asset('storage/' . $episode->image_url) }}" 
                         alt="Épisode {{ $episode->numero_episode }}: {{ $episode->titre }}"
                         class="w-full h-full object-cover">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">
                                Épisode {{ $episode->numero_episode }}: {{ $episode->titre }}
                            </h1>
                            <p class="text-lg">
                                Saison {{ $episode->saison }} de 
                          
                            </p>
                        </div>
                        <form action="{{ route('visionnages.toggle', $episode->id) }}" method="POST" class="flex items-center">
                            @csrf
                            <button type="submit" 
                                    class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition">
                                @if($episode->visionnages->contains('user_id', auth()->id()))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Marquer comme non vu</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Marquer comme vu</span>
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Résumé de l'épisode -->
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4 text-orange-600">Résumé</h2>
                <p class="text-gray-700 leading-relaxed">{{ $episode->resume }}</p>
            </div>
        </div>

        <!-- Section des commentaires -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-orange-600">Commentaires</h2>
            
            <!-- Formulaire de commentaire -->
            <form action="{{ route('commentaires.store', $episode->id) }}" method="POST" class="mb-8">
                @csrf
                <div class="mb-4">
                    <textarea name="contenu" rows="3" 
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                              placeholder="Partagez votre avis sur cet épisode..."></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                        Publier
                    </button>
                </div>
            </form>

            <!-- Liste des commentaires -->
            <div class="space-y-6">
                @forelse($episode->commentaires as $commentaire)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-gray-900">{{ $commentaire->user->name }}</span>
                                <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($commentaire->date_commentaire)->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($commentaire->user_id === auth()->id())
                                <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-600 transition-colors"
                                            title="Supprimer le commentaire">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <p class="text-gray-700">{{ $commentaire->contenu }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Aucun commentaire pour cet épisode. Soyez le premier à commenter !</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection 