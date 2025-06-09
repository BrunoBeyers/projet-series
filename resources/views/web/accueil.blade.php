@extends('layouts.app')

@section('content')
<style>
    .video-bg {
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        object-fit: cover;
        z-index: 0;
        filter: brightness(0.6) blur(0.5px);
    }
    .overlay {
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(255, 140, 0, 0.15) 100%);
        z-index: 1;
        pointer-events: none;
    }
    .floating-particles {
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        z-index: 2;
        pointer-events: none;
        background-image: 
            radial-gradient(2px 2px at 20px 30px, rgba(255, 140, 0, 0.3), transparent),
            radial-gradient(2px 2px at 40px 70px, rgba(255, 140, 0, 0.2), transparent),
            radial-gradient(1px 1px at 90px 40px, rgba(255, 255, 255, 0.4), transparent),
            radial-gradient(1px 1px at 130px 80px, rgba(255, 255, 255, 0.3), transparent);
        background-size: 200px 100px;
        animation: float 20s ease-in-out infinite;
    }
    .fade-in {
        animation: fadeInUp 1.2s ease-out both;
    }
    .fade-in-delay {
        animation: fadeInUp 1.2s ease-out 0.3s both;
    }
    .fade-in-delay-2 {
        animation: fadeInUp 1.2s ease-out 0.6s both;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(1deg); }
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .feature-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 140, 0, 0.1);
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -12px rgba(255, 140, 0, 0.3);
        border-color: rgba(255, 140, 0, 0.3);
    }
    .btn-primary {
        background: linear-gradient(135deg, #ff8c00 0%, #ff6b00 100%);
        box-shadow: 0 10px 25px -5px rgba(255, 140, 0, 0.4);
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px -5px rgba(255, 140, 0, 0.6);
    }
    .text-gradient {
        background: linear-gradient(135deg, #ff8c00 0%, #ff6b00 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .icon-glow {
        filter: drop-shadow(0 0 10px rgba(255, 140, 0, 0.5));
    }
</style>

<video class="video-bg" autoplay loop muted playsinline>
    <source src="{{ asset('storage/videos/VID.mp4') }}" type="video/mp4">
    Votre navigateur ne supporte pas la vidéo.
</video>
<div class="overlay"></div>
<div class="floating-particles"></div>

<div class="relative z-10 min-h-screen flex flex-col items-center justify-center px-4 py-12">
    <!-- Section Hero -->
    <div class="glass-card rounded-3xl p-12 max-w-5xl w-full text-center mb-16 fade-in">
        <div class="mb-8">
            <h1 class="text-6xl md:text-7xl font-black mb-4 tracking-tight">
                <span class="text-white drop-shadow-2xl">Suivi</span>
                <span class="text-gradient">Séries</span>
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-orange-400 to-orange-600 mx-auto rounded-full"></div>
        </div>
        
        <p class="text-xl md:text-2xl text-white/90 mb-12 font-light leading-relaxed max-w-3xl mx-auto">
            L'expérience ultime pour suivre tes séries préférées.<br>
        
        </p>
        <div class="flex flex-wrap justify-center gap-8">
                <div class="flex-1 min-w-[200px] text-center">
                    <div class="text-4xl font-black text-gradient mb-2">12+</div>
                    <div class="text-white/80 font-medium">Séries référencées</div>
                </div>
                <div class="flex-1 min-w-[200px] text-center">
                    <div class="text-4xl font-black text-gradient mb-2">300+</div>
                    <div class="text-white/80 font-medium">Épisodes suivis</div>
                </div>
            </div>
    </div>
    
   

    </div>
    
   
</div>
@endsection