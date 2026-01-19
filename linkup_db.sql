-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 19 jan. 2026 à 23:58
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `linkup_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE `activite` (
  `id_activite` int(11) NOT NULL,
  `id_createur` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `image_couverture` varchar(255) DEFAULT 'assets/img/default_activity.jpg',
  `date_heure` datetime NOT NULL,
  `duree` varchar(100) DEFAULT NULL,
  `lieu` varchar(255) DEFAULT NULL,
  `acces_info` text DEFAULT NULL,
  `nb_place` int(11) DEFAULT NULL,
  `equipements` text DEFAULT NULL,
  `niveau` enum('facile','moyen','difficile') DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT 0.00,
  `condition_participation` text DEFAULT NULL,
  `statut` enum('ouvert','complet','annule') DEFAULT 'ouvert',
  `visibilite` enum('public','prive','amis') DEFAULT 'public',
  `date_creation` datetime DEFAULT current_timestamp(),
  `date_modification` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `activite_tag`
--

CREATE TABLE `activite_tag` (
  `id_activite` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_destinataire` int(11) NOT NULL,
  `statut` enum('ami','en_attente','refuse','bloque') DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

CREATE TABLE `evaluation` (
  `id_eval` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_activite` int(11) NOT NULL,
  `note` tinyint(3) UNSIGNED DEFAULT NULL CHECK (`note` between 1 and 5),
  `commentaire` text DEFAULT NULL,
  `date_eval` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

CREATE TABLE `faq` (
  `id_faq` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `reponse` text NOT NULL,
  `categorie` varchar(100) DEFAULT NULL,
  `ordre` int(11) DEFAULT 0,
  `actif` tinyint(1) DEFAULT 1,
  `date_creation` datetime DEFAULT current_timestamp(),
  `date_modification` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `membre_salon`
--

CREATE TABLE `membre_salon` (
  `id_user` int(11) NOT NULL,
  `id_de_salon` int(11) NOT NULL,
  `role` enum('moderateur','createur','membre') DEFAULT 'membre',
  `statut` enum('actif','banni','muet') DEFAULT 'actif',
  `date_d_arrivee` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id_message` int(11) NOT NULL,
  `id_expediteur` int(11) NOT NULL,
  `id_destinataire` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date_envoi` datetime DEFAULT current_timestamp(),
  `lu` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message_salon`
--

CREATE TABLE `message_salon` (
  `id_message_salon` int(11) NOT NULL,
  `id_de_salon` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date_d_envoi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id_notif` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `date_envoi` datetime DEFAULT current_timestamp(),
  `lu` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participation`
--

CREATE TABLE `participation` (
  `id_participation` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_activite` int(11) NOT NULL,
  `statut` enum('inscrit','en_attente','annule') DEFAULT 'inscrit',
  `date_inscription` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `preference`
--

CREATE TABLE `preference` (
  `id_preference` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `moyenne_des_evaluations_du_type` float DEFAULT 0,
  `date_derniere_mise_a_jour` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recommendation`
--

CREATE TABLE `recommendation` (
  `id_recommandation` int(11) NOT NULL,
  `id_activite` int(11) NOT NULL,
  `id_preference` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `pertinence` float DEFAULT NULL,
  `vu` tinyint(1) DEFAULT 0,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reset_mot_de_passe`
--

CREATE TABLE `reset_mot_de_passe` (
  `id_reset` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `date_expiration` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `salon_de_discussion`
--

CREATE TABLE `salon_de_discussion` (
  `id_de_salon` int(11) NOT NULL,
  `id_activite` int(11) NOT NULL,
  `titre` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `visibilite` enum('public','prive') DEFAULT 'prive',
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `signalement`
--

CREATE TABLE `signalement` (
  `id_signalement` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `type_cible` varchar(50) NOT NULL,
  `id_cible` int(11) NOT NULL,
  `raison` text NOT NULL,
  `description` text DEFAULT NULL,
  `statut` enum('ouvert','en_attente','resolu','rejete') DEFAULT 'ouvert',
  `date_signalement` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `id_tag` int(11) NOT NULL,
  `nom_tag` varchar(50) NOT NULL,
  `couleur` varchar(7) DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_activite`
--

CREATE TABLE `type_activite` (
  `id_type` int(11) NOT NULL,
  `nom_du_type` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_activite`
--

INSERT INTO `type_activite` (`id_type`, `nom_du_type`, `description`, `icon`, `date_creation`) VALUES
(1, 'sport', 'Activités physiques et sportives', NULL, '2026-01-19 20:11:07'),
(2, 'art', 'Expositions, ateliers et sorties culturelles', NULL, '2026-01-19 20:11:07'),
(3, 'nature', 'Randonnées et activités de plein air', NULL, '2026-01-19 20:11:07');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `localisation` varchar(255) DEFAULT NULL,
  `interets` text DEFAULT NULL,
  `photo_profil` varchar(255) DEFAULT 'assets/img/default_avatar.png',
  `role` enum('admin','utilisateur') DEFAULT 'utilisateur',
  `statut` enum('actif','suspendu','banni') DEFAULT 'actif',
  `date_inscription` datetime DEFAULT current_timestamp(),
  `note_moyenne_createur` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activite`
--
ALTER TABLE `activite`
  ADD PRIMARY KEY (`id_activite`),
  ADD KEY `id_type` (`id_type`),
  ADD KEY `idx_date` (`date_heure`),
  ADD KEY `idx_createur` (`id_createur`),
  ADD KEY `idx_statut` (`statut`);
ALTER TABLE `activite` ADD FULLTEXT KEY `idx_recherche` (`titre`,`description`);

--
-- Index pour la table `activite_tag`
--
ALTER TABLE `activite_tag`
  ADD PRIMARY KEY (`id_activite`,`id_tag`),
  ADD KEY `id_tag` (`id_tag`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`),
  ADD UNIQUE KEY `uni_relation` (`id_user`,`id_destinataire`),
  ADD KEY `id_destinataire` (`id_destinataire`);

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id_eval`),
  ADD UNIQUE KEY `uni_avis` (`id_user`,`id_activite`),
  ADD KEY `idx_user` (`id_user`),
  ADD KEY `idx_activite` (`id_activite`);

--
-- Index pour la table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`),
  ADD KEY `idx_faq_ordre` (`ordre`),
  ADD KEY `idx_actif` (`actif`);

--
-- Index pour la table `membre_salon`
--
ALTER TABLE `membre_salon`
  ADD PRIMARY KEY (`id_user`,`id_de_salon`),
  ADD KEY `id_de_salon` (`id_de_salon`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_destinataire` (`id_destinataire`),
  ADD KEY `idx_conversation` (`id_expediteur`,`id_destinataire`,`date_envoi`),
  ADD KEY `idx_lu` (`lu`);

--
-- Index pour la table `message_salon`
--
ALTER TABLE `message_salon`
  ADD PRIMARY KEY (`id_message_salon`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `idx_salon_timeline` (`id_de_salon`,`date_d_envoi`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `idx_user_notif` (`id_user`,`lu`);

--
-- Index pour la table `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`id_participation`),
  ADD UNIQUE KEY `uni_inscription` (`id_user`,`id_activite`),
  ADD KEY `idx_user` (`id_user`),
  ADD KEY `idx_activite` (`id_activite`);

--
-- Index pour la table `preference`
--
ALTER TABLE `preference`
  ADD PRIMARY KEY (`id_preference`),
  ADD UNIQUE KEY `uni_user_type` (`id_user`,`id_type`),
  ADD KEY `id_type` (`id_type`);

--
-- Index pour la table `recommendation`
--
ALTER TABLE `recommendation`
  ADD PRIMARY KEY (`id_recommandation`),
  ADD KEY `id_activite` (`id_activite`),
  ADD KEY `id_preference` (`id_preference`),
  ADD KEY `idx_user_vu` (`id_user`,`vu`);

--
-- Index pour la table `reset_mot_de_passe`
--
ALTER TABLE `reset_mot_de_passe`
  ADD PRIMARY KEY (`id_reset`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `email` (`email`);

--
-- Index pour la table `salon_de_discussion`
--
ALTER TABLE `salon_de_discussion`
  ADD PRIMARY KEY (`id_de_salon`),
  ADD UNIQUE KEY `id_activite` (`id_activite`);

--
-- Index pour la table `signalement`
--
ALTER TABLE `signalement`
  ADD PRIMARY KEY (`id_signalement`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `idx_moderation` (`type_cible`,`id_cible`),
  ADD KEY `idx_statut` (`statut`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id_tag`),
  ADD UNIQUE KEY `nom_tag` (`nom_tag`);

--
-- Index pour la table `type_activite`
--
ALTER TABLE `type_activite`
  ADD PRIMARY KEY (`id_type`),
  ADD UNIQUE KEY `nom_du_type` (`nom_du_type`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_identite` (`nom`,`prenom`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_statut` (`statut`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activite`
--
ALTER TABLE `activite`
  MODIFY `id_activite` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id_eval` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message_salon`
--
ALTER TABLE `message_salon`
  MODIFY `id_message_salon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `participation`
--
ALTER TABLE `participation`
  MODIFY `id_participation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `preference`
--
ALTER TABLE `preference`
  MODIFY `id_preference` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `recommendation`
--
ALTER TABLE `recommendation`
  MODIFY `id_recommandation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reset_mot_de_passe`
--
ALTER TABLE `reset_mot_de_passe`
  MODIFY `id_reset` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `salon_de_discussion`
--
ALTER TABLE `salon_de_discussion`
  MODIFY `id_de_salon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `signalement`
--
ALTER TABLE `signalement`
  MODIFY `id_signalement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_activite`
--
ALTER TABLE `type_activite`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activite`
--
ALTER TABLE `activite`
  ADD CONSTRAINT `activite_ibfk_1` FOREIGN KEY (`id_createur`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `activite_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `type_activite` (`id_type`);

--
-- Contraintes pour la table `activite_tag`
--
ALTER TABLE `activite_tag`
  ADD CONSTRAINT `activite_tag_ibfk_1` FOREIGN KEY (`id_activite`) REFERENCES `activite` (`id_activite`) ON DELETE CASCADE,
  ADD CONSTRAINT `activite_tag_ibfk_2` FOREIGN KEY (`id_tag`) REFERENCES `tag` (`id_tag`) ON DELETE CASCADE;

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `contact_ibfk_2` FOREIGN KEY (`id_destinataire`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`id_activite`) REFERENCES `activite` (`id_activite`) ON DELETE CASCADE;

--
-- Contraintes pour la table `membre_salon`
--
ALTER TABLE `membre_salon`
  ADD CONSTRAINT `membre_salon_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `membre_salon_ibfk_2` FOREIGN KEY (`id_de_salon`) REFERENCES `salon_de_discussion` (`id_de_salon`) ON DELETE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_expediteur`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`id_destinataire`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `message_salon`
--
ALTER TABLE `message_salon`
  ADD CONSTRAINT `message_salon_ibfk_1` FOREIGN KEY (`id_de_salon`) REFERENCES `salon_de_discussion` (`id_de_salon`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_salon_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `participation_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `participation_ibfk_2` FOREIGN KEY (`id_activite`) REFERENCES `activite` (`id_activite`) ON DELETE CASCADE;

--
-- Contraintes pour la table `preference`
--
ALTER TABLE `preference`
  ADD CONSTRAINT `preference_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `preference_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `type_activite` (`id_type`) ON DELETE CASCADE;

--
-- Contraintes pour la table `recommendation`
--
ALTER TABLE `recommendation`
  ADD CONSTRAINT `recommendation_ibfk_1` FOREIGN KEY (`id_activite`) REFERENCES `activite` (`id_activite`) ON DELETE CASCADE,
  ADD CONSTRAINT `recommendation_ibfk_2` FOREIGN KEY (`id_preference`) REFERENCES `preference` (`id_preference`) ON DELETE SET NULL,
  ADD CONSTRAINT `recommendation_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reset_mot_de_passe`
--
ALTER TABLE `reset_mot_de_passe`
  ADD CONSTRAINT `reset_mot_de_passe_ibfk_1` FOREIGN KEY (`email`) REFERENCES `utilisateur` (`email`) ON DELETE CASCADE;

--
-- Contraintes pour la table `salon_de_discussion`
--
ALTER TABLE `salon_de_discussion`
  ADD CONSTRAINT `salon_de_discussion_ibfk_1` FOREIGN KEY (`id_activite`) REFERENCES `activite` (`id_activite`) ON DELETE CASCADE;

--
-- Contraintes pour la table `signalement`
--
ALTER TABLE `signalement`
  ADD CONSTRAINT `signalement_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
