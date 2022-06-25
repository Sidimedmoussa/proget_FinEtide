-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 21 juin 2022 à 22:21
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gesvoiture`
--

-- --------------------------------------------------------

--
-- Structure de la table `admine`
--

CREATE TABLE `admine` (
  `nom` varchar(50) DEFAULT NULL,
  `pasword` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `idAD` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admine`
--

INSERT INTO `admine` (`nom`, `pasword`, `email`, `idAD`) VALUES
('khadija', '1234', 'khadija@gmail.com', 1);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `NUMCLIENT` int(11) NOT NULL,
  `NNI` varchar(10) DEFAULT NULL,
  `NOM` varchar(50) DEFAULT NULL,
  `PRENOM` varchar(50) DEFAULT NULL,
  `TEL` varchar(8) DEFAULT NULL,
  `ADRESSE` varchar(50) DEFAULT NULL,
  `DELEVRER_LE` date DEFAULT NULL,
  `PERMIS` varchar(6) DEFAULT NULL,
  `CLIENTIMG` varchar(100) DEFAULT 'default.jpg',
  `EMAIL` varchar(100) DEFAULT NULL,
  `PASS` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`NUMCLIENT`, `NNI`, `NOM`, `PRENOM`, `TEL`, `ADRESSE`, `DELEVRER_LE`, `PERMIS`, `CLIENTIMG`, `EMAIL`, `PASS`) VALUES
