<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test des routes - TCGalaxy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Test des routes TCGalaxy</h1>
        <div class="alert alert-success">
            Si vous voyez cette page, les routes web fonctionnent correctement!
        </div>

        <h2 class="mt-4">Routes disponibles</h2>
        <ul class="list-group mt-3">
            <li class="list-group-item">
                <a href="/" class="d-block">Page d'accueil</a>
                <small class="text-muted">La page d'accueil principale du site</small>
            </li>
            <li class="list-group-item">
                <a href="/events/find" class="d-block">Recherche d'événements</a>
                <small class="text-muted">Page de recherche géolocalisée d'événements</small>
            </li>
            <li class="list-group-item">
                <a href="/api/games" class="d-block" target="_blank">API: Liste des jeux</a>
                <small class="text-muted">Endpoint API pour récupérer la liste des jeux</small>
            </li>
            <li class="list-group-item">
                <a href="/api/events" class="d-block" target="_blank">API: Liste des événements</a>
                <small class="text-muted">Endpoint API pour récupérer la liste des événements</small>
            </li>
            <li class="list-group-item">
                <a href="/api/events/search?latitude=48.8566&longitude=2.3522&radius=50" class="d-block" target="_blank">API: Recherche d'événements</a>
                <small class="text-muted">Endpoint API pour la recherche géolocalisée (près de Paris)</small>
            </li>
        </ul>
        
        <h2 class="mt-4">Test de l'API</h2>
        <div class="card mt-3">
            <div class="card-body">
                <button id="testApi" class="btn btn-primary">Tester l'API Games</button>
                <div id="apiResult" class="mt-3">
                    <pre class="bg-light p-3 d-none" id="apiResultData"></pre>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('testApi').addEventListener('click', function() {
            fetch('/api/games')
                .then(response => response.json())
                .then(data => {
                    const resultElement = document.getElementById('apiResultData');
                    resultElement.textContent = JSON.stringify(data, null, 2);
                    resultElement.classList.remove('d-none');
                })
                .catch(error => {
                    const resultElement = document.getElementById('apiResultData');
                    resultElement.textContent = 'Erreur: ' + error.message;
                    resultElement.classList.remove('d-none');
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>