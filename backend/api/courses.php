<?php
/**
 * API Courses - Converti depuis routes/courses.js
 * Gestion des cours disponibles
 */
class CoursesAPI {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    /**
     * Gérer les requêtes pour l'API courses
     */
    public function handleRequest($method, $path) {
        // Extraire l'ID si présent dans le path
        $pathParts = explode('/', trim($path, '/'));
        $id = isset($pathParts[1]) && is_numeric($pathParts[1]) ? (int)$pathParts[1] : null;

        try {
            switch ($method) {
                case 'GET':
                    if ($id !== null) {
                        $this->getCourse($id);
                    } else {
                        $this->getAllCourses();
                    }
                    break;

                case 'POST':
                    $this->createCourse();
                    break;

                case 'PUT':
                    if ($id !== null) {
                        $this->updateCourse($id);
                    } else {
                        http_response_code(400);
                        echo json_encode(['message' => 'ID requis pour la mise à jour']);
                    }
                    break;

                case 'DELETE':
                    if ($id !== null) {
                        $this->deleteCourse($id);
                    } else {
                        http_response_code(400);
                        echo json_encode(['message' => 'ID requis pour la suppression']);
                    }
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(['message' => 'Méthode non autorisée']);
            }
        } catch (Exception $e) {
            error_log('Erreur API courses: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['message' => 'Erreur serveur']);
        }
    }

    /**
     * GET /api/courses - Liste tous les cours
     */
    private function getAllCourses() {
        try {
            $courses = $this->db->all('SELECT * FROM courses');
            http_response_code(200);
            echo json_encode($courses);
        } catch (Exception $e) {
            error_log('Erreur liste cours: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['message' => 'Erreur serveur']);
        }
    }

    /**
     * GET /api/courses/:id - Détails d'un cours
     */
    private function getCourse($id) {
        try {
            $course = $this->db->get('SELECT * FROM courses WHERE id = ?', [$id]);

            if (!$course) {
                http_response_code(404);
                echo json_encode(['message' => 'Cours non trouvé']);
                return;
            }

            http_response_code(200);
            echo json_encode($course);
        } catch (Exception $e) {
            error_log('Erreur détails cours: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['message' => 'Erreur serveur']);
        }
    }

    /**
     * POST /api/courses - Créer un nouveau cours
     */
    private function createCourse() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['name'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Le nom du cours est requis']);
                return;
            }

            $result = $this->db->run(
                'INSERT INTO courses (name, description) VALUES (?, ?)',
                [$data['name'], $data['description'] ?? null]
            );

            $course = [
                'id' => $result['lastInsertId'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ];

            http_response_code(201);
            echo json_encode($course);
        } catch (Exception $e) {
            error_log('Erreur création cours: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['message' => 'Erreur serveur']);
        }
    }

    /**
     * PUT /api/courses/:id - Mettre à jour un cours
     */
    private function updateCourse($id) {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            $course = $this->db->get('SELECT * FROM courses WHERE id = ?', [$id]);
            if (!$course) {
                http_response_code(404);
                echo json_encode(['message' => 'Cours non trouvé']);
                return;
            }

            $this->db->run(
                'UPDATE courses SET name = ?, description = ? WHERE id = ?',
                [$data['name'] ?? $course['name'], $data['description'] ?? $course['description'], $id]
            );

            $updatedCourse = $this->db->get('SELECT * FROM courses WHERE id = ?', [$id]);

            http_response_code(200);
            echo json_encode($updatedCourse);
        } catch (Exception $e) {
            error_log('Erreur mise à jour cours: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['message' => 'Erreur serveur']);
        }
    }

    /**
     * DELETE /api/courses/:id - Supprimer un cours
     */
    private function deleteCourse($id) {
        try {
            $course = $this->db->get('SELECT * FROM courses WHERE id = ?', [$id]);
            if (!$course) {
                http_response_code(404);
                echo json_encode(['message' => 'Cours non trouvé']);
                return;
            }

            $this->db->run('DELETE FROM courses WHERE id = ?', [$id]);

            http_response_code(200);
            echo json_encode(['message' => 'Cours supprimé avec succès']);
        } catch (Exception $e) {
            error_log('Erreur suppression cours: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['message' => 'Erreur serveur']);
        }
    }
}
