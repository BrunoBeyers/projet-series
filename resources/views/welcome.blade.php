<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suivi de Séries - Votre compagnon série intelligent</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #fdf8f3 50%, #f9f1e8 100%);
            color: #1a1a1a;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .grain {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            pointer-events: none;
        }
        
        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 1.5rem 2rem;
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.9);
            border-bottom: 1px solid rgba(255, 138, 76, 0.2);
        }
        
        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-links {
            display: flex;
            gap: 1rem;
        }
        
        .nav-link {
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            color: rgba(26, 26, 26, 0.7);
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            border: 1px solid transparent;
        }
        
        .nav-link:hover {
            color: #1a1a1a;
            background: rgba(255, 138, 76, 0.1);
            border-color: rgba(255, 138, 76, 0.2);
        }
        
        .nav-link.primary {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: #ffffff;
            border: none;
        }
        
        .nav-link.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
        }
        
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            position: relative;
        }
        
        .hero-content {
            max-width: 800px;
            z-index: 10;
        }
        
        .hero-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(255, 138, 76, 0.1);
            border: 1px solid rgba(255, 138, 76, 0.3);
            border-radius: 25px;
            color: #e67e22;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }
        
        .hero-title {
            font-size: clamp(3rem, 8vw, 5rem);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #2c3e50 0%, #ff6b35 50%, #f7931e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(26, 26, 26, 0.7);
            margin-bottom: 3rem;
            line-height: 1.6;
            font-weight: 300;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .cta-button {
            padding: 1rem 2rem;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .cta-button.primary {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: #ffffff;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
        }
        
        .cta-button.primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.4);
        }
        
        .cta-button.secondary {
            background: rgba(255, 255, 255, 0.8);
            color: #ff6b35;
            border: 2px solid rgba(255, 138, 76, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .cta-button.secondary:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(255, 138, 76, 0.5);
            transform: translateY(-2px);
        }
        
        .features {
            padding: 6rem 2rem;
            background: linear-gradient(180deg, transparent 0%, rgba(255, 138, 76, 0.05) 100%);
        }
        
        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 138, 76, 0.2);
            border-radius: 16px;
            padding: 2rem;
            backdrop-filter: blur(20px);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.6), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            border-color: rgba(255, 138, 76, 0.4);
            box-shadow: 0 20px 40px rgba(255, 138, 76, 0.15);
            background: rgba(255, 255, 255, 0.8);
        }
        
        .feature-card:hover::before {
            opacity: 1;
        }
        
        .feature-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
        
        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #2c3e50;
        }
        
        .feature-description {
            color: rgba(26, 26, 26, 0.7);
            line-height: 1.6;
        }
        
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }
        
        .floating-element {
            position: absolute;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(247, 147, 30, 0.1));
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-element:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-element:nth-child(2) {
            top: 70%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .floating-element:nth-child(3) {
            top: 40%;
            right: 20%;
            animation-delay: 4s;
            width: 60px;
            height: 60px;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .footer {
            text-align: center;
            padding: 2rem;
            border-top: 1px solid rgba(255, 138, 76, 0.2);
            color: rgba(26, 26, 26, 0.5);
            background: rgba(255, 255, 255, 0.3);
        }
        
        @media (max-width: 768px) {
            .nav {
                padding: 1rem;
            }
            
            .nav-links {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .nav-link {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            
            .hero {
                padding: 1rem;
                min-height: 90vh;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .features {
                padding: 3rem 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="grain"></div>
    
    <nav class="nav">
        <div class="nav-content">
            <div class="logo">Suivi de Séries</div>
            <div class="nav-links">
                <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                <a href="{{ route('register') }}" class="nav-link primary">Inscription</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        
        <div class="hero-content">
            <div class="hero-badge">Nouvelle génération de tracking</div>
            <h1 class="hero-title">Maîtrisez vos séries comme jamais</h1>
            <p class="hero-subtitle">
                Une plateforme intelligente qui transforme votre façon de suivre, organiser et découvrir vos séries préférées. Expérience premium, résultats garantis.
            </p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="cta-button primary">Commencer gratuitement</a>
                <a href="{{ route('login') }}" class="cta-button secondary">J'ai déjà un compte</a>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="features-container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3 class="feature-title">Suivi intelligent</h3>
                    <p class="feature-description">
                        Algorithmes avancés pour un tracking précis de votre progression. Synchronisation automatique et recommandations personnalisées.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">💬</div>
                    <h3 class="feature-title">Analyse approfondie</h3>
                    <p class="feature-description">
                        Commentaires structurés, notes détaillées et système de notation professionnel pour chaque épisode visionné.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">⭐</div>
                    <h3 class="feature-title">Curation premium</h3>
                    <p class="feature-description">
                        Système de favoris intelligent avec catégorisation automatique et suggestions basées sur vos préférences.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3 class="feature-title">Plateforme unifiée</h3>
                    <p class="feature-description">
                        Accès centralisé à toutes les plateformes de streaming avec informations de disponibilité en temps réel.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Suivi de Séries — Projet académique réalisé avec Laravel</p>
    </footer>
</body>
</html>