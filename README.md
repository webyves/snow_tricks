# snow_tricks
Projet 6 du parcours DA PHP/Symfony de OpenClassrooms
- lien site hebergé : http://snow-tricks.ybernier.fr
- lien fichier Git : https://github.com/webyves/snow_tricks

# Code Validation
- [![SymfonyInsight](https://insight.symfony.com/projects/942fd9bd-7bb3-4aa6-a49f-ba6fa6f30daa/big.svg)](https://insight.symfony.com/projects/942fd9bd-7bb3-4aa6-a49f-ba6fa6f30daa)
- [![Codacy Badge](https://api.codacy.com/project/badge/Grade/c1d986f543c544eba452b27d071c1eae)](https://www.codacy.com/app/webyves/snow_tricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=webyves/snow_tricks&amp;utm_campaign=Badge_Grade)
- liens vers analyse Codacy : https://app.codacy.com/project/webyves/snow_tricks/dashboard

# Installation Notes (SANS ACCES SSH)
1) Cloner le repository sur votre serveur
	- dé-zipper le fichier vendor.zip a la racine de votre dossier.
	- verifier la presence du fichier .htaccess dans le dossier {VOTRE_DOSSIER_DE_PROJET}/public
2) Importer le fichier SQL de votre choix sur votre base de donnée MySQL :
	- DB_MySQL_Install.sql est une base de donnée vierge
	- DB_MySQL_Demo.sql est une base de donnée avec un jeu de demo
3) faites pointer votre domaine (ou sous-domaine multisite) sur le dossier {VOTRE_DOSSIER_DE_PROJET}/public
4) Mettre a jour le fichier .env (situé a la racine) sur les lignes suivantes :
	- DB_HOST={VOTRE_SERVEUR_DATABASE}
	- DB_NAME={NOM_DE_VOTRE_DATABASE}
	- DB_USER={VOTRE_NOM_UTILISATEUR_DATABASE}
	- DB_PASSWORD={VOTRE_MOT_PASSE_DATABASE}

	- EMAIL_URL={VOTRE_SERVEUR_EMAIL}
	- EMAIL_PORT={VOTRE_PORT_DE_SERVEUR_EMAIL}  465 pour le SSL
	- EMAIL_ENCRYPTION={VOTRE_TYPE_DE_SECURITE_EMAIL}  SSL est le plus repandu
	- EMAIL_MODE={VOTRE_METHODE_CONNEXION_EMAIL}  login est le plus repandu
	- EMAIL_USERNAME={VOTRE_NOM_UTILISATEUR_EMAIL}
	- EMAIL_PASSWORD={VOTRE_MOT_PASSE_EMAIL}

	- ADMIN_CONTACT_EMAIL={EMAIL_DE_VOTRE_ADMINISTRATEUR}

	- CAPTCHA_SITE_KEY={VOTRE_CLEF_SITE_RECAPTCHA}
	- CAPTCHA_SECRET_KEY={VOTRE_CLEF_SECRETE_RECAPTCHA}

# Installation Notes (PAR SSH)
1) Cloner le repository sur votre serveur
2) verifiez et mettez a jour les informations dans le fichier .env
	- voir etape 4 de l'installation sans acces SSH pour plus d'infos
3) Utiliser composer pour installer et mettre a jour les composant avec la commande 
	- composer install
4) Créer la base de donnée et mettez la a jour avec les commandes
	- php bin/console doctrine:database:create
	- php bin/console doctrine:migrations:migrate
5) envoyer les fixtures
	- php bin/console hautelook:fixture:load
6) lancer votre serveur :
	- en local executez la commande : php bin/console server:run
	- en ligne : voir etape 3 installation sans SSH puis rendez vous sur votre http://addresse.de.monsite.fr


# Patch Notes
