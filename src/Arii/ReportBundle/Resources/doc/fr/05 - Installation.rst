Base de données
===============

Sensibilité à la casse pour MySQL

ALTER TABLE `report_job` MODIFY
`job_name` VARCHAR(128) 
CHARACTER SET utf8
COLLATE utf8_bin;
