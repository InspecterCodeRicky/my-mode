-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mar. 21 avr. 2020 à 11:56
-- Version du serveur :  10.1.37-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `target_file` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date_create` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_edit` varchar(255) NOT NULL,
  `keyAccess` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `target_file`, `author`, `date_create`, `category`, `status`, `date_edit`, `keyAccess`) VALUES
(34, 'orem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor', '<p>dede</p>', 'images/gallery/1586608579-Balloon_by_Matt_Benson.jpg', 'moim2 JUSME', '2019-11-24', 'dede', 'post', '', 'admin5e91e424cea1dadmin5e91e424cea1d'),
(35, 'Mon premier article non publié', '<p><em><strong>dede</strong></em></p>', 'images/gallery/1586622072-Beach_by_Samuel_Scrimshaw.jpg', 'moim2 JUSME', '2019-11-03', '', 'not-post', '', 'admin5e91e424cea1d'),
(37, 'La mode est elle en hausse pour la société HIM, marque blanche', '<p><strong>Lorem</strong> ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'images/gallery/1586682703-post_14.png', 'moim2 JUSME', '2019-12-16', 'mode, test', 'not-post', '12 avril 2020', 'admin5e91e424cea1d'),
(38, 'Mon premier article non publié', '<p>dede de</p>', 'images/gallery/1586767075-post_8.png', 'moim2 JUSME', '2019-05-08', 'mode, test', 'post', '13 avril 2020', 'admin5e91e424cea1d'),
(39, 'test', '<p>frfrfrf</p>', 'images/gallery/1586767075-post_8.png', 'moim2 JUSME', '2020-04-18', '', 'post', '', 'admin5e91e424cea1d'),
(40, 'dede', '<p>dede</p>', 'images/gallery/1587237757-post_13.png', 'moim2 JUSME', '2020-04-18', '', 'post', '', 'admin5e91e424cea1d');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `date_depart` varchar(255) NOT NULL,
  `hour_depart` varchar(255) NOT NULL,
  `date_end` varchar(255) NOT NULL,
  `hour_end` varchar(255) NOT NULL,
  `keyAccess` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_edit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `title`, `content`, `address`, `date_depart`, `hour_depart`, `date_end`, `hour_end`, `keyAccess`, `author`, `status`, `date_edit`) VALUES
(2, 'haut', '<p>dede dejkn k khqs k kqnk kkq kq kq k kqskqs kq hkqsh q \r\n </p>', '55 Rue Myrha', '2020-04-15', '15:15', '2020-04-15', '15:15', 'admin5e91e424cea1d', 'moim2 JUSME', 'post', ''),
(5, 'je  hkhkh', '<p>dede</p>\r\n<p>&nbsp;</p>', '20 rue champagne', '2020-04-14', '02:02', '2020-04-15', '03:02', 'admin5e91e424cea1d', 'moim2 JUSME', 'not-post', ''),
(6, 'Paris casting pour amateur', '<p>Des promoteurs veulent faire un casting a paris pour les d&eacute;butants afin de leurs donner leur chance. pour cela inscrivez vous sur la platforme.</p>', '55 Rue Myrha', '2020-05-19', '15:12', '2020-05-20', '16:14', 'admin5e91e424cea1d', 'moim2 JUSME', 'post', ''),
(7, 'Paris shopping ', '<p><strong>Journ&eacute;e 100% shopping d&eacute;di&eacute;e au madras. Quelques chiffres : -24 stands -dur&eacute;e moyenne de presence sur le Madras Day: 30 min</strong></p>\r\n<p>&nbsp;</p>\r\n<p>Le Madras Day, moment shopping, d&eacute;di&eacute; au madras .</p>\r\n<p>&nbsp;</p>\r\n<p>Quelques chiffres:</p>\r\n<ul>\r\n<li>24 stands</li>\r\n<li>2500 visiteurs attendus</li>\r\n<li>30 min de shopping en moyenne</li>\r\n<li>2000 invitations gratuites</li>\r\n<li>Public: 0 &agrave; 99 ans</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>Entr&eacute;e gratuite pour les moins de 15 ans</p>\r\n<p>Billeterie sur place: 5&euro;</p>\r\n<p>Possibilit&eacute; de venir en madras</p>', 'MAS  Rue des Terres au Curé  75013 Paris', '2020-07-11', '10:00', '2020-07-11', '19:00', 'admin5e91e424cea1d', 'moim2 JUSME', 'post', ''),
(8, 'Paris Fashion Week Fashion Shows', '<p>One of the big 4\'s is the Paris Fashion Week. There will be fashion shows, parties, pop-up shops, swim shows, fashion talks/workshops, etc.. The who\'s who in the industry will be there from designers, models, celebrities, influencers, buyers, fashion bloggers, brands, media and press.<br />The fashoin shows are in general industry only event and potential attendees will be contacted to provide additional info such as social media account or company info in order to be considered. There are some fashion shows that have opened a limited amount of access to the general public and those will be available to people who just love fashion.</p>', 'Paris 04 ème arrondissement ', '2020-09-04', '09:00', '2020-09-07', '22:00', 'admin5e91e424cea1d', 'moim2 JUSME', 'post', ''),
(9, 'test 4', '<p>dezjndk kjz <strong>djez&nbsp; jze</strong></p>\r\n<ul>\r\n<li><strong>liste&nbsp;</strong></li>\r\n<li><strong>liste&nbsp;</strong></li>\r\n<li><strong>liste&nbsp;</strong></li>\r\n</ul>', 'Residence Ilot des Poiriers 1 rue Frederic Joliot Curie', '2020-04-09', '14:15', '2020-04-10', '15:15', 'admin5e9dab012fbf1', 'Elena Justin', 'post', '');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `date_send` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `email`, `name`, `subject`, `message`, `date_send`) VALUES
(1, 'demo@demo.com', 'ricardo', 'mon objet', 'Mon message', '2020-04-21 12:27'),
(2, 'demo@demo.com', 'ded', 'dede', 'ded', '2020-11-21 12:27');

