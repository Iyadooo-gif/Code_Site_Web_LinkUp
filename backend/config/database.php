<?php
/**
 * Classe de gestion de la base de données SQLite
 * Convertie depuis database.js
 */
class Database {
    private $pdo;
    private $dbPath;

    public function __construct() {
        $this->dbPath = __DIR__ . '/../database.db';
    }

    /**
     * Connexion à la base de données SQLite
     */
    private function connect() {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO('sqlite:' . $this->dbPath);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                error_log('Connecté à la base de données SQLite');
            } catch (PDOException $e) {
                error_log('Erreur connexion base de données: ' . $e->getMessage());
                throw $e;
            }
        }
        return $this->pdo;
    }

    /**
     * Initialiser les tables de la base de données
     */
    public function initialize() {
        try {
            $pdo = $this->connect();

            // Table courses
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS courses (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    description TEXT,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )
            ");

            // Table messages
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS messages (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    course_id INTEGER NOT NULL,
                    sender_name TEXT NOT NULL,
                    content TEXT NOT NULL,
                    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (course_id) REFERENCES courses(id)
                )
            ");

            error_log('Base de données initialisée');
        } catch (PDOException $e) {
            error_log('Erreur initialisation base de données: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Exécuter une requête INSERT/UPDATE/DELETE
     */
    public function run($sql, $params = []) {
        try {
            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            return [
                'lastInsertId' => $pdo->lastInsertId(),
                'changes' => $stmt->rowCount()
            ];
        } catch (PDOException $e) {
            error_log('Erreur requête run: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Récupérer une seule ligne
     */
    public function get($sql, $params = []) {
        try {
            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log('Erreur requête get: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Récupérer toutes les lignes
     */
    public function all($sql, $params = []) {
        try {
            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetchAll();
            return $result !== false ? $result : [];
        } catch (PDOException $e) {
            error_log('Erreur requête all: ' . $e->getMessage());
            throw $e;
        }
    }
}
