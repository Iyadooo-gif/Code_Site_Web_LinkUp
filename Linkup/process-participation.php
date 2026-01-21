<?php
// process-participation.php
require_once 'config.php';

// 1. Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// 2. Vérifier si l'ID de l'activité est présent
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['user_id'];
$id_activite = (int)$_GET['id'];

try {
    // 3. Vérifier si l'utilisateur n'est pas déjà inscrit
    $stmt = $pdo->prepare("SELECT id_participation FROM participation WHERE id_user = ? AND id_activite = ? AND statut = 'inscrit'");
    $stmt->execute([$id_user, $id_activite]);
    
    if ($stmt->fetch()) {
        // Déjà inscrit ? On redirige simplement
        header("Location: activity-details.php?id=$id_activite");
        exit;
    }

    // 4. Vérifier s'il reste de la place
    $stmt = $pdo->prepare("SELECT nb_place FROM activite WHERE id_activite = ?");
    $stmt->execute([$id_activite]);
    $activity = $stmt->fetch(); // <-- Le point-virgule important était peut-être manquant ici
    
    // Compter les inscrits actuels
    $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM participation WHERE id_activite = ? AND statut = 'inscrit'");
    $stmtCount->execute([$id_activite]);
    $nb_inscrits = $stmtCount->fetchColumn();

    if ($nb_inscrits >= $activity['nb_place']) {
        // Complet
        echo "<script>alert('Désolé, cette activité est complète.'); window.location.href='activity-details.php?id=$id_activite';</script>";
        exit;
    }

    // 5. Inscription (Insertion en base)
    $stmt = $pdo->prepare("INSERT INTO participation (id_user, id_activite, statut, date_inscription) VALUES (?, ?, 'inscrit', NOW())");
    $stmt->execute([$id_user, $id_activite]);

    // Succès !
    header("Location: activity-details.php?id=$id_activite");
    exit;

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>