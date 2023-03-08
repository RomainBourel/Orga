-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 08 mars 2023 à 13:31
-- Version du serveur : 10.6.11-MariaDB-cll-lve
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u783303511_orga`
--

-- --------------------------------------------------------

--
-- Structure de la table `available`
--

CREATE TABLE `available` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `proposition_date_id` int(11) NOT NULL,
  `is_available` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `available`
--

INSERT INTO `available` (`id`, `user_id`, `proposition_date_id`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 7, 15, 1, '2023-01-14 12:29:26', '2023-01-14 12:29:26');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'nouriture', '2023-01-13 14:29:27', '2023-01-13 14:29:27'),
(2, 'boisson', '2023-01-13 14:29:27', '2023-01-13 14:29:27'),
(3, 'autre', '2023-01-13 14:29:27', '2023-01-13 14:29:27');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `party_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 15, 'coucou les amis', '2023-02-10 10:53:26', '2023-02-10 10:53:26'),
(2, 1, 15, 'comment allez vous', '2023-02-10 10:54:00', '2023-02-10 10:54:00'),
(3, 1, 15, 'test', '2023-02-10 11:08:16', '2023-02-10 11:08:16'),
(4, 1, 15, 'test', '2023-02-10 11:08:57', '2023-02-10 11:08:57'),
(5, 1, 15, 'aze', '2023-02-10 11:21:59', '2023-02-10 11:21:59'),
(6, 1, 15, 'aze', '2023-02-10 11:22:05', '2023-02-10 11:22:05'),
(7, 1, 12, 'coucou comment ça vas', '2023-02-10 13:24:05', '2023-02-10 13:24:05'),
(8, 1, 12, 'moi nickel', '2023-02-10 13:24:20', '2023-02-10 13:24:20'),
(12, 11, 20, 'Hello, êtes vous dispo ?', '2023-02-24 11:16:57', '2023-02-24 11:16:57');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230113100220', '2023-01-13 14:28:33', 515),
('DoctrineMigrations\\Version20230207124527', '2023-02-08 16:12:33', 1386),
('DoctrineMigrations\\Version20230208163156', '2023-02-08 16:34:54', 434);

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `principal` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `location`
--

INSERT INTO `location` (`id`, `user_id`, `name`, `address`, `city`, `zip_code`, `created_at`, `updated_at`, `principal`) VALUES
(1, 1, 'maison', '39 rue de Beaucourt', 'Roubaix', '59100', '2023-01-13 14:38:36', '2023-01-13 18:42:54', 1),
(3, 3, 'La maison du Kebab', '13 rue de la Sauce', 'Istanbul', '11111', '2023-01-13 15:25:02', '2023-01-13 15:25:02', 1),
(6, 5, 'Chez toto', '75 rue du canal', 'Feurs', '42100', '2023-01-13 15:52:55', '2023-01-13 15:52:55', 1),
(7, 6, 'Bourel', '39 rue Beaucourt', 'Roubaix', '59100', '2023-01-13 16:48:23', '2023-01-13 16:48:23', 1),
(9, 8, 'maison', '39 rue de beaucourt', 'Roubaix', '59100', '2023-01-31 22:10:39', '2023-01-31 22:10:39', 1),
(10, 9, 'Chez moi', 'ici', 'Paris', '59126', '2023-02-10 10:17:17', '2023-02-10 10:17:17', 1),
(11, 10, 'grosse teuf', '68 rue roger salengro', 'Lille', '59000', '2023-02-10 10:24:44', '2023-02-10 10:24:44', 1),
(12, 11, 'Mon adresse', '88 rue du blablabla88 rue du blablabla88 rue du blablabla88 rue du blablabla88 rue du blablabla88 rue du blablabla88 rue du blablabla88 rue du blablabla88 rue du blablabla88 rue du blablabla88 rue du blablabla88 rue du blablabla88 rue du blablabla88 rue d', 'Lolo', '55555', '2023-02-24 11:11:58', '2023-03-08 11:24:36', 0);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `party`
--

