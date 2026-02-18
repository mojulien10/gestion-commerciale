<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gestion Commerciale') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-base-200">
        <div class="min-h-screen">
            <!-- Navigation -->
            <div class="navbar bg-base-100 shadow-md sticky top-0 z-50">
                <div class="navbar-start">
                    <div class="dropdown">
                        <label tabindex="0" class="btn btn-ghost lg:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                            </svg>
                        </label>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a href="{{ route('dashboard') }}">📊 Dashboard</a></li>
                            <li><a href="{{ route('clients.index') }}">👥 Clients</a></li>
                            <li><a>📦 Produits</a></li>
                            <li><a>💰 Ventes</a></li>
                            <li><a>📈 Rapports</a></li>
                        </ul>
                    </div>
                    <a href="{{ route('dashboard') }}" class="btn btn-ghost normal-case text-xl">
                        <span class="font-bold text-primary">💼 Gestion Commerciale</span>
                    </a>
                </div>
                
                <div class="navbar-center hidden lg:flex">
                    <ul class="menu menu-horizontal px-1">
                        <li><a href="{{ route('dashboard') }}" class="btn btn-ghost">📊 Dashboard</a></li>
                        <li><a href="{{ route('clients.index') }}" class="btn btn-ghost">👥 Clients</a></li>
                        <li><a class="btn btn-ghost">📦 Produits</a></li>
                        <li><a class="btn btn-ghost">💰 Ventes</a></li>
                        <li><a class="btn btn-ghost">📈 Rapports</a></li>
                    </ul>
                </div>
                
                <div class="navbar-end">
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full bg-primary text-primary-content flex items-center justify-center">
                                <span class="text-lg font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </label>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                            <li class="menu-title">
                                <span>{{ Auth::user()->name }}</span>
                            </li>
                            <li><a href="{{ route('profile.edit') }}">⚙️ Paramètres</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left">🚪 Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-base-100 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="py-12">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>