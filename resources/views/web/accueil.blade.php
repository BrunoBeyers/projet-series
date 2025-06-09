@extends('layouts.app')

@section('content')
<style>
    .video-bg {
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        object-fit: cover;
        z-index: 0;
        filter: brightness(0.7) blur(1px);
    }

    .overlay {
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.5) 10%, rgba(255, 140, 0, 0.2) 90%);
        z-index: 0;
        pointer-events: none;
    }

    .fade-in {
        animation: fadeInUp 1.2s ease-out both;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<video class="video-bg w-screen h-screen" autoplay loop muted playsinline>
    <source src="{{ asset('storage/videos/VID.mp4') }}" type="video/mp4">
    Votre navigateur ne supporte pas la vidéo.
</video>
<div class="overlay"></div>

<div class="relative z-10 flex flex-col items-center justify-center min-h-[80vh] px-4">
    <div class="bg-white/70 backdrop-blur-md rounded-2xl shadow-2xl p-10 max-w-3xl w-full text-center fade-in">
        <h1 class="text-5xl md:text-6xl font-extrabold text-orange-600 mb-6 tracking-tight drop-shadow-xl">
            Suivi<span class="text-gray-800">Séries</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-700 mb-8 font-medium leading-relaxed">
            Garde une trace de tes épisodes, découvre de nouvelles séries et évite les spoilers.<br>
            Tout ça avec style.
        </p>

        <div class="flex flex-wrap justify-center gap-3 mb-10">
            <span class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full font-semibold shadow">✔️ Suivi des épisodes</span>
            <span class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full font-semibold shadow">⭐ Séries favorites</span>
            <span class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full font-semibold shadow">🛡️ Anti-spoiler</span>
            <span class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full font-semibold shadow">🔎 Recherche intuitive</span>
        </div>

        <a href="{{ route('register') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-full shadow-xl text-lg transition duration-300">
            Rejoins la communauté
        </a>
        <p class="mt-4 text-gray-600 text-sm">
            Déjà membre ? <a href="{{ route('login') }}" class="text-orange-600 underline hover:text-orange-800">Connecte-toi</a>
        </p>
    </div>
</div>
@endsection
