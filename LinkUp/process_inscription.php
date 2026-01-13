<?php


require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // On verifie si l'email existe si oui message d'erreur
    $stmt = $pdo->prepare("SELECT id_user FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        echo "<script>alert('Cet email est déjà utilisé'); window.location.href='inscription.php';</script>";
        exit;
    }

    $nom_parts = explode(' ', $nom, 2);
    $prenom = $nom_parts[0];
    $nom_famille = isset($nom_parts[1]) ? $nom_parts[1] : '';
    // On hash le mdp pour la securite
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // insertion dans la bdd
    $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom_famille, $prenom, $email, $hashed_password]);
    // on connecte l utilisateur au site
    $user_id = $pdo->lastInsertId();

    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $nom;
    
    header('Location: index.php');
    exit;
}
?>