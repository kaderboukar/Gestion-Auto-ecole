-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 09 fév. 2024 à 10:19
-- Version du serveur : 5.7.40
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gest_inscription`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240206173224', '2024-02-06 17:32:34', 288),
('DoctrineMigrations\\Version20240207110223', '2024-02-07 11:02:28', 112),
('DoctrineMigrations\\Version20240207111020', '2024-02-07 11:10:24', 52),
('DoctrineMigrations\\Version20240207121025', '2024-02-07 12:10:33', 73),
('DoctrineMigrations\\Version20240207233241', '2024-02-07 23:33:08', 500);

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matricule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `deleted_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id`, `nom`, `prenom`, `email`, `matricule`, `telephone`, `created_at`, `deleted_at`, `status`, `password`) VALUES
(1, 'Etudiant', 'test1', 'etudiant@gmail.com', NULL, 91056163, '2024-02-07 21:54:06', NULL, 1, '$2y$13$dHVGDXpV0aS9hQP8Mn4LHOqQKekVpIfUtC8LgAaijrnzUHQKRjdvO');

-- --------------------------------------------------------

--
-- Structure de la table `instructeur`
--

DROP TABLE IF EXISTS `instructeur`;
CREATE TABLE IF NOT EXISTS `instructeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `deleted_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `instructeur`
--

INSERT INTO `instructeur` (`id`, `nom`, `prenom`, `email`, `telephone`, `created_at`, `deleted_at`, `status`) VALUES
(1, 'Instructeur', 'lamine', 'instructeur@gmail.com', 91056163, '2024-02-07 16:27:24', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_reservation_id` int(11) DEFAULT NULL,
  `montant` decimal(20,3) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `deleted_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6D28840D85542AE1` (`id_reservation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_etudiant_id` int(11) DEFAULT NULL,
  `id_instructeur_id` int(11) DEFAULT NULL,
  `date_reservation` date NOT NULL,
  `heure_reservation` time NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `deleted_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_42C84955C5F87C54` (`id_etudiant_id`),
  KEY `IDX_42C84955189A150F` (`id_instructeur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id`, `id_etudiant_id`, `id_instructeur_id`, `date_reservation`, `heure_reservation`, `created_at`, `deleted_at`, `status`) VALUES
(1, 1, 1, '2024-02-07', '22:22:00', '2024-02-07 22:58:02', NULL, 1),
(2, 1, 1, '2024-02-09', '22:22:00', '2024-02-08 10:48:32', NULL, 0),
(3, 1, 1, '2024-02-09', '22:22:00', '2024-02-08 11:09:29', NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_etudiant_id` int(11) DEFAULT NULL,
  `id_instructeur_id` int(11) DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `deleted_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` int(11) DEFAULT NULL,
  `first_connexion` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8D93D649C5F87C54` (`id_etudiant_id`),
  KEY `IDX_8D93D649189A150F` (`id_instructeur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `id_etudiant_id`, `id_instructeur_id`, `last_name`, `email`, `password`, `roles`, `created_at`, `deleted_at`, `status`, `first_name`, `telephone`, `first_connexion`) VALUES
(1, NULL, NULL, 'Administrateur', 'admin@gmail.com', '$2y$13$xnOLHjDMRyqF3MHCMLywdemJE/nxs.aFt3XfuOTKx6XukBxkmqKLm', '[\"ROLE_ADMIN\"]', '2024-02-07 11:18:34', NULL, 1, 'Système', 0, NULL),
(2, NULL, 1, 'Instructeur', 'instructeur@gmail.com', '$2y$13$Z.Ur6q.aewAWspJolDd8K.XZO7WXeOCn7A4ttB3yyVIJ9Fcur11P6', '[\"ROLE_INSTRUCTEUR\"]', '2024-02-07 16:27:24', NULL, 1, 'lamine', 91056163, 1),
(3, 1, NULL, 'Etudiant', 'etudiant@gmail.com', '$2y$13$dHVGDXpV0aS9hQP8Mn4LHOqQKekVpIfUtC8LgAaijrnzUHQKRjdvO', '[\"ROLE_ETUDIANT\"]', '2024-02-07 21:54:06', NULL, 1, 'test1', 91056163, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `FK_6D28840D85542AE1` FOREIGN KEY (`id_reservation_id`) REFERENCES `reservation` (`id`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_42C84955189A150F` FOREIGN KEY (`id_instructeur_id`) REFERENCES `instructeur` (`id`),
  ADD CONSTRAINT `FK_42C84955C5F87C54` FOREIGN KEY (`id_etudiant_id`) REFERENCES `etudiant` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649189A150F` FOREIGN KEY (`id_instructeur_id`) REFERENCES `instructeur` (`id`),
  ADD CONSTRAINT `FK_8D93D649C5F87C54` FOREIGN KEY (`id_etudiant_id`) REFERENCES `etudiant` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
