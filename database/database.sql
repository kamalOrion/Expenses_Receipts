-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 14 nov. 2022 à 13:37
-- Version du serveur : 5.7.26
-- Version de PHP : 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `omel_last`
--

-- --------------------------------------------------------

--
-- Structure de la table `depenses`
--

DROP TABLE IF EXISTS `depenses`;
CREATE TABLE IF NOT EXISTS `depenses` (
  `depense_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type_depense_id` int(11) DEFAULT NULL,
  `liste_depense_valide_id` int(11) NOT NULL DEFAULT '0',
  `qte` int(11) DEFAULT NULL,
  `prix_unitaire` int(11) NOT NULL,
  `mode_paiement` varchar(15) NOT NULL,
  `echeance` date DEFAULT NULL,
  `commentaire` text NOT NULL,
  `statut` int(11) NOT NULL DEFAULT '1',
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`depense_id`),
  KEY `id_depense` (`type_depense_id`),
  KEY `type_id` (`type_depense_id`),
  KEY `fk_users_depenses` (`user_id`),
  KEY `fk_listeDepense_depense` (`liste_depense_valide_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `depenses`
--

INSERT INTO `depenses` (`depense_id`, `user_id`, `type_depense_id`, `liste_depense_valide_id`, `qte`, `prix_unitaire`, `mode_paiement`, `echeance`, `commentaire`, `statut`, `date_enreg`, `date_modif`) VALUES
(1, 2, 176, 1, 1, 500, 'Espèce', '2022-11-11', '', 1, '2022-11-11 20:39:22', '2022-11-11 20:39:22'),
(2, 2, 6, 1, 24, 190, 'Espèce', '2022-11-11', '', 1, '2022-11-11 20:41:01', '2022-11-11 20:41:01'),
(3, 2, 122, 2, 2, 2800, 'Espèce', '2022-11-12', '', 1, '2022-11-12 01:44:17', '2022-11-12 01:44:17'),
(4, 2, 150, 2, 1, 1200, 'Espèce', '2022-11-12', '', 1, '2022-11-12 01:44:47', '2022-11-12 01:44:47'),
(5, 2, 149, 2, 2, 600, 'Espèce', '2022-11-12', '', 1, '2022-11-12 01:45:28', '2022-11-12 01:45:28'),
(6, 2, 152, 2, 1, 1000, 'Espèce', '2022-11-12', '', 1, '2022-11-12 01:46:07', '2022-11-12 01:46:07'),
(7, 2, 112, 2, 1, 1350, 'Espèce', '2022-11-12', '', 1, '2022-11-12 01:46:41', '2022-11-12 01:46:41'),
(8, 2, 113, 2, 4, 1300, 'Espèce', '2022-11-12', '', 1, '2022-11-12 01:47:12', '2022-11-12 01:47:12'),
(9, 2, 120, 2, 2, 3500, 'Espèce', '2022-11-12', '', 1, '2022-11-12 01:48:09', '2022-11-12 01:48:09'),
(10, 2, 75, 2, 1, 2400, 'Espèce', '2022-11-12', '', 1, '2022-11-12 01:48:46', '2022-11-12 01:48:46'),
(11, 2, 76, 2, 2, 1000, 'Espèce', '2022-11-12', '', 1, '2022-11-12 01:49:23', '2022-11-12 01:49:23'),
(12, 2, 99, 3, 1, 1800, 'Espèce', '2022-11-13', '', 1, '2022-11-13 16:30:30', '2022-11-13 16:30:30'),
(13, 2, 26, 3, 1, 5050, 'Espèce', '2022-11-13', '', 1, '2022-11-13 16:32:40', '2022-11-13 16:32:40'),
(14, 2, 80, 3, 3, 3300, 'Espèce', '2022-11-13', '', 1, '2022-11-13 16:33:32', '2022-11-13 16:33:32'),
(15, 2, 23, 3, 1, 4800, 'Espèce', '2022-11-13', '', 1, '2022-11-13 16:35:18', '2022-11-13 16:35:18'),
(16, 2, 22, 3, 1, 2500, 'Espèce', '2022-11-13', '', 1, '2022-11-13 16:35:49', '2022-11-13 16:35:49'),
(17, 2, 142, 3, 4, 150, 'Espèce', '2022-11-13', '', 1, '2022-11-13 16:36:47', '2022-11-13 16:36:47'),
(18, 2, 71, 3, 2, 1100, 'Espèce', '2022-11-13', '', 1, '2022-11-13 16:37:33', '2022-11-13 16:37:33'),
(19, 1, 182, 0, 1, 200, 'Espèce', '2022-11-14', '', 1, '2022-11-14 13:13:34', '2022-11-14 13:13:34'),
(20, 1, 171, 0, 10, 25, 'Espèce', '2022-11-14', '', 0, '2022-11-14 13:13:59', '2022-11-14 13:13:59'),
(21, 1, 152, 0, 5, 1000, 'momo', '2022-11-14', '', 0, '2022-11-14 13:14:33', '2022-11-14 13:14:33'),
(22, 1, 158, 0, 5, 2500, 'momo', '2022-11-14', '', 1, '2022-11-14 13:15:01', '2022-11-14 13:15:01');

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `parent` varchar(20) NOT NULL,
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

DROP TABLE IF EXISTS `groupes`;
CREATE TABLE IF NOT EXISTS `groupes` (
  `groupe_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `privileges` text NOT NULL,
  `statut` int(11) NOT NULL,
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`groupe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `groupes`
--

INSERT INTO `groupes` (`groupe_id`, `nom`, `privileges`, `statut`, `date_enreg`, `date_modif`) VALUES
(1, 'Directeur', 'tableau_de_bord/recettes/b_vente/b_recette/depenses/b_depense/b_select_depense/b_depense_valide/b_depense_effectue/profil/administration/admin_groupe/admin_utilisateur/admin_structure/admin_produit/admin_type_depense/CTV/AV/MV/SV/GVR/DVR/CTD/AD/MD/SD/VD/ID/GDE/DDE', 1, '2022-11-11 15:25:07', '2022-11-11 16:05:58'),
(2, 'Gérant', 'recettes/b_vente/b_recette/depenses/b_depense/b_select_depense/b_depense_valide/b_depense_effectue/profil/CTV/AV/MV/SV/GVR/DVR/CTD/AD/MD/SD/VD/ID/GDE/DDE', 1, '2022-11-11 15:26:19', '2022-11-11 20:48:24'),
(3, 'Serveur', 'recettes/b_vente/profil/AV/MV/SV', 1, '2022-11-11 15:26:35', '2022-11-11 15:48:04'),
(4, 'Caisse', 'recettes/b_vente/b_recette/profil/CTV/GVR/DVR/CTD/AD/MD/SD/GDE/DDE', 1, '2022-11-11 15:26:49', '2022-11-11 20:52:31');

-- --------------------------------------------------------

--
-- Structure de la table `jonction_user_groupe`
--

DROP TABLE IF EXISTS `jonction_user_groupe`;
CREATE TABLE IF NOT EXISTS `jonction_user_groupe` (
  `user_id` int(11) NOT NULL,
  `groupe_id` int(11) NOT NULL,
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `jonction_user_groupe` (`user_id`,`groupe_id`),
  KEY `groupe_id` (`groupe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `jonction_user_groupe`
--

INSERT INTO `jonction_user_groupe` (`user_id`, `groupe_id`, `date_enreg`, `date_modif`) VALUES
(1, 1, '2022-11-11 15:54:36', '2022-11-11 15:54:36'),
(4, 3, '2022-11-11 15:55:23', '2022-11-11 15:55:23'),
(7, 3, '2022-11-11 15:55:23', '2022-11-11 15:55:23'),
(3, 4, '2022-11-11 15:55:29', '2022-11-11 15:55:29'),
(2, 2, '2022-11-11 15:58:25', '2022-11-11 15:58:25');

-- --------------------------------------------------------

--
-- Structure de la table `liste_depenses_valides`
--

DROP TABLE IF EXISTS `liste_depenses_valides`;
CREATE TABLE IF NOT EXISTS `liste_depenses_valides` (
  `liste_depenses_valides_id` int(11) NOT NULL AUTO_INCREMENT,
  `auteur_id` int(11) NOT NULL,
  `document_id` int(11) DEFAULT NULL,
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`liste_depenses_valides_id`),
  UNIQUE KEY `fk_document_listeDepensesValides` (`document_id`),
  KEY `fk_users_ldv` (`auteur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `liste_depenses_valides`
--

INSERT INTO `liste_depenses_valides` (`liste_depenses_valides_id`, `auteur_id`, `document_id`, `date_enreg`, `date_modif`) VALUES
(1, 2, NULL, '2022-11-11 20:50:33', '2022-11-11 20:50:33'),
(2, 2, NULL, '2022-11-13 20:30:12', '2022-11-13 20:30:12'),
(3, 2, NULL, '2022-11-13 22:16:54', '2022-11-13 22:16:54');

-- --------------------------------------------------------

--
-- Structure de la table `params_plateforme`
--

DROP TABLE IF EXISTS `params_plateforme`;
CREATE TABLE IF NOT EXISTS `params_plateforme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entreprise` varchar(150) NOT NULL,
  `urlLogo` varchar(255) NOT NULL,
  `email_entreprise` varchar(255) NOT NULL,
  `smtp_host` varchar(150) NOT NULL,
  `smtp_user` varchar(150) NOT NULL,
  `smtp_pass` varchar(150) NOT NULL,
  `smtp_port` varchar(150) NOT NULL,
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `params_plateforme`
--

INSERT INTO `params_plateforme` (`id`, `entreprise`, `urlLogo`, `email_entreprise`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `date_enreg`, `date_modif`) VALUES
(1, 'INOVACT', 'assets/img/plateformeLogo.png', 'info@inovact.com', 'inovact.com', 'business@inovact.com', '@Ha1lu417', '465', '2022-06-08 15:29:56', '2022-09-23 19:01:22');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `produit_id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`produit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`produit_id`, `libelle`, `date_enreg`, `date_modif`) VALUES
(1, 'CHAWARMA VIANDE', '2022-11-08 15:42:28', '2022-11-08 15:42:28'),
(2, 'CHAWARMA POULET', '2022-11-08 15:42:28', '2022-11-08 15:42:28'),
(3, 'CHAWARMA CAILLE', '2022-11-08 15:42:28', '2022-11-08 15:42:28'),
(4, 'ASSIETTE CHAWARMA', '2022-11-08 15:42:28', '2022-11-08 15:42:28'),
(5, 'HAMBURGER', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(6, 'ASSSIETTE HAMBURGER', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(7, 'BROCHETTE DE FRUITS', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(8, 'SALADE DE FRUITS', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(9, 'BOULE DE GLACE', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(10, 'ANANAS EN PIROGUE', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(11, 'SANDWICH POISSON', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(12, 'SANDWICH VIANDE', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(13, 'SPAGHETTI AVEC OMELETTE', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(14, 'SPAGHETTI AVEC VIANDE', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(15, 'SALADE COMPOSEE', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(16, 'SALADE AUX ŒUFS DE CAILLE', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(17, 'SALADE O\'MEL', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(18, 'SALADE D\'AVOCAT AU THON', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(19, 'AVOCAT AUX CREVETTES', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(20, 'CREPE FARCIE', '2022-11-08 15:42:29', '2022-11-08 15:42:29'),
(21, 'SOUPE DE POISSON', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(22, 'SOUPE DE LEGUMES', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(23, 'LANGUE DE BŒUF EN SAUCE', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(24, 'CAILLE BRAISE OU GRILLE', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(25, 'CAILLE A LA PROVENCALE', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(26, 'YASSA DE CAILLE', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(27, 'FRICASSE DE CAILLE O\'MEL', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(28, 'LAPIN BRAISE OU GRILLE', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(29, 'AILERON BRAISE OU FRIT', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(30, 'VIANDE DE MOUTON BRAISE', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(31, 'BROCHETTE DE BŒUF', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(32, 'FILET DE BŒUF A LA CREME', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(33, 'FILET DE BŒUF AU POIVRE VERT', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(34, 'ROGNON DE BŒUF A LA CREME', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(35, 'LANGUE DE BŒUF BRAISE OU GRILLE', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(36, 'ROGNON DE BŒUF A L\'AIL', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(37, 'BROCHETTE DE POISSON', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(38, 'POISSON BRAISE', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(39, 'FILET DE POISSON A LA CREME', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(40, 'FILET DE SOLE PERSILLE', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(41, 'SOLE MEUNIERE', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(42, 'ACCOMPAGNEMENT SUPPLEMENTAIRE', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(43, 'SAUCE TOMATE POISSON FRAIS', '2022-11-08 15:42:30', '2022-11-08 15:42:30'),
(44, 'SAUCE ARACHIDE (MOUTON)', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(45, 'SAUCE ASSROKOUIN', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(46, 'SAUCE LEGUMES', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(47, 'DAKOUIN', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(48, 'BOMIWO(POULET OU CAILLE)', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(49, 'GAMBAS SAUTEES', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(50, 'BROCHETTE DE GAMBAS', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(51, 'CREVETTES GRILLEES OU EN SAUCE', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(52, 'CALAMAR A LA PROVENCALE', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(53, 'PIZZA VEGETARIENNE', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(54, 'PIZZA MEXICAINE', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(55, 'PIZZA MARGARITA', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(56, 'PIZZA ASTERIX', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(57, 'PIZZA AMERICAINE', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(58, 'PIZZA RIO', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(59, 'PIZZA HOT DOG', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(60, 'PIZZA MARINIERE', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(61, 'PIZZA FRUITS DE MER', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(62, 'PIZZA O\'MEL', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(63, 'PIZZA MINI FORMAT', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(64, 'CONSO MARTINI', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(65, 'CONSO SUZE', '2022-11-08 15:42:31', '2022-11-08 15:42:31'),
(66, 'CONSO RICARD', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(67, 'CONSO PASTIS', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(68, 'CONSO CAMPARI', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(69, 'CONSO MALIBU', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(70, 'CONSO RHUM BRUM', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(71, 'CONSO RHUM BLANC', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(72, 'CONSO BAILEY\'S', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(73, 'CONSO SHERIDAN\'S', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(74, 'CONSO JB', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(75, 'CONSO BLACK LABEL', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(76, 'CONSO RED LABEL', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(77, 'CONSO CHIVAS REGAL', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(78, 'CONSO JACK DANIELS', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(79, 'CONSO GLENFIDICH', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(80, 'CONSO ORANGE SEC', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(81, 'CONSO COINTREAU', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(82, 'CONSO GIN/ TEQUILA / VODKA', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(83, 'SOIF SANS ALCOOL', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(84, 'CINDERELLA SANS ALCOOL', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(85, 'CHANTACCO', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(86, 'RIVERT', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(87, 'AMERICANO', '2022-11-08 15:42:32', '2022-11-08 15:42:32'),
(88, 'TI PUNCH', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(89, 'INDIAN SUMMER', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(90, 'PERROQUET', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(91, 'O\'MEL', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(92, 'CASTEL', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(93, 'BENINOISE', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(94, 'PILS', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(95, 'BEAUFORT', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(96, 'DOPPEL LARGER', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(97, 'EKU', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(98, 'GUINESS', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(99, 'HEINEKEN', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(100, 'DESPERADOS', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(101, 'PRESSION 0,5L', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(102, 'SUCRERIE', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(103, 'PANACHE/ TEQUILA', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(104, 'EAUX MINERALES GRAND', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(105, 'POSSO CITRON', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(106, 'POSSO GAZ', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(107, 'ROX', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(108, 'XXL', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(109, 'JUS DE FRUITS NATURELS', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(110, 'THE', '2022-11-08 15:42:33', '2022-11-08 15:42:33'),
(111, 'CAFE EXPRESSO', '2022-11-08 15:42:34', '2022-11-08 15:42:34'),
(112, 'NESCAFE', '2022-11-08 15:42:34', '2022-11-08 15:42:34'),
(113, 'SIROP MENTHE OU GRENADINE', '2022-11-08 15:42:34', '2022-11-08 15:42:34'),
(114, 'CONSO VIN', '2022-11-08 15:42:34', '2022-11-08 15:42:34'),
(115, 'BOUTEILLE DE VIN', '2022-11-08 15:42:34', '2022-11-08 15:42:34'),
(116, 'BOUTEILLE DE VIN', '2022-11-08 15:42:34', '2022-11-08 15:42:34'),
(117, 'BOUTEILLE DE VIN', '2022-11-08 15:42:34', '2022-11-08 15:42:34'),
(118, 'CONSO REMY MARTIN', '2022-11-08 15:42:34', '2022-11-08 15:42:34'),
(119, 'CONSO AMAGNAC', '2022-11-08 15:42:34', '2022-11-08 15:42:34'),
(120, 'CONSO CALVADOS', '2022-11-08 15:42:34', '2022-11-08 15:42:34'),
(121, 'CONSO COGNAC', '2022-11-08 15:42:34', '2022-11-08 15:42:34');

-- --------------------------------------------------------

--
-- Structure de la table `recettes`
--

DROP TABLE IF EXISTS `recettes`;
CREATE TABLE IF NOT EXISTS `recettes` (
  `recette_id` int(11) NOT NULL AUTO_INCREMENT,
  `auteur_id` int(11) NOT NULL,
  `date_recette` date DEFAULT NULL,
  `documents_id` int(11) NOT NULL,
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`recette_id`),
  KEY `fk_document_recettes` (`documents_id`),
  KEY `fk_user_recette` (`auteur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `recettes`
--

INSERT INTO `recettes` (`recette_id`, `auteur_id`, `date_recette`, `documents_id`, `date_enreg`, `date_modif`) VALUES
(3, 2, '2022-11-11', 0, '2022-11-12 00:37:41', '2022-11-12 00:37:41'),
(4, 2, '2022-11-12', 0, '2022-11-12 23:40:54', '2022-11-12 23:40:54'),
(5, 2, '2022-11-13', 0, '2022-11-13 23:43:29', '2022-11-13 23:43:29');

-- --------------------------------------------------------

--
-- Structure de la table `structures`
--

DROP TABLE IF EXISTS `structures`;
CREATE TABLE IF NOT EXISTS `structures` (
  `structure_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `statut` int(11) NOT NULL,
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`structure_id`),
  KEY `fk_users_structure` (`admin_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `structures`
--

INSERT INTO `structures` (`structure_id`, `admin_id`, `nom`, `statut`, `date_enreg`, `date_modif`) VALUES
(1, 1, 'O\'mel', 1, '2022-11-07 18:35:19', '2022-11-11 15:23:09');

-- --------------------------------------------------------

--
-- Structure de la table `type_depense`
--

DROP TABLE IF EXISTS `type_depense`;
CREATE TABLE IF NOT EXISTS `type_depense` (
  `type_depense_id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`type_depense_id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `type_depense`
--

INSERT INTO `type_depense` (`type_depense_id`, `libelle`, `description`, `date_enreg`, `date_modif`) VALUES
(1, 'GUINESS', '', '2022-11-11 16:14:54', '2022-11-11 16:14:54'),
(2, 'BEAUFORT ', '', '2022-11-11 16:14:54', '2022-11-11 16:14:54'),
(3, 'PILS TOGO', '', '2022-11-11 16:14:54', '2022-11-11 16:14:54'),
(4, 'BENINOISE', '', '2022-11-11 16:14:54', '2022-11-11 16:14:54'),
(5, 'PANACHE', '', '2022-11-11 16:14:54', '2022-11-11 16:14:54'),
(6, 'WORLD COLA', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(7, 'DOPPEL LARGER', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(8, 'TEQUILA', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(9, 'EKU', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(10, 'COCKTAIL / YOUZOU', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(11, 'PAMPLEMOUSSE/MOKA', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(12, 'XXL', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(13, 'EAU MINERALE', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(14, 'PRESSION(FUT)', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(15, 'ROX', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(16, 'HEINEKEN', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(17, 'DESPERADOS', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(18, 'CITRON', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(19, 'NESCAFE', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(20, 'MENTHE FRAICHE', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(21, 'PURE WATER', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(22, 'PAPIER TOILETTE', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(23, 'PAPIER SERVIETTE', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(24, 'PAPIER RAME', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(25, 'PAPIER THERMIQUE', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(26, 'SBEE', '', '2022-11-11 16:14:55', '2022-11-11 16:14:55'),
(27, 'JAVEL', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(28, 'AGRAFE', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(29, 'BALAI', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(30, 'PELLE BALAI', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(31, 'DESODORISANT TOILETTE', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(32, 'CHIFFON', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(33, 'LIQUIDE VAISSELLE', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(34, 'THE VERT', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(35, 'SUCRE ROUX', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(36, 'TORCHON ', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(37, 'ANANAS', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(38, 'PASTEQUE', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(39, 'PAPAYE', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(40, 'POMME FRUIT', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(41, 'SERPILLERE', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(42, 'CAMPARI', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(43, 'SUZE', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(44, 'MARTINI ROUGE', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(45, 'MARTINI BLANC', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(46, 'RHUM BLANC', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(47, 'RHUM BRUN', '', '2022-11-11 16:14:56', '2022-11-11 16:14:56'),
(48, 'SUCRE DE CANNE', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(49, 'VODKA', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(50, 'ORANGE SEC', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(51, 'TEQUILA', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(52, 'BLACK LABEL', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(53, 'GIN ', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(54, 'JB', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(55, 'RICARD', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(56, 'PASTIS', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(57, 'RED LABEL', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(58, 'SHERIDAN\'S', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(59, 'BAILEY\'s', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(60, 'JACK DANIELS', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(61, 'SIROP DE MENTHE', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(62, 'SIROP DE GRENADINE', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(63, 'MALIBU', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(64, 'COINTREAU', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(65, 'LAIT PEAK', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(66, 'AMPOULE', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(67, 'REABONNEMENT CANAL PLUS', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(68, 'ESSENCE EN LITRES', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(69, 'PAILLE', '', '2022-11-11 16:14:57', '2022-11-11 16:14:57'),
(70, 'PIQUE DENT', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(71, 'PAIN LIBANAIS', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(72, 'PAIN HAMBURGER', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(73, 'SAUCE SOJA', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(74, 'POIVRE BLANC MOULU', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(75, 'MAYONNAISE', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(76, 'CHOUX', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(77, 'PAPIER CHAWARMA', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(78, 'KETCHUP PETIT', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(79, 'KETCHUP GRAND', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(80, 'VIANDE CHAWARMA', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(81, 'VIANDE HAMBURGER', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(82, 'LAITUE', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(83, 'OIGNON', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(84, 'TOMATE FRAICHE', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(85, 'BLANC DE POULET', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(86, 'POULET CHAIR', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(87, 'ŒUFS', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(88, 'SPAGHETTI', '', '2022-11-11 16:14:58', '2022-11-11 16:14:58'),
(89, 'POMME DE TERRE', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(90, 'CONCOMBRE', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(91, 'CAROTTE', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(92, 'COURGETTE', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(93, 'HARICOT VERT', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(94, 'BETTERAVE', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(95, 'AIL', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(96, 'GINGEMBRE', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(97, 'ALOKO', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(98, 'FRITES', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(99, 'FRITES', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(100, 'POIVRON', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(101, 'PERSIL', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(102, 'ŒUFS DE CAILLE', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(103, 'THON', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(104, 'CHAMPIGNON', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(105, 'MAIS DOUX', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(106, 'PETIT POIS', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(107, 'CREVETTE FRAIS', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(108, 'FARINE DE BLE', '', '2022-11-11 16:14:59', '2022-11-11 16:14:59'),
(109, 'LAIT EN POUDRE', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(110, 'SUCRE', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(111, 'SEL', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(112, 'HUILE DE CUISSON', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(113, 'HUILE DE FRITURE', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(114, 'POISSON CARPE AU KG', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(115, 'POISSON BAR AU KG', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(116, 'SOLE AU KG', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(117, 'GROS BAR AU KG', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(118, 'POULET BICY', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(119, 'CAILLE', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(120, 'LAPIN FRAIS AU KG', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(121, 'ROGNON DE BŒUF', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(122, 'AILERON AU KG', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(123, 'LANGUE DE BŒUF', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(124, 'FILET DE BŒUF AU KG', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(125, 'VIANDE DE MOUTON AU KG', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(126, 'HERBES DE PROVENCE', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(127, 'MOUTARDE', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(128, 'CREME FRAICHE', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(129, 'POIVRE VERT', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(130, 'VINAIGRE', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(131, 'SARDINE', '', '2022-11-11 16:15:00', '2022-11-11 16:15:00'),
(132, 'PAPIER ALUMINIUM', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(133, 'PAPIER FILM', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(134, 'BICARBONATE', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(135, 'TOMATE CONCENTREE', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(136, 'TELIBO', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(137, 'MAIS POP CORN', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(138, 'MAIS POUR FARINE', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(139, 'BARQUE EMPORTER PETIT', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(140, 'BARQUE EMPORTER  GRAND', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(141, 'SACHET POUBELLE', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(142, 'SACHET PORTION', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(143, 'SACHET EMPORTER', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(144, 'GARI', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(145, 'TIGE BROCHETTE', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(146, 'PATE D\'ARACHIDE', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(147, 'HUILE ROUGE', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(148, 'ASSROKOUIN', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(149, 'KPAMAN', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(150, 'POISSON FUME', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(151, 'CRABE', '', '2022-11-11 16:15:01', '2022-11-11 16:15:01'),
(152, 'FROMAGE', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(153, 'GBOMAN', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(154, 'AMANVIVE', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(155, 'TCHIAYO', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(156, 'GAMBAS AU KILO', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(157, 'CALAMAR AU KILO', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(158, 'JAMBON DE DINDE', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(159, 'SAUCISSE', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(160, 'OMO', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(161, 'EPONGE', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(162, 'SPATULE', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(163, 'SAC DE RIZ', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(164, 'KILO DE RIZ', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(165, 'POISSON SECHE', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(166, 'CORNICHON', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(167, 'PIMENT VERT', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(168, 'PIMENT MOULU', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(169, 'CARTON PIZZA', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(170, 'ASSAISONNEMENT COMPOSE', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(171, 'CUBE', '', '2022-11-11 16:15:02', '2022-11-11 16:15:02'),
(172, 'MOZZARELLA', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(173, 'COUPE PIZZA', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(174, 'MANWE', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(175, 'AGBELI', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(176, 'ATCHEKE', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(177, 'GBOTA', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(178, 'GAZ', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(179, '4 EPICES', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(180, 'DETENTEUR', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(181, 'RACCORD', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(182, 'CESAME', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(183, 'ANCHOIX', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(184, 'OLIVE NOIRE', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(185, 'LEVURE BOULANGERE', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03'),
(186, 'PINCEAUX', '', '2022-11-11 16:15:03', '2022-11-11 16:15:03');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `structure_id` int(11) NOT NULL,
  `nom_prenoms` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `statut` varchar(11) NOT NULL DEFAULT 'Désactivé',
  `tel` int(11) DEFAULT NULL,
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_structure_user` (`structure_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `structure_id`, `nom_prenoms`, `email`, `mdp`, `statut`, `tel`, `date_enreg`, `date_modif`) VALUES
(1, 1, 'Administrateur Suprème', 'admin@admin.com', '$2y$10$NO3wBr4v5IkzjFMtV5jLCOkKHnHdXnzTc0w6LjJo6Wgjbhu2P/uFC', 'Actif', 0, '2022-11-07 18:15:22', '2022-11-07 18:15:22'),
(2, 1, 'Fade Vochi', 'fadevochi@gmail.com', '$2y$10$QSG4VnP8AsJ5nHeZ74zyuuI00gMYSbVeWMosYBEp3ZZI6gdQQzBWe', 'Actif', 0, '2022-11-07 18:36:06', '2022-11-07 18:36:06'),
(3, 1, 'Emmanuella Asmana', 'emmanuellaasmana0@gmail.com', '$2y$10$6VRAhew5/I1JLneAPRbj2O57PqyRi2vEd.RqR.nGjHCrsDK/dRtG2', 'Actif', 0, '2022-11-07 18:36:40', '2022-11-07 18:36:40'),
(4, 1, 'Honor Emaba', 'honoremaba12@gmail.com', '$2y$10$fWNI9QRmBubx7yA1fv/R8uiOqxsjR9IG6gjwmpJ0wc.FK1Y9RDHBO', 'Actif', 0, '2022-11-07 18:37:20', '2022-11-07 18:37:20'),
(5, 1, 'Eskil Gakpe', 'eskilgakpe5@gmail.com', '$2y$10$eWPlXncQmX1Sx1UqssxiaOALC26v33NPslnhD0r1S.mQqBgqikpIS', 'Actif', 0, '2022-11-07 18:37:57', '2022-11-07 18:37:57'),
(6, 1, 'Laurent Ayite', 'laurentayite@akpahgmail.com', '$2y$10$Y3fUcmFiGhwyA19DfuN4iuAtb0kXkCwi7Z4.ga7jQ0o0OMTw1C6bi', 'Desactive', 0, '2022-11-07 18:38:48', '2022-11-07 18:38:48'),
(7, 1, 'Houedikin Yvette', 'houedikinyvette@gmail.com', '$2y$10$8eJWFXWmjaZLM4e9saTtF.ZNHdV5RMFUY7fkqm6QNzCYkseJYM.xu', 'Actif', 0, '2022-11-07 18:39:55', '2022-11-07 18:39:55');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

DROP TABLE IF EXISTS `ventes`;
CREATE TABLE IF NOT EXISTS `ventes` (
  `vente_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `recette_id` int(11) DEFAULT NULL,
  `qte` int(11) NOT NULL,
  `prix_unitaire` int(11) NOT NULL,
  `mode_paiement` varchar(15) NOT NULL,
  `commentaire` text NOT NULL,
  `date_vente` date NOT NULL,
  `statut` int(11) NOT NULL,
  `date_enreg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`vente_id`),
  KEY `fk_users_recettes` (`user_id`),
  KEY `fk_recette_vente` (`recette_id`),
  KEY `produit_id` (`produit_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `ventes`
--

INSERT INTO `ventes` (`vente_id`, `user_id`, `produit_id`, `recette_id`, `qte`, `prix_unitaire`, `mode_paiement`, `commentaire`, `date_vente`, `statut`, `date_enreg`, `date_modif`) VALUES
(1, 7, 1, 3, 1, 1200, 'momo', '', '2022-11-11', 1, '2022-11-11 20:31:31', '2022-11-12 00:37:41'),
(3, 4, 95, 3, 6, 500, 'momo', '', '2022-11-11', 1, '2022-11-11 23:15:35', '2022-11-12 00:37:41'),
(4, 4, 94, 3, 5, 700, 'momo', '', '2022-11-11', 1, '2022-11-11 23:18:46', '2022-11-12 00:37:41'),
(5, 4, 102, 3, 1, 400, 'momo', '', '2022-11-11', 1, '2022-11-11 23:19:41', '2022-11-12 00:37:41'),
(6, 4, 38, 3, 1, 5000, 'momo', '', '2022-11-11', 1, '2022-11-11 23:20:24', '2022-11-12 00:37:41'),
(7, 7, 97, 3, 1, 700, 'Espèce', '', '2022-11-11', 1, '2022-11-11 23:24:00', '2022-11-12 00:37:41'),
(8, 4, 1, 3, 2, 1700, 'momo', '', '2022-11-11', 1, '2022-11-11 23:25:30', '2022-11-12 00:37:41'),
(9, 4, 103, 3, 1, 500, 'momo', '', '2022-11-11', 1, '2022-11-11 23:26:16', '2022-11-12 00:37:41'),
(10, 7, 102, 3, 1, 400, 'Espèce', '', '2022-11-11', 1, '2022-11-11 23:26:21', '2022-11-12 00:37:41'),
(11, 7, 1, 3, 1, 1700, 'Espèce', '', '2022-11-11', 1, '2022-11-11 23:28:27', '2022-11-12 00:37:41'),
(12, 4, 68, 3, 2, 2000, 'Espèce', '', '2022-11-11', 1, '2022-11-11 23:29:05', '2022-11-12 00:37:41'),
(13, 7, 31, 3, 1, 3500, 'Espèce', '', '2022-11-11', 1, '2022-11-11 23:30:55', '2022-11-12 00:37:41'),
(14, 7, 104, 3, 1, 500, 'Espèce', '', '2022-11-11', 1, '2022-11-11 23:32:01', '2022-11-12 00:37:41'),
(15, 4, 95, 3, 5, 500, 'Espèce', '', '2022-11-11', 1, '2022-11-11 23:32:51', '2022-11-12 00:37:41'),
(16, 7, 17, 3, 1, 3000, 'Espèce', '', '2022-11-11', 1, '2022-11-11 23:33:43', '2022-11-12 00:37:41'),
(17, 4, 103, 3, 2, 500, 'Espèce', '', '2022-11-11', 1, '2022-11-11 23:33:59', '2022-11-12 00:37:41'),
(18, 7, 109, 3, 1, 1000, 'Espèce', '', '2022-11-11', 1, '2022-11-11 23:34:55', '2022-11-12 00:37:41'),
(19, 7, 102, 3, 1, 400, 'Espèce', '', '2022-11-11', 1, '2022-11-11 23:35:33', '2022-11-12 00:37:41'),
(20, 4, 95, 3, 1, 500, 'Espèce', 'Baby foot et nn Beaufort ', '2022-11-11', 1, '2022-11-11 23:35:55', '2022-11-12 00:37:41'),
(21, 7, 98, 3, 1, 800, 'Espèce', '', '2022-11-12', 1, '2022-11-12 00:20:43', '2022-11-12 00:37:41'),
(22, 7, 103, 3, 1, 500, 'Espèce', '', '2022-11-12', 1, '2022-11-12 00:22:15', '2022-11-12 00:37:41'),
(23, 7, 5, 3, 1, 2000, 'Espèce', '', '2022-11-12', 1, '2022-11-12 00:25:17', '2022-11-12 00:37:41'),
(24, 4, 109, 3, 1, 1000, 'momo', '', '2022-11-12', 1, '2022-11-12 00:34:13', '2022-11-12 00:37:41'),
(25, 4, 95, 3, 3, 500, 'momo', '', '2022-11-12', 1, '2022-11-12 00:34:39', '2022-11-12 00:37:41'),
(26, 4, 94, 3, 1, 700, 'momo', '', '2022-11-12', 1, '2022-11-12 00:34:58', '2022-11-12 00:37:41'),
(27, 4, 5, 3, 2, 2000, 'momo', '', '2022-11-12', 1, '2022-11-12 00:35:21', '2022-11-12 00:37:41'),
(28, 4, 97, 4, 6, 700, 'Espèce', '', '2022-11-12', 1, '2022-11-12 16:49:00', '2022-11-12 23:40:54'),
(29, 4, 104, 4, 1, 500, 'Espèce', '', '2022-11-12', 1, '2022-11-12 16:49:31', '2022-11-12 23:40:54'),
(30, 4, 95, 4, 3, 500, 'Espèce', '', '2022-11-12', 1, '2022-11-12 17:25:40', '2022-11-12 23:40:54'),
(31, 4, 93, 4, 1, 500, 'Espèce', '', '2022-11-12', 1, '2022-11-12 17:28:38', '2022-11-12 23:40:54'),
(32, 4, 48, 4, 1, 4000, 'Espèce', 'Poulet qui est vendue ', '2022-11-12', 1, '2022-11-12 19:08:56', '2022-11-12 23:40:54'),
(33, 4, 94, 4, 4, 700, 'Espèce', '', '2022-11-12', 1, '2022-11-12 19:10:24', '2022-11-12 23:40:54'),
(34, 4, 108, 4, 2, 800, 'Espèce', '', '2022-11-12', 1, '2022-11-12 19:10:41', '2022-11-12 23:40:54'),
(35, 7, 1, 4, 2, 1200, 'Espèce', '', '2022-11-12', 1, '2022-11-12 20:27:43', '2022-11-12 23:40:54'),
(36, 7, 1, 4, 1, 1200, 'Espèce', '', '2022-11-12', 1, '2022-11-12 21:15:55', '2022-11-12 23:40:54'),
(37, 7, 68, 4, 1, 2000, 'Espèce', '', '2022-11-12', 1, '2022-11-12 21:18:23', '2022-11-12 23:40:54'),
(38, 7, 95, 4, 1, 500, 'Espèce', '', '2022-11-12', 1, '2022-11-12 21:19:18', '2022-11-12 23:40:54'),
(39, 4, 1, 4, 1, 1200, 'Espèce', '', '2022-11-12', 1, '2022-11-12 22:01:27', '2022-11-12 23:40:54'),
(40, 4, 102, 4, 1, 400, 'Espèce', '', '2022-11-12', 1, '2022-11-12 22:03:17', '2022-11-12 23:40:54'),
(41, 4, 13, 4, 1, 2000, 'Espèce', '', '2022-11-12', 1, '2022-11-12 22:13:10', '2022-11-12 23:40:54'),
(42, 4, 94, 4, 2, 700, 'Espèce', '', '2022-11-12', 1, '2022-11-12 22:13:55', '2022-11-12 23:40:54'),
(43, 4, 108, 4, 1, 800, 'Espèce', '', '2022-11-12', 1, '2022-11-12 22:14:12', '2022-11-12 23:40:54'),
(44, 4, 98, 4, 1, 800, 'Espèce', '', '2022-11-12', 1, '2022-11-12 22:15:14', '2022-11-12 23:40:54'),
(45, 4, 104, 4, 1, 500, 'Espèce', '', '2022-11-12', 1, '2022-11-12 22:15:56', '2022-11-12 23:40:54'),
(46, 4, 113, 4, 1, 1000, 'Espèce', '', '2022-11-12', 1, '2022-11-12 22:16:21', '2022-11-12 23:40:54'),
(47, 7, 95, 4, 2, 500, 'Espèce', '', '2022-11-12', 1, '2022-11-12 23:38:08', '2022-11-12 23:40:54'),
(48, 7, 98, 4, 1, 800, 'Espèce', '', '2022-11-12', 1, '2022-11-12 23:38:46', '2022-11-12 23:40:54'),
(49, 7, 103, 4, 2, 500, 'Espèce', '', '2022-11-12', 1, '2022-11-12 23:39:13', '2022-11-12 23:40:54'),
(50, 7, 102, 5, 1, 400, 'Espèce', '', '2022-11-13', 1, '2022-11-13 17:59:32', '2022-11-13 23:43:29'),
(51, 7, 1, 5, 1, 1200, 'momo', '', '2022-11-13', 1, '2022-11-13 19:46:24', '2022-11-13 23:43:29'),
(52, 7, 2, 5, 3, 1500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:09:58', '2022-11-13 23:43:29'),
(53, 7, 1, 5, 1, 1200, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:10:42', '2022-11-13 23:43:29'),
(54, 7, 95, 5, 3, 500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:11:17', '2022-11-13 23:43:29'),
(55, 7, 109, 5, 2, 1000, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:12:19', '2022-11-13 23:43:29'),
(56, 7, 103, 5, 2, 500, 'momo', '', '2022-11-13', 1, '2022-11-13 20:13:21', '2022-11-13 23:43:29'),
(57, 7, 104, 5, 1, 500, 'momo', '', '2022-11-13', 1, '2022-11-13 20:13:50', '2022-11-13 23:43:29'),
(58, 4, 1, 5, 1, 1200, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:26:19', '2022-11-13 23:43:29'),
(59, 4, 93, 5, 1, 500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:26:43', '2022-11-13 23:43:29'),
(60, 4, 103, 5, 1, 500, 'Espèce', 'Panaché ', '2022-11-13', 1, '2022-11-13 20:27:43', '2022-11-13 23:43:29'),
(61, 4, 95, 5, 4, 500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:39:52', '2022-11-13 23:43:29'),
(62, 4, 93, 5, 6, 500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:40:12', '2022-11-13 23:43:29'),
(63, 4, 102, 5, 1, 400, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:40:37', '2022-11-13 23:43:29'),
(64, 7, 1, 5, 1, 1200, 'momo', '', '2022-11-13', 1, '2022-11-13 20:44:53', '2022-11-13 23:43:29'),
(65, 4, 97, 5, 2, 700, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:52:24', '2022-11-13 23:43:29'),
(66, 4, 98, 5, 6, 800, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:53:30', '2022-11-13 23:43:29'),
(67, 4, 94, 5, 2, 700, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:54:21', '2022-11-13 23:43:29'),
(68, 4, 93, 5, 2, 500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 20:54:44', '2022-11-13 23:43:29'),
(69, 4, 95, 5, 1, 500, 'Espèce', 'Baby foot ', '2022-11-13', 1, '2022-11-13 20:55:55', '2022-11-13 23:43:29'),
(70, 7, 103, 5, 1, 500, 'momo', '', '2022-11-13', 1, '2022-11-13 20:56:01', '2022-11-13 23:43:29'),
(71, 7, 1, 5, 1, 1200, 'Espèce', '', '2022-11-13', 1, '2022-11-13 21:10:46', '2022-11-13 23:43:29'),
(72, 7, 104, 5, 1, 500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 21:12:05', '2022-11-13 23:43:29'),
(73, 4, 54, 5, 1, 4500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 21:54:32', '2022-11-13 23:43:29'),
(74, 7, 1, 5, 1, 1200, 'Espèce', '', '2022-11-13', 1, '2022-11-13 22:17:10', '2022-11-13 23:43:29'),
(75, 7, 48, 5, 2, 4000, 'Espèce', '', '2022-11-13', 1, '2022-11-13 22:17:41', '2022-11-13 23:43:29'),
(76, 4, 1, 5, 3, 1200, 'Espèce', '', '2022-11-13', 1, '2022-11-13 22:17:43', '2022-11-13 23:43:29'),
(77, 4, 13, 5, 1, 2000, 'Espèce', '', '2022-11-13', 1, '2022-11-13 22:18:03', '2022-11-13 23:43:29'),
(78, 4, 42, 5, 1, 1000, 'Espèce', 'Frite', '2022-11-13', 1, '2022-11-13 22:18:51', '2022-11-13 23:43:29'),
(79, 4, 94, 5, 1, 700, 'Espèce', '', '2022-11-13', 1, '2022-11-13 22:19:50', '2022-11-13 23:43:29'),
(80, 4, 104, 5, 1, 500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 22:20:11', '2022-11-13 23:43:29'),
(81, 7, 42, 5, 2, 1000, 'Espèce', '2 Aloco', '2022-11-13', 1, '2022-11-13 22:20:49', '2022-11-13 23:43:29'),
(82, 4, 54, 5, 2, 4500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 22:27:12', '2022-11-13 23:43:29'),
(83, 4, 1, 5, 1, 1200, 'Espèce', '', '2022-11-13', 1, '2022-11-13 22:27:58', '2022-11-13 23:43:29'),
(84, 4, 93, 5, 3, 500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 22:28:49', '2022-11-13 23:43:29'),
(85, 4, 96, 5, 3, 500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 22:29:18', '2022-11-13 23:43:29'),
(87, 4, 98, 5, 1, 800, 'momo', '', '2022-11-13', 1, '2022-11-13 23:32:44', '2022-11-13 23:43:29'),
(88, 7, 104, 5, 1, 500, 'Espèce', '', '2022-11-13', 1, '2022-11-13 23:40:51', '2022-11-13 23:43:29'),
(89, 1, 103, NULL, 2, 500, 'Espèce', '', '2022-11-14', 0, '2022-11-14 13:10:31', '2022-11-14 13:10:31'),
(90, 1, 1, NULL, 3, 1200, 'Espèce', '', '2022-11-14', 0, '2022-11-14 13:11:12', '2022-11-14 13:11:12');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
