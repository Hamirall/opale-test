# Opale

## Back

### Installation

```bash
docker compose up -d
```

Dans le container exécuter la commande suivante pour créer la base de données et ajotuer les données

Tout est déjá configuré dans le fichier .env (normalement je ne pousse pas, c'est juste pour le test)

```bash
php php bin/console doctrine:database:create
```

```bash
php bin/console d:m:m
```

```bash
php bin/console app-import-recall
```

### Usage
Exposé sur le port 80 via un reverse proxy traefik

## Front

### Installation

```bash
yarn install && yarn dev
```

l'application est exposée sur le port 3000 par défaut.
En générel pour le front je ne fais pas de docker pour le dev, donc il si vous n'avez pas de nodejs sur votre machine, il faudra l'installer ou utiliser un container docker pour le dev.


Bon test
