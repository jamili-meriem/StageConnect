#!/bin/bash
# docker/entrypoint.sh
set -e

echo "🚀 Démarrage de StageConnect..."

# Générer APP_KEY si absent
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Attendre MySQL (sécurité supplémentaire)
echo "⏳ Attente de la base de données..."
until php artisan migrate:status &>/dev/null; do
    sleep 2
done

# Migrations automatiques
echo "🗄️  Exécution des migrations..."
php artisan migrate --force

# Seeder en production si la table users est vide
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null || echo "0")
if [ "$USER_COUNT" = "0" ]; then
    echo "🌱 Initialisation des données de test..."
    php artisan db:seed --force
fi

# Storage link
echo "🔗 Création du lien storage..."
php artisan storage:link --force 2>/dev/null || true

# Cache pour la production
echo "⚡ Optimisation du cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ StageConnect prêt !"

# Démarrer Apache
exec apache2-foreground