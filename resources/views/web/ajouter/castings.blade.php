@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-8 bg-gray-50 rounded-lg shadow-lg">
    <h1 class="text-3xl font-extrabold mb-8 text-orange-600 border-b-4 border-orange-500 pb-2">
        Gérer les Castings
    </h1>

    {{-- Messages succès / erreur --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow transition duration-300">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg shadow transition duration-300">
            {{ session('error') }}
        </div>
    @endif

    {{-- Formulaire ajout casting --}}
    <form action="{{ route('castings.store') }}" method="POST" class="bg-white rounded-xl shadow-md p-8 mb-10 space-y-6" novalidate>
        @csrf
        <div>
            <label for="acteur_id" class="block text-gray-700 font-semibold mb-2">Acteur</label>
            <select name="acteur_id" id="acteur_id" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                <option value="" disabled selected>Sélectionnez un acteur</option>
                @foreach($acteurs as $acteur)
                    <option value="{{ $acteur->id }}" {{ old('acteur_id') == $acteur->id ? 'selected' : '' }}>
                        {{ $acteur->prenom }} {{ $acteur->nom }}
                    </option>
                @endforeach
            </select>
            @error('acteur_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="serie_id" class="block text-gray-700 font-semibold mb-2">Série</label>
            <select name="serie_id" id="serie_id" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                <option value="" disabled selected>Sélectionnez une série</option>
                @foreach($series as $serie)
                    <option value="{{ $serie->id }}" {{ old('serie_id') == $serie->id ? 'selected' : '' }}>
                        {{ $serie->titre }}
                    </option>
                @endforeach
            </select>
            @error('serie_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="role" class="block text-gray-700 font-semibold mb-2">Rôle</label>
            <input type="text" name="role" id="role" required
                   value="{{ old('role') }}"
                   placeholder="Ex : John Doe"
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 transition" />
            @error('role')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 rounded-lg shadow-lg transition duration-300">
            Ajouter le casting
        </button>
    </form>

    {{-- Liste des castings --}}
    <section class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6 text-orange-600 border-b border-orange-300 pb-2">Castings existants</h2>

        <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full text-left text-gray-700">
                <thead class="bg-orange-100 text-orange-700 uppercase text-sm font-semibold">
                    <tr>
                        <th class="px-6 py-3">Acteur</th>
                        <th class="px-6 py-3">Série</th>
                        <th class="px-6 py-3">Rôle</th>
                        <th class="px-6 py-3 w-32">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($series as $serie)
                        @foreach($serie->castings as $casting)
                            <tr class="border-b last:border-b-0 hover:bg-orange-50 transition">
                                <td class="px-6 py-4 font-medium">{{ $casting->acteur->prenom }} {{ $casting->acteur->nom }}</td>
                                <td class="px-6 py-4">{{ $serie->titre }}</td>
                                <td class="px-6 py-4">{{ $casting->role }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('castings.destroy', $casting->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce casting ?');">
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
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500 italic">
                                Aucun casting trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
