<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suivi de Séries</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-[#1b1b18] flex items-center justify-center min-h-screen flex-col p-6">
    <header class="w-full max-w-2xl text-sm mb-8">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm leading-normal">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-sm leading-normal">
                        Connexion
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm leading-normal">
                            Inscription
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="w-full max-w-2xl bg-white rounded-lg shadow-md p-8 flex flex-col items-center">
        <div class="mb-6">
            <span class="inline-block bg-orange-100 text-orange-600 rounded-full px-4 py-2 text-lg font-semibold shadow">
                <svg class="inline w-7 h-7 mr-2 align-middle" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5V6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v10.5M4 19.5L20 17" />
                </svg>
                Suivi de Séries
            </span>
        </div>
        <h1 class="text-3xl font-bold mb-2 text-orange-600">Organisez votre passion des séries</h1>
        <p class="text-lg text-gray-700 mb-6 text-center">
            Gardez une trace de vos épisodes vus, évitez les spoilers, ajoutez vos séries en favoris et découvrez sur quelles plateformes elles sont disponibles.<br>
            Un outil simple, moderne et pensé pour les vrais sériephiles.
        </p>
        <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 w-full">
            <li class="flex items-center bg-orange-50 rounded p-4 shadow-sm">
                <span class="text-orange-500 text-2xl mr-3">✔️</span>
                Marquez les épisodes vus
            </li>
            <li class="flex items-center bg-orange-50 rounded p-4 shadow-sm">
                <span class="text-orange-500 text-2xl mr-3">💬</span>
                Commentez chaque épisode
            </li>
            <li class="flex items-center bg-orange-50 rounded p-4 shadow-sm">
                <span class="text-orange-500 text-2xl mr-3">⭐</span>
                Ajoutez vos séries en favoris
            </li>
            <li class="flex items-center bg-orange-50 rounded p-4 shadow-sm">
                <span class="text-orange-500 text-2xl mr-3">🛡️</span>
                Activez le mode anti-spoiler
            </li>
            <li class="flex items-center bg-orange-50 rounded p-4 shadow-sm">
                <span class="text-orange-500 text-2xl mr-3">🔎</span>
                Recherchez facilement une série
            </li>
            <li class="flex items-center bg-orange-50 rounded p-4 shadow-sm">
                <span class="text-orange-500 text-2xl mr-3">📺</span>
                Découvrez les plateformes de diffusion
            </li>
        </ul>
        <div class="flex flex-col md:flex-row gap-4 w-full justify-center">
            <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded shadow text-lg text-center transition">
                Commencer maintenant
            </a>
            <a href="{{ route('accueil') }}" class="bg-white border border-orange-500 text-orange-600 font-semibold px-6 py-3 rounded shadow text-lg text-center hover:bg-orange-50 transition">
                J'ai déjà un compte
            </a>
        </div>
    </main>
    <footer class="mt-8 text-gray-400 text-xs text-center">
        &copy; {{ date('Y') }} Suivi de Séries &mdash; Un projet personnel pour les passionnés
    </footer>
</body>
</html>