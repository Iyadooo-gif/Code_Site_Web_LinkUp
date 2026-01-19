<?php
// Point d'entrée principal de l'API PHP
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Gérer les requêtes OPTIONS pour CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Inclure les fichiers nécessaires
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/api/courses.php';
require_once __DIR__ . '/api/messages.php';

// Initialiser la base de données
$database = new Database();
$database->initialize();

// Router simple basé sur l'URI
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Extraire le chemin de l'URI (enlever les paramètres de requête)
$path = parse_url($requestUri, PHP_URL_PATH);

// Supprimer le préfixe du chemin si nécessaire
$basePath = '/api';
if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}

// Router
if (strpos($path, '/courses') === 0) {
    $coursesApi = new CoursesAPI($database);
    $coursesApi->handleRequest($requestMethod, $path);
} elseif (strpos($path, '/messages') === 0) {
    $messagesApi = new MessagesAPI($database);
    $messagesApi->handleRequest($requestMethod, $path);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Route non trouvée']);
}
