#\!/bin/bash

# Démarrer le serveur Laravel et Vite en parallèle
echo "🚀 Démarrage du serveur de développement TCG HUB..."
echo "📦 Lancement du compilateur d'assets Vite..."
npm run dev &
VITE_PID=$\!

echo "🛠️ Lancement du serveur Laravel..."
php artisan serve

# Assurer que tous les processus sont arrêtés à la sortie
trap "kill $VITE_PID" EXIT
EOF < /dev/null