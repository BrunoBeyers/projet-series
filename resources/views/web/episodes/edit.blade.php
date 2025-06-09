@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-extrabold mb-6 text-gray-800">
        Modifier l’épisode 
        <span class="text-orange-600">"{{ $episode->titre }}"</span> — 
        Saison {{ $saison->numero }} de {{ $saison->serie->titre }}
    </h1>

    <form action="{{ route('episodes.update', [$saison->serie->id, $saison->id, $episode->id]) }}" 
          method="POST" enctype="multipart/form-data" 
          class="bg-white shadow-md rounded-xl p-8 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="numero_episode" class="block font-semibold text-gray-700 mb-2">Numéro d’épisode</label>
            <input type="number" name="numero_episode" id="numero_episode" value="{{ old('numero_episode', $episode->numero_episode) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" min="1" required>
            @error('numero_episode')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="titre" class="block font-semibold text-gray-700 mb-2">Titre</label>
            <input type="text" name="titre" id="titre" value="{{ old('titre', $episode->titre) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            @error('titre')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="resume" class="block font-semibold text-gray-700 mb-2">Résumé</label>
            <textarea name="resume" id="resume" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('resume', $episode->resume) }}</textarea>
            @error('resume')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Image actuelle -->
        <div>
            <label class="block font-semibold text-gray-700 mb-2">Image actuelle</label>
            @if($episode->image_url)
                <img src="{{ asset('storage/' . $episode->image_url) }}" 
                     alt="Image épisode" 
                     class="rounded shadow max-w-[200px] h-auto object-cover">
            @else
                <p class="text-gray-400 italic">Aucune image</p>
            @endif
        </div>

        <!-- Upload avec aperçu -->
        <div x-data="{ preview: null }">
            <label for="image" class="block font-semibold text-gray-700 mb-2">Nouvelle image (optionnelle)</label>
            <div 
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-orange-500 transition"
                @click="$refs.fileInput.click()"
            >
                <template x-if="!preview">
                    <p class="text-gray-500">Cliquez ici pour sélectionner une image</p>
                </template>

                <template x-if="preview">
                    <img :src="preview" alt="Preview" class="mx-auto h-40 object-cover rounded">
                </template>
            </div>

            <input type="file" name="image" id="image" accept="image/*"
                   class="hidden" x-ref="fileInput"
                   @change="
                       const file = $refs.fileInput.files[0];
                       const reader = new FileReader();
                       reader.onload = (e) => preview = e.target.result;
                       reader.readAsDataURL(file);
                   ">
            @error('image')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>

<!-- Alpine.js requis pour l’aperçu -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
