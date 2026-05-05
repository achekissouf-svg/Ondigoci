<!DOCTYPE html>
<html lang="fr" class="bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ondigoci - Espace Administration</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS (For compatibility with existing views) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
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
                            500: '#ff6b35',
                            600: '#e55a28',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e5a9e 0%, #0f3a63 100%);
        }
    </style>
</head>
<body class="text-gray-800 antialiased h-screen flex overflow-hidden selection:bg-primary-500 selection:text-white">

    <!-- Sidebar -->
    <aside class="w-72 sidebar-gradient text-white flex flex-col hidden md:flex shadow-2xl transition-all duration-300 relative z-20">
        <!-- Logo -->
        <div class="h-20 flex items-center px-8 border-b border-white/10 relative z-10">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white shadow-lg shadow-orange-500/20 group-hover:scale-110 transition-transform">
                    <i class="fas fa-handshake"></i>
                </div>
                <span class="text-2xl font-black tracking-tighter text-white">Ondigoci</span>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-8 space-y-1.5 overflow-y-auto custom-scrollbar relative z-10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-5 py-3.5 rounded-xl {{ Request::routeIs('admin.dashboard') ? 'bg-white text-primary-500 shadow-xl shadow-black/20 font-bold' : 'text-blue-100 hover:bg-white/10' }} transition-all duration-300 group">
                <i class="fas fa-grid-2 w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span>Tableau de bord</span>
            </a>
            
            <p class="px-5 pt-6 pb-2 text-[10px] font-black text-blue-300/50 uppercase tracking-[0.2em]">Opérations</p>

            <a href="{{ route('admin.monetization.index') }}" class="flex items-center gap-3 px-6 py-3.5 rounded-2xl {{ Request::routeIs('admin.monetization.index') ? 'bg-amber-400 text-white shadow-lg shadow-amber-400/30' : 'text-blue-100 hover:bg-white/10' }} transition-all group">
                <i class="fas fa-star text-lg group-hover:rotate-12 transition-transform"></i>
                <span class="font-bold">Monétisation</span>
            </a>

            <a href="{{ route('admin.monetization.payments') }}" class="flex items-center gap-3 px-6 py-3.5 rounded-2xl {{ Request::routeIs('admin.monetization.payments') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/30' : 'text-blue-100 hover:bg-white/10' }} transition-all group">
                <i class="fas fa-file-invoice-dollar text-lg group-hover:rotate-12 transition-transform"></i>
                <span class="font-bold">Validation Paiements</span>
            </a>

            <a href="{{ route('admin.verifications.index') }}" class="flex items-center gap-3 px-6 py-3.5 rounded-2xl {{ Request::routeIs('admin.verifications.index') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'text-blue-100 hover:bg-white/10' }} transition-all group">
                <i class="fas fa-user-shield text-lg group-hover:rotate-12 transition-transform"></i>
                <span class="font-bold">Vérification Boutiques</span>
            </a>



            <a href="{{ route('admin.commandes.index') }}" class="flex items-center gap-3 px-5 py-3 rounded-xl {{ Request::routeIs('admin.commandes.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'text-blue-100 hover:bg-white/10' }} transition-all group">
                <i class="fas fa-receipt w-5 text-center group-hover:rotate-12 transition-transform"></i>
                <span class="font-medium">Commandes</span>
            </a>

            <a href="{{ route('admin.produits.index') }}" class="flex items-center gap-3 px-5 py-3 rounded-xl {{ Request::routeIs('admin.produits.*') ? 'bg-white/10 text-white' : 'text-blue-100 hover:bg-white/10' }} transition-all">
                <i class="fas fa-box w-5 text-center opacity-70"></i>
                <span class="font-medium">Stock / Produits</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-5 py-3 rounded-xl {{ Request::routeIs('admin.categories.*') ? 'bg-white/10 text-white' : 'text-blue-100 hover:bg-white/10' }} transition-all">
                <i class="fas fa-tags w-5 text-center opacity-70"></i>
                <span class="font-medium">Catégories</span>
            </a>

            <p class="px-5 pt-6 pb-2 text-[10px] font-black text-blue-300/50 uppercase tracking-[0.2em]">Utilisateurs</p>

            <a href="{{ route('admin.boutiques.index') }}" class="flex items-center gap-3 px-5 py-3 rounded-xl {{ Request::routeIs('admin.boutiques.*') ? 'bg-white/10 text-white' : 'text-blue-100 hover:bg-white/10' }} transition-all">
                <i class="fas fa-store w-5 text-center opacity-70"></i>
                <span class="font-medium">Boutiques</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-5 py-3 rounded-xl {{ Request::routeIs('admin.users.*') ? 'bg-white/10 text-white' : 'text-blue-100 hover:bg-white/10' }} transition-all">
                <i class="fas fa-users w-5 text-center opacity-70"></i>
                <span class="font-medium">Clients</span>
            </a>

            <p class="px-5 pt-6 pb-2 text-[10px] font-black text-blue-300/50 uppercase tracking-[0.2em]">Modération</p>

            <a href="{{ route('admin.avis.index') }}" class="flex items-center gap-3 px-5 py-3 rounded-xl {{ Request::routeIs('admin.avis.*') ? 'bg-white/10 text-white' : 'text-blue-100 hover:bg-white/10' }} transition-all">
                <i class="fas fa-star w-5 text-center opacity-70"></i>
                <span class="font-medium">Avis Clients</span>
            </a>
        </nav>

        <!-- User Info -->
        <div class="p-6">
            <div class="flex items-center gap-3 px-4 py-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center text-white font-bold shadow-lg shadow-orange-500/20">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] font-black text-blue-300 uppercase tracking-widest">Admin Panel</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col w-full h-full bg-white relative">
        <!-- Subtle Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%231e5a9e\' fill-opacity=\'0.02\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] z-0"></div>
        
        <!-- Navbar -->
        <header class="h-20 glass z-30 sticky top-0 flex items-center justify-between px-10 border-b border-slate-200/60">
            <div class="flex items-center">
                <button class="md:hidden text-slate-500 hover:text-primary-500 mr-4">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="flex flex-col">
                    <h1 class="font-black text-slate-900 text-xl tracking-tight">@yield('header_title', 'Administration')</h1>
                    <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Système en ligne
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <a href="{{ url('/?preview=1') }}" target="_blank" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-[10px] font-black text-slate-600 hover:text-white hover:bg-primary-500 hover:border-primary-500 transition-all shadow-sm">
                    <i class="fas fa-external-link-alt"></i> 
                    <span class="hidden sm:inline">VOIR LE SITE</span>
                </a>
                <div class="h-8 border-l border-slate-200"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-11 h-11 rounded-xl bg-white shadow-sm border border-slate-200 text-slate-400 hover:text-white hover:bg-rose-500 hover:border-rose-500 transition-all group" title="Déconnexion">
                        <i class="fas fa-power-off group-hover:rotate-90 transition-transform"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8 z-10 relative">
            <div class="max-w-7xl mx-auto">
                @if (session('success'))
                    <div class="mb-8 p-4 rounded-2xl glass border-l-4 border-green-500 text-green-800 flex items-center shadow-lg shadow-green-500/10 animate-in fade-in slide-in-from-top-4 duration-300">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-check text-green-600 text-sm"></i>
                        </div>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-8 p-4 rounded-2xl glass border-l-4 border-red-500 text-red-800 flex items-center shadow-lg shadow-red-500/10 animate-in fade-in slide-in-from-top-4 duration-300">
                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-600 text-sm"></i>
                        </div>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
