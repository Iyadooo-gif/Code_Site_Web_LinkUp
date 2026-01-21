<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['user_id'];
$id_activite = (int)$_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM participation WHERE id_user = ? AND id_activite = ?");
    $stmt->execute([$id_user, $id_activite]);

    header("Location: activity-details.php?id=$id_activite");
    exit;
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>