@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-8 bg-gray-50 rounded-lg shadow-lg">
    {{-- Bouton retour / gestion castings --}}
    <a href="{{ route('castings.create') }}"
       class="inline-flex items-center mb-8 px-5 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg shadow-md transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
        </svg>
        Gérer les Castings
    </a>

    <h1 class="text-3xl font-extrabold mb-8 text-orange-600 border-b-4 border-orange-500 pb-3">Ajouter un acteur</h1>

    {{-- Messages de succès --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow transition duration-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulaire ajout acteur --}}
    <form action="{{ route('acteurs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-8 space-y-6" novalidate>
        @csrf

        <div>
            <label for="nom" class="block text-gray-700 font-semibold mb-2">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition" />
            @error('nom')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="prenom" class="block text-gray-700 font-semibold mb-2">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition" />
            @error('prenom')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="date_naissance" class="block text-gray-700 font-semibold mb-2">Date de naissance</label>
            <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition" />
            @error('date_naissance')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="biographie" class="block text-gray-700 font-semibold mb-2">Biographie</label>
            <textarea name="biographie" id="biographie" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-3 resize-y focus:outline-none focus:ring-2 focus:ring-orange-500 transition">{{ old('biographie') }}</textarea>
            @error('biographie')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
    <label for="image" class="block text-gray-700 font-semibold mb-2">Photo de l'acteur</label>
    <label for="image" 
           class="cursor-pointer flex items-center justify-center gap-3 w-full border-2 border-dashed border-gray-300 rounded-lg px-4 py-6 text-gray-500 hover:border-orange-500 hover:text-orange-600 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M12 7v5" />
        </svg>
        <span id="file-name" class="select-none">Cliquez pour choisir une image</span>
    </label>
    <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="document.getElementById('file-name').textContent = this.files.length ? this.files[0].name : 'Cliquez pour choisir une image'">
    @error('image')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


        <button type="submit"
                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 rounded-lg shadow-lg transition duration-300">
            Ajouter l'acteur
        </button>
    </form>

    {{-- Liste acteurs existants --}}
    @if($acteurs->count())
        <section class="mt-10">
            <h2 class="text-2xl font-bold mb-6 text-orange-600 border-b border-orange-300 pb-2">Acteurs existants</h2>

            <div class="overflow-x-auto rounded-lg shadow bg-white">
                <table class="min-w-full text-left text-gray-700">
                    <thead class="bg-orange-100 text-orange-700 uppercase text-sm font-semibold">
                        <tr>
                            <th class="px-6 py-3">Photo</th>
                            <th class="px-6 py-3">Nom</th>
                            <th class="px-6 py-3">Prénom</th>
                            <th class="px-6 py-3">Date de naissance</th>
                            <th class="px-6 py-3">Biographie</th>
                            <th class="px-6 py-3 w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($acteurs as $acteur)
                            <tr class="border-b last:border-b-0 hover:bg-orange-50 transition">
                            <td class="px-6 py-4">
    @if($acteur->image_url)
        @php
            $isExternal = Str::startsWith($acteur->image_url, ['http://', 'https://']);
        @endphp

        <img 
            src="{{ $isExternal ? $acteur->image_url : asset('storage/' . $acteur->image_url) }}" 
            alt="Photo de {{ $acteur->nom }}" 
            class="h-16 w-16 object-cover rounded-lg shadow-sm"
        >
    @else
        <span class="text-gray-400 italic">-</span>
    @endif
</td>

                                <td class="px-6 py-4 font-medium">{{ $acteur->nom }}</td>
                                <td class="px-6 py-4">{{ $acteur->prenom }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($acteur->date_naissance)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 max-w-xs truncate" title="{{ $acteur->biographie }}">{{ \Illuminate\Support\Str::limit($acteur->biographie, 100) }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('acteurs.destroy', $acteur->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet acteur ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-lg shadow-sm transition duration-200">
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
    @endif
</div>
@endsection
