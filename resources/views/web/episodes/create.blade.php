@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">
        Ajouter un épisode – 
        <span class="text-orange-600">Saison {{ $saison->numero }}</span>
        <span class="text-gray-600">de {{ $saison->serie->titre }}</span>
    </h1>

    <form action="{{ route('episodes.store', [$saison->serie->id, $saison->id]) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-8 space-y-6">
        @csrf

        <div>
            <label for="numero_episode" class="block font-semibold mb-2 text-gray-700">Numéro d’épisode</label>
            <input type="number" name="numero_episode" id="numero_episode" value="{{ old('numero_episode') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" min="1" required>
            @error('numero_episode')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="titre" class="block font-semibold mb-2 text-gray-700">Titre</label>
            <input type="text" name="titre" id="titre" value="{{ old('titre') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            @error('titre')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="resume" class="block font-semibold mb-2 text-gray-700">Résumé</label>
            <textarea name="resume" id="resume" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('resume') }}</textarea>
            @error('resume')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Zone drag & drop pour l'image -->
        <div x-data="{ imageName: '', imagePreview: '' }">
            <label for="image" class="block font-semibold mb-2 text-gray-700">Image (optionnelle)</label>

            <div 
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-orange-500 transition"
                @click="$refs.imageInput.click()"
            >
                <template x-if="!imagePreview">
                    <p class="text-gray-500">Cliquez pour sélectionner une image</p>
                </template>

                <template x-if="imagePreview">
                    <img :src="imagePreview" alt="Preview" class="mx-auto h-32 object-cover rounded mt-2">
                </template>
            </div>

            <input type="file" name="image" id="image" accept="image/*" 
                   class="hidden" x-ref="imageInput"
                   @change="
                       const file = $refs.imageInput.files[0];
                       imageName = file.name;
                       const reader = new FileReader();
                       reader.onload = (e) => imagePreview = e.target.result;
                       reader.readAsDataURL(file);
                   ">

            @error('image')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                Ajouter l’épisode
            </button>
        </div>
    </form>
</div>

<!-- Alpine.js pour l'aperçu image -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
