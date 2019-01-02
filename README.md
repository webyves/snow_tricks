# snow_tricks
Projet 6 du parcours DA PHP/Symfony de OpenClassrooms
- lien site hebergé : http://snow-tricks.ybernier.fr
- lien fichier Git : https://github.com/webyves/snow_tricks

# Code Validation
- [![Codacy Badge](https://api.codacy.com/project/badge/Grade/c1d986f543c544eba452b27d071c1eae)](https://www.codacy.com/app/webyves/snow_tricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=webyves/snow_tricks&amp;utm_campaign=Badge_Grade)
- liens vers analyse Codacy : https://app.codacy.com/project/webyves/snow_tricks/dashboard

# Installation Notes
1) Cloner le repository sur votre serveur
	- verifier la presence du fichier .htaccess dans le dossier {VOTRE_DOSSIER_DE_PROJET}/public
2) Importer le fichier SQL de votre choix sur votre base de donnée MySQL :
	- DB_MySQL_Install.sql est une base de donnée vierge
	- DB_MySQL_Demo.sql est une base de donnée avec un jeu de demo
3) faites pointer votre domaine (ou sous-domaine multisite) sur le dossier {VOTRE_DOSSIER_DE_PROJET}/public
4) Mettre a jour le fichier .env.local (situé a la racine) sur les lignes suivantes :
	- DATABASE_URL=mysql://db_login:db_password@db_server/db_name
	- MAILER_URL=null://localhost

# Patch Notes
