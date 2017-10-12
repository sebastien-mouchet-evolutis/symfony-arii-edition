Migration
=========

Documentation: http://symfony.com/doc/current/doctrine/multiple_entity_managers.html

Configuration
-------------

Fichier config.yml:
 doctrine:
     dbal:
         default_connection: default
         connections:
             default:
                 driver:   "%database_driver%"
                 host:     "%database_host%"
                 port:     "%database_port%"
                 dbname:   "%database_name%"
                 user:     "%database_user%"
                 password: "%database_password%"
                 charset:  UTF8
             local:
                 driver:   pdo_mysql
                 host:     127.0.0.1
                 port:     3306
                 dbname:   arii
                 user:     root
                 password: null
                 charset:  UTF8                
     orm:
         auto_generate_proxy_classes: "%kernel.debug%"
         entity_managers:
             default:
                 auto_mapping: true        
             local:
                 connection: local

Commande en ligne
-----------------

Exemple pour une mise à jour
 php bin/console doctrine:schema:update --force --em=local

Urls de migration
-----------------
/migration/job.html


