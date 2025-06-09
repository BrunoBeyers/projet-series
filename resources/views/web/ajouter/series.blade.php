@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">Gestion des séries</h1>
        <a href="{{ route('seriesAjout.create') }}"
           class="inline-block bg-orange-600 hover:bg-orange-700 text-white font-medium px-5 py-2 rounded-lg shadow transition">
            Ajouter une série
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 text-green-800 border border-green-200 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($series->count())
        <div class="overflow-x-auto bg-white shadow-xl rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100 text-gray-700 text-left uppercase tracking-wide text-xs">
                    <tr>
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Titre</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($series as $serie)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                @if($serie->image_url)
                                    <img src="{{ asset($serie->image_url) }}" alt="Image de la série"
                                         class="w-24 h-auto rounded-lg shadow-md object-cover">
                                @else
                                    <span class="text-gray-400 italic">Aucune image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 text-base">
                                {{ $serie->titre }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ \Illuminate\Support\Str::limit($serie->description, 100) }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('seriesAjout.edit', $serie->id) }}"
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md transition shadow-sm">
                                    Modifier
                                </a>

                                <a href="{{ route('saisons.index', $serie->id) }}"
                                   class="inline-block bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md transition shadow-sm">
                                    Gérer
                                </a>

                                <form action="{{ route('seriesAjout.destroy', $serie->id) }}" method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette série ?');">
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
    @else
        <div class="mt-12 text-center text-gray-500 text-lg italic">
            Aucune série enregistrée pour le moment.
        </div>
    @endif
</div>
@endsection
