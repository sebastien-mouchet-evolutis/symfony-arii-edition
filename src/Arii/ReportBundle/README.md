Rapports
========

> Ce module permet de créer, générer et publier des rapports [JasperReports](http://community.jaspersoft.com/project/jasperreports-library) en utilisant JobScheduler en tant que serveur Jasper.

Les configurations de rapport pouvaient être créées par un éditeur graphique nommé iReport qui est maintenant remplacé par JasperStudio.
La connexion à la base de données du JobScheduler est utilisée par défaut mais il est évidemment possible d'indiquer d'autres paramètres.

Installation
------------

### JobScheduler

La première étape consiste à configurer Jobcheduler pour qu'il prenne le rôle de serveur Jasper.

- On télécharge les bibliothèques nécessaire dans le projet [SourceForge JasperReports](http://sourceforge.net/projects/jasperreports/files/jasperreports/)
- On crée un répertoire __jasper__ dans le répertoire __lib__ de JobScheduler
- On copie les fichiers dans le répertoire __lib/jasper__
- On indique l'emplacement des jars dans le fichier __config/factory.ini__
```perl
class_path = ${SCHEDULER_HOME}/lib/pgsql/*.jar;${SCHEDULER_HOME}/lib/patches/*.jar;${SCHEDULER_HOME}/lib/user_lib/*.jar;${SCHEDULER_HOME}/lib/sos/*.jar;${SCHEDULER_HOME}/lib/3rd-party/*.jar;${SCHEDULER_HOME}/lib/jdbc/*.jar;${SCHEDULER_HOME}/lib/jasper/*.jar;${SCHEDULER_DATA}/config;${SCHEDULER_HOME}/lib/log/log4j/*.jar
```
*Sur Unix, il faudra remplacer les ; par des :*
- On redémarre le Jobscheduler pour prendre en compte la nouvelle configuration

A titre indicatif, le contenu de lib/jasper devrait contenir ces fichiers:
```
jasperreports-4.5.0.jar
commons-digester-1.7.jar
groovy-all-1.7.5.jar
iText-2.1.7.jar
jcommon-1.0.22.jar
jfreechart-1.0.12-LICENSE.txt
jfreechart-1.0.12.jar
poi-3.7-20101029.jar
```
*Ces fichiers dépendent de l'utilisation des objets inclus dans le rapport, cette liste n'est donc pas exhaustive.*

### Jobs 



__v1.5.0__


I've attached an Order-Job which uses JasperReports (see http://jasperreports.sourceforge.net) to create a report file from a report configuration.

The database connection of the Job Scheduler is used or alternatively a configurable database connection can be used to query report data.
This job supports the report formats PDF, HTML, RTF, XML and XLS.
See http://sourceforge.net/apps/mediawiki/jobscheduler/index.php?title=Job_JobSchedulerJasperReportJob

The job implementation is a little old. Please consider this only as release candidate.

For this you need additional jar files which are containing in the attachment.
Please edit the ./config/factory.ini

[java]
class_path              = ${SCHEDULER_HOME}/lib/ext/*.jar;${SCHEDULER_HOME}/lib/*.jar;${SCHEDULER_HOME}/lib/hibernate/*.jar

On Unix use ':' instead of ';' in the above class_path.

Copy the ./lib directory from the attachment to the ./lib directory of the JobScheduler installation and restart the JobScheduler.
Copy the ./jobs directory from the attachment to the ./jobs directory of the JobScheduler installation.
Copy the ./config directory from the attachment to the ./config directory of the JobScheduler installation.

You find only a MySQL example in ./config/jasperreports/example.
If you use another database then you must edit the SQL files in ./config/jasperreports/example.