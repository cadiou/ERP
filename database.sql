-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 02 août 2021 à 22:43
-- Version du serveur :  8.0.26-0ubuntu0.20.04.2
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `erp`
--

-- --------------------------------------------------------

--
-- Structure de la table `class`
--

CREATE TABLE `class` (
  `id` int NOT NULL,
  `name` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `station_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Structure de la table `collection`
--

CREATE TABLE `collection` (
  `cid` int NOT NULL,
  `sid` int NOT NULL,
  `unit` varchar(8) NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `concept`
--

CREATE TABLE `concept` (
  `id` int NOT NULL,
  `name` varchar(40) NOT NULL,
  `station_id` int NOT NULL DEFAULT '1',
  `code` varchar(5) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `vacation` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `group`
--

CREATE TABLE `group` (
  `id` int NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `group`
--

INSERT INTO `group` (`id`, `name`) VALUES
(23, 'CADIOU.DEV');

-- --------------------------------------------------------

--
-- Structure de la table `mag_area`
--

CREATE TABLE `mag_area` (
  `id` int NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `station_id` int NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mag_area`
--

INSERT INTO `mag_area` (`id`, `name`, `station_id`) VALUES
(1, '34 bis', 5);

-- --------------------------------------------------------

--
-- Structure de la table `mag_brand`
--

CREATE TABLE `mag_brand` (
  `id` int NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mag_brand`
--

INSERT INTO `mag_brand` (`id`, `name`) VALUES
(1, 'Apple');

-- --------------------------------------------------------

--
-- Structure de la table `mag_category`
--

CREATE TABLE `mag_category` (
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `ord` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mag_category`
--

INSERT INTO `mag_category` (`id`, `name`, `ord`) VALUES
(1, 'Téléphone', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `mag_class`
--

CREATE TABLE `mag_class` (
  `id` int NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `info` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `station_id` int NOT NULL DEFAULT '3',
  `planning` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mag_class`
--

INSERT INTO `mag_class` (`id`, `name`, `info`, `station_id`, `planning`) VALUES
(1, 'PERSO', 'Personnel', 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `mag_contact`
--

CREATE TABLE `mag_contact` (
  `id` int NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(13) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `info` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fonction` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `station_id` int NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mag_contact`
--

INSERT INTO `mag_contact` (`id`, `name`, `email`, `mobile`, `info`, `fonction`, `station_id`) VALUES
(1, 'Bob', '', '', '', '', 5);

-- --------------------------------------------------------

--
-- Structure de la table `mag_inventaire`
--

CREATE TABLE `mag_inventaire` (
  `id` int NOT NULL,
  `class_id` int NOT NULL DEFAULT '0',
  `model_id` int NOT NULL,
  `tag` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `serial` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `refMoscou` int DEFAULT NULL,
  `status_id` int NOT NULL DEFAULT '0',
  `area_id` int NOT NULL DEFAULT '0',
  `info` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `verif` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `barcode` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mag_inventaire`
--

INSERT INTO `mag_inventaire` (`id`, `class_id`, `model_id`, `tag`, `serial`, `refMoscou`, `status_id`, `area_id`, `info`, `verif`, `barcode`) VALUES
(2, 1, 2, NULL, NULL, NULL, 0, 1, '', NULL, '0001');

-- --------------------------------------------------------

--
-- Structure de la table `mag_item_log`
--

CREATE TABLE `mag_item_log` (
  `id` int NOT NULL,
  `item_id` int NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` int NOT NULL,
  `initials` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(25) DEFAULT NULL,
  `snapshot` mediumblob,
  `uid` int NOT NULL,
  `station_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Ticketing';

-- --------------------------------------------------------

--
-- Structure de la table `mag_model`
--

CREATE TABLE `mag_model` (
  `id` int NOT NULL,
  `brand_id` int NOT NULL,
  `reference` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `info` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hyperlien` varchar(2083) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `prix` decimal(10,0) DEFAULT NULL,
  `poids` decimal(4,3) DEFAULT NULL,
  `origine` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mag_model`
--

INSERT INTO `mag_model` (`id`, `brand_id`, `reference`, `description`, `info`, `hyperlien`, `prix`, `poids`, `origine`, `category_id`) VALUES
(2, 1, 'Iphone 7', 'Smartphone', '', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `mag_page`
--

CREATE TABLE `mag_page` (
  `name` enum('caumartin','matinale','kit1','kit2','kit3','kit4','kit5','kit6','kit7','kit8','kit9','kit10','kit11','kit12','kit13','cartes_sxs_sd','telephones','batteries','light_panels','chargeurs_cam','chargeurs','lecteurs_cartes','nextodi','minettes','tmp','kits_son','aviwest','studio','web','bricolage') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int DEFAULT NULL,
  `model_id` int DEFAULT NULL,
  `area_id` int DEFAULT NULL,
  `description` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_phase`
--

CREATE TABLE `mag_phase` (
  `id` int NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `station_id` int NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mag_phase`
--

INSERT INTO `mag_phase` (`id`, `name`, `station_id`) VALUES
(1, 'PVW', 5),
(2, 'PRO', 5),
(3, 'WIP', 5),
(4, 'CHK', 5);

-- --------------------------------------------------------

--
-- Structure de la table `mag_rack`
--

CREATE TABLE `mag_rack` (
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `station_id` int NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mag_resa`
--

CREATE TABLE `mag_resa` (
  `id` int NOT NULL,
  `level` tinyint NOT NULL DEFAULT '0',
  `date_start` datetime NOT NULL,
  `date_stop` datetime NOT NULL,
  `contact_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `info` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `slug` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_rack_id` int DEFAULT NULL,
  `stop_rack_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mag_resa`
--

INSERT INTO `mag_resa` (`id`, `level`, `date_start`, `date_stop`, `contact_id`, `user_id`, `info`, `slug`, `start_rack_id`, `stop_rack_id`) VALUES
(1, 0, '2021-08-11 06:30:00', '2021-08-11 06:30:00', NULL, 1, NULL, NULL, NULL, NULL),
(2, 0, '2021-08-06 06:30:00', '2021-08-06 06:30:00', NULL, 1, NULL, NULL, NULL, NULL),
(3, 1, '2021-08-06 06:30:00', '2021-08-06 06:30:00', 1, 1, 'They said... you know.', 'THE WILD', NULL, NULL),
(4, 4, '2021-08-03 06:30:00', '2021-08-03 06:30:00', 1, 1, '', 'Action en pleine tempête', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `mag_resa_item`
--

CREATE TABLE `mag_resa_item` (
  `item_id` int NOT NULL,
  `resa_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mag_resa_item`
--

INSERT INTO `mag_resa_item` (`item_id`, `resa_id`) VALUES
(2, 3),
(2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `mag_sim`
--

CREATE TABLE `mag_sim` (
  `id` int NOT NULL,
  `operator` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nsce` varchar(13) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `info` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `device_id` int DEFAULT NULL,
  `slot` tinyint DEFAULT NULL,
  `msisdn` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `valid` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_status`
--

CREATE TABLE `mag_status` (
  `id` int NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `station_id` int NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mag_status`
--

INSERT INTO `mag_status` (`id`, `name`, `station_id`) VALUES
(0, 'OK', 5),
(1, 'KO', 5),
(2, 'NOK', 3),
(3, 'WIP', 3),
(4, 'PVW', 3);

-- --------------------------------------------------------

--
-- Structure de la table `sample`
--

CREATE TABLE `sample` (
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cid` int NOT NULL,
  `uid` int NOT NULL,
  `value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `slug`
--

CREATE TABLE `slug` (
  `thread` int NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` int NOT NULL DEFAULT '1',
  `station_id` int NOT NULL DEFAULT '1',
  `concept_id` int NOT NULL DEFAULT '0',
  `class_id` int NOT NULL DEFAULT '0',
  `system_id` int NOT NULL DEFAULT '0',
  `format_id` int NOT NULL DEFAULT '0',
  `deadline` datetime DEFAULT NULL,
  `client` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `station`
--

CREATE TABLE `station` (
  `id` int NOT NULL,
  `name` varchar(40) NOT NULL,
  `group_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `station`
--

INSERT INTO `station` (`id`, `name`, `group_id`) VALUES
(5, 'ERP', 23);

-- --------------------------------------------------------

--
-- Structure de la table `system`
--

CREATE TABLE `system` (
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `station_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `id` int NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ticket`
--

CREATE TABLE `ticket` (
  `id` int NOT NULL,
  `thread` int NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` int NOT NULL,
  `initials` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `type` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `snapshot` mediumblob,
  `uid` int NOT NULL,
  `station_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Ticketing';

-- --------------------------------------------------------

--
-- Structure de la table `time`
--

CREATE TABLE `time` (
  `station_id` int NOT NULL,
  `id` int NOT NULL,
  `uid` int NOT NULL,
  `concept_id` int NOT NULL,
  `thread` int NOT NULL,
  `start` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stop` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `username` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id` int NOT NULL,
  `name` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `station_id` int NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`username`, `password`, `id`, `name`, `active`, `station_id`) VALUES
('~A', '', 1, 'Alice', 1, 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`,`station_id`) USING BTREE;

--
-- Index pour la table `collection`
--
ALTER TABLE `collection`
  ADD UNIQUE KEY `cid` (`cid`,`sid`);

--
-- Index pour la table `concept`
--
ALTER TABLE `concept`
  ADD PRIMARY KEY (`id`,`station_id`);

--
-- Index pour la table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mag_area`
--
ALTER TABLE `mag_area`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mag_brand`
--
ALTER TABLE `mag_brand`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mag_category`
--
ALTER TABLE `mag_category`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `mag_class`
--
ALTER TABLE `mag_class`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mag_contact`
--
ALTER TABLE `mag_contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mag_inventaire`
--
ALTER TABLE `mag_inventaire`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `Class` (`class_id`),
  ADD KEY `Status` (`status_id`),
  ADD KEY `Area` (`area_id`),
  ADD KEY `Model` (`model_id`);

--
-- Index pour la table `mag_item_log`
--
ALTER TABLE `mag_item_log`
  ADD PRIMARY KEY (`id`,`station_id`) USING BTREE;

--
-- Index pour la table `mag_model`
--
ALTER TABLE `mag_model`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Brand` (`brand_id`),
  ADD KEY `Category` (`category_id`);

--
-- Index pour la table `mag_page`
--
ALTER TABLE `mag_page`
  ADD UNIQUE KEY `name` (`name`,`class_id`,`model_id`,`area_id`),
  ADD KEY `Page Class` (`class_id`) USING BTREE,
  ADD KEY `Page Area` (`area_id`),
  ADD KEY `Page Model` (`model_id`);

--
-- Index pour la table `mag_phase`
--
ALTER TABLE `mag_phase`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Index pour la table `mag_rack`
--
ALTER TABLE `mag_rack`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mag_resa`
--
ALTER TABLE `mag_resa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `start_rack` (`start_rack_id`),
  ADD KEY `stop_rack` (`stop_rack_id`);

--
-- Index pour la table `mag_resa_item`
--
ALTER TABLE `mag_resa_item`
  ADD PRIMARY KEY (`item_id`,`resa_id`),
  ADD KEY `Resa` (`resa_id`);

--
-- Index pour la table `mag_sim`
--
ALTER TABLE `mag_sim`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Device` (`device_id`);

--
-- Index pour la table `mag_status`
--
ALTER TABLE `mag_status`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `slug`
--
ALTER TABLE `slug`
  ADD UNIQUE KEY `thread` (`thread`,`station_id`) USING BTREE;

--
-- Index pour la table `station`
--
ALTER TABLE `station`
  ADD PRIMARY KEY (`id`,`group_id`);

--
-- Index pour la table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`,`station_id`) USING BTREE;

--
-- Index pour la table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`id`,`station_id`) USING BTREE;

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `id` (`id`,`station_id`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `class`
--
ALTER TABLE `class`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `collection`
--
ALTER TABLE `collection`
  MODIFY `cid` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `concept`
--
ALTER TABLE `concept`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `group`
--
ALTER TABLE `group`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `mag_area`
--
ALTER TABLE `mag_area`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `mag_brand`
--
ALTER TABLE `mag_brand`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `mag_category`
--
ALTER TABLE `mag_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `mag_class`
--
ALTER TABLE `mag_class`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `mag_contact`
--
ALTER TABLE `mag_contact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `mag_inventaire`
--
ALTER TABLE `mag_inventaire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `mag_item_log`
--
ALTER TABLE `mag_item_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_model`
--
ALTER TABLE `mag_model`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `mag_phase`
--
ALTER TABLE `mag_phase`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `mag_rack`
--
ALTER TABLE `mag_rack`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_resa`
--
ALTER TABLE `mag_resa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `mag_sim`
--
ALTER TABLE `mag_sim`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_status`
--
ALTER TABLE `mag_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `station`
--
ALTER TABLE `station`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `system`
--
ALTER TABLE `system`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `time`
--
ALTER TABLE `time`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `mag_inventaire`
--
ALTER TABLE `mag_inventaire`
  ADD CONSTRAINT `Area` FOREIGN KEY (`area_id`) REFERENCES `mag_area` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Classe` FOREIGN KEY (`class_id`) REFERENCES `mag_class` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Model` FOREIGN KEY (`model_id`) REFERENCES `mag_model` (`id`),
  ADD CONSTRAINT `Status` FOREIGN KEY (`status_id`) REFERENCES `mag_status` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `mag_model`
--
ALTER TABLE `mag_model`
  ADD CONSTRAINT `Brand` FOREIGN KEY (`brand_id`) REFERENCES `mag_brand` (`id`),
  ADD CONSTRAINT `Category` FOREIGN KEY (`category_id`) REFERENCES `mag_category` (`id`);

--
-- Contraintes pour la table `mag_page`
--
ALTER TABLE `mag_page`
  ADD CONSTRAINT `Page Model` FOREIGN KEY (`model_id`) REFERENCES `mag_model` (`id`);

--
-- Contraintes pour la table `mag_resa`
--
ALTER TABLE `mag_resa`
  ADD CONSTRAINT `start_rack` FOREIGN KEY (`start_rack_id`) REFERENCES `mag_rack` (`id`),
  ADD CONSTRAINT `stop_rack` FOREIGN KEY (`stop_rack_id`) REFERENCES `mag_rack` (`id`);

--
-- Contraintes pour la table `mag_resa_item`
--
ALTER TABLE `mag_resa_item`
  ADD CONSTRAINT `Item` FOREIGN KEY (`item_id`) REFERENCES `mag_inventaire` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Resa` FOREIGN KEY (`resa_id`) REFERENCES `mag_resa` (`id`);

--
-- Contraintes pour la table `mag_sim`
--
ALTER TABLE `mag_sim`
  ADD CONSTRAINT `Device` FOREIGN KEY (`device_id`) REFERENCES `mag_inventaire` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