-- --------------------------------------------------------

--
-- Structure de la table `talents`
--

CREATE TABLE `talents` (
  `id` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `birthday` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `color_eyes` varchar(255) NOT NULL,
  `color_hair` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `photos` text NOT NULL,
  `date_register` varchar(255) NOT NULL,
  `size` double NOT NULL,
  `keyAccess` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `talents`
--

INSERT INTO `talents` (`id`, `lastname`, `firstname`, `birthday`, `genre`, `email`, `password`, `color_eyes`, `color_hair`, `address`, `phone`, `photos`, `date_register`, `size`, `keyAccess`) VALUES
(5, 'jusme', 'Jean', '04-06-1997', 'Homme', 'ricky10@gmail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614759476, 'img/talents/1586138283-emma.jpg|img/talents/1586138371_post_8.png|img/talents/1586138374_post_16.png|img/talents/1586138378_post_18.png|img/talents/1586138382_post_1.png|img/talents/1586138386_post_11.png|img/talents/1586138390_post_18.png|  img/talents/1586208025_post_17.png|', '06 avril 2020', 0, 'model5e8b110ae0c040'),
(6, 'JUSME', 'Jean', '04-06-1997', 'Homme', 'ricky1001@gmail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614859584, 'img/talents/1586138283-emma.jpg|img/talents/1586138371_post_8.png|img/talents/1586138374_post_16.png|img/talents/1586138378_post_18.png|img/talents/1586138382_post_1.png|img/talents/1586138386_post_11.png|img/talents/1586138390_post_18.png|', '06 avril 2020', 0, 'model5e8b110ae0c050'),
(7, 'JUSME', 'Jean', '04-06-1997', 'Homme', 'ricky101098@gmail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614859584, 'img/talents/1586138283-emma.jpg|img/talents/1586138371_post_8.png|img/talents/1586138374_post_16.png|img/talents/1586138378_post_18.png|img/talents/1586138382_post_1.png|img/talents/1586138386_post_11.png|img/talents/1586138390_post_18.png|', '06 avril 2020', 0, 'model5e8b110ae0c060'),
(8, 'JUSME', 'Jean', '04-06-1997', 'Homme', 'ricky1@gmail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614859584, 'img/talents/1586138283-emma.jpg|img/talents/1586138371_post_8.png|img/talents/1586138374_post_16.png|img/talents/1586138378_post_18.png|img/talents/1586138382_post_1.png|img/talents/1586138386_post_11.png|img/talents/1586138390_post_18.png|', '06 avril 2020', 0, 'model5e8b110ae0c080'),
(9, 'JUSME', 'Jean', '04-06-1997', 'Homme', 'ricky1098@gmail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614859584, 'img/talents/1586138283-emma.jpg|img/talents/1586138371_post_8.png|img/talents/1586138374_post_16.png|img/talents/1586138378_post_18.png|img/talents/1586138382_post_1.png|img/talents/1586138386_post_11.png|img/talents/1586138390_post_18.png|', '06 avril 2020', 0, 'model5e8b110ae0c15000'),
(10, 'JUSME', 'Jean', '04-06-1997', 'Homme', 'ricky109810@gmail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614859584, 'img/talents/1586138283-emma.jpg|img/talents/1586138371_post_8.png|img/talents/1586138374_post_16.png|img/talents/1586138378_post_18.png|img/talents/1586138382_post_1.png|img/talents/1586138386_post_11.png|img/talents/1586138390_post_18.png|', '06 avril 2020', 0, 'model5e8b110a50c040'),
(11, 'JUSME', 'Jean', '04-06-1997', 'Homme', 'ricky910@gmail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614859584, 'img/talents/1586138283-emma.jpg|img/talents/1586138371_post_8.png|img/talents/1586138374_post_16.png|img/talents/1586138378_post_18.png|img/talents/1586138382_post_1.png|img/talents/1586138386_post_11.png|img/talents/1586138390_post_18.png|', '06 avril 2020', 0, 'model545b110ae0c040'),
(12, 'JUSME', 'Jean', '04-06-1997', 'Homme', 'ricky989810@gmail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614859584, 'img/talents/1586138283-emma.jpg|img/talents/1586138371_post_8.png|img/talents/1586138374_post_16.png|img/talents/1586138378_post_18.png|img/talents/1586138382_post_1.png|img/talents/1586138386_post_11.png|img/talents/1586138390_post_18.png|', '06 avril 2020', 0, ''),
(13, 'JUSME', 'Jean', '04-06-1997', 'Homme', 'ricky010110@gmail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614859584, 'img/talents/1586138283-emma.jpg|img/talents/1586138371_post_8.png|img/talents/1586138374_post_16.png|img/talents/1586138378_post_18.png|img/talents/1586138382_post_1.png|img/talents/1586138386_post_11.png|img/talents/1586138390_post_18.png|', '06 avril 2020', 0, ''),
(14, 'JUSME', 'Jean', '04-06-1997', 'Homme', 'ricky101210@gmail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614859584, 'img/talents/1586138283-emma.jpg|img/talents/1586138371_post_8.png|img/talents/1586138374_post_16.png|img/talents/1586138378_post_18.png|img/talents/1586138382_post_1.png|img/talents/1586138386_post_11.png|img/talents/1586138390_post_18.png|', '06 avril 2020', 0, ''),
(16, 'JUSME', 'Jean', '04-06-1997', 'Homme', 'ricky@mail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614759476, 'img/talents/1586141901-petter.png|', '06 avril 2020', 0, ''),
(17, 'JUSME', 'jjj', '08-06-2000', 'Homme', 'root@root.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '', 614759477, 'img/talents/1586601119-Balloon_by_Matt_Benson.jpg|', '11 avril 2020', 0, 'talents5e919c9f5db6b'),
(18, 'Jusme', 'Farah', '01-04-2000', 'Femme', 'farah@demo.com', '450a1bb3725a1dcbc1355abfe5fc8c25', '', '', '', 612457854, 'img/talents/1586787739-post_2.png|  img/talents/1587243337_post_18.png|', '13 avril 2020', 0, 'talents5e94759b84ffa'),
(20, 'Eléna', 'JUSTIN', '07-12-1998', 'Femme', 'justin@elena.fr', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', 'noir', '', '14 rue de la place ', 614759476, 'img/talents/1587326415-unc2.png|img/talents/1587326429_post_18.png|', '19 avril 2020', 1.81, 'talents5e9cadcf7d871'),
(21, 'JUSME', 'Jean', '16-04-1998', 'Femme', 'demo2@demo.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', '', '', '15 rue de la place', 614759476, 'img/talents/1587391015-1586138390_post_18.png| img/talents/1587392180_1586138374_post_16.png|', '20 avril 2020', 0, 'talents5e9daa2709c3a');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type_profile` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `profile_target` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `date_register` varchar(255) NOT NULL,
  `keyAccess` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `type_profile`, `firstname`, `lastname`, `genre`, `profile_target`, `phone`, `date_register`, `keyAccess`) VALUES
(5, 'ricky@gmail.com', 'd94ef6d0ad9c1f51a5d9545c31c9d02f', 'users', 'Jean', 'JUSME', 'Homme', 'images/user.png', 614759474, '2020-06-04', 'user5e8b110ae0c040'),
(7, 'ricky100198@gmail.com', 'eee0ac21c7ba89b22872fd2a46ee7992', 'users', 'moim2', 'JUSME', 'Homme', 'images/gallery/1587213890-profile-post_16.png', 614759476, '2020-11-04', 'admin5e91e424cea1d'),
(8, 'demo3@demo.com', '8ab645367bc5684711dd47ca1cb591e4', 'users', 'Elena', 'Justin', 'Femme', 'images/gallery/1587391351-profile-1586138374_post_16.png', 25511515, '2020-20-04', 'admin5e9dab012fbf1');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `talents`
--
ALTER TABLE `talents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `talents`
--
ALTER TABLE `talents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
