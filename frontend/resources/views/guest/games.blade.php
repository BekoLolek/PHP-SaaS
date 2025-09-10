
@extends('../layouts.app')

@section('content')
    <h2>All Games</h2>
    <ul id="games-list">
        <!-- Games will be populated here -->
    </ul>

    <script>
        async function loadGames() {
            try {
                const response = await fetch('/api/games'); // Your API endpoint
                const data = await response.json();
                const list = document.getElementById('games-list');
                list.innerHTML = '';

                data.data.games.forEach(game => {
                    const li = document.createElement('li');
                    li.textContent = `${game.name} (ID: ${game.id})`;
                    list.appendChild(li);
                });
            } catch (err) {
                console.error('Failed to load games', err);
            }
        }

        document.addEventListener('DOMContentLoaded', loadGames);
    </script>
@endsection
