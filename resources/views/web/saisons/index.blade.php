@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">Saisons – <span class="text-orange-600">{{ $serie->titre }}</span></h1>

        <a href="{{ route('saisons.create', $serie->id) }}"
           class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-5 py-2 rounded-lg shadow transition">
            + Ajouter une saison
        </a>
    </div>

    @if ($saisons->isEmpty())
        <div class="mt-8 text-center text-gray-500 text-lg italic">
            Aucune saison enregistrée pour cette série.
        </div>
    @else
        <div class="overflow-x-auto bg-white shadow-xl rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase tracking-wide text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">N°</th>
                        <th class="px-6 py-3 text-left">Année</th>
                        <th class="px-6 py-3 text-left">Description</th>
                        <th class="px-6 py-3 text-left">Image</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($saisons as $saison)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $saison->numero }}</td>
                            <td class="px-6 py-4">{{ $saison->annee_sortie }}</td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ Str::limit($saison->description, 80) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($saison->image_url)
                                    <img src="{{ asset('storage/' . $saison->image_url) }}" alt="Saison {{ $saison->numero }}"
                                         class="w-28 h-16 object-cover rounded shadow-sm">
                                @else
                                    <span class="text-gray-400 italic">Aucune image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('saisons.edit', $saison->id) }}"
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md transition shadow-sm">
                                    Modifier
                                </a>

                                <a href="{{ route('episodes.index', [$serie->id, $saison->id]) }}"
                                   class="inline-block bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md transition shadow-sm">
                                    Épisodes
                                </a>

                                <form action="{{ route('saisons.update', $saison->id) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Confirmez-vous la suppression de la saison {{ $saison->numero }} ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md transition shadow-sm">
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
