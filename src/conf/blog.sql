-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 20 mai 2021 à 09:32
-- Version du serveur :  8.0.25-0ubuntu0.20.04.1
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
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--
DROP TABLE IF EXISTS `billets`;
CREATE TABLE `billets` (
  `id` int NOT NULL,
  `titre` varchar(64) DEFAULT NULL,
  `body` text,
  `cat_id` int DEFAULT '1',
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `billets`
--

INSERT INTO `billets` (`id`, `titre`, `body`, `cat_id`, `date`) VALUES
(1, 'go sluc, go', 'tout est dans le titre', 1, '2014-11-20'),
(2, 'Concert : nolwenn live', 'de la balle, Ca vaut bien Mick Jagger et Iggy Stooges réunis.\r\nAngus Young doit ecouter en boucle...', 3, '2014-11-20'),
(3, 'Titanic', 'un gros bateau qui croise un glaçon', 2, '2014-11-20'),
(4, 'Josef The Cat', 'a demoniac ginger cat', 5, '2022-05-15');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int NOT NULL,
  `titre` varchar(64) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `titre`, `description`) VALUES
(1, 'sport', 'tout sur le sport en general'),
(2, 'cinema', 'tout sur le cinema'),
(3, 'music', "toute la music que j'aaiiiimeuh, elle vient de la, elle vient du bluuuuuuzee"),
(4, 'TV', 'tout sur les programmes tele, les emissions, les series, et vos stars preferes'),
(5, 'Other', 'infos diverses');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--
DROP TABLE IF EXISTS `membres`;
CREATE TABLE `membres` (
  `id` int NOT NULL,
  `pseudo` varchar(15) NOT NULL,
  `nom` varchar(15) NOT NULL,
  `prenom` varchar(15) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `mdp_hash` varchar(62) NOT NULL,
  `droit` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membres`
--
INSERT INTO `membres` (`id`, `pseudo`, `nom`, `prenom`, `mail`, `mdp_hash`, `droit`) VALUES
    (1, 'JosefZeCat', 'Parisse', 'Josef', 'JosefZeCat@mail.com', '$2y$10$3l21SWW6coA.qZPgfBA.vulJX1FYIq.DamD21tEFLQ3Y4IWViIGGS', 0),
    (2, 'Toofik', 'Godfrin', 'Emilien', 'Toofik@mail.com', '$2y$10$qNUabGPUov4KdpWgvOh3o.f9m0E6tYVNK0vqY6EiwFe4asZMm.mhC', 1);
COMMIT;

--
-- Structure de la table `commentaires`
--
DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
    `id` int NOT NULL,
    `billet` int(11) NOT NULL,
    `content` varchar(400) NOT NULL,
    `auteur` varchar(50) NOT NULL,
    `date` date DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentaires`
--
INSERT INTO `commentaires` (`id`, `billet`, `content`, `auteur`, `date`) VALUES
    (1, 4, 'Attaquer les humains naifs, rien de plus fun', 'JosefZeCat', '2022-05-21');


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `billets`
--
ALTER TABLE `billets`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `categ` (`cat_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`);



--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `billets`
--
ALTER TABLE `billets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `billets`
--
ALTER TABLE `billets`
  ADD CONSTRAINT `categ` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
