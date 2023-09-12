# Task
Do refactoring of 
```/beforeRefactoring/app.php```

# Docker

You could use Docker for run application.
Folder _infrastructure contains docker configuration

```
cd _infrastructure
docker compose build
docker compose up -d
docker compose exec php bash
```

# Run application

```
php index.php input.txt
```

# Run tests

Just one test for example.
I will provide wider tests coverage upon request.

```
./vendor/bin/phpunit test
```
