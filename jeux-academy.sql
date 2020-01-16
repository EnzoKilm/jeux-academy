-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 16 jan. 2020 à 17:14
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
-- Structure de la table `casse_briques_settings`
--

DROP TABLE IF EXISTS `casse_briques_settings`;
CREATE TABLE IF NOT EXISTS `casse_briques_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Numéro du niveau de la carte pour le jeu de casse briques',
  `map` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Map du niveau correspondant',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `casse_briques_settings`
--

INSERT INTO `casse_briques_settings` (`id`, `map`) VALUES
(1, '00033933000\r\n01220002210\r\n11200000211\r\n00011111000\r\n00111011100\r\n00001110000\r\n00000000000\r\n00000000000\r\n00000000000'),
(2, '11991119911\r\n00012221000\r\n00003330000\r\n00111311100\r\n00001210000\r\n00000100000\r\n00000000000\r\n00000000000\r\n00000000000'),
(3, '11000000000\r\n00000000000\r\n00000000000\r\n00000000000\r\n00000000000\r\n00000000000\r\n00000000000\r\n00000000000\r\n00000000000'),
(4, '00000000000\r\n00000000000\r\n00333333300\r\n00333333300\r\n00333333300\r\n00033333000\r\n00033333000\r\n00033333000\r\n00000000000');

-- --------------------------------------------------------

--
-- Structure de la table `casse_briques_users`
--

DROP TABLE IF EXISTS `casse_briques_users`;
CREATE TABLE IF NOT EXISTS `casse_briques_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id du joueur pour ce jeu',
  `niveau` int(11) NOT NULL COMMENT 'Niveau du joueur dans le jeu de casse briques',
  `id_joueur` int(11) NOT NULL COMMENT 'Numéro d''identification unique du joueur pour le jeu de casse briques',
  PRIMARY KEY (`id`),
  KEY `id_joueur` (`id_joueur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `casse_briques_users`
--

INSERT INTO `casse_briques_users` (`id`, `niveau`, `id_joueur`) VALUES
(1, 1, 1);

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
  PRIMARY KEY (`id`),
  KEY `id_joueur` (`id_joueur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `demineur_users`
--

INSERT INTO `demineur_users` (`id`, `win`, `loose`, `bombs_exploded`, `bombs_defused`, `id_joueur`) VALUES
(1, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

DROP TABLE IF EXISTS `jeux`;
CREATE TABLE IF NOT EXISTS `jeux` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du jeu',
  `nom` varchar(255) NOT NULL COMMENT 'Nom du jeu',
  `developpeur` varchar(255) NOT NULL COMMENT 'Développeur du jeu',
  `note_positive` int(11) NOT NULL COMMENT 'Nombre de votes positifs pour le jeu',
  `note_negative` int(11) NOT NULL COMMENT 'Nombre de votes négatifs pour le jeu',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `jeux`
--

INSERT INTO `jeux` (`id`, `nom`, `developpeur`, `note_positive`, `note_negative`) VALUES
(1, 'cassebriques', 'Enzo Beauchamp', 0, 0),
(2, 'demineur', 'Alex Beurthe', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Numéro d''identification unique du compte',
  `pseudo` varchar(255) COLLATE latin1_general_cs NOT NULL COMMENT 'Pseudo du joueur',
  `mdp` varchar(255) COLLATE latin1_general_cs NOT NULL COMMENT 'Mot de passe du compte',
  `nom` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Nom du joueur',
  `prenom` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Prénom du joueur',
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Email du joueur',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `mdp`, `nom`, `prenom`, `email`) VALUES
(1, 'EnzoKilm', '6b5b0dd03c9c85725032ce5f3a0918ae', 'Beauchamp', 'Enzo', 'enzo-beauchamp@live.fr'),
(2, 'RedWing_Jms', '61b5aed1f377a9506bfaaaccd640a5c0', 'Monnier', 'Jean-Louis', 'redwingjms44@gmail.com');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `casse_briques_users`
--
ALTER TABLE `casse_briques_users`
  ADD CONSTRAINT `casse_briques_users_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `demineur_users`
--
ALTER TABLE `demineur_users`
  ADD CONSTRAINT `demineur_users_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
