@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">
        Ajouter une saison – 
        <span class="text-orange-600">{{ $serie->titre }}</span>
    </h1>

    <form action="{{ route('saisons.store', $serie) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-8 space-y-6">
        @csrf

        <div>
            <label for="numero" class="block font-semibold mb-2 text-gray-700">Numéro de saison</label>
            <input type="number" name="numero" id="numero" value="{{ old('numero') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            @error('numero')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description" class="block font-semibold mb-2 text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="annee_sortie" class="block font-semibold mb-2 text-gray-700">Année de sortie</label>
            <input type="number" name="annee_sortie" id="annee_sortie" value="{{ old('annee_sortie') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            @error('annee_sortie')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Zone drag & drop avec aperçu -->
        <div x-data="{ imagePreview: '' }">
            <label for="image" class="block font-semibold mb-2 text-gray-700">Image de la saison</label>

            <div 
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-orange-500 transition"
                @click="$refs.imageInput.click()"
            >
                <template x-if="!imagePreview">
                    <p class="text-gray-500">Cliquez pour sélectionner une image</p>
                </template>

                <template x-if="imagePreview">
                    <img :src="imagePreview" alt="Aperçu de l’image" class="mx-auto h-40 object-cover rounded">
                </template>
            </div>

            <input type="file" name="image" id="image" accept="image/*" 
                   class="hidden" x-ref="imageInput"
                   @change="
                       const file = $refs.imageInput.files[0];
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
                Ajouter la saison
            </button>
        </div>
    </form>
</div>

<!-- Alpine.js requis -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
