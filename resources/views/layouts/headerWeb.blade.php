<header class="glass-effect shadow-lg mb-8 z-20 relative sticky top-0">
    <div class="container mx-auto flex items-center justify-between py-4 px-6">
        <!-- Logo et Brand -->
        <div class="flex items-center gap-3">
            <a href="{{ url('/') }}" class="flex items-center gap-3 text-2xl font-bold tracking-tight hover:scale-105 transition-transform duration-300">
                <div class="logo-glow relative">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5V6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v10.5M4 19.5L20 17" />
                    </svg>
                    <div class="notification-badge"></div>
                </div>
                <span class="brand-text">SuiviSéries</span>
            </a>
        </div>
        
        <!-- Navigation Desktop -->
        <nav class="hidden md:flex items-center gap-1">
            <a href="{{ route('accueil') }}" class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}">Accueil</a>
            <a href="{{ route('series.index') }}" class="nav-link {{ request()->routeIs('series.*') ? 'active' : '' }}">Séries</a>
    
            <a href="{{ route('ajouter.index') }}" class="nav-link {{ request()->routeIs('ajouter.*') ? 'active' : '' }}">Gérer</a>
            @auth
                <a href="{{ route('profil.perso') }}" class="nav-link {{ request()->routeIs('profil.*') ? 'active' : '' }}">Mon profil</a>
            @endauth
        </nav>
        
        <!-- Actions utilisateur Desktop -->
        <div class="hidden md:flex items-center gap-3 ml-8">
            @auth
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600 font-medium">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="nav-link disconnect-btn">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            @else
                <div class="auth-links">
                    <a href="{{ route('login') }}" class="nav-link">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Connexion
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Inscription
                        </a>
                    @endif
                </div>
            @endauth
        </div>
        
        <!-- Menu Mobile Toggle -->
        <button class="md:hidden mobile-menu-btn p-2 rounded-lg" onclick="toggleMobileMenu()">
            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>
    
    <!-- Menu Mobile -->
    <div class="mobile-menu md:hidden" id="mobileMenu">
        <nav class="flex flex-col gap-2">
            <a href="{{ route('accueil') }}" class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}">Accueil</a>
            <a href="{{ route('series.index') }}" class="nav-link {{ request()->routeIs('series.*') ? 'active' : '' }}">Séries</a>
            <a href="{{ route('favoris.index') }}" class="nav-link {{ request()->routeIs('favoris.*') ? 'active' : '' }}">Mes favoris</a>
            <a href="{{ route('ajouter.index') }}" class="nav-link {{ request()->routeIs('ajouter.*') ? 'active' : '' }}">Ajouter</a>
            @auth
                <a href="{{ route('profil.perso') }}" class="nav-link {{ request()->routeIs('profil.*') ? 'active' : '' }}">Mon profil</a>
            @endauth
            
            <div class="border-t border-orange-100 pt-4 mt-4">
                @auth
                    <div class="flex flex-col gap-2">
                        <span class="text-sm text-gray-600 font-medium px-4 py-2">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link disconnect-btn w-full text-left">Déconnexion</button>
                        </form>
                    </div>
                @else
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link">Inscription</a>
                        @endif
                    </div>
                @endauth
            </div>
        </nav>
    </div>
</header>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    * {
        font-family: 'Inter', sans-serif;
    }
    
    .glass-effect {
        background: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .logo-glow {
        filter: none;
    }
    
    .notification-badge {
        display: none;
    }
    
    .nav-link {
        position: relative;
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 14px;
        color: #1f2937;
        transition: all 0.2s ease;
        text-decoration: none;
        overflow: hidden;
        border: 1px solid transparent;
    }
    
    .nav-link::before {
        display: none;
    }
    
    .nav-link:hover {
        color: #ea580c;
        background: rgba(251, 146, 60, 0.1);
        border-color: rgba(251, 146, 60, 0.2);
    }
    
    .nav-link.active {
        color: #ea580c;
        background: rgba(251, 146, 60, 0.15);
        border-color: rgba(251, 146, 60, 0.3);
    }
    
    .brand-text {
        background: linear-gradient(135deg, #ea580c, #fb923c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .mobile-menu-btn {
        background: rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.08);
        transition: all 0.2s ease;
    }
    
    .mobile-menu-btn:hover {
        background: rgba(0, 0, 0, 0.06);
    }
    
    .mobile-menu {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 50;
        padding: 20px;
        background: rgba(255, 255, 255, 0.98);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        transform: translateY(-10px);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .mobile-menu.active {
        transform: translateY(0);
        opacity: 1;
        visibility: visible;
    }
    
    .disconnect-btn {
        background: #ef4444;
        color: white !important;
        border: 1px solid #ef4444;
        transition: all 0.2s ease;
        font-weight: 500;
    }
    
    .disconnect-btn:hover {
        background: #dc2626;
        border-color: #dc2626;
        color: white !important;
    }
    
    .auth-links {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    
    .auth-links .nav-link {
        background: rgba(251, 146, 60, 0.1);
        border: 1px solid rgba(251, 146, 60, 0.3);
        color: #ea580c;
        font-weight: 600;
    }
    
    .auth-links .nav-link:hover {
        background: #ea580c;
        color: white;
        border-color: #ea580c;
    }
    
    .notification-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('active');
    }
    
    // Fermer le menu mobile en cliquant ailleurs
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobileMenu');
        const button = event.target.closest('.mobile-menu-btn');
        
        if (!button && !menu.contains(event.target)) {
            menu.classList.remove('active');
        }
    });
</script>