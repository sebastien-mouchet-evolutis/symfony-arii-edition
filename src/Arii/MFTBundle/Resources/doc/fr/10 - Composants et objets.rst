Composants et objets
====================

Les définitions d'un transfert sont stockées sur le portail, cela permet de s'affranchir d'outil utilisé pour le transfert aussi bien lors de la conception que pour le suivi. Le portail va créer les fichiers de configurations propres à l'outil et indiquer la ligne de commande pour une utilisation externe au portail.

Un transfert est l'ensemble des opérations nécessaires pour déplacer le lot de fichiers d'un point initial à un point final pour un partenaire.

Un transfert peut être traité en une seule opération mais il est généralement le résultat d'un ensemble de déplacements.

<dot name="schema">
ARII_CATEGORY   [label="Catégorie";color=blue]
ARII_CONNECTION [label="Connexions";color="color"]
subgraph clusterTRANSFER {
label=Définitions
 MFT_PARTNERS    [label="Partenaires"]
 MFT_TRANSFERS   [label="Transferts"]
 MFT_OPERATIONS  [label="Opérations"]
 MFT_PARAMETERS  [label="Paramètres"]
}
MFT_TRANSFERS ->  MFT_PARTNERS -> ARII_CATEGORY
MFT_OPERATIONS -> MFT_PARAMETERS
MFT_OPERATIONS -> ARII_CONNECTION
MFT_OPERATIONS -> MFT_TRANSFERS

subgraph clusterHISTORY {
label=Historisation
 MFT_HISTORY    [label="Historique"]
 MFT_DELIVERIES [label="Livraisons"]
 MFT_TRANSMISSIONS [label="Transmissions"]
}

MFT_HISTORY -> MFT_TRANSFERS
MFT_DELIVERIES -> MFT_OPERATIONS
MFT_DELIVERIES -> MFT_TRANSMISSIONS

MFT_STATUS [label="Statut"]
MFT_TRANSFERS -> MFT_STATUS -> MFT_HISTORY [style=dotted]
</dot>

Portail
-------

Le module de transfert de fichiers s'appuie sur Ari'i, il en utilise les tables mais il est nécessaire de disposer des droits suffisants pour modifier ces données.

### Connexions
La table des connexions est réservée à l'administrateur Infra et fait partie intégrante du noyau. Le transfert utilise les paramètres de connexion mais ne les redéfinit pas.

### Catégories
Les catégories permettent de classer les partenaires pour les intégrer dans le portail.
- Un partenaire peut être lié à une catégorie

Définitions
-----------
### Partenaires
Le partenaire regroupe les transferts pour un partenaire externe ou pour une application si il s'agit de déplacements internes.

### Transferts
Un transfert est défini par l'ensemble des opérations qui permettent de déplacer un lot de fichiers d'un point à nu autre.
- Un transfert est lié à un partenaire

### Opérations
L'opération est l'action exécutée sur une série de fichiers pour les déplacer d'un point à un autre. Elle indique la source, la cible, l'action (send, receive, copy...) et les paramètres.
- Une opération est liée à un transfert
- Une opération nécessite des connexions 

### Paramètres
Les paramètres du transfert sont propres au module MFT et définit les options génériques nécessaires aux échanges de fichiers.
- Les paramétrages est lié à une ou plusieurs opérations

### Planification (non implémentée)
Conserver les paramètres dans la base de données permet de suivre plus efficacement les transferts en comparant ce qui est attendu avec ce qui est exécuté.

Historisation
-------------

### Statut
Le statut relie un transfert à sa dernière exécution historisée.
- Le statut est lié à un transfert et à l'historique

### Historique
L'historique conserve les données d'exécution d'un transfert.
- L'historique est lié à un transfert

### Livraisons
Les livraisons conserve les données d'exécution d'une opération, il concerne l'ensemble des fichiers d'un lot.
- Une livraison est liée à son opération

### Transmission
La transmission conserve les données d'exécution du fichier d'un lot transféré.
- Une transmission est liés à une livraison.







