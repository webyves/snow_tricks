-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 31 jan. 2019 à 10:52
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

--
-- Déchargement des données de la table `tricks`
--

INSERT INTO `tricks` (`id`, `name`, `content`, `date_create`, `date_update`, `user_create_id`, `trick_group_id`, `user_update_id`, `slug`) VALUES
(1, 'Backside Triple Cork 1440', 'En langage snowboard, un cork est une rotation horizontale plus ou moins désaxée, selon un mouvement d\'épaules effectué juste au moment du saut. Le tout premier Triple Cork a été plaqué par Mark McMorris en 2011, lequel a récidivé lors des Winter X Games 2012... avant de se faire voler la vedette par Torstein Horgmo, lors de ce même championnat. Le Norvégien réalisa son propre Backside Triple Cork 1440 et obtint la note parfaite de 50/50.', '2019-01-01 15:58:43', '2019-01-01 15:58:43', 1, 1, 1, 'backside-triple-cork-1440'),
(2, 'Double Mc Twist 1260', 'Le Mc Twist est un flip (rotation verticale) agrémenté d\'une vrille. Un saut très périlleux réservé aux professionnels. Le champion précoce Shaun White s\'est illustré par un Double Mc Twist 1260 lors de sa session de Half-Pipe aux Jeux Olympiques de Vancouver en 2010. Nul doute que c\'est cette figure qui lui a valu de remporter la médaille d\'or.', '2018-12-24 01:30:37', '2018-12-24 01:30:37', 1, 4, 1, 'double-mc-twist-1260'),
(3, 'Double Backside Rodeo 1080', 'À l\'instar du cork, le rodeo est une rotation désaxée, qui se reconnaît par son aspect vrillé. Un des plus beaux de l\'histoire est sans aucun doute le Double Backside Rodeo 1080 effectué pour la première fois en compétition par le jeune prodige Travis Rice, lors du Icer Air 2007. La pirouette est tellement culte qu\'elle a fini dans un jeu vidéo où Travis Rice est l\'un des personnages.', '2018-12-30 10:19:05', '2018-12-30 10:19:05', 1, 1, 1, 'double-backside-rodeo-1080'),
(4, 'Double Backflip One Foot', 'Comme on peut le deviner, les \"one foot\" sont des figures réalisées avec un pied décroché de la fixation. Pendant le saut, le snowboarder doit tendre la jambe du côté dudit pied. L\'esthète Scotty Vine – une sorte de Danny MacAskill du snowboard – en a réalisé un bel exemple avec son Double Backflip One Foot.', '2019-01-01 06:50:25', '2019-01-01 06:50:25', 1, 3, 1, 'double-backflip-one-foot'),
(5, 'Method Air', 'Cette figure – qui consiste à attraper sa planche d\'une main et le tourner perpendiculairement au sol – est un classique \"old school\". Il n\'empêche qu\'il est indémodable, avec de vrais ambassadeurs comme Jamie Lynn ou la star Terje Haakonsen. En 2007, ce dernier a même battu le record du monde du \"air\" le plus haut en s\'élevant à 9,8 mètres au-dessus du kick (sommet d\'un mur d\'une rampe ou autre structure de saut).', '2018-12-28 12:15:12', '2018-12-28 12:15:12', 1, 2, 1, 'method-air'),
(6, '180°', 'saut avec une rotation d\'un demi-tour (souvent abrégé par le sens de rotation. Par exemple on dit qu\'on réalise un back(side) pour dire un 180° backside)', '2018-12-23 12:58:32', '2018-12-23 12:58:32', 1, 5, 1, '180'),
(7, '360°', 'un saut avec une rotation d\'un tour complet (souvent abrégé 3-6 ou 3).', '2019-01-01 10:11:10', '2019-01-01 10:11:10', 1, 5, 1, '360'),
(8, 'Indy', 'Ce grab consiste à attraper (catcher) sa planche avec sa main arrière entre les deux pieds. Le tweak de ce trick est en général effectué en tendant la jambe avant.', '2018-12-28 02:52:54', '2018-12-28 02:52:54', 1, 2, 1, 'indy'),
(9, 'Japan', 'saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.', '2018-12-25 07:02:51', '2018-12-25 07:02:51', 1, 2, 1, 'japan'),
(10, 'Mute', 'saisie de la carre frontside de la planche entre les deux pieds avec la main avant ;', '2018-12-29 18:45:55', '2018-12-29 18:45:55', 1, 2, 1, 'mute');

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

--
-- Déchargement des données de la table `trick_group`
--

INSERT INTO `trick_group` (`id`, `name`, `description`) VALUES
(1, 'Cork', 'Rotation horizontale plus ou moins désaxée.'),
(2, 'Grab', 'Attraper sa planche d\'une main.'),
(3, 'Backflip', 'Rotation verticale arriere.'),
(4, 'Frontflip', 'Rotation verticale avant.'),
(5, 'Rotations', 'Rotation basique.'),
(6, 'Slides', 'Consiste à glisser sur une barre de slide.'),
(7, 'One Foot Trick', 'Figures réalisée avec un pied décroché de la fixation.');

-- --------------------------------------------------------

--
-- Structure de la table `trick_image`
--

CREATE TABLE `trick_image` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `trick_image`
--

INSERT INTO `trick_image` (`id`, `trick_id`, `link`) VALUES
(1, 6, '84a3eb81e608389a4c57ed810d98bba3.jpeg'),
(2, 7, '695981905e3b6a5822380bb51703da85.jpeg'),
(3, 8, 'c75c8e62c32b5117468893338a169218.jpeg'),
(4, 9, '9d69adc0961fae930b6089f44c5efa3f.jpeg'),
(5, 10, 'fe6b0006916b317a648d4f24d537e535.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `trick_video`
--

CREATE TABLE `trick_video` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `link` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `trick_video`
--

INSERT INTO `trick_video` (`id`, `trick_id`, `link`) VALUES
(1, 1, 'https://www.youtube.com/embed/Br6ZJM01I6s'),
(2, 2, 'https://www.youtube.com/embed/XATkSnCFsRU'),
(3, 3, 'https://www.youtube.com/embed/vquZvxGMJT0'),
(4, 5, 'https://www.youtube.com/embed/2Ul5P-KucE8');

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

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `date_inscription`, `avatar`, `valid`) VALUES
(1, 'super@admin.fr', '$2y$10$XP0u/A5Q7MxT1Q4sKpvSlOBNPvszxnfZ.7sc5Sr/29YPXaPNXAVfi', 'Super', 'Admin', '2018-12-19 20:04:22', '', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `trick_comment`
--
ALTER TABLE `trick_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `trick_group`
--
ALTER TABLE `trick_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `trick_image`
--
ALTER TABLE `trick_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `trick_video`
--
ALTER TABLE `trick_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