CREATE TABLE `party` (
  `id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `slug` varchar(255) NOT NULL,
  `invitation_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `party`
--

INSERT INTO `party` (`id`, `creator_id`, `location_id`, `name`, `description`, `created_at`, `updated_at`, `slug`, `invitation_token`) VALUES
(8, 5, 6, 'Manger des sushis', NULL, '2023-01-13 15:58:43', '2023-01-13 15:58:43', 'Manger-des-sushis', NULL),
(10, 5, 6, '123', NULL, '2023-01-13 16:13:50', '2023-01-13 16:13:50', '123', NULL),
(11, 6, 7, 'Galette', 'Venez tous déguster une bonne galette chez nous', '2023-01-13 16:55:08', '2023-01-13 16:55:18', 'Galette', 'fa6d678326701d3100c03684126944b.HqIS4YCQOZHzrgJih7AEIphGREFWfntl3IWgwHC26c0.KcFUitejU9C7-041_vRgS88jdRIPDhE97_D38gKDq4gq5CWV-ftepaPGUw'),
(12, 1, 1, 'Invitation Justin à manger chez nous', NULL, '2023-01-13 18:44:33', '2023-01-13 18:44:37', 'Invitation-Justin-a-manger-chez-nous', '05fe58aab131fea5e02e3de250c8b.HEKYAxscgzOq0RcLjWk2J257SEUn_ajT_EGVdp-0G7E.VAbZNWJt8WzSmFBTvwZibzo1AC9Nxff-ryvKEvXwSeskcutheVDtQOCXRg'),
(13, 1, 1, 'La fête', NULL, '2023-01-14 12:04:02', '2023-01-14 12:10:38', 'La-fete', 'a0e770e444a7daccb35664012c7a4e.nT1zaRRMTY80nZzBlYWCXDcRm2RFq9t9edjB6yAzo4w.pVEeUHc6APV6_PWi9tLBcU914yM1zJwEIIqvkVVH9trLRRcde3gku3780Q'),
(15, 1, 1, 'soirée pizza', 'venez nombreux', '2023-02-10 10:52:35', '2023-02-10 10:54:11', 'soiree-pizza', 'fdbc6a9ad83631d4fc85dd8c4a.mTPKnDshXeCO-WQ7wggFd-A8kiuVDvFQxqarQOAf3Dc.03fy-g5zObe5zS5JgCV9J7lz82_vY6kTo8fudplqiwDQQ6XwdBQJiaOcXA'),
(17, 1, 1, 'semaine masqué', NULL, '2023-02-10 13:49:06', '2023-02-10 13:49:06', 'semaine-masque', NULL),
(20, 11, 12, 'Anniv de seb', NULL, '2023-02-24 11:14:31', '2023-02-24 11:17:04', 'Anniv-de-seb', '0326de7d908c38d.zp9rbo0FikJY09T5mM1slxiUz_W-REqJu85lpp3wJMc.tMBbQ-pN5zYW5oWK3YA0-2_grazOARC99po_3--zbpi2zh9exVzYJw7lnQ');

-- --------------------------------------------------------

--
-- Structure de la table `party_user`
--

CREATE TABLE `party_user` (
  `party_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `party_user`
--

INSERT INTO `party_user` (`party_id`, `user_id`) VALUES
(8, 5),
(10, 5),
(11, 6),
(12, 1),
(13, 1),
(13, 7),
(15, 1),
(17, 1),
(20, 11);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `unity_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `udated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `is_moderate` tinyint(1) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `unity_id`, `category_id`, `user_id`, `name`, `description`, `picture`, `slug`, `created_at`, `udated_at`, `is_moderate`, `is_published`) VALUES
(1, 4, 1, 1, 'pizza margarita', NULL, 'margarita-63c16d4a1d397.jpg', 'pizza-margarita', '2023-01-13 14:40:10', '2023-01-13 14:40:10', NULL, 1),
(2, 1, 3, 3, 'eau', NULL, NULL, 'eau', '2023-01-13 15:25:37', '2023-01-13 15:25:37', NULL, NULL),
(6, 1, 1, 6, 'Galette', 'Frangipane', NULL, 'Galette', '2023-01-13 16:50:29', '2023-01-13 16:50:29', NULL, NULL),
(8, 1, 3, 6, 'Jus d’orange', NULL, NULL, 'Jus-d-orange', '2023-01-13 16:55:01', '2023-01-13 16:55:01', NULL, NULL),
(9, 3, 2, 1, 'Boisson sans alcool', NULL, NULL, 'Boisson-sans-alcool', '2023-01-14 12:02:45', '2023-01-14 12:02:45', NULL, 1),
(10, 3, 2, 1, 'Boisson alcoolisée', NULL, NULL, 'Boisson-alcoolisee', '2023-01-14 12:03:09', '2023-01-14 12:32:55', NULL, 1),
(12, 2, 1, 1, 'Biscuits apéro', NULL, NULL, 'Biscuits-apero', '2023-01-14 12:03:55', '2023-01-14 12:03:55', NULL, 1),
(13, 3, 2, 1, 'coca cola', NULL, 'coca-cola-63e6460672ae9.png', 'coca-cola', '2023-02-10 13:26:30', '2023-02-10 13:26:30', NULL, 1),
(15, 1, 1, 1, 'fromage raclette', NULL, 'Raclette-plateau-houlgate-63e64f12a962d.jpg', 'fromage-raclette', '2023-02-10 14:05:06', '2023-03-06 09:36:36', NULL, 1),
(16, 4, 3, 1, 'appareil raclette', NULL, 'appareil-a-raclette-8-pers-bois-63e654a4331f9.jpg', 'appareil-raclette', '2023-02-10 14:28:52', '2023-02-10 14:28:52', NULL, 1),
(18, 2, 1, 1, 'poisson', NULL, NULL, 'poisson', '2023-03-06 09:22:58', '2023-03-06 09:22:58', NULL, 1),
(19, 4, 3, 1, 'Jdr', NULL, '586F0AE1-BC22-4AB6-88E7-24367FC3188C-640853fdb36c8.jpg', 'Jdr', '2023-03-08 09:23:09', '2023-03-08 09:23:09', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `product_party`
--

CREATE TABLE `product_party` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `sharing` tinyint(1) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_party`
--

INSERT INTO `product_party` (`id`, `product_id`, `party_id`, `sharing`, `quantity`, `created_at`, `updated_at`) VALUES
(7, 8, 11, 0, 1, '2023-01-13 16:55:08', '2023-01-13 16:55:08'),
(8, 9, 13, 0, 5, '2023-01-14 12:04:02', '2023-01-14 12:04:02'),
(9, 10, 13, 0, 5, '2023-01-14 12:04:02', '2023-01-14 12:04:02'),
(11, 12, 13, 0, 6, '2023-01-14 12:04:02', '2023-01-14 12:04:02'),
(13, 1, 15, 0, 3, '2023-02-10 10:52:35', '2023-02-10 10:52:35'),
(23, 13, 20, 0, 1, '2023-02-24 11:15:13', '2023-02-24 11:15:13'),
(24, 9, 20, 0, 2, '2023-02-24 11:15:44', '2023-02-24 11:15:44');

-- --------------------------------------------------------

--
-- Structure de la table `product_user`
--

CREATE TABLE `product_user` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_user`
--

INSERT INTO `product_user` (`product_id`, `user_id`) VALUES
(15, 13);

-- --------------------------------------------------------

--
-- Structure de la table `proposition_date`
--

CREATE TABLE `proposition_date` (
  `id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `starting_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `ending_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `number_max_participant` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `final_date` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `proposition_date`
--

INSERT INTO `proposition_date` (`id`, `party_id`, `starting_at`, `ending_at`, `number_max_participant`, `created_at`, `updated_at`, `final_date`) VALUES
(8, 8, '2023-01-13 16:53:00', '2023-01-27 16:53:00', 10, '2023-01-13 15:58:43', '2023-01-13 15:58:43', NULL),
(10, 10, '2023-01-14 17:13:00', '2023-01-15 17:13:00', 5, '2023-01-13 16:13:50', '2023-01-13 16:13:50', NULL),
(11, 11, '2023-01-13 17:52:00', '2023-01-13 23:52:00', 10, '2023-01-13 16:55:08', '2023-01-13 16:55:08', NULL),
(12, 12, '2023-01-29 12:30:00', NULL, NULL, '2023-01-13 18:44:33', '2023-02-10 13:23:57', 1),
(13, 12, '2023-02-05 12:30:00', NULL, NULL, '2023-01-13 18:44:33', '2023-02-10 13:23:57', 0),
(14, 12, '2023-03-12 12:30:00', NULL, NULL, '2023-01-13 18:44:33', '2023-02-10 13:23:57', 0),
(15, 13, '2023-01-21 13:00:00', NULL, NULL, '2023-01-14 12:04:02', '2023-01-14 12:04:02', NULL),
(16, 13, '2023-01-22 13:00:00', NULL, NULL, '2023-01-14 12:04:02', '2023-01-14 12:04:02', NULL),
(18, 15, '2023-02-11 12:00:00', NULL, NULL, '2023-02-10 10:52:35', '2023-02-10 13:48:38', 1),
(19, 15, '2023-02-12 12:00:00', '2023-02-12 18:00:00', NULL, '2023-02-10 10:52:35', '2023-02-10 13:48:38', 0),
(22, 17, '2023-02-11 14:48:00', '2023-02-19 14:48:00', NULL, '2023-02-10 13:49:06', '2023-02-10 13:49:06', 1),
(27, 20, '2023-02-24 12:14:00', '2023-02-25 12:14:00', NULL, '2023-02-24 11:14:31', '2023-02-24 11:14:31', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reserved_product`
--

CREATE TABLE `reserved_product` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_party_id` int(11) NOT NULL,
  `quantity_reserved` int(11) NOT NULL,
  `quantity_buy` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reserved_product`
--

INSERT INTO `reserved_product` (`id`, `user_id`, `product_party_id`, `quantity_reserved`, `quantity_buy`, `created_at`, `updated_at`, `status`) VALUES
(5, 7, 9, 5, 5, '2023-01-14 12:29:41', '2023-01-14 12:33:15', 'bought'),
(6, 7, 11, 6, 6, '2023-01-14 12:30:01', '2023-01-14 12:30:02', 'bought');

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) NOT NULL,
  `hashed_token` varchar(100) NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `unity`
--

CREATE TABLE `unity` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `shortname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `unity`
--

INSERT INTO `unity` (`id`, `name`, `created_at`, `updated_at`, `shortname`) VALUES
(1, 'gramme', '2023-01-13 14:29:27', '2023-01-13 14:29:27', 'g'),
(2, 'kilogramme', '2023-01-13 14:29:27', '2023-01-13 14:29:27', 'Kg'),
(3, 'litre', '2023-01-13 14:29:27', '2023-01-13 14:29:27', 'L'),
(4, 'pièce', '2023-01-13 14:29:27', '2023-01-13 14:29:27', 'pièce');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`, `username`) VALUES
(1, 'romainboureldev@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$v5J1iyi6q7S08WvwWq8Ev.l1dU7/QJxfV2DWc6V8.yg1jU4h6JRkO', 1, 'romain'),
(2, 'sergetouvoli@outlook.fr', '[]', '$2y$13$xTlk4v2nisC/VbRL7cRis.rOUvFyGBLqRDX.fRFEeJP1U5qMVSu1e', 1, 'serge'),
(3, 'testdusitearomain@fethi.me', '[]', '$2y$13$Sv8/XWmIbaMUxq/.TlXp.OShe4e3DMoLHoX7RVWdT4XLSXEmsqL9m', 1, 'Fethi'),
(5, 'marine.erbon@gmail.com', '[]', '$2y$13$AR9t9NwJndO.vpwxwp51QOCiOEvIkgZkYbUKMcTjkjyDY1WKXWu2W', 1, 'toto42'),
(6, 'faustine.vilain@hotmail.fr', '[]', '$2y$13$4fKVzXilMhhOFkhI.tbbEeAX9Jt9uviLxY9rlXKyp5boYDbmWbgP2', 1, 'Faustine'),
(7, 'eric.bourel@wanadoo.fr', '[]', '$2y$13$Ume0xBbh0eA3p60FfgLT0eA8Bf1aaOWg9l73kBi0c11lOzC7cwEpq', 1, 'eric.bourel@wanadoo.fr'),
(8, 'romainbourel@outlook.fr', '{\"1\":\"ROLE_USER\"}', '$2y$13$iQnC9u1TmENP630txBa5qeNWPahXwT2./9S6mgQ7RKA4WPalmYvaS', 1, 'romain'),
(9, 'romainboureldev+2@gmail.com', '[]', '$2y$13$OeKzj1HZj4sPDJh23w2H4Oq/AyUTigCrtrES0kp9AmW7rb6B6HTQW', 1, 'romain-2'),
(10, 'cecilevilport@gmail.com', '[]', '$2y$13$ic8VhgZ4Cn8fzHO.7UvVk.W/ZcRvZEOhFtvUIAqfsWvdU8GSVaMP.', 1, 'cecilev'),
(11, 'kepoka@getairmail.com', '[]', '$2y$13$LCdo59Bd8IfgFPSTNy1i6OARm9w4zD9xw1WYoxeG6ki1deqIEu59a', 1, 'kepoka'),
(12, 'romainboureldev+1@gmail.com', '[]', '$2y$13$XtfdWzzBl/MLPTrfdu0Nw.p/Rz.oyRXUMOE3EpAlohpZKWgQrosEi', 1, 'romain1'),
(13, 'sofians@hotmail.fr', '[]', '$2y$13$MhHFpnDmWYznjZfhYjbT0e8jQldN7vwAeao9eLSsJKtW6/rmx8hEK', 1, 'so');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `available`
--
ALTER TABLE `available`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A58FA485A76ED395` (`user_id`),
  ADD KEY `IDX_A58FA4851CC09F84` (`proposition_date_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`),
  ADD KEY `IDX_9474526C213C1059` (`party_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5E9E89CBA76ED395` (`user_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_89954EE061220EA6` (`creator_id`),
  ADD KEY `IDX_89954EE064D218E` (`location_id`);

--
-- Index pour la table `party_user`
--
ALTER TABLE `party_user`
  ADD PRIMARY KEY (`party_id`,`user_id`),
  ADD KEY `IDX_9230179A213C1059` (`party_id`),
  ADD KEY `IDX_9230179AA76ED395` (`user_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04ADF6859C8C` (`unity_id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`),
  ADD KEY `IDX_D34A04ADA76ED395` (`user_id`);

--
-- Index pour la table `product_party`
--
ALTER TABLE `product_party`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_28C935BC4584665A` (`product_id`),
  ADD KEY `IDX_28C935BC213C1059` (`party_id`);

--
-- Index pour la table `product_user`
--
ALTER TABLE `product_user`
  ADD PRIMARY KEY (`product_id`,`user_id`),
  ADD KEY `IDX_7BF4E84584665A` (`product_id`),
  ADD KEY `IDX_7BF4E8A76ED395` (`user_id`);

--
-- Index pour la table `proposition_date`
--
ALTER TABLE `proposition_date`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F13CF708213C1059` (`party_id`);

--
-- Index pour la table `reserved_product`
--
ALTER TABLE `reserved_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6A917B6AA76ED395` (`user_id`),
  ADD KEY `IDX_6A917B6AEA8C7ACE` (`product_party_id`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Index pour la table `unity`
--
ALTER TABLE `unity`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `available`
--
ALTER TABLE `available`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `party`
--
ALTER TABLE `party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `product_party`
--
ALTER TABLE `product_party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `proposition_date`
--
ALTER TABLE `proposition_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `reserved_product`
--
ALTER TABLE `reserved_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `unity`
--
ALTER TABLE `unity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `available`
--
ALTER TABLE `available`
  ADD CONSTRAINT `FK_A58FA4851CC09F84` FOREIGN KEY (`proposition_date_id`) REFERENCES `proposition_date` (`id`),
  ADD CONSTRAINT `FK_A58FA485A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C213C1059` FOREIGN KEY (`party_id`) REFERENCES `party` (`id`),
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `FK_5E9E89CBA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `party`
--
ALTER TABLE `party`
  ADD CONSTRAINT `FK_89954EE061220EA6` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_89954EE064D218E` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`);

--
-- Contraintes pour la table `party_user`
--
ALTER TABLE `party_user`
  ADD CONSTRAINT `FK_9230179A213C1059` FOREIGN KEY (`party_id`) REFERENCES `party` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9230179AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D34A04ADA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_D34A04ADF6859C8C` FOREIGN KEY (`unity_id`) REFERENCES `unity` (`id`);

--
-- Contraintes pour la table `product_party`
--
ALTER TABLE `product_party`
  ADD CONSTRAINT `FK_28C935BC213C1059` FOREIGN KEY (`party_id`) REFERENCES `party` (`id`),
  ADD CONSTRAINT `FK_28C935BC4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `product_user`
--
ALTER TABLE `product_user`
  ADD CONSTRAINT `FK_7BF4E84584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7BF4E8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `proposition_date`
--
ALTER TABLE `proposition_date`
  ADD CONSTRAINT `FK_F13CF708213C1059` FOREIGN KEY (`party_id`) REFERENCES `party` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reserved_product`
--
ALTER TABLE `reserved_product`
  ADD CONSTRAINT `FK_6A917B6AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_6A917B6AEA8C7ACE` FOREIGN KEY (`product_party_id`) REFERENCES `product_party` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
