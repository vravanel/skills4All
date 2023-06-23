# skills4All

### Installation

1. Clone le projet
2. Run `composer install`
3. Run `yarn install`
4. Run `yarn encore dev` 

# Database
1. Copiez le fichier env en .env.local
2. Renseignez le nom de votre base de donnée
3. php bin/console d:d:d -f (uniquement si la BDD n'a pas été créée)
4. php bin/console d:d:c
5. php bin/console d:m:m 
6. php bin/console d:f:l 

### Voir le site

1. Run `symfony server:start` 
2. Run `yarn run dev --watch` ou  `yarn dev-server` (pour avoir le refresh automatique )