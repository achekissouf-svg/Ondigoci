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
    
    <!-- Tailwind CSS (via CDN for immediate rendering without build process if needed, or Vite if configured) -->
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
                            500: '#3b82f6',
                            600: '#2563eb',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="text-gray-800 antialiased h-screen flex overflow-hidden selection:bg-primary-500 selection:text-white">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col hidden md:flex shadow-2xl transition-all duration-300">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-xl font-bold tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-red-500 hover:from-white hover:to-white transition-all">
                <i class="fas fa-handshake text-orange-500"></i> Ondigoci
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-primary-600 text-white shadow-lg shadow-primary-500/30 transition-all hover:-translate-y-0.5">
                <i class="fas fa-chart-pie w-5"></i>
                <span class="font-medium">Tableau de bord</span>
            </a>
            
            <p class="px-4 pt-4 pb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Gestion</p>

            <a href="{{ route('admin.boutiques.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                <i class="fas fa-store w-5"></i>
                <span class="font-medium">Boutiques</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                <i class="fas fa-users w-5"></i>
                <span class="font-medium">Clients</span>
            </a>
            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                <i class="fas fa-newspaper w-5"></i>
                <span class="font-medium">Articles</span>
            </a>
        </nav>

        <!-- User Info -->
        <div class="border-t border-slate-800 p-4">
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-800/50">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-indigo-500 flex items-center justify-center text-white font-bold shadow-inner">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">Administrateur</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col w-full h-full bg-slate-50/50 relative">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50 z-0"></div>
        <!-- Navbar -->
        <header class="h-16 glass z-10 sticky top-0 flex items-center justify-between px-6 border-b border-slate-200/50">
            <div class="flex items-center">
                <button class="md:hidden text-slate-500 hover:text-slate-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="ml-4 font-semibold text-slate-800 text-lg">@yield('header_title', 'Administration')</h1>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" target="_blank" class="text-sm text-slate-500 hover:text-primary-600 font-medium transition-colors hidden sm:block">
                    <i class="fas fa-external-link-alt mr-1"></i> Voir le site
                </a>
                <div class="h-6 border-l border-slate-300 mx-2 hidden sm:block"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-10 h-10 rounded-full bg-white shadow-sm border border-slate-200 text-slate-500 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-all">
                        <i class="fas fa-power-off"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 z-10 relative">
            <div class="max-w-7xl mx-auto">
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl glass border-l-4 border-green-500 text-green-700 flex items-start shadow-sm transform transition-all">
                        <i class="fas fa-check-circle mt-0.5 mr-3 text-green-500"></i>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>
