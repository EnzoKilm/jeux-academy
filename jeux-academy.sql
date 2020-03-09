-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 09 mars 2020 à 09:53
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `jeux-academy`
--

-- --------------------------------------------------------

--
-- Structure de la table `amis`
--

DROP TABLE IF EXISTS `amis`;
CREATE TABLE IF NOT EXISTS `amis` (
  `joueur_id` int(11) NOT NULL COMMENT 'Id du joueur qui a un ami',
  `ami_id` int(11) NOT NULL COMMENT 'Id de l''ami du joueur',
  `accepted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'True si l''ami a accepté la demande | False si il ne l''a pas accepté',
  PRIMARY KEY (`joueur_id`),
  KEY `id_ami` (`ami_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `amis`
--

INSERT INTO `amis` (`joueur_id`, `ami_id`, `accepted`) VALUES
(2, 1, 0),
(3, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `cassebriques_settings`
--

DROP TABLE IF EXISTS `cassebriques_settings`;
CREATE TABLE IF NOT EXISTS `cassebriques_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Numéro du niveau de la carte pour le jeu de casse briques',
  `map` mediumtext COLLATE utf8_bin NOT NULL COMMENT 'Map du niveau correspondant',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `cassebriques_settings`
--

INSERT INTO `cassebriques_settings` (`id`, `map`) VALUES
(1, '00033933000\r\n01220002210\r\n11200000211\r\n00011111000\r\n00111011100\r\n00001110000\r\n00000000000\r\n00000000000\r\n00000000000'),
(2, '11991119911\r\n00012221000\r\n00003330000\r\n00111311100\r\n00001210000\r\n00000100000\r\n00000000000\r\n00000000000\r\n00000000000'),
(3, '11000000000\r\n00000000000\r\n00000000000\r\n00000000000\r\n00000000000\r\n00000000000\r\n00000000000\r\n00000000000\r\n00000000000'),
(4, '00000000000\r\n00000000000\r\n00333333300\r\n00333333300\r\n00333333300\r\n00033333000\r\n00033333000\r\n00033333000\r\n00000000000');

-- --------------------------------------------------------

--
-- Structure de la table `cassebriques_users`
--

DROP TABLE IF EXISTS `cassebriques_users`;
CREATE TABLE IF NOT EXISTS `cassebriques_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id du joueur pour ce jeu',
  `niveau` int(11) NOT NULL COMMENT 'Niveau du joueur dans le jeu de casse briques',
  `id_joueur` int(11) NOT NULL COMMENT 'Numéro d''identification unique du joueur pour le jeu de casse briques',
  `vote` tinyint(1) DEFAULT NULL COMMENT 'NULL si l''utilisateur n''a jamais voté / True si il a voté pour le jeu / False si il a voté contre le jeu',
  PRIMARY KEY (`id`),
  KEY `id_joueur` (`id_joueur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `cassebriques_users`
--

INSERT INTO `cassebriques_users` (`id`, `niveau`, `id_joueur`, `vote`) VALUES
(1, 1, 1, 1),
(2, 1, 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `demineur_users`
--

DROP TABLE IF EXISTS `demineur_users`;
CREATE TABLE IF NOT EXISTS `demineur_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du joueur',
  `win` int(11) NOT NULL COMMENT 'Parties gagnées',
  `loose` int(11) NOT NULL COMMENT 'Parties perdues',
  `bombs_exploded` int(11) NOT NULL COMMENT 'Bombes faites explosées',
  `bombs_defused` int(11) NOT NULL COMMENT 'Bombes désamorcées',
  `id_joueur` int(11) NOT NULL COMMENT 'Identifiant du joueur',
  `vote` tinyint(1) DEFAULT NULL COMMENT 'True si l''utilisateur a déjà voté pour le jeu / False dans le cas contraire',
  PRIMARY KEY (`id`),
  KEY `id_joueur` (`id_joueur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `demineur_users`
--

INSERT INTO `demineur_users` (`id`, `win`, `loose`, `bombs_exploded`, `bombs_defused`, `id_joueur`, `vote`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(2, 0, 0, 0, 0, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

DROP TABLE IF EXISTS `jeux`;
CREATE TABLE IF NOT EXISTS `jeux` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du jeu',
  `nom` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Nom du jeu',
  `display_name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Nom affiché sur la page',
  `developpeur` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Développeur du jeu',
  `description` text COLLATE utf8_bin NOT NULL COMMENT 'Texte de description du jeu',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `jeux`
--

INSERT INTO `jeux` (`id`, `nom`, `display_name`, `developpeur`, `description`) VALUES
(1, 'cassebriques', 'Casse briques', 'Enzo Beauchamp', 'Casse les briques à l\'aide de la balle et de la raquette.'),
(2, 'demineur', 'Démineur', 'Alex Beurthe', 'Dévoile toutes les cases mais attention aux bombes!'),
(3, 'pong', 'Pong', 'Tristan Meillat', 'Fais rebondir la balle avec la raquette jusqu\'à ce que tu gagnes!');

-- --------------------------------------------------------

--
-- Structure de la table `pong_users`
--

DROP TABLE IF EXISTS `pong_users`;
CREATE TABLE IF NOT EXISTS `pong_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du joueur dans le jeu',
  `id_joueur` int(11) NOT NULL COMMENT 'Identifiant du joueur',
  `vote` tinyint(1) DEFAULT NULL COMMENT 'Vote du joueur pour le jeu',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Numéro d''identification unique du compte',
  `pseudo` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Pseudo du joueur',
  `mdp` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Mot de passe du compte',
  `nom` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Nom du joueur',
  `prenom` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Prénom du joueur',
  `email` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Email du joueur',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `mdp`, `nom`, `prenom`, `email`) VALUES
(1, 'EnzoKilm', '6b5b0dd03c9c85725032ce5f3a0918ae', 'Beauchamp', 'Enzo', 'enzo-beauchamp@live.fr'),
(2, 'RedWing_Jms', '61b5aed1f377a9506bfaaaccd640a5c0', 'Monnier', 'Jean-Louis', 'redwingjms44@gmail.com'),
(3, 'HideInBush', 'e10adc3949ba59abbe56e057f20f883e', 'Barbereau', 'Maxime', 'barbereau.maxime@gmail.com');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `amis`
--
ALTER TABLE `amis`
  ADD CONSTRAINT `id_ami` FOREIGN KEY (`ami_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `id_joueur` FOREIGN KEY (`joueur_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `cassebriques_users`
--
ALTER TABLE `cassebriques_users`
  ADD CONSTRAINT `cassebriques_users_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `demineur_users`
--
ALTER TABLE `demineur_users`
  ADD CONSTRAINT `demineur_users_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
