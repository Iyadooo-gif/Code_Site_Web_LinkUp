-- ============================================================
-- LINKUP - BASE DE DONNÉES PRINCIPALE
-- Structure organisée et bien documentée
-- ============================================================

-- Créer la base de données si elle n'existe pas
CREATE DATABASE IF NOT EXISTS linkup_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE linkup_db;

-- Désactiver les vérifications de clés étrangères temporairement
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- SECTION 1 : UTILISATEURS & SÉCURITÉ
-- ============================================================

-- Table: utilisateur
-- Contient les informations de base des utilisateurs
CREATE TABLE IF NOT EXISTS utilisateur (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    localisation VARCHAR(255),
    interets TEXT, 
    photo_profil VARCHAR(255) DEFAULT 'assets/img/default_avatar.png',
    role ENUM('admin', 'utilisateur') DEFAULT 'utilisateur',
    statut ENUM('actif', 'suspendu', 'banni') DEFAULT 'actif',
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    note_moyenne_createur DECIMAL(3,2) DEFAULT NULL, 
    INDEX idx_identite (nom, prenom),
    INDEX idx_email (email),
    INDEX idx_statut (statut)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: reset_mot_de_passe
-- Gère la réinitialisation sécurisée des mots de passe
CREATE TABLE IF NOT EXISTS reset_mot_de_passe (
    id_reset INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    date_expiration DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_token (token), 
    FOREIGN KEY (email) REFERENCES utilisateur(email) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: contact
-- Gère les relations amicales et les blocages
CREATE TABLE IF NOT EXISTS contact (
    id_contact INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_destinataire INT NOT NULL,
    statut ENUM('ami', 'en_attente', 'refuse', 'bloque') DEFAULT 'en_attente',
    UNIQUE KEY uni_relation (id_user, id_destinataire),
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_destinataire) REFERENCES utilisateur(id_user) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: notification
-- Stocke les notifications envoyées aux utilisateurs
CREATE TABLE IF NOT EXISTS notification (
    id_notif INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    message TEXT NOT NULL,
    type VARCHAR(50),
    date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP,
    lu BOOLEAN DEFAULT FALSE,
    INDEX idx_user_notif (id_user, lu), 
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SECTION 2 : ACTIVITÉS, TAGS & INTERACTIONS
-- ============================================================

-- Table: type_activite
-- Catégories principales d'activités (Sport, Loisir, etc.)
CREATE TABLE IF NOT EXISTS type_activite (
    id_type INT AUTO_INCREMENT PRIMARY KEY,
    nom_du_type VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(255),
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: tag
-- Tags pour affiner les catégories (Plein air, Gratuit, etc.)
CREATE TABLE IF NOT EXISTS tag (
    id_tag INT AUTO_INCREMENT PRIMARY KEY,
    nom_tag VARCHAR(50) NOT NULL UNIQUE,
    couleur VARCHAR(7),
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: activite
-- Événements/Activités créées par les utilisateurs
CREATE TABLE IF NOT EXISTS activite (
    id_activite INT AUTO_INCREMENT PRIMARY KEY,
    id_createur INT NOT NULL,
    id_type INT NOT NULL,
    titre VARCHAR(200) NOT NULL,
    description TEXT,
    image_couverture VARCHAR(255) DEFAULT 'assets/img/default_activity.jpg',
    date_heure DATETIME NOT NULL,
    lieu VARCHAR(255),
    nb_place INT,
    condition_participation TEXT,
    statut ENUM('ouvert', 'complet', 'annule') DEFAULT 'ouvert',
    visibilite ENUM('public', 'prive', 'amis') DEFAULT 'public',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_createur) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_type) REFERENCES type_activite(id_type),
    INDEX idx_date (date_heure),
    INDEX idx_createur (id_createur),
    INDEX idx_statut (statut),
    FULLTEXT idx_recherche (titre, description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: activite_tag (Relation Many-to-Many)
-- Associe les tags aux activités
CREATE TABLE IF NOT EXISTS activite_tag (
    id_activite INT NOT NULL,
    id_tag INT NOT NULL,
    PRIMARY KEY (id_activite, id_tag),
    FOREIGN KEY (id_activite) REFERENCES activite(id_activite) ON DELETE CASCADE,
    FOREIGN KEY (id_tag) REFERENCES tag(id_tag) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: participation
-- Inscriptions des utilisateurs aux activités
CREATE TABLE IF NOT EXISTS participation (
    id_participation INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_activite INT NOT NULL,
    statut ENUM('inscrit', 'en_attente', 'annule') DEFAULT 'inscrit',
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_activite) REFERENCES activite(id_activite) ON DELETE CASCADE,
    UNIQUE KEY uni_inscription (id_user, id_activite),
    INDEX idx_user (id_user),
    INDEX idx_activite (id_activite)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: evaluation
-- Évaluations et avis sur les activités/créateurs
CREATE TABLE IF NOT EXISTS evaluation (
    id_eval INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_activite INT NOT NULL,
    note TINYINT UNSIGNED CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    date_eval DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_activite) REFERENCES activite(id_activite) ON DELETE CASCADE,
    UNIQUE KEY uni_avis (id_user, id_activite),
    INDEX idx_user (id_user),
    INDEX idx_activite (id_activite)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SECTION 3 : MESSAGERIE & SALONS DE DISCUSSION
-- ============================================================

-- Table: message
-- Conversations privées entre utilisateurs
CREATE TABLE IF NOT EXISTS message (
    id_message INT AUTO_INCREMENT PRIMARY KEY,
    id_expediteur INT NOT NULL,
    id_destinataire INT NOT NULL,
    contenu TEXT NOT NULL,
    date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP,
    lu BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_expediteur) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_destinataire) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    INDEX idx_conversation (id_expediteur, id_destinataire, date_envoi),
    INDEX idx_lu (lu)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: salon_de_discussion
-- Salons liés aux activités
CREATE TABLE IF NOT EXISTS salon_de_discussion (
    id_de_salon INT AUTO_INCREMENT PRIMARY KEY,
    id_activite INT NOT NULL UNIQUE,
    titre VARCHAR(200),
    description TEXT,
    visibilite ENUM('public', 'prive') DEFAULT 'prive',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_activite) REFERENCES activite(id_activite) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: message_salon
-- Messages dans les salons de discussion
CREATE TABLE IF NOT EXISTS message_salon (
    id_message_salon INT AUTO_INCREMENT PRIMARY KEY,
    id_de_salon INT NOT NULL,
    id_user INT NOT NULL,
    contenu TEXT NOT NULL,
    date_d_envoi DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_de_salon) REFERENCES salon_de_discussion(id_de_salon) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    INDEX idx_salon_timeline (id_de_salon, date_d_envoi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: membre_salon
-- Gère les membres et leurs rôles dans les salons
CREATE TABLE IF NOT EXISTS membre_salon (
    id_user INT NOT NULL,
    id_de_salon INT NOT NULL,
    role ENUM('moderateur', 'createur', 'membre') DEFAULT 'membre',
    statut ENUM('actif', 'banni', 'muet') DEFAULT 'actif',
    date_d_arrivee DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_user, id_de_salon),
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_de_salon) REFERENCES salon_de_discussion(id_de_salon) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SECTION 4 : PRÉFÉRENCES & RECOMMANDATIONS
-- ============================================================

-- Table: preference
-- Préférences des utilisateurs par type d'activité
CREATE TABLE IF NOT EXISTS preference (
    id_preference INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_type INT NOT NULL,
    moyenne_des_evaluations_du_type FLOAT DEFAULT 0,
    date_derniere_mise_a_jour DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_type) REFERENCES type_activite(id_type) ON DELETE CASCADE,
    UNIQUE KEY uni_user_type (id_user, id_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: recommendation
-- Recommandations personnalisées pour les utilisateurs
CREATE TABLE IF NOT EXISTS recommendation (
    id_recommandation INT AUTO_INCREMENT PRIMARY KEY,
    id_activite INT NOT NULL,
    id_preference INT,
    id_user INT NOT NULL,
    pertinence FLOAT, 
    vu BOOLEAN DEFAULT FALSE,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_activite) REFERENCES activite(id_activite) ON DELETE CASCADE,
    FOREIGN KEY (id_preference) REFERENCES preference(id_preference) ON DELETE SET NULL,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    INDEX idx_user_vu (id_user, vu)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SECTION 5 : MODÉRATION & SUPPORT
-- ============================================================

-- Table: signalement
-- Signalements d'abus/contenu inapproprié
CREATE TABLE IF NOT EXISTS signalement (
    id_signalement INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    type_cible VARCHAR(50) NOT NULL,   
    id_cible INT NOT NULL,    
    raison TEXT NOT NULL,
    description TEXT,
    statut ENUM('ouvert', 'en_attente', 'resolu', 'rejete') DEFAULT 'ouvert',
    date_signalement DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    INDEX idx_moderation (type_cible, id_cible),
    INDEX idx_statut (statut)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: faq
-- Questions fréquemment posées
CREATE TABLE IF NOT EXISTS faq (
    id_faq INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    reponse TEXT NOT NULL,
    categorie VARCHAR(100),
    ordre INT DEFAULT 0,
    actif BOOLEAN DEFAULT TRUE,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_faq_ordre (ordre),
    INDEX idx_actif (actif)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Réactiver les vérifications de clés étrangères
SET FOREIGN_KEY_CHECKS = 1;
-- modif dernière minute
ALTER TABLE activite 
ADD COLUMN duree VARCHAR(100) AFTER date_heure,
ADD COLUMN equipements TEXT AFTER nb_place,
ADD COLUMN niveau ENUM('facile', 'moyen', 'difficile') AFTER equipements,
ADD COLUMN prix DECIMAL(10,2) DEFAULT 0.00 AFTER niveau,
ADD COLUMN acces_info TEXT AFTER lieu;
INSERT IGNORE INTO type_activite (nom_du_type, description) VALUES 
('sport', 'Activités physiques et sportives'),
('art', 'Expositions, ateliers et sorties culturelles'),
('nature', 'Randonnées et activités de plein air');

