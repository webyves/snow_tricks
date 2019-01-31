-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 31 jan. 2019 à 10:51
-- Version du serveur :  5.7.17
-- Version de PHP :  7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `snow_tricks`
--
CREATE DATABASE IF NOT EXISTS `snow_tricks` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `snow_tricks`;

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20181213135611'),
('20181213172954'),
('20181213173147'),
('20181213174135'),
('20181213180958'),
('20181213182346'),
('20181215142308'),
('20181215173345'),
('20181216151655'),
('20181218171614'),
('20190107103510'),
('20190107112528'),
('20190108112403'),
('20190112150912');

-- --------------------------------------------------------

--
-- Structure de la table `tricks`
--

CREATE TABLE `tricks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `user_create_id` int(11) NOT NULL,
  `trick_group_id` int(11) NOT NULL,
  `user_update_id` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `trick_comment`
--

CREATE TABLE `trick_comment` (
  `id` int(11) NOT NULL,
  `user_create_id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trick_group`
--

CREATE TABLE `trick_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `trick_image`
--

CREATE TABLE `trick_image` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `trick_video`
--

CREATE TABLE `trick_video` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `link` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_inscription` datetime NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_token` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `tricks`
--
ALTER TABLE `tricks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E1D902C19B875DF8` (`trick_group_id`),
  ADD KEY `IDX_E1D902C1EEFE5067` (`user_create_id`),
  ADD KEY `IDX_E1D902C1D5766755` (`user_update_id`);

--
-- Index pour la table `trick_comment`
--
ALTER TABLE `trick_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F7292B34EEFE5067` (`user_create_id`),
  ADD KEY `IDX_F7292B34B281BE2E` (`trick_id`);

--
-- Index pour la table `trick_group`
--
ALTER TABLE `trick_group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `trick_image`
--
ALTER TABLE `trick_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E1204E0B281BE2E` (`trick_id`);

--
-- Index pour la table `trick_video`
--
ALTER TABLE `trick_video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B7E8DA93B281BE2E` (`trick_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CF080AB3A76ED395` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tricks`
--
ALTER TABLE `tricks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `trick_comment`
--
ALTER TABLE `trick_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `trick_group`
--
ALTER TABLE `trick_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `trick_image`
--
ALTER TABLE `trick_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `trick_video`
--
ALTER TABLE `trick_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tricks`
--
ALTER TABLE `tricks`
  ADD CONSTRAINT `FK_E1D902C19B875DF8` FOREIGN KEY (`trick_group_id`) REFERENCES `trick_group` (`id`),
  ADD CONSTRAINT `FK_E1D902C1D5766755` FOREIGN KEY (`user_update_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_E1D902C1EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `trick_comment`
--
ALTER TABLE `trick_comment`
  ADD CONSTRAINT `FK_F7292B34B281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `tricks` (`id`),
  ADD CONSTRAINT `FK_F7292B34EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `trick_image`
--
ALTER TABLE `trick_image`
  ADD CONSTRAINT `FK_E1204E0B281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `tricks` (`id`);

--
-- Contraintes pour la table `trick_video`
--
ALTER TABLE `trick_video`
  ADD CONSTRAINT `FK_B7E8DA93B281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `tricks` (`id`);

--
-- Contraintes pour la table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `FK_CF080AB3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
