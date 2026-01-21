<?php
require_once 'config.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $stmt = $pdo->prepare("SELECT id_user, prenom, nom FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $stmt = $pdo->prepare("INSERT INTO reset_mot_de_passe (email, token, date_expiration) VALUES (?, ?, ?)");
        $stmt->execute([$email, $token, $expiry]);
        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/LinkUp/reset-password.php?token=" . $token;
        
        $to = $email;
        $subject = "Réinitialisation de votre mot de passe - LinkUp";
        $message_body = "Bonjour " . htmlspecialchars($user['prenom'] . ' ' . $user['nom']) . ",\n\n" .
                "Vous avez demandé à réinitialiser votre mot de passe sur LinkUp.\n\n" .
                "Cliquez sur le lien ci-dessous pour créer un nouveau mot de passe :\n" .
                $resetLink . "\n\n" .
                "Ce lien expirera dans 1 heure.\n\n" .
                "Si vous n'avez pas demandé cette réinitialisation, ignorez simplement cet email.\n\n" .
                "© " . date('Y') . " LinkUp - Tous droits réservés";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/plain; charset=UTF-8" . "\r\n";
        $headers .= "From: groupe.app.g4@gmail.com" . "\r\n";
        
        if (mail($to, $subject, $message_body, $headers)) {
            $message = "Un email de réinitialisation a été envoyé à votre adresse.";
        } else {
            $error = "Erreur lors de l'envoi de l'email. Veuillez réessayer.";
        }
    } else {
        $message = "Si cet email existe dans notre système, un lien de réinitialisation a été envoyé.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <title>LinkUp - Mot de passe oublié</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/password.css" />
  </head>
  <body>
    <?php include 'header.php'; ?>

    <main class="main">
      <section class="login">
        <h1 class="auth__title">Mot de passe oublié</h1>

        <?php if ($message): ?>
          <div class="notification-item">
            <p class="notification-text"><?php echo htmlspecialchars($message); ?></p>
          </div>
        <?php endif; ?>

        <?php if ($error): ?>
          <div class="notification-item">
            <p class="notification-text"><?php echo htmlspecialchars($error); ?></p>
          </div>
        <?php endif; ?>

        <form class="form" method="POST" action="forgot-password.php">
          <div class="form__group">
            <label class="form__label" for="email">Email</label>
            <input
              class="form__input"
              id="email"
              name="email"
              type="email"
              placeholder="Entrez votre email"
              required
            />
          </div>

          <button class="form__submit" type="submit">Envoyer le lien</button>
        </form>
        
        <p class="auth__footer">
          Vous vous souvenez de votre mot de passe ?
          <a class="auth__footer-link" href="./login.php">Se connecter</a>
        </p>
      </section>
    </main>
    
    <?php include 'footer.php'; ?>
    <script src="js/passwordvisibility.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>
