<?php


require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Rechercher l'utilisateur
    $stmt = $pdo->prepare("SELECT id_user, nom, prenom, email, mot_de_passe, role FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    // erreur si nom utilisateur et/ou mot de passe incorrect
    if (!$user || !password_verify($password, $user['mot_de_passe'])) {
        echo "<script>alert('Email ou mot de passe incorrect'); window.location.href='login.php';</script>";
        exit;
    }
    // on connecte l utilisateur
    $_SESSION['user_id'] = $user['id_user'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name'] = $user['prenom'] . ' ' . $user['nom'];
    $_SESSION['user_role'] = $user['role'];

    header('Location: index.php');
    exit;
}
?>