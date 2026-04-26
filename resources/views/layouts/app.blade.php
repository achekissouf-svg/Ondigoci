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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header Top - White section with logo and search */
        .header-top {
            background-color: #fff;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 28px;
            font-weight: 700;
            color: #1e5a9e;
        }

        .logo-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .search-bar-container {
            position: relative;
            flex: 1;
            max-width: 500px;
        }

        .search-bar-container input {
            width: 100%;
            padding: 12px 50px 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-bar-container input:focus {
            border-color: #ff6b35;
        }

        .search-bar-container button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: #ff6b35;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-bar-container button:hover {
            background: #e55a28;
        }

        .auth-section {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .auth-section a {
            color: #1e5a9e;
            text-decoration: none;
            transition: color 0.3s;
        }

        .auth-section a:hover {
            color: #ff6b35;
        }

        /* Navigation Bar - Blue section */
        .navbar-main {
            background: linear-gradient(135deg, #1e5a9e, #2d6db5);
            padding: 0;
        }

        .navbar-main .navbar-nav .nav-link {
            color: white !important;
            padding: 15px 20px;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .navbar-main .navbar-nav .nav-link:hover,
        .navbar-main .navbar-nav .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
        }

        .navbar-main .navbar-nav .nav-link.home-btn {
            background: #ff6b35;
        }

        .navbar-main .navbar-nav .nav-link.home-btn:hover {
            background: #e55a28;
        }

        /* Dropdown styling */
        .navbar-main .dropdown-menu {
            background: white;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .navbar-main .dropdown-item {
            color: #333;
            padding: 10px 20px;
        }

        .navbar-main .dropdown-item:hover {
            background: #f5f5f5;
            color: #1e5a9e;
        }

        /* Card hover effects */
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        }

        /* Footer */
        .footer-main {
            background: linear-gradient(135deg, #1a4d7e, #1e5a9e);
            color: white;
            padding: 50px 0 20px;
            margin-top: 60px;
        }

        .footer-main h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .footer-main a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-main a:hover {
            color: #ff6b35;
        }

        .footer-main .contact-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .footer-main .contact-info i {
            color: #ff6b35;
            font-size: 18px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: #ff6b35;
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            margin-top: 30px;
            text-align: center;
            color: rgba(255,255,255,0.7);
            font-size: 14px;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .logo-section {
                font-size: 22px;
            }
            
            .search-bar-container {
                max-width: 100%;
                margin: 10px 0;
            }
            
            .navbar-main .navbar-nav .nav-link {
                padding: 10px 15px;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Header Top Section -->
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-lg-3 col-md-12">
                    <a href="{{ url('/') }}" class="logo-section">
                        <div class="logo-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <span>ndigoci</span>
                    </a>
                </div>
                
                <div class="col-lg-6 col-md-8">
                    <form class="search-bar-container" id="searchForm" action="{{ route('shop') }}" method="GET" onsubmit="handleSearch(event)">
                        <input type="text" id="searchInput" name="q" placeholder="Rechercher des produits ou catégories..." autocomplete="off">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                
                <div class="col-lg-3 col-md-4">
                    <div class="auth-section justify-content-end align-items-center">
                        @auth
                            <a href="{{ route('cart.index') }}" class="position-relative me-4" style="color: #1e5a9e; font-size: 1.3rem; transition: color 0.3s;" onmouseover="this.style.color='#ff6b35'" onmouseout="this.style.color='#1e5a9e'">
                                <i class="fas fa-shopping-cart"></i>
                                <span id="cart-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm" style="font-size: 0.65rem; padding: 0.25em 0.5em;">
                                    {{ Auth::user()->paniers()->sum('quantite') ?: 0 }}
                                </span>
                            </a>
                            <i class="fas fa-user ms-2"></i>
                            <span>{{ Auth::user()->name }}</span>
                        @else
                            <i class="fas fa-user"></i>
                            <span>Compte</span>
                            <a href="{{ route('login') }}">Connexion</a>
                            <span>/</span>
                            <a href="{{ route('register') }}">Inscription</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-main">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link home-btn" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop') }}">Tous nos produits</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown">
                            Catégories
                        </a>
                        <ul class="dropdown-menu">
                            @if(isset($layoutCategories))
                                @foreach($layoutCategories as $cat)
                                    <li><a class="dropdown-item" href="{{ route('shop', ['q' => $cat->libel_categorie]) }}">{{ $cat->libel_categorie }}</a></li>
                                @endforeach
                            @else
                                <li><a class="dropdown-item" href="#">Aucune catégorie</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop') }}">Ventes Flash</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="@auth{{ route('client.commandes') }}@else#@endauth">Suivi de commande</a>
                    </li>
                    @auth
                        @if(Auth::user()->role === 'client')
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('client.notifications') }}" id="notificationBell" title="Notifications" style="font-size: 1.2rem;">
                                <i class="fas fa-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle" id="notificationBadge" style="display: none; width: 12px; height: 12px;"></span>
                            </a>
                        </li>
                        @endif
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link" href="#">Centre d'aide</a>
                    </li>
                    @auth
                    <li class="nav-item dropdown ms-auto">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> Mon Compte
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                @if(Auth::user()->role === 'admin')
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-pie text-primary"></i> Panneau Admin</a>
                                @elseif(Auth::user()->role === 'boutique')
                                    <a class="dropdown-item" href="{{ route('boutique.dashboard') }}"><i class="fas fa-store text-success"></i> Ma Boutique</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-desktop text-muted"></i> Mon Compte</a>
                                    @if(!Auth::user()->boutique)
                                        <a class="dropdown-item fw-bold text-primary" href="{{ route('boutique.register') }}"><i class="fas fa-plus-circle"></i> Ouvrir ma boutique</a>
                                    @endif
                                @endif
                            </li>
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.commandes.index') }}"><i class="fas fa-receipt text-primary"></i> Commandes reçues</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i class="fas fa-users text-secondary"></i> Gérer les clients</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.boutiques.index') }}"><i class="fas fa-store text-warning"></i> Gérer les boutiques</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.produits.index') }}"><i class="fas fa-box text-success"></i> Mon Stock (Admin)</a></li>
                            @elseif(Auth::user()->role === 'boutique')
                                <li><a class="dropdown-item" href="{{ route('boutique.commandes.index') }}"><i class="fas fa-receipt text-primary"></i> Commandes reçues</a></li>
                                <li><a class="dropdown-item" href="{{ route('boutique.produits.index') }}"><i class="fas fa-box text-success"></i> Gérer mes produits</a></li>
                            @else
                                {{-- Client uniquement --}}
                                <li><a class="dropdown-item" href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart text-primary"></i> Mon Panier</a></li>
                                <li><a class="dropdown-item" href="{{ route('client.commandes') }}"><i class="fas fa-box text-secondary"></i> Mes Commandes</a></li>
                            @endif
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user text-muted"></i> Mon Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5>À Propos d'Ondigoci</h5>
                    <p style="color: rgba(255,255,255,0.8); line-height: 1.6;">
                        Ondigoci est votre marketplace de confiance pour tous vos achats en ligne. 
                        Livraison rapide et sécurisée partout en Côte d'Ivoire.
                    </p>
                </div>
                
                <div class="col-md-3 mb-4">
                    <h5>Liens Utiles</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">À propos</a></li>
                        <li class="mb-2"><a href="#">Conditions d'utilisation</a></li>
                        <li class="mb-2"><a href="#">Politique de confidentialité</a></li>
                        <li class="mb-2"><a href="#">Politique de retour</a></li>
                        <li class="mb-2"><a href="#">FAQ</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3 mb-4">
                    <h5>Contactez-nous</h5>
                    <div class="contact-info">
                        <i class="fas fa-phone"></i>
                        <span>+225 05 05 05 05 05</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-envelope"></i>
                        <span>contact@ondigoci.com</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Abidjan, Côte d'Ivoire</span>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <h5>Suivez-nous</h5>
                    <div class="social-links">
                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p class="mb-0">&copy; 2026 Ondigoci. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Handle search form submission
        function handleSearch(event) {
            const searchInput = document.getElementById('searchInput');
            const query = searchInput.value.trim();
            
            if (query === '') {
                event.preventDefault();
                alert('Veuillez entrer un terme de recherche');
                return false;
            }
            
            // Allow form submission with the search query
            return true;
        }

        // Add event listeners for better UX
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            
            // Focus and blur effects
            searchInput.addEventListener('focus', function() {
                this.style.borderColor = '#ff6b35';
                this.style.boxShadow = '0 0 8px rgba(255, 107, 53, 0.3)';
            });
            
            searchInput.addEventListener('blur', function() {
                this.style.borderColor = '#e0e0e0';
                this.style.boxShadow = 'none';
            });
            
            // Auto-submit on Enter key
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('searchForm').submit();
                }
            });
        });

        // Charger les notifications automatiquement
        @auth
            @if(Auth::user()->role === 'client')
            function loadNotifications() {
                fetch('{{ route('client.notifications.data') }}')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('notificationBadge');
                        if (data.count > 0) {
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Erreur chargement notifications:', error));
            }
            
            // Charger au démarrage
            loadNotifications();
            
            // Rafraîchir toutes les 10 secondes
            setInterval(loadNotifications, 10000);
            @endif
        @endauth
    </script>
    
    @yield('scripts')
</body>
</html>