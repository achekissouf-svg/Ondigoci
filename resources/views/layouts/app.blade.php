<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.ondigo.ci.png') }}">
    <title>Ondigoci - @yield('title')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#1e5a9e',
                            600: '#164e85',
                            900: '#0f3a63',
                        },
                        orange: {
                            50: '#fff7ed',
                            400: '#fb923c',
                            500: '#ff6b35',
                            600: '#e55a28',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Bootstrap Overrides for compatibility */
        .btn-primary {
            background-color: #1e5a9e;
            border-color: #1e5a9e;
        }
        .btn-primary:hover {
            background-color: #164e85;
            border-color: #164e85;
        }
        .text-primary { color: #1e5a9e !important; }
        .bg-primary { background-color: #1e5a9e !important; }
        
        /* Glassmorphism Classes */
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Fix for sticky header shadow */
        .header-sticky {
            position: sticky;
            top: 0;
            z-index: 50;
            transition: all 0.3s ease;
        }
        /* Dropdown Hover Effect */
        @media (min-width: 1024px) {
            .dropdown:hover > .dropdown-menu {
                display: block;
                margin-top: 0;
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
            .dropdown-menu {
                display: block;
                opacity: 0;
                visibility: hidden;
                transform: translateY(10px);
                transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Top Announcement Bar -->
    @if(!auth()->check() || auth()->user()->role === 'client' || request()->has('preview'))
    <div class="bg-primary-900 text-white py-2 text-[10px] font-black uppercase tracking-[0.2em] text-center hidden md:block">
        Livraison gratuite à partir de 50 000 FCFA • Support client 24/7
    </div>
    @endif

    <!-- Main Header & Navigation -->
    <header class="header-sticky glass-header">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20 gap-8">
                <!-- Logo -->
                <a href="{{ auth()->check() && auth()->user()->role !== 'client' ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('boutique.dashboard')) : url('/') }}" class="flex items-center gap-2 group min-w-fit">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white shadow-lg shadow-orange-500/20 group-hover:scale-110 transition-transform">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <span class="text-2xl font-black tracking-tighter text-primary-500">Ondigoci</span>
                </a>

                <!-- Search Bar -->
                @if(!auth()->check() || auth()->user()->role === 'client' || request()->has('preview'))
                <div class="flex-1 max-w-2xl hidden lg:block text-center relative" id="searchContainer">
                    <form action="{{ route('shop') }}" method="GET" class="relative group inline-block w-full">
                        <input type="text" name="q" id="instantSearch" placeholder="Rechercher un produit, une catégorie..." autocomplete="off"
                               class="w-full h-12 bg-slate-100 border-none rounded-2xl px-6 pr-14 text-sm font-medium focus:ring-2 focus:ring-orange-500 transition-all outline-none shadow-inner">
                        <button type="submit" class="absolute right-2 top-1.5 w-9 h-9 bg-orange-500 text-white rounded-xl flex items-center justify-center hover:bg-orange-600 transition-colors shadow-lg shadow-orange-500/30">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                    </form>
                    <!-- Instant Search Results -->
                    <div id="searchResults" class="absolute top-full left-0 right-0 bg-white mt-2 rounded-[1.5rem] shadow-2xl border border-slate-100 overflow-hidden hidden z-[60]">
                        <div id="resultsContent" class="p-2"></div>
                        <div class="p-3 bg-slate-50 border-t border-slate-100 text-center">
                            <a href="#" id="viewAllResults" class="text-xs font-bold text-primary-500 hover:text-primary-600">Voir tous les résultats</a>
                        </div>
                    </div>
                </div>
                @else
                <div class="flex-1 flex items-center justify-center">
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-300">Interface Vendeur Professionnelle</span>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex items-center gap-4">
                    @auth
                        @if(Auth::user()->role === 'client' || request()->has('preview'))
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative p-2.5 bg-slate-100 rounded-2xl text-slate-600 hover:text-primary-500 transition-colors group">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span id="cart-badge" class="absolute -top-1 -right-1 w-5 h-5 bg-orange-500 text-white text-[10px] font-black rounded-full flex items-center justify-center border-2 border-white shadow-sm group-hover:scale-110 transition-transform">
                                {{ Auth::user()->paniers()->sum('quantite') ?: 0 }}
                            </span>
                        </a>

                        <a href="{{ route('client.notifications') }}" class="relative p-2.5 bg-slate-100 rounded-2xl text-slate-600 hover:text-primary-500 transition-colors group">
                            <i class="fas fa-bell text-lg"></i>
                            <span id="notificationBadge" class="absolute top-2.5 right-2.5 w-2 h-2 bg-orange-500 rounded-full border-2 border-white" style="display: none;"></span>
                        </a>
                        @endif

                        <!-- User Profile Dropdown -->
                        <div class="dropdown">
                            <button class="flex items-center gap-2 p-1.5 pr-4 bg-slate-100 rounded-2xl hover:bg-slate-200 transition-colors border-0" data-bs-toggle="dropdown">
                                <div class="w-9 h-9 bg-primary-500 rounded-xl flex items-center justify-center text-white font-black text-sm uppercase">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="text-left hidden sm:block">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Mon Compte</p>
                                    <p class="text-xs font-bold text-slate-700 leading-none">{{ Str::limit(Auth::user()->name, 10) }}</p>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-2xl rounded-[1.5rem] p-2 mt-2">
                                <li>
                                    @if(Auth::user()->role === 'admin')
                                        <a class="dropdown-item rounded-xl py-2.5 font-bold text-primary-500 bg-primary-50 mb-1" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-pie me-2"></i> Dashboard Admin</a>
                                    @elseif(Auth::user()->role === 'boutique')
                                        <a class="dropdown-item rounded-xl py-2.5 font-bold text-orange-500 bg-orange-50 mb-1" href="{{ route('boutique.dashboard') }}"><i class="fas fa-store me-2"></i> Ma Boutique</a>
                                    @endif
                                </li>
                                @if(Auth::user()->role === 'client' && !Auth::user()->boutique)
                                    <li><a class="dropdown-item rounded-xl py-2.5 font-bold text-primary-600" href="{{ route('boutique.register') }}"><i class="fas fa-plus-circle me-2"></i> Devenir Vendeur</a></li>
                                @endif
                                <li><a class="dropdown-item rounded-xl py-2.5 text-sm font-medium" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2 opacity-50"></i> Mon Profil</a></li>
                                <li><a class="dropdown-item rounded-xl py-2.5 text-sm font-medium" href="{{ route('client.commandes') }}"><i class="fas fa-box me-2 opacity-50"></i> Mes Commandes</a></li>
                                <li><hr class="dropdown-divider opacity-5 my-2"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item rounded-xl py-2.5 text-sm font-bold text-rose-500 hover:bg-rose-50"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-black text-primary-500 hover:text-primary-600 transition-colors uppercase tracking-widest">Connexion</a>
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-primary-500 text-white text-sm font-black rounded-2xl hover:bg-primary-600 transition-all shadow-lg shadow-primary-500/20 uppercase tracking-widest">S'inscrire</a>
                        </div>
                    @endauth
                    
                    <!-- Mobile Menu Toggle -->
                    <button class="p-2.5 bg-slate-100 rounded-2xl text-slate-600 lg:hidden border-0" data-bs-toggle="collapse" data-bs-target="#mobileNav">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Secondary Nav (Categories & Links) -->
        @if(!auth()->check() || auth()->user()->role === 'client' || request()->has('preview'))
        <nav class="border-t border-slate-100 hidden lg:block bg-white">
            <div class="container mx-auto px-4">
                <div class="flex items-center gap-10">
                    <div class="dropdown">
                        <button class="flex items-center gap-3 py-4 text-sm font-black uppercase tracking-[0.1em] text-slate-700 border-0 bg-transparent group" data-bs-toggle="dropdown">
                            <i class="fas fa-bars text-orange-500"></i> Toutes les catégories
                        </button>
                        <ul class="dropdown-menu border-0 shadow-2xl rounded-[1.5rem] p-3 mt-0 w-64 grid grid-cols-1 gap-1">
                            @if(isset($layoutCategories))
                                @foreach($layoutCategories as $cat)
                                    <li>
                                        <a class="dropdown-item rounded-xl py-2.5 text-sm font-semibold hover:bg-primary-50 hover:text-primary-600 flex items-center justify-between" 
                                           href="{{ route('shop', ['q' => $cat->libel_categorie]) }}">
                                            {{ $cat->libel_categorie }}
                                            <i class="fas fa-chevron-right text-[10px] opacity-0 group-hover:opacity-30"></i>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="flex items-center gap-8 h-full">
                        <a href="{{ url('/') }}" class="text-sm font-bold text-slate-600 hover:text-primary-500 transition-colors py-4 border-b-2 border-transparent hover:border-primary-500">Accueil</a>
                        <a href="{{ route('shop') }}" class="text-sm font-bold text-slate-600 hover:text-primary-500 transition-colors py-4 border-b-2 border-transparent hover:border-primary-500">Boutique</a>
                        <a href="{{ route('shop') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600 transition-colors py-4 border-b-2 border-transparent hover:border-orange-500">Ventes Flash <i class="fas fa-bolt ms-1"></i></a>
                        <a href="#" class="text-sm font-bold text-slate-600 hover:text-primary-500 transition-colors py-4 border-b-2 border-transparent hover:border-primary-500">Aide & Support</a>
                    </div>
                </div>
            </div>
        </nav>
        @endif

        <!-- Mobile Navigation Menu -->
        <div class="collapse lg:hidden bg-white border-t border-slate-100" id="mobileNav">
            <div class="p-6 space-y-4">
                @if(!auth()->check() || auth()->user()->role === 'client' || request()->has('preview'))
                <form action="{{ route('shop') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Rechercher..." class="w-full h-11 bg-slate-100 border-none rounded-xl px-4 text-sm">
                    <button type="submit" class="absolute right-3 top-2.5 text-slate-400"><i class="fas fa-search"></i></button>
                </form>
                <div class="flex flex-col gap-3">
                    <a href="{{ url('/') }}" class="font-bold text-slate-700 p-3 bg-slate-50 rounded-xl">Accueil</a>
                    <a href="{{ route('shop') }}" class="font-bold text-slate-700 p-3 hover:bg-slate-50 rounded-xl transition-colors">Boutique</a>
                    <a href="#" class="font-bold text-orange-500 p-3 hover:bg-orange-50 rounded-xl transition-colors">Ventes Flash</a>
                </div>
                @else
                <div class="p-4 bg-slate-50 rounded-2xl text-center">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Espace Professionnel</p>
                </div>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-primary-900 text-white pt-20 pb-10 mt-20 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-500 via-primary-500 to-orange-500"></div>
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Brand -->
                <div class="space-y-6">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-primary-500 shadow-lg">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <span class="text-2xl font-black tracking-tighter text-white">Ondigoci</span>
                    </a>
                    <p class="text-primary-100/60 text-sm leading-relaxed">
                        Ondigoci est votre marketplace de confiance en Côte d'Ivoire. Nous connectons les vendeurs locaux aux acheteurs exigeants.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-orange-500 transition-all group">
                            <i class="fab fa-facebook-f text-sm group-hover:scale-110"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-orange-500 transition-all group">
                            <i class="fab fa-twitter text-sm group-hover:scale-110"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-orange-500 transition-all group">
                            <i class="fab fa-instagram text-sm group-hover:scale-110"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h5 class="text-white font-black uppercase tracking-widest text-xs mb-8">Navigation Rapide</h5>
                    <ul class="space-y-4">
                        @if(!auth()->check() || auth()->user()->role === 'client' || request()->has('preview'))
                        <li><a href="{{ route('shop') }}" class="text-primary-100/60 hover:text-orange-500 text-sm transition-colors font-medium">Tous les produits</a></li>
                        <li><a href="#" class="text-primary-100/60 hover:text-orange-500 text-sm transition-colors font-medium">Ventes Flash</a></li>
                        <li><a href="#" class="text-primary-100/60 hover:text-orange-500 text-sm transition-colors font-medium">Devenir Vendeur</a></li>
                        @endif
                        <li><a href="#" class="text-primary-100/60 hover:text-orange-500 text-sm transition-colors font-medium">Centre d'aide</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h5 class="text-white font-black uppercase tracking-widest text-xs mb-8">Informations Légales</h5>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-primary-100/60 hover:text-orange-500 text-sm transition-colors font-medium">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-primary-100/60 hover:text-orange-500 text-sm transition-colors font-medium">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-primary-100/60 hover:text-orange-500 text-sm transition-colors font-medium">Mentions Légales</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h5 class="text-white font-black uppercase tracking-widest text-xs mb-8">Nous contacter</h5>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 group">
                            <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-all">
                                <i class="fas fa-phone-alt text-sm"></i>
                            </div>
                            <p class="text-primary-100/60 text-sm font-medium">+225 05 05 05 05 05</p>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-all">
                                <i class="fas fa-envelope text-sm"></i>
                            </div>
                            <p class="text-primary-100/60 text-sm font-medium">contact@ondigoci.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/5 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-primary-100/30 text-xs font-bold uppercase tracking-tighter">&copy; 2026 Ondigoci. Tous droits réservés.</p>
                <div class="flex gap-6">
                    <i class="fab fa-cc-visa text-2xl text-primary-100/20 hover:text-primary-100 transition-colors"></i>
                    <i class="fab fa-cc-mastercard text-2xl text-primary-100/20 hover:text-primary-100 transition-colors"></i>
                    <i class="fas fa-mobile-alt text-2xl text-primary-100/20 hover:text-primary-100 transition-colors"></i>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Instant Search Logic
        const searchInput = document.getElementById('instantSearch');
        const resultsBox = document.getElementById('searchResults');
        const resultsContent = document.getElementById('resultsContent');
        const viewAllBtn = document.getElementById('viewAllResults');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    resultsBox.classList.add('hidden');
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                let html = '';
                                data.forEach(item => {
                                    html += `
                                        <a href="${item.url}" class="flex items-center gap-3 p-3 hover:bg-slate-50 rounded-xl transition-colors group">
                                            <div class="w-12 h-12 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                                                <img src="${item.image}" class="w-full h-full object-contain p-1">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-bold text-slate-700 truncate group-hover:text-primary-500">${item.name}</p>
                                                <p class="text-xs font-black text-primary-500">${item.price}</p>
                                            </div>
                                            <i class="fas fa-chevron-right text-[10px] text-slate-300 group-hover:text-primary-500 transition-colors"></i>
                                        </a>
                                    `;
                                });
                                resultsContent.innerHTML = html;
                                viewAllBtn.href = `{{ route('shop') }}?q=${encodeURIComponent(query)}`;
                                resultsBox.classList.remove('hidden');
                            } else {
                                resultsContent.innerHTML = '<p class="p-4 text-sm text-slate-400 font-medium text-center">Aucun produit trouvé</p>';
                                resultsBox.classList.remove('hidden');
                            }
                        });
                }, 300);
            });

            // Close results when clicking outside
            document.addEventListener('click', function(e) {
                if (!document.getElementById('searchContainer').contains(e.target)) {
                    resultsBox.classList.add('hidden');
                }
            });
        }

        // Sticky Header Script
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header-sticky');
            if (window.scrollY > 50) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        });

        // Universal Toast Notification
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('universal-toast-container');
            if (!toastContainer) return;

            const toastId = 'toast-' + Date.now();
            const bgColor = type === 'success' ? 'bg-emerald-500' : 'bg-rose-500';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            const toastHtml = `
                <div id="${toastId}" class="flex items-center gap-4 ${bgColor} text-white px-6 py-4 rounded-2xl shadow-2xl mb-4 animate-bounce-in min-w-[300px]">
                    <i class="fas ${icon} text-xl"></i>
                    <div class="flex-1">
                        <p class="text-sm font-black tracking-tight">${message}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-white/50 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);
            setTimeout(() => {
                const toast = document.getElementById(toastId);
                if (toast) toast.remove();
            }, 4000);
        }

        // Standardized AddToCart
        function addToCart(productId) {
            @guest
                showToast('Veuillez vous connecter pour ajouter au panier', 'error');
                setTimeout(() => window.location.href = '{{ route("login") }}', 1500);
                return;
            @endguest

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ id_produit: productId, quantite: 1 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const badge = document.getElementById('cart-badge');
                    if (badge) {
                        badge.textContent = data.cartCount;
                        badge.classList.add('scale-125');
                        setTimeout(() => badge.classList.remove('scale-125'), 300);
                    }
                    showToast('Produit ajouté au panier !');
                } else {
                    showToast(data.message || 'Erreur lors de l\'ajout', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Une erreur est survenue', 'error');
            });
        }

        // Notification Badge Update
        function updateNotificationBadge() {
            @auth
                @if(Auth::user()->role === 'client')
                    fetch('{{ route('client.notifications.data') }}')
                        .then(response => response.json())
                        .then(data => {
                            const badge = document.getElementById('notificationBadge');
                            if (badge) {
                                if (data.count > 0) {
                                    badge.style.display = 'block';
                                } else {
                                    badge.style.display = 'none';
                                }
                            }
                        });
                @endif
            @endauth
        }

        document.addEventListener('DOMContentLoaded', updateNotificationBadge);
        setInterval(updateNotificationBadge, 30000);
    </script>

    <!-- Toast Container -->
    <div id="universal-toast-container" class="fixed top-8 left-1/2 -translate-x-1/2 z-[9999] flex flex-col items-center"></div>

    <style>
        @keyframes bounce-in {
            0% { transform: translateY(-20px) scale(0.9); opacity: 0; }
            50% { transform: translateY(10px) scale(1.05); opacity: 1; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }
        .animate-bounce-in {
            animation: bounce-in 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    </style>
    
    @yield('scripts')
</body>
</html>