<?php
// process-chat.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// 1. Inclusion de la configuration existante (PDO + Session)
require_once 'config.php';

// 2. Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Vous devez être connecté pour accéder au chat.']);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

// 3. ROUTAGE DES REQUÊTES
try {
    // --- GET : Récupération des données ---
    if ($method === 'GET') {
        $action = $_GET['action'] ?? '';

        // A. Lister les activités disponibles (remplace "courses")
        if ($action === 'courses') {
            // On récupère les activités réelles créées via create-activity.php
            $stmt = $pdo->query("SELECT id_activite as id, titre as name, description FROM activite ORDER BY id_activite DESC LIMIT 15");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } 
        
        // B. Charger les messages d'une activité spécifique
        elseif ($action === 'messages' && isset($_GET['course_id'])) {
            $courseId = (int)$_GET['course_id'];
            $stmt = $pdo->prepare("SELECT sender_name, content, sent_at FROM messages WHERE id_activite = ? ORDER BY sent_at ASC");
            $stmt->execute([$courseId]);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
    } 

    // --- POST : Envoi d'un nouveau message ---
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!empty($data['content']) && !empty($data['course_id'])) {
            // On utilise le nom de l'utilisateur en session pour la sécurité
            $senderName = $_SESSION['user_name'] ?? 'Anonyme';
            $courseId = (int)$data['course_id'];
            $content = trim($data['content']);

            $stmt = $pdo->prepare("INSERT INTO messages (id_activite, sender_name, content) VALUES (?, ?, ?)");
            $stmt->execute([$courseId, $senderName, $content]);

            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Données incomplètes']);
        }
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}