
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Leaderboard Showcase</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        @import "tailwindcss";
    </style>
    <script>
        function showPage(page) {
            const main = document.querySelector('main');
            main.innerHTML = '<p>Loading...</p>';

            switch(page) {
                case 'dashboard':
                    main.innerHTML = '<h2 class="text-2xl font-bold mb-2">Dashboard</h2><p>Welcome to the dashboard.</p>';
                    break;
                case 'games':
                    main.innerHTML = '<h2 class="text-2xl font-bold mb-2">Games</h2><p>Here will be the games list loaded from API.</p>';
                    break;
                case 'leaderboards':
                    main.innerHTML = '<h2 class="text-2xl font-bold mb-2">Leaderboards</h2><p>Leaderboards content.</p>';
                    break;
                case 'players':
                    main.innerHTML = '<h2 class="text-2xl font-bold mb-2">Players</h2><p>Player scores will be displayed here.</p>';
                    break;
                case 'manage':
                    main.innerHTML = '<h2 class="text-2xl font-bold mb-2">Manage</h2><p>Select an option from the submenu.</p>';
                    break;
                case 'manage_games':
                    main.innerHTML = '<h2 class="text-2xl font-bold mb-2">Manage Games</h2><p>Here you can add or delete games.</p>';
                    break;
                case 'manage_leaderboards':
                    main.innerHTML = '<h2 class="text-2xl font-bold mb-2">Manage Leaderboards</h2><p>Manage leaderboard actions here.</p>';
                    break;
                case 'manage_stats':
                    main.innerHTML = '<h2 class="text-2xl font-bold mb-2">Leaderboard Stats</h2><p>View statistics here.</p>';
                    break;
                case 'manage_api_keys':
                    main.innerHTML = '<h2 class="text-2xl font-bold mb-2">API Keys</h2><p>Generate new keys here.</p>';
                    break;
                default:
                    main.innerHTML = '<h2 class="text-2xl font-bold mb-2">Page not found</h2>';
            }
        }
    </script>
</head>
<body class="min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-gray-800 text-white p-4">
    <h1 class="text-xl font-bold">Game Leaderboard Showcase</h1>
</header>

<!-- Main layout: sidebar + content -->
<div class="flex flex-1">

    <!-- Sidebar / Navbar -->
    <nav class="w-64 bg-gray-200 p-4">
        <h3 class="font-bold mb-4">Menu</h3>
        <ul class="space-y-2">
            <li><a href="#" class="block p-2 rounded hover:bg-gray-300" onclick="showPage('dashboard')">Dashboard</a></li>
            <li><a href="#" class="block p-2 rounded hover:bg-gray-300" onclick="showPage('games')">Games</a></li>
            <li><a href="#" class="block p-2 rounded hover:bg-gray-300" onclick="showPage('leaderboards')">Leaderboards</a></li>
            <li><a href="#" class="block p-2 rounded hover:bg-gray-300" onclick="showPage('players')">Players</a></li>

            @if(session('logged_in'))
                <li>
                    <a href="#" class="block p-2 rounded hover:bg-gray-300" onclick="showPage('manage')">Manage ▼</a>
                    <ul class="pl-4 mt-1 space-y-1">
                        <li><a href="#" class="block p-1 rounded hover:bg-gray-300" onclick="showPage('manage_games')">Games</a></li>
                        <li><a href="#" class="block p-1 rounded hover:bg-gray-300" onclick="showPage('manage_leaderboards')">Leaderboards</a></li>
                        <li><a href="#" class="block p-1 rounded hover:bg-gray-300" onclick="showPage('manage_stats')">Stats</a></li>
                        <li><a href="#" class="block p-1 rounded hover:bg-gray-300" onclick="showPage('manage_api_keys')">API Keys</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>

    <!-- Main content area -->
    <main class="flex-1 p-4">
        @yield('content')
    </main>

</div>

<!-- Footer -->
<footer class="bg-gray-800 text-white p-4 text-center mt-auto">
    &copy; 2025 Game Leaderboard
</footer>

</body>
</html>
