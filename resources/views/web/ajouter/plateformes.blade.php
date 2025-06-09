@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold mb-8 text-orange-600">Ajouter une plateforme</h1>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('plateformes.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-8 space-y-6">
        @csrf
        {{-- Nom plateforme --}}
        <div>
            <label for="nom" class="block text-gray-700 font-semibold mb-2">Nom de la plateforme</label>
            <input type="text" name="nom" id="nom" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                   value="{{ old('nom') }}">
            @error('nom')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Logo --}}
        <div>
            <label for="image" class="block text-gray-700 font-semibold mb-2">Logo de la plateforme (image)</label>
            <div class="flex items-center space-x-4">
                <label for="image" 
                       class="cursor-pointer bg-orange-600 hover:bg-orange-700 text-white font-semibold px-5 py-2 rounded shadow transition select-none">
                    Choisir un fichier
                </label>
                <span id="file-name" class="text-gray-600 italic truncate max-w-xs">Aucun fichier sélectionné</span>
            </div>
            <input type="file" name="image" id="image" accept="image/*" class="hidden">
            @error('image')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            {{-- Aperçu de l’image --}}
            <div id="preview-container" class="mt-4 hidden">
                <p class="font-semibold mb-1 text-gray-700">Aperçu :</p>
                <img id="preview-image" src="#" alt="Aperçu logo" class="w-24 h-24 object-contain rounded shadow border border-gray-300" />
            </div>
        </div>

        {{-- Bouton --}}
        <button type="submit" 
                class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
            Ajouter la plateforme
        </button>
    </form>

    {{-- Liste des plateformes --}}
    @if(isset($plateformes) && $plateformes->count())
        <section class="mt-12">
            <h2 class="text-2xl font-bold mb-6 text-orange-600">Plateformes existantes</h2>
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full bg-white rounded-lg">
                    <thead class="bg-orange-100 text-orange-700 uppercase text-sm font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-left">Logo</th>
                            <th class="px-6 py-3 text-left">Nom</th>
                            <th class="px-6 py-3 text-left w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($plateformes as $plateforme)
                        <tr class="border-b last:border-b-0 hover:bg-orange-50 transition">
                            <td class="px-6 py-4">
                                @if($plateforme->url)
                                    <img src="{{ $plateforme->url }}" alt="Logo {{ $plateforme->nom }}" class="w-14 h-14 object-contain rounded shadow" />
                                @else
                                    <div class="w-14 h-14 flex items-center justify-center bg-orange-50 rounded text-orange-300 font-bold text-xl select-none">
                                        ?
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-lg text-gray-800">{{ $plateforme->nom }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('plateformes.destroy', $plateforme->id) }}" method="POST" 
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer cette plateforme ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow transition">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @else
        <p class="mt-12 text-gray-500 italic text-center">Aucune plateforme n’a encore été ajoutée.</p>
    @endif
</div>

{{-- Script pour prévisualisation image --}}
<script>
document.getElementById('image').addEventListener('change', function(event) {
    const input = event.target;
    const fileNameSpan = document.getElementById('file-name');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');

    if (input.files && input.files[0]) {
        fileNameSpan.textContent = input.files[0].name;

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        fileNameSpan.textContent = 'Aucun fichier sélectionné';
        previewContainer.classList.add('hidden');
        previewImage.src = '#';
    }
});
</script>
@endsection
