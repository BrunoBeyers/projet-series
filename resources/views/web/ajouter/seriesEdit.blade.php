@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-800">
        Modifier la série <span class="text-orange-600">"{{ $serie->titre }}"</span>
    </h1>

    <form action="{{ route('seriesAjout.update', $serie->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-xl p-8 space-y-6">
        @csrf
        @method('PUT')

        {{-- Titre --}}
        <div>
            <label for="titre" class="block text-gray-700 font-semibold mb-2">Titre</label>
            <input type="text" name="titre" id="titre" value="{{ old('titre', $serie->titre) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            @error('titre')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('description', $serie->description) }}</textarea>
            @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Image actuelle --}}
        @if ($serie->image_url)
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Image actuelle</label>
                <img src="{{ asset($serie->image_url) }}" alt="Image actuelle"
                     class="w-40 h-auto object-cover rounded shadow-md border">
            </div>
        @endif

        {{-- Upload d’image avec aperçu --}}
        <div x-data="{ preview: null }">
            <label for="image" class="block text-gray-700 font-semibold mb-2">Nouvelle image (facultatif)</label>

            <div 
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-orange-500 transition"
                @click="$refs.fileInput.click()">
                <template x-if="!preview">
                    <p class="text-gray-500">Cliquez ici pour sélectionner une image</p>
                </template>

                <template x-if="preview">
                    <img :src="preview" alt="Aperçu de l’image" class="mx-auto h-40 object-cover rounded shadow">
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

        {{-- Bouton --}}
        <div>
            <button type="submit"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>

<!-- Alpine.js pour l’aperçu d'image -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
