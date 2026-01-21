<?php
require_once 'config.php';

$message = '';
$error = '';
$valid_token = false;
$token = null;


if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $pdo->prepare("SELECT r.id_reset, u.id_user, u.email, u.prenom, u.nom 
                        FROM reset_mot_de_passe r 
                        JOIN utilisateur u ON r.email = u.email 
                        WHERE r.token = ? AND r.date_expiration > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if ($user) {
        $valid_token = true;
    } else {
        $error = "Ce lien de réinitialisation est invalide ou a expiré.";
    }
} else {
    $error = "Token de réinitialisation manquant.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE utilisateur SET mot_de_passe = ? WHERE id_user = ?");
        $stmt->execute([$hashed_password, $user['id_user']]);
        $stmt = $pdo->prepare("DELETE FROM reset_mot_de_passe WHERE token = ?");
        $stmt->execute([$token]);
        $message = "Votre mot de passe a été réinitialisé avec succès !";
        $valid_token = false;
    }
}
?>