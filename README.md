**Gestion des Inscriptions au Permis de Conduire avec Symfony**

Ce projet est une application Symfony développée pour une auto-école, permettant de gérer les inscriptions au permis de conduire. Les fonctionnalités principales incluent l'inscription des étudiants, la réservation des heures de conduite, la passation des tests pratiques, et le paiement des services.

**Installation**

Pour installer et exécuter ce projet localement, suivez ces étapes :

**---Cloner le projet :** git clone https://github.com/kaderboukar/Gestion-Auto-ecole.git

**---Installer les dépendances :** composer install

**---Configurer la base de données :**
Copiez le fichier .env.example en .env et configurez votre base de données.

**---Créez la base de données :** php bin/console doctrine:database:create

**---Exécutez les migrations :** php bin/consoledoctrine:migrations:migrate

**---Démarrer le serveur local :** symfony server:start

**Utilisation**

Après avoir installé le projet, vous pouvez accéder à l'application via votre navigateur à l'adresse http://localhost:8000.

**---Inscription :** Les étudiants peuvent s'inscrire en créant un compte avec leurs informations personnelles.

**---Réservation des heures de conduite :** Les étudiants peuvent réserver des heures de conduite disponibles.

**---Passation des tests pratiques :** Les étudiants peuvent passer des tests pratiques en ligne.

**---Paiement des services :** Les étudiants peuvent payer pour les services via des options de paiement sécurisées.

**---Authentification :** Un système d'authentification est en place pour les étudiants et les instructeurs.

**compte admin**

**---email:** admin@gmail.com
**---mot de passe:** 1234

