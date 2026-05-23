git init
git add artisan bootstrap config public storage tests composer.json composer.lock package.json package-lock.json phpunit.xml vite.config.js tailwind.config.js postcss.config.js README.md .editorconfig .env.example .gitattributes .gitignore
git commit -m "Initialize Laravel project structure and configs"

git add database app/Models
git commit -m "Add database migrations, seeders, and Eloquent models"

git add app/Http routes
git commit -m "Add controllers, middleware, and routing"

git add resources
git commit -m "Add views and frontend assets"

git add .
git commit -m "Add remaining application code and resources"

git branch -M main
git remote add origin https://github.com/SandeepAngala/sweetcrumbs.git
git push -u origin main
