Import
======

L'import des données est réalisé par l'envoi sur les urls d'import d'arii de fichiers conformes, c'est à dire respectant le format attendu. Une autre solution est de déposer le fichier dans l'espace de travail et d'appeler la même url. Cette deuxième option est généralement utilisée pour un mode debug ou lorsque les flux http ne sont pas autorisés entre la machine source et Arii.

Autosys
-------

Fichier local: workspace\Report\Import\ATS

# Jobs
Url: /post/ats/jobs

spooler
job_name
job_type
box_name
machine
user
command
description
application
env

# Executions
Url: /post/ats/event_demon

# Calendriers
Url: /post/ats/calendars

# Audit
Url: /post/ats/audit

Règles
------



Agrégations
-----------

/cron/run2rules.html
/cron/run2apps.html
/cron/run2jobs.html
/cron/run2rundays.html
/cron/runs2runmonths.html
/cron/job2rules.html
/cron/job2jobdays.html
/cron/jobs2jobmonths.html

Tableau de bord
---------------