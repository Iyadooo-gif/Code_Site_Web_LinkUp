<?php
/**
 * API Messages - Converti depuis routes/messages.js
 * Gestion des messages pour les cours
 */
class MessagesAPI {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    /**
     * Gérer les requêtes pour l'API messages
     */
    public function handleRequest($method, $path) {
        // Extraire le courseId si présent dans le path
        $pathParts = explode('/', trim($path, '/'));
        $courseId = isset($pathParts[1]) && is_numeric($pathParts[1]) ? (int)$pathParts[1] : null;

        try {
            switch ($method) {
                case 'GET':
                    if ($courseId !== null) {
                        $this->getMessagesByCourse($courseId);
                    } else {
                        http_response_code(400);
                        echo json_encode(['message' => 'ID du cours requis']);
                    }
                    break;

                case 'POST':
                    $this->createMessage();
                    break;

                case 'DELETE':
                    if ($courseId !== null) {
                        $this->deleteMessage($courseId);
                    } else {
                        http_response_code(400);
                        echo json_encode(['message' => 'ID du message requis']);
                    }
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(['message' => 'Méthode non autorisée']);
            }
        } catch (Exception $e) {
            error_log('Erreur API messages: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['message' => 'Erreur serveur']);
        }
    }

    /**
     * GET /api/messages/:courseId - Récupérer les messages d'un cours
     */
    private function getMessagesByCourse($courseId) {
        try {
            $messages = $this->db->all(
                'SELECT * FROM messages WHERE course_id = ? ORDER BY sent_at ASC',
                [$courseId]
            );

            http_response_code(200);
            echo json_encode($messages);
        } catch (Exception $e) {
            error_log('Erreur récupération messages: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['message' => 'Erreur serveur']);
        }
    }

    /**
     * POST /api/messages - Envoyer un message
     */
    private function createMessage() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            // Validation des données
            if (!isset($data['course_id']) || !isset($data['sender_name']) || !isset($data['content'])) {
                http_response_code(400);
                echo json_encode(['message' => 'course_id, sender_name et content sont requis']);
                return;
            }

            $result = $this->db->run(
                'INSERT INTO messages (course_id, sender_name, content) VALUES (?, ?, ?)',
                [$data['course_id'], $data['sender_name'], $data['content']]
            );

            $message = [
                'id' => $result['lastInsertId'],
                'course_id' => $data['course_id'],
                'sender_name' => $data['sender_name'],
                'content' => $data['content'],
                'sent_at' => date('Y-m-d H:i:s')
            ];

            http_response_code(201);
            echo json_encode($message);
        } catch (Exception $e) {
            error_log('Erreur envoi message: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['message' => 'Erreur serveur']);
        }
    }

    /**
     * DELETE /api/messages/:id - Supprimer un message
     */
    private function deleteMessage($id) {
        try {
            $message = $this->db->get('SELECT * FROM messages WHERE id = ?', [$id]);
            if (!$message) {
                http_response_code(404);
                echo json_encode(['message' => 'Message non trouvé']);
                return;
            }

            $this->db->run('DELETE FROM messages WHERE id = ?', [$id]);

            http_response_code(200);
            echo json_encode(['message' => 'Message supprimé avec succès']);
        } catch (Exception $e) {
            error_log('Erreur suppression message: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['message' => 'Erreur serveur']);
        }
    }
}
