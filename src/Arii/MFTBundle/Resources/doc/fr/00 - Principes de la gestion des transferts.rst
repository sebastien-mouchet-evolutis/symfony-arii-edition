Principes de la gestion des transferts
======================================

Il existe de nombreux [outils de transferts de fichiers](https://en.wikipedia.org/wiki/Comparison_of_FTP_client_software) mais peu sont open source et capables de couvrir un large périmètre. Une solution pérenne est généralement de s'appuyer sur plusieurs outils pour répondre à l'ensemble des besoins mais l'inconvénient est l'obligation de maitriser ces différents outils, le but premier est donc d'offrir une interface générique pour la majorité des outils.

Besoin
------

Pour suivre des transferts de fichiers, il est nécessaire de disposer des éléments suivants:
- un référentiel contenant les informations nécessaires aux transferts
- un état des transferts pour le suivi en temps réel
- un historique pour compléter les informations du suivi

Par rapport à ces éléments, on considère le transfert lui-même:
- le client apte à dialoguer avec le protocole du serveur
- éventuellement un serveur ou un systême point à point
- les paramètres de connexion pour ce transfert

Le client dépend de l'opération a effectuer et de la façon de l'effectuer:
- Opération: copie, déplacement, suppression, création...
- Protocoles: ftp, sftp, copie... mais aussi stmp, imap...

Cette dernière partie doit s'intégrée, à la manière d'un plugin, dans un système générique qui renvoie une vue fonctionnelle.

Architecture
------------
Prenons l'exemple de Jade qui propose un client utilisant un référentiel au format ini ou xml et générant un fichier csv pour historiser les exzcutions de transferts dans une base de données à travers un JobScheduler. La brique de transfert est intéressante car elle permet en soi d'intégrer des modules pour différents protocoles mais le manque de référentiel ne permet pas une vue globale, de plus l'historisation des exécutions est insuffisante car un transfert manquant ne sera pas remonté sur la console.

<ditaa name="jade">
+-------+ +--------------------------------------------+
|       | |                 Module MFT                 |
| Ari'i | +---------------------+----------------------+
|       | |    MFT (Export)     |     MFT (Import)     | 
+-------+ +--------*------------+----------------------+
                   |                              ^  
                   v                              | 
          +---------------+              +--------*--------+
          | Configuration |--> Client -->| Fichier Journal |
          +---------------+              +-----------------+
</ditaa>

L'intérêt est de toujours fournir à l'utilisateur une vue fonctionnelle de ses transferts quel que soit la technologie mise en place.

L'export peut tout aussi bien générer la ligne de commande complète, il suffit simplement de créer un nouveau modèle.

Connaître les définitions et les exécutions d'un transfert donne les moyens de comparer ce qui est attendu et ce qui est effectif.

Facteur
-------

Le transfert de fichiers est très proche du métier de facteur:
- il achemine une lettre ou un colis d'un expéditeur
- il peut livrer plusieurs lettres en une seule fois
- il garantit la livraison au destinataire
- il connaît les adresses de l'expéditeur 
- il peut éventuellement demander un accusé de réception
- il peut gérer des abonnements
- il ne connait pas le contenu des lettres 

On considérera donc les éléments suivants:
- le transfert est l'acheminement d'un ou plusieurs fichiers
- chaque transfert est liés à une connexion (host, port, user, password...)

Du point de vue Ari'i, on considère:
- l'abonnement qui est la demande de transferts
- la catégorie pour organiser les abonnements
- la livraison qui est l'exécution de l'abonnement
- le transfert qui est le détail de la livraison

Exécution
---------

- Le fichier de configuration est construit à partir des informations de la table MFT_TRANSFERS et ARII_CONNECTIONS.
- L'exécution génère un log qui est traité pour identifier les erreurs d'exécutions
- Chaque transfert est stocké dans la table MFT_HISTORY
- Chaque livrausns est stockée dans la table MFT_DELIVERIES.

Outils
======

Nous avons retenu les outils suivants:
- [Yade](http://www.sos-berlin/com) de SOS Berlin qui offre une configuration centralisée en .INI ou en fichier XML
- [cURL](http://curl.haxx.se) qui permet la gestion la plus complête des transferts montants et descendants en HTTP
- [FDT](http://monalisa.cern.ch/FDT/) qui signifie Fast Data Transfer qui offre une sécurité optimale pour le transfert

D'autres outils sont à l'étude et cette liste devrait évoluer dans la mesure où:
- ils sont open source et peuvent être distribués
- ils sont multi plateforme et fonctionnent indifféremment sur Unix et Windows
- ils offrent une sécurité et une fiabilité suffisante pour la production
 