(1, '2147483647', 'moussa', 'med', '45067806', 'dar naim', '2022-06-01', '777894', 'default.jpg', 'moussa@gmail.com', 'moussa'),
(18, '1234657809', 'kkkkk', 'hhhh', '45879090', 'ayn talh', '2022-06-21', '123490', '162b1ccecb480c.jpg', 'kkkkk@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Structure de la table `contrats`
--

CREATE TABLE `contrats` (
  `NUMCONTRACT` int(11) NOT NULL,
  `NUMCLIENT` int(11) DEFAULT NULL,
  `MATRICULE` varchar(20) DEFAULT NULL,
  `DATEDEPART` datetime DEFAULT NULL,
  `DATEARRIVET` datetime DEFAULT NULL,
  `PRIXLOC` float DEFAULT NULL,
  `ETAT` varchar(7) DEFAULT 'termine',
  `duree` int(11) DEFAULT NULL,
  `typedure` varchar(10) DEFAULT NULL,
  `passedtime` varchar(10) DEFAULT 'no',
  `archived` varchar(10) DEFAULT 'non',
  `DETEDERESEPTION` datetime DEFAULT NULL,
  `PRIXDEP` float DEFAULT NULL,
  `resevoir` varchar(3) DEFAULT 'non'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `contrats`
--

INSERT INTO `contrats` (`NUMCONTRACT`, `NUMCLIENT`, `MATRICULE`, `DATEDEPART`, `DATEARRIVET`, `PRIXLOC`, `ETAT`, `duree`, `typedure`, `passedtime`, `archived`, `DETEDERESEPTION`, `PRIXDEP`, `resevoir`) VALUES
(2, 1, '0944AV03', '2022-06-02 19:57:07', '2022-06-04 05:57:07', 10200, 'encour', 34, 'Heurs', 'depa', 'non', NULL, NULL, 'non'),
(16, 1, '9867HF06', '2022-06-20 00:00:00', '2022-06-23 00:00:00', 14400, 'termine', 3, 'Jours', 'no', 'non', '2022-06-23 00:00:00', 0, 'oui'),
(17, 1, '0908AA07', '2022-06-21 23:24:00', '2022-06-21 06:25:10', 2500, 'termine', 5, 'Jours', 'depa', 'non', '2022-06-21 06:25:00', 0, 'oui'),
(19, 1, '6078AA06', '2022-06-20 00:00:00', '2022-06-27 00:00:00', 33600, 'termine', 7, 'Jours', 'no', 'non', '2022-06-27 00:00:00', 0, 'oui');

-- --------------------------------------------------------

--
-- Structure de la table `couleur`
--

CREATE TABLE `couleur` (
  `coulerName` varchar(20) DEFAULT NULL,
  `NUMCOL` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `couleur`
--

INSERT INTO `couleur` (`coulerName`, `NUMCOL`) VALUES
('blanche', 1),
('noir', 2),
('gree', 3),
('violet', 4);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

CREATE TABLE `marque` (
  `marqueNum` int(11) NOT NULL,
  `marqueName` varchar(20) DEFAULT NULL,
  `marqueImg` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`marqueNum`, `marqueName`, `marqueImg`) VALUES
(1, 'chevrolet', '16297c635785de.png'),
(2, 'ford', '16297c66068d0e.png'),
(3, 'hyundai', '16297c67f55b70.png'),
(4, 'jeep', '16297c6a1b4bf5.png'),
(5, 'land-rover', '16297c6b8cc962.png'),
(6, 'mercedes benz', '16297c6d5cf4c9.png'),
(7, 'mitsubishi', '16297c7018d442.png'),
(8, 'peugeot', '16297c71b2ade2.png'),
(9, 'renault', '16297c7369b57e.png'),
(10, 'toyota', '16297d06eeb8d3.png');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `NUMRESERVATION` int(11) NOT NULL,
  `CLIENT` int(11) DEFAULT NULL,
  `VOITURE` varchar(20) DEFAULT NULL,
  `DUREE` int(11) DEFAULT NULL,
  `TYPEDUREE` varchar(10) DEFAULT NULL,
  `DATERESS` datetime DEFAULT NULL,
  `DATERETOUR` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `NUMVOITURE` int(11) NOT NULL,
  `MATRICULE` varchar(20) DEFAULT NULL,
  `MARQUE` varchar(20) DEFAULT NULL,
  `MODELE` int(11) DEFAULT NULL,
  `CARBURANT` varchar(20) DEFAULT NULL,
  `COULER` varchar(20) DEFAULT NULL,
  `PRIXJOUR` float DEFAULT NULL,
  `PRIHEURE` float DEFAULT NULL,
  `IMAGE` varchar(100) DEFAULT NULL,
  `ETAT` varchar(7) DEFAULT 'non',
  `CARBURANTPROG` float DEFAULT NULL,
  `depannage` varchar(3) DEFAULT 'non'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`NUMVOITURE`, `MATRICULE`, `MARQUE`, `MODELE`, `CARBURANT`, `COULER`, `PRIXJOUR`, `PRIHEURE`, `IMAGE`, `ETAT`, `CARBURANTPROG`, `depannage`) VALUES
(1, '0908AA07', 'chevrolet', 2019, 'Gaz Oil', 'noir', 12000, 500, '16297cea302e47.png', 'non', 50, 'non'),
(2, '9867HF06', 'mercedes benz', 2011, 'Gaz Oil', 'gree', 4800, 200, '16297cfa3f3fc5.png', 'non', 20, 'non'),
(3, '0944AV03', 'mercedes benz', 2019, 'Gaz Oil', 'blanche', 7200, 300, '16297d133e4999.png', 'oui', 57, 'non'),
(4, '6078AA06', 'mercedes benz', 2020, 'Gaz Oil', 'blanche', 4800, 200, '16297d0c190192.png', 'non', 100, 'non');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admine`
--
ALTER TABLE `admine`
  ADD PRIMARY KEY (`idAD`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`NUMCLIENT`),
  ADD UNIQUE KEY `NNI` (`NNI`),
  ADD UNIQUE KEY `PERMIS` (`PERMIS`);

--
-- Index pour la table `contrats`
--
ALTER TABLE `contrats`
  ADD PRIMARY KEY (`NUMCONTRACT`),
  ADD UNIQUE KEY `MATRICULE` (`MATRICULE`),
  ADD KEY `NUMCLIENT` (`NUMCLIENT`);

--
-- Index pour la table `couleur`
--
ALTER TABLE `couleur`
  ADD PRIMARY KEY (`NUMCOL`);

--
-- Index pour la table `marque`
--
ALTER TABLE `marque`
  ADD PRIMARY KEY (`marqueNum`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`NUMRESERVATION`),
  ADD KEY `CLIENT` (`CLIENT`),
  ADD KEY `VOITURE` (`VOITURE`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`NUMVOITURE`),
  ADD UNIQUE KEY `MATRICULE` (`MATRICULE`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admine`
--
ALTER TABLE `admine`
  MODIFY `idAD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `NUMCLIENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `contrats`
--
ALTER TABLE `contrats`
  MODIFY `NUMCONTRACT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `couleur`
--
ALTER TABLE `couleur`
  MODIFY `NUMCOL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `marque`
--
ALTER TABLE `marque`
  MODIFY `marqueNum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `NUMRESERVATION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `NUMVOITURE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contrats`
--
ALTER TABLE `contrats`
  ADD CONSTRAINT `contrats_ibfk_1` FOREIGN KEY (`NUMCLIENT`) REFERENCES `client` (`NUMCLIENT`),
  ADD CONSTRAINT `contrats_ibfk_2` FOREIGN KEY (`NUMCLIENT`) REFERENCES `client` (`NUMCLIENT`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`CLIENT`) REFERENCES `client` (`NUMCLIENT`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`VOITURE`) REFERENCES `voiture` (`MATRICULE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
