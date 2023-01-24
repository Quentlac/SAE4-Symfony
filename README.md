# Installation de app-stages

Pour installer l'application sur une machine disposant de :
- PHP version >=7.2.5
- Postgres en local sur le port 5432

suivre les étapes suivantes :

## Installer composer et symfony CLI sur votre machine
https://symfony.com/doc/5.4/setup.html

##  Créer une application "webapp" symfony version 5.4
symfony new app-stages --version=5.4 --webapp

##  Cloner le dépôt GitLab dans le répertoire app-stages
https://gricad-gitlab.univ-grenoble-alpes.fr/iut2-info/sa-4-a/bo-stages

##  Se positionner dans le répertoire du projet
cd app-stages

##  Installer les packages supplémentaires requis (api-platform, lexik-jwt)
composer update

## Si Linux (ou Mac ?), installer le package acl (apt install acl) et donner les bons droits sur les clés SSL :
- setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
- setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt

##  Créer une base Postgres appelée app-stages pour un utilisateur app-stages de mot de passe app-stages
Vérifier que c'est cohérent avec la variable **DATABASE_URL** dans le fichier **.env** (Postgres en local sur le port 5432)

##  Peupler la base de données
Dans pg_admin, restaurer la base **app-stages** à partir du fichier **dump_BD.sql**

##  Lancer le serveur de dev de symfony
symfony server:start -no-tls -d

##  Naviguer vers l'application 
http://localhost:8000/

##  Connexion
L'administrateur a le login **fontenae**, mot de passe : **eric**
Les étudiants créés par défaut ont pour mot de passe leur **prenom** (sans majuscule mais avec les accents sauf sur le 1er car.)

##  Consulter la doc de l'API REST (et la tester !)
http://localhost:8000/api/

## Tester l'API REST avec Postman : 2 exemples proposés (authentification et GET etudiants)
Le fichier exemples-requetes-API...json est une collection de requêtes à charger depuis PostMan

##  A la fin, arrêter le serveur
symfony server:stop