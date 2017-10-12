Transferts de fichiers
======================

Le module de transferts de fichiers permet de définir, tester et suivre les déplacements ou copies de fichiers.

Un transfert est la copie d'un fichier d'un point de connexion à un autre. Un point de connexion est défini par les paramètres de connexions: 
- Serveur
- Utilisateur
- Mot de passe ou clé

Le point de connexion est défini par l'administrateur qui est garant de l'infrastructure, il fournit seulement le nom qui sera utilisé pour le transfert.


Pré-requis
----------
Modules:
- Core
- User

Installation
------------

## Creation de la base de données

    php app/console doctrine:schema:update --force

Releases
--------
__1.5__
