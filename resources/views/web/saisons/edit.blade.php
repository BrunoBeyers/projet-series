@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">
        Modifier la saison {{ $saison->numero }} – 
        <span class="text-orange-600">{{ $saison->serie->titre }}</span>
    </h1>

    <form action="{{ route('saisons.update', $saison) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-8 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="numero" class="block font-semibold mb-2 text-gray-700">Numéro de saison</label>
            <input type="number" name="numero" id="numero" value="{{ old('numero', $saison->numero) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            @error('numero')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description" class="block font-semibold mb-2 text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('description', $saison->description) }}</textarea>
            @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="annee_sortie" class="block font-semibold mb-2 text-gray-700">Année de sortie</label>
            <input type="number" name="annee_sortie" id="annee_sortie" value="{{ old('annee_sortie', $saison->annee_sortie) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            @error('annee_sortie')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Zone d'upload avec aperçu -->
        <div x-data="{ preview: null }">
            <label for="image" class="block font-semibold mb-2 text-gray-700">Changer l'image de la saison</label>

            <div 
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-orange-500 transition"
                @click="$refs.fileInput.click()"
            >
                <template x-if="!preview">
                    <p class="text-gray-500">Cliquez pour sélectionner une nouvelle image</p>
                </template>

                <template x-if="preview">
                    <img :src="preview" alt="Nouvelle image" class="mx-auto h-40 object-cover rounded">
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

        <!-- Image actuelle -->
        @if($saison->image_url)
            <div class="mt-4">
                <p class="font-semibold text-gray-600 mb-1">Image actuelle :</p>
                @php
                    $isExternal = Str::startsWith($saison->image_url, ['http://', 'https://']);
                @endphp
                <img src="{{ $isExternal ? $saison->image_url : asset('storage/' . $saison->image_url) }}" 
                     alt="Image saison"
                     class="rounded-md shadow max-h-40 object-cover border border-gray-200">
            </div>
        @endif

        <div>
            <button type="submit"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>

<!-- Alpine.js requis -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
