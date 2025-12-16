-- ============================================================
-- INITIALISATION DU PROJET LINKUP (VERSION V2 - PROD)
-- ============================================================
-- NOTE: suppression automatique retirée pour éviter toute perte de données
CREATE DATABASE IF NOT EXISTS LinkUpDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE LinkUpDB;

-- On désactive les sécurités temporairement pour créer les tables dans l'ordre qu'on veut
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- 1. UTILISATEURS & SÉCURITÉ
-- ============================================================

CREATE TABLE utilisateur (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    localisation VARCHAR(255),
    interets TEXT, 
    
    -- NOUVEAU : Photo de profil (stocke le chemin du fichier, pas l'image elle-même)
    photo_profil VARCHAR(255) DEFAULT 'assets/img/default_avatar.png',

    role ENUM('admin', 'utilisateur') DEFAULT 'utilisateur',
    statut ENUM('actif', 'suspendu', 'banni') DEFAULT 'actif',
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    -- MOTEUR DE REPUTATION : Note moyenne calculée automatiquement par Trigger
    note_moyenne_createur DECIMAL(3,2) DEFAULT NULL, 

    -- OPTIMISATION : Recherche rapide sur l'identité
    INDEX idx_identite (nom, prenom)
);

-- NOUVEAU : Table pour gérer la réinitialisation de mot de passe sécurisée
CREATE TABLE reset_mot_de_passe (
    id_reset INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL, -- Token unique envoyé par mail
    date_expiration DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_token (token), 
    FOREIGN KEY (email) REFERENCES utilisateur(email) ON DELETE CASCADE
);

CREATE TABLE contact (
    id_contact INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_destinataire INT NOT NULL,
    statut ENUM('ami', 'en_attente', 'refuse', 'bloque') DEFAULT 'en_attente',
    UNIQUE KEY uni_relation (id_user, id_destinataire),
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_destinataire) REFERENCES utilisateur(id_user) ON DELETE CASCADE
);

CREATE TABLE notification (
    id_notif INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    message TEXT NOT NULL,
    type VARCHAR(50),
    date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP,
    lu BOOLEAN DEFAULT FALSE,
    INDEX idx_user_notif (id_user, lu), 
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
);

-- ============================================================
-- 2. ACTIVITÉS, TAGS & INTERACTIONS
-- ============================================================

CREATE TABLE type_activite (
    id_type INT AUTO_INCREMENT PRIMARY KEY,
    nom_du_type VARCHAR(100) NOT NULL, -- Catégorie principale (ex: Sport)
    description TEXT
);

-- NOUVEAU : Table des Tags pour affiner les catégories (ex: "Plein air", "Gratuit")
CREATE TABLE tag (
    id_tag INT AUTO_INCREMENT PRIMARY KEY,
    nom_tag VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE activite (
    id_activite INT AUTO_INCREMENT PRIMARY KEY,
    id_createur INT NOT NULL,
    id_type INT NOT NULL, -- Catégorie principale obligatoire
    titre VARCHAR(200) NOT NULL,
    description TEXT,
    
    -- NOUVEAU : Image de couverture de l'événement
    image_couverture VARCHAR(255) DEFAULT 'assets/img/default_activity.jpg',
    
    date_heure DATETIME NOT NULL,
    lieu VARCHAR(255),
    nb_place INT,
    condition_participation TEXT,
    statut ENUM('ouvert', 'complet', 'annule') DEFAULT 'ouvert',
    visibilite ENUM('public', 'prive', 'amis') DEFAULT 'public',
    
    FOREIGN KEY (id_createur) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_type) REFERENCES type_activite(id_type),
    
    -- OPTIMISATION : Indexation temporelle et textuelle
    INDEX idx_date (date_heure),
    FULLTEXT idx_recherche (titre, description)
);

-- NOUVEAU : Table de liaison Activité <-> Tags (Many-to-Many)
CREATE TABLE activite_tag (
    id_activite INT NOT NULL,
    id_tag INT NOT NULL,
    PRIMARY KEY (id_activite, id_tag),
    FOREIGN KEY (id_activite) REFERENCES activite(id_activite) ON DELETE CASCADE,
    FOREIGN KEY (id_tag) REFERENCES tag(id_tag) ON DELETE CASCADE
);

CREATE TABLE participation (
    id_participation INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_activite INT NOT NULL,
    statut ENUM('inscrit', 'en_attente', 'annule') DEFAULT 'inscrit',
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_activite) REFERENCES activite(id_activite) ON DELETE CASCADE,
    UNIQUE KEY uni_inscription (id_user, id_activite)
);

CREATE TABLE evaluation (
    id_eval INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_activite INT NOT NULL,
    note TINYINT UNSIGNED CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    date_eval DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user),
    FOREIGN KEY (id_activite) REFERENCES activite(id_activite),
    UNIQUE KEY uni_avis (id_user, id_activite)
);

