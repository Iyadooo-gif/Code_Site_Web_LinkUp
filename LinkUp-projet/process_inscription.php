<?php
// process_inscription.php - Version simple

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT id_user FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        echo "<script>alert('Cet email est déjà utilisé'); window.location.href='inscription.html';</script>";
        exit;
    }

    // Séparer le nom en prénom et nom de famille
    $nom_parts = explode(' ', $nom, 2);
    $prenom = $nom_parts[0];
    $nom_famille = isset($nom_parts[1]) ? $nom_parts[1] : '';

    // Hacher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom_famille, $prenom, $email, $hashed_password]);
    
    $user_id = $pdo->lastInsertId();

    // Créer la session
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $nom;

    // Rediriger
    header('Location: index.html');
    exit;
}
?>