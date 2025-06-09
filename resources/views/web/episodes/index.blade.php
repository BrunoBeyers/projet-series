@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">
        Épisodes de la 
        <span class="text-orange-600">Saison {{ $saison->numero }}</span> 
        <span class="text-gray-600">— {{ $saison->serie->titre }}</span>
    </h1>

    <div class="mb-6">
        <a href="{{ route('episodes.create', [$saison->serie->id, $saison->id]) }}"
           class="inline-block bg-orange-600 hover:bg-orange-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
            + Ajouter un épisode
        </a>
    </div>

    @if ($episodes->isEmpty())
        <div class="text-gray-500 text-center italic mt-10">
            Aucun épisode n’a encore été enregistré pour cette saison.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 text-sm font-semibold uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">N°</th>
                        <th class="px-4 py-3 text-left">Titre</th>
                        <th class="px-4 py-3 text-left">Résumé</th>
                        <th class="px-4 py-3 text-left">Image</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach ($episodes as $episode)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium">{{ $episode->numero_episode }}</td>
                            <td class="px-4 py-3">{{ $episode->titre }}</td>
                            <td class="px-4 py-3">
                                {{ \Illuminate\Support\Str::limit($episode->resume, 50) }}
                            </td>
                            <td class="px-4 py-3">
                                @if($episode->image_url)
                                    <img src="{{ asset('storage/' . $episode->image_url) }}" 
                                         alt="Image épisode"
                                         class="w-24 h-16 object-cover rounded border">
                                @else
                                    <span class="text-gray-400 italic">Pas d’image</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 space-x-3">
                                <a href="{{ route('episodes.edit', [$saison->serie->id, $saison->id, $episode->id]) }}"
                                   class="text-blue-600 hover:underline font-medium">Modifier</a>

                                <form action="{{ route('episodes.destroy', [$saison->serie->id, $saison->id, $episode->id]) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet épisode ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:underline font-medium">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