-- ============================================================
-- 3. MESSAGERIE & SALONS
-- ============================================================

CREATE TABLE message (
    id_message INT AUTO_INCREMENT PRIMARY KEY,
    id_expediteur INT NOT NULL,
    id_destinataire INT NOT NULL,
    contenu TEXT NOT NULL,
    date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_expediteur) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_destinataire) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    INDEX idx_conversation (id_expediteur, id_destinataire, date_envoi)
);

CREATE TABLE salon_de_discussion (
    id_de_salon INT AUTO_INCREMENT PRIMARY KEY,
    id_activite INT NOT NULL UNIQUE,
    titre VARCHAR(200),
    visibilite ENUM('public', 'prive') DEFAULT 'prive',
    FOREIGN KEY (id_activite) REFERENCES activite(id_activite) ON DELETE CASCADE
);

CREATE TABLE message_salon (
    id_message_salon INT AUTO_INCREMENT PRIMARY KEY,
    id_de_salon INT NOT NULL,
    id_user INT NOT NULL,
    contenu TEXT NOT NULL,
    date_d_envoi DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_de_salon) REFERENCES salon_de_discussion(id_de_salon) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user),
    INDEX idx_salon_timeline (id_de_salon, date_d_envoi)
);

CREATE TABLE membre_salon (
    id_user INT NOT NULL,
    id_de_salon INT NOT NULL,
    role ENUM('moderateur', 'createur', 'membre') DEFAULT 'membre',
    statut ENUM('actif', 'banni', 'muet') DEFAULT 'actif',
    date_d_arrivee DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_user, id_de_salon),
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_de_salon) REFERENCES salon_de_discussion(id_de_salon) ON DELETE CASCADE
);

-- ============================================================
-- 4. ALGORITHMES & ADMINISTRATION
-- ============================================================

CREATE TABLE preference (
    id_preference INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_type INT NOT NULL,
    moyenne_des_evaluations_du_type FLOAT DEFAULT 0, 
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_type) REFERENCES type_activite(id_type)
);

CREATE TABLE recommendation (
    id_recommandation INT AUTO_INCREMENT PRIMARY KEY,
    id_activite INT NOT NULL,
    id_preference INT,
    id_user INT NOT NULL,
    pertinence FLOAT, 
    vu BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_activite) REFERENCES activite(id_activite) ON DELETE CASCADE,
    FOREIGN KEY (id_preference) REFERENCES preference(id_preference),
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
);

CREATE TABLE signalement (
    id_signalement INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    type_cible VARCHAR(50),   
    id_cible INT NOT NULL,    
    raison TEXT,
    date_signalement DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES utilisateur(id_user),
    INDEX idx_moderation (type_cible, id_cible)
);

CREATE TABLE faq (
    id_faq INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    reponse TEXT NOT NULL,
    ordre INT DEFAULT 0,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_faq_ordre (ordre)
);

-- ============================================================
-- 5. AUTOMATISATION (TRIGGERS)
-- ============================================================

DELIMITER $$

-- Trigger 1: Mise à jour après un nouvel avis
CREATE TRIGGER trigger_update_note_insert AFTER INSERT ON evaluation FOR EACH ROW
BEGIN
    DECLARE v_createur_id INT;
    SELECT id_createur INTO v_createur_id FROM activite WHERE id_activite = NEW.id_activite;
    UPDATE utilisateur SET note_moyenne_createur = (
        SELECT AVG(e.note) FROM evaluation e JOIN activite a ON e.id_activite = a.id_activite WHERE a.id_createur = v_createur_id
    ) WHERE id_user = v_createur_id;
END$$

-- Trigger 2: Mise à jour après modification d'avis
CREATE TRIGGER trigger_update_note_update AFTER UPDATE ON evaluation FOR EACH ROW
BEGIN
    DECLARE v_createur_id INT;
    SELECT id_createur INTO v_createur_id FROM activite WHERE id_activite = NEW.id_activite;
    UPDATE utilisateur SET note_moyenne_createur = (
        SELECT AVG(e.note) FROM evaluation e JOIN activite a ON e.id_activite = a.id_activite WHERE a.id_createur = v_createur_id
    ) WHERE id_user = v_createur_id;
END$$

-- Trigger 3: Mise à jour après suppression d'avis
CREATE TRIGGER trigger_update_note_delete AFTER DELETE ON evaluation FOR EACH ROW
BEGIN
    DECLARE v_createur_id INT;
    SELECT id_createur INTO v_createur_id FROM activite WHERE id_activite = OLD.id_activite;
    UPDATE utilisateur SET note_moyenne_createur = (
        SELECT AVG(e.note) FROM evaluation e JOIN activite a ON e.id_activite = a.id_activite WHERE a.id_createur = v_createur_id
    ) WHERE id_user = v_createur_id;
END$$

DELIMITER ;

SET FOREIGN_KEY_CHECKS = 1;
