-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 02 août 2021 à 11:59
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `magasin_210614`
--

-- --------------------------------------------------------

--
-- Structure de la table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET latin1 NOT NULL,
  `station_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Structure de la table `collection`
--

CREATE TABLE `collection` (
  `cid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `unit` varchar(8) NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `concept`
--

CREATE TABLE `concept` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `station_id` int(11) NOT NULL DEFAULT '1',
  `code` varchar(5) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `vacation` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mag_area`
--

CREATE TABLE `mag_area` (
  `id` int(11) NOT NULL,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `station_id` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_brand`
--

CREATE TABLE `mag_brand` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_category`
--

CREATE TABLE `mag_category` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `ord` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mag_class`
--

CREATE TABLE `mag_class` (
  `id` int(11) NOT NULL,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `info` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `station_id` int(11) NOT NULL DEFAULT '3',
  `planning` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_contact`
--

CREATE TABLE `mag_contact` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `info` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `fonction` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `station_id` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_inventaire`
--

CREATE TABLE `mag_inventaire` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL DEFAULT '0',
  `model_id` int(11) NOT NULL,
  `tag` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serial` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `refMoscou` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '0',
  `area_id` int(11) NOT NULL DEFAULT '0',
  `info` text COLLATE utf8_unicode_ci NOT NULL,
  `verif` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barcode` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_item_log`
--

CREATE TABLE `mag_item_log` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `initials` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(25) DEFAULT NULL,
  `snapshot` mediumblob,
  `uid` int(11) NOT NULL,
  `station_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Ticketing';

-- --------------------------------------------------------

--
-- Structure de la table `mag_model`
--

CREATE TABLE `mag_model` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `reference` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `info` text COLLATE utf8_unicode_ci NOT NULL,
  `hyperlien` varchar(2083) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prix` decimal(10,0) DEFAULT NULL,
  `poids` decimal(4,3) DEFAULT NULL,
  `origine` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_page`
--

CREATE TABLE `mag_page` (
  `name` enum('caumartin','matinale','kit1','kit2','kit3','kit4','kit5','kit6','kit7','kit8','kit9','kit10','kit11','kit12','kit13','cartes_sxs_sd','telephones','batteries','light_panels','chargeurs_cam','chargeurs','lecteurs_cartes','nextodi','minettes','tmp','kits_son','aviwest','studio','web','bricolage') COLLATE utf8_unicode_ci NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `description` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_phase`
--

CREATE TABLE `mag_phase` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `station_id` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_rack`
--

CREATE TABLE `mag_rack` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `station_id` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mag_resa`
--

CREATE TABLE `mag_resa` (
  `id` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `date_start` datetime NOT NULL,
  `date_stop` datetime NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `info` text COLLATE utf8_unicode_ci,
  `slug` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_rack_id` int(11) DEFAULT NULL,
  `stop_rack_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_resa_item`
--

CREATE TABLE `mag_resa_item` (
  `item_id` int(11) NOT NULL,
  `resa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_sim`
--

CREATE TABLE `mag_sim` (
  `id` int(11) NOT NULL,
  `operator` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `nsce` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `info` text COLLATE utf8_unicode_ci NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `slot` tinyint(4) DEFAULT NULL,
  `msisdn` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valid` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mag_status`
--

CREATE TABLE `mag_status` (
  `id` int(11) NOT NULL,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `station_id` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sample`
--

CREATE TABLE `sample` (
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `slug`
--

CREATE TABLE `slug` (
  `thread` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT '1',
  `station_id` int(11) NOT NULL DEFAULT '1',
  `concept_id` int(11) NOT NULL DEFAULT '0',
  `class_id` int(11) NOT NULL DEFAULT '0',
  `system_id` int(11) NOT NULL DEFAULT '0',
  `format_id` int(11) NOT NULL DEFAULT '0',
  `deadline` datetime DEFAULT NULL,
  `client` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(128) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `station`
--

CREATE TABLE `station` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `system`
--

CREATE TABLE `system` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `station_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `thread` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `initials` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `type` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `snapshot` mediumblob,
  `uid` int(11) NOT NULL,
  `station_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Ticketing';

-- --------------------------------------------------------

--
-- Structure de la table `time`
--

CREATE TABLE `time` (
  `station_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `concept_id` int(11) NOT NULL,
  `thread` int(11) NOT NULL,
  `start` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stop` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `username` varchar(3) CHARACTER SET latin1 NOT NULL,
  `password` varchar(64) CHARACTER SET latin1 NOT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET latin1 NOT NULL,
  `active` tinyint(1) NOT NULL,
  `station_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `collection`
--
ALTER TABLE `collection`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `concept`
--
ALTER TABLE `concept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_brand`
--
ALTER TABLE `mag_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_category`
--
ALTER TABLE `mag_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_contact`
--
ALTER TABLE `mag_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_inventaire`
--
ALTER TABLE `mag_inventaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_item_log`
--
ALTER TABLE `mag_item_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_model`
--
ALTER TABLE `mag_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_phase`
--
ALTER TABLE `mag_phase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_rack`
--
ALTER TABLE `mag_rack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_resa`
--
ALTER TABLE `mag_resa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mag_sim`
--
ALTER TABLE `mag_sim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `station`
--
ALTER TABLE `station`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `system`
--
ALTER TABLE `system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `time`
--
ALTER TABLE `time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `mag_inventaire`
--
ALTER TABLE `mag_inventaire`
  ADD CONSTRAINT `Area` FOREIGN KEY (`area_id`) REFERENCES `mag_area` (`id`),
  ADD CONSTRAINT `Class` FOREIGN KEY (`class_id`) REFERENCES `mag_class` (`id`),
  ADD CONSTRAINT `Model` FOREIGN KEY (`model_id`) REFERENCES `mag_model` (`id`),
  ADD CONSTRAINT `Status` FOREIGN KEY (`status_id`) REFERENCES `mag_status` (`id`);

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
  ADD CONSTRAINT `Page Area` FOREIGN KEY (`area_id`) REFERENCES `mag_area` (`id`),
  ADD CONSTRAINT `Page Class` FOREIGN KEY (`class_id`) REFERENCES `mag_class` (`id`),
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
